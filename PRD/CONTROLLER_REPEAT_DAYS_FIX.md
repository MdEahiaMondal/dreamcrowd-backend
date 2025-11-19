# ClassManagementController - Repeat Days Fix

## Issue Reported
After form submission, the `TeacherReapetDays` table was not inserting day, start_time, and end_time data for **OneDay** and **Trial** classes.

**Implementation Date:** November 2, 2025
**Status:** ✅ FIXED

---

## Problem Analysis

### Root Cause:

The code to insert repeat days into `TeacherReapetDays` table was located inside an `else` block:

```php
if ($gigData->recurring_type == 'OneDay' || $gigData->recurring_type == 'Trial') {
    // Trial-specific logic
    $gig->status = 1;

} else {
    // THIS BLOCK ONLY RUNS FOR RECURRING CLASSES
    $gig->status = 1;

    if ($request->day_repeat != null) {
        foreach ($request->day_repeat as $key => $value) {
            TeacherReapetDays::create([
                'gig_id' => $request->gig_id,
                'day' => $value,
                'start_time' => $request->start_repeat[$key],
                'end_time' => $request->end_repeat[$key],
            ]);
        }
    }
}
```

**Problem:**
- OneDay classes → Goes into `if` block → Repeat days NOT saved ❌
- Trial classes → Goes into `if` block → Repeat days NOT saved ❌
- Recurring classes → Goes into `else` block → Repeat days saved ✅

Since we enabled the "Repeat On" section for ALL class types, the repeat days data needs to be saved for ALL types, not just Recurring.

---

## Solution Implemented

### Updated Controller Logic (Lines 555-593)

**Before:**
```php
if ($gigData->recurring_type == 'OneDay' || $gigData->recurring_type == 'Trial') {
    // Trial-specific logic
    if ($gigData->recurring_type == 'Trial') {
        $payment->is_trial = 1;
        $payment->trial_type = $gigData->trial_type;
        // ... free trial pricing logic
    }

    $gig->status = 1;

} else {
    $gig->status = 1;

    // Repeat days only saved for Recurring classes
    if ($request->day_repeat != null) {
        foreach ($request->day_repeat as $key => $value) {
            TeacherReapetDays::create([
                'gig_id' => $request->gig_id,
                'day' => $value,
                'start_time' => $request->start_repeat[$key],
                'end_time' => $request->end_repeat[$key],
            ]);
        }
    }
}
```

**After:**
```php
// Trial-specific logic
if ($gigData->recurring_type == 'Trial') {
    $payment->is_trial = 1;
    $payment->trial_type = $gigData->trial_type;

    if ($gigData->trial_type == 'Free') {
        if (in_array($gigData->group_type, ['Public', 'Both'])) {
            $gig->public_rate = 0;
            $payment->public_rate = 0;
            $payment->public_earning = 0;
            $payment->public_discount = 0;
        }

        if (in_array($gigData->group_type, ['Private', 'Both'])) {
            $gig->private_rate = 0;
            $payment->private_rate = 0;
            $payment->private_earning = 0;
            $payment->private_discount = 0;
        }
    }
}

// Save repeat days for ALL class types (OneDay, Trial, Recurring)
if ($request->day_repeat != null) {
    // Delete existing repeat days first (in case of update)
    TeacherReapetDays::where('gig_id', $request->gig_id)->delete();

    // Insert new repeat days
    foreach ($request->day_repeat as $key => $value) {
        TeacherReapetDays::create([
            'gig_id' => $request->gig_id,
            'day' => $value,
            'start_time' => $request->start_repeat[$key],
            'end_time' => $request->end_repeat[$key],
        ]);
    }
}

$gig->status = 1;
```

---

## Key Changes

### 1. **Removed Conditional Wrapper** ✅

Moved the repeat days logic OUTSIDE the `if/else` block so it runs for all class types.

**Before:**
```php
if (OneDay or Trial) {
    // ...
} else {
    // Only Recurring gets here
    if ($request->day_repeat != null) {
        // Save repeat days
    }
}
```

**After:**
```php
// Trial-specific logic (if needed)
if (Trial) {
    // ...
}

// Save repeat days for ALL types
if ($request->day_repeat != null) {
    // Save repeat days
}
```

---

### 2. **Added Delete Before Insert** ✅

When updating a class, we now delete old repeat days before inserting new ones:

```php
// Delete existing repeat days first (in case of update)
TeacherReapetDays::where('gig_id', $request->gig_id)->delete();
```

**Why:**
- Prevents duplicate entries when teacher updates schedule
- Ensures old days are removed if teacher unselects them
- Clean slate for fresh data

---

### 3. **Kept Trial-Specific Logic Separate** ✅

Trial class pricing logic now runs independently:

```php
// Trial-specific logic
if ($gigData->recurring_type == 'Trial') {
    $payment->is_trial = 1;
    $payment->trial_type = $gigData->trial_type;
    // ... force $0 pricing for free trials
}
```

This ensures trial pricing still works correctly while repeat days are saved for all types.

---

## How Data Flows Now

### Form Submission:

When a teacher submits the payment form, these arrays are sent:

```php
$request->day_repeat = ['Monday', 'Wednesday', 'Friday'];
$request->start_repeat = ['09:00', '09:00', '10:00'];
$request->end_repeat = ['10:00', '11:00', '12:00'];
```

---

### Controller Processing:

**Step 1:** Save schedule data (start_date, start_time, end_time) - Already done ✅

**Step 2:** Handle trial-specific pricing - Already done ✅

**Step 3:** Save repeat days (NEW FIX) ✅
```php
// Delete old entries
TeacherReapetDays::where('gig_id', 123)->delete();

// Insert new entries
foreach (['Monday', 'Wednesday', 'Friday'] as $key => $day) {
    TeacherReapetDays::create([
        'gig_id' => 123,
        'day' => 'Monday',  // $day
        'start_time' => '09:00',  // $request->start_repeat[$key]
        'end_time' => '10:00',  // $request->end_repeat[$key]
    ]);
}
```

---

### Database Result:

**teacher_reapet_days table:**

| id | gig_id | day | start_time | end_time | created_at | updated_at |
|----|--------|-----|------------|----------|------------|------------|
| 1 | 123 | Monday | 09:00 | 10:00 | ... | ... |
| 2 | 123 | Wednesday | 09:00 | 11:00 | ... | ... |
| 3 | 123 | Friday | 10:00 | 12:00 | ... | ... |

---

## Class Types Supported

### ✅ OneDay Classes
- Teacher selects one day (e.g., Monday)
- Sets start and end time
- **NOW SAVES** to `TeacherReapetDays` table

### ✅ Trial Classes (Free & Paid)
- Teacher selects one day for trial session
- Sets start and end time
- **NOW SAVES** to `TeacherReapetDays` table
- Trial-specific pricing still works correctly

### ✅ Recurring Classes
- Teacher selects multiple days (e.g., Mon/Wed/Fri)
- Sets start and end time for each day
- **ALREADY WORKED**, now just refactored for consistency

---

## Database Schema

### TeacherReapetDays Table:

```sql
CREATE TABLE teacher_reapet_days (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    gig_id BIGINT UNSIGNED NOT NULL,
    day VARCHAR(255) NOT NULL,  -- e.g., 'Monday', 'Tuesday'
    start_time TIME NOT NULL,    -- e.g., '09:00:00'
    end_time TIME NOT NULL,      -- e.g., '10:00:00'
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (gig_id) REFERENCES teacher_gigs(id) ON DELETE CASCADE
);
```

### Model (app/Models/TeacherReapetDays.php):

```php
class TeacherReapetDays extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_id',
        'day',
        'start_time',
        'end_time',
    ];
}
```

---

## Update vs Create Handling

### When Creating New Class:
1. `gig_id` is set from form
2. Repeat days are inserted (none exist yet)
3. Creates new rows in `teacher_reapet_days`

### When Updating Existing Class:
1. Old repeat days are deleted:
   ```php
   TeacherReapetDays::where('gig_id', $request->gig_id)->delete();
   ```
2. New repeat days are inserted
3. Ensures no duplicate or stale data

---

## Testing Checklist

### OneDay Classes:
- [ ] Create OneDay class → Select Monday 09:00-10:00 → Submit
- [ ] Check `teacher_reapet_days` table → Should have 1 row with Monday data ✅
- [ ] Update class → Change to Tuesday 10:00-11:00 → Submit
- [ ] Check table → Should have 1 row with Tuesday data (Monday deleted) ✅

### Trial Classes (Free):
- [ ] Create Free Trial → Select Wednesday 14:00-14:30 → Submit
- [ ] Check `teacher_reapet_days` → Should have 1 row with Wednesday data ✅
- [ ] Check `teacher_gig_payments` → Should have `is_trial=1`, `trial_type='Free'` ✅

### Trial Classes (Paid):
- [ ] Create Paid Trial → Select Friday 15:00-16:00 → Submit
- [ ] Check `teacher_reapet_days` → Should have 1 row with Friday data ✅
- [ ] Check `teacher_gig_payments` → Should have `is_trial=1`, `trial_type='Paid'` ✅

### Recurring Classes:
- [ ] Create Recurring → Select Mon/Wed/Fri with different times → Submit
- [ ] Check `teacher_reapet_days` → Should have 3 rows ✅
- [ ] Update class → Remove Wednesday, add Thursday → Submit
- [ ] Check table → Should have Mon/Thu/Fri rows (Wed deleted) ✅

---

## Data Integrity

### Cascade Delete:
If a teacher deletes a gig, all repeat days should be automatically deleted:

```sql
FOREIGN KEY (gig_id) REFERENCES teacher_gigs(id) ON DELETE CASCADE
```

**Verify:**
```php
$gig = TeacherGig::find(123);
$gig->delete();

// All TeacherReapetDays with gig_id=123 should be automatically deleted
$count = TeacherReapetDays::where('gig_id', 123)->count();
// $count should be 0
```

---

## Before vs After Comparison

### Before Fix:

**OneDay Class:**
- Form submitted with `day_repeat=['Monday']`, `start_repeat=['09:00']`, `end_repeat=['10:00']`
- Controller: Goes into `if (OneDay)` block → Repeat days NOT saved ❌
- Database: `teacher_reapet_days` table empty ❌
- Result: Class created but schedule data lost ❌

**Trial Class:**
- Form submitted with `day_repeat=['Friday']`, `start_repeat=['14:00']`, `end_repeat=['14:30']`
- Controller: Goes into `if (Trial)` block → Repeat days NOT saved ❌
- Database: `teacher_reapet_days` table empty ❌
- Result: Trial created but schedule data lost ❌

**Recurring Class:**
- Form submitted with `day_repeat=['Mon','Wed','Fri']`, times arrays
- Controller: Goes into `else` block → Repeat days saved ✅
- Database: 3 rows in `teacher_reapet_days` ✅
- Result: Works correctly ✅

---

### After Fix:

**OneDay Class:**
- Form submitted with `day_repeat=['Monday']`, `start_repeat=['09:00']`, `end_repeat=['10:00']`
- Controller: Processes trial logic (if applicable) → THEN saves repeat days ✅
- Database: 1 row in `teacher_reapet_days` with Monday data ✅
- Result: Class created with proper schedule ✅

**Trial Class:**
- Form submitted with `day_repeat=['Friday']`, `start_repeat=['14:00']`, `end_repeat=['14:30']`
- Controller: Sets trial pricing → THEN saves repeat days ✅
- Database: 1 row in `teacher_reapet_days` with Friday data ✅
- Result: Trial created with schedule and proper pricing ✅

**Recurring Class:**
- Form submitted with `day_repeat=['Mon','Wed','Fri']`, times arrays
- Controller: Deletes old days → Inserts new days ✅
- Database: 3 rows in `teacher_reapet_days` ✅
- Result: Still works correctly, now with update handling ✅

---

## Related Changes

This fix works together with:

1. **PAYMENT_BLADE_SCHEDULE_FIX.md** - Removed duplicate schedule section, made "Repeat On" visible for all
2. **PAYMENT_VALIDATION_SCRIPT_FIX.md** - Updated JavaScript validation to check repeat inputs
3. **Lines 545-553** - Save schedule data (start_date, start_time, end_time) for all class types

All three parts must be deployed together for the feature to work end-to-end.

---

## Backward Compatibility

✅ **100% Compatible**

- Existing Recurring classes already have data in `teacher_reapet_days` table
- No data migration needed
- Only affects NEW OneDay and Trial classes going forward
- Existing classes not affected

---

## Performance Impact

**Minimal:**

- One extra DELETE query per update (negligible)
- INSERT queries were already happening for Recurring classes
- Now just extended to all class types
- Cascading deletes handled by database (no PHP overhead)

---

## Files Modified

| File | Lines Modified | Type | Description |
|------|---------------|------|-------------|
| `ClassManagementController.php` | 555-593 | PHP | Moved repeat days logic outside conditional |

**Total Lines Changed:** ~40 lines (restructured logic)

---

## Error Handling

### If day_repeat is null:
```php
if ($request->day_repeat != null) {
    // Only runs if data exists
}
```
No action taken - class created without repeat days (edge case).

### If arrays are mismatched:
```php
foreach ($request->day_repeat as $key => $value) {
    TeacherReapetDays::create([
        'day' => $value,
        'start_time' => $request->start_repeat[$key],  // Uses same $key
        'end_time' => $request->end_repeat[$key],      // Uses same $key
    ]);
}
```
Arrays should always match due to frontend validation, but Laravel will throw an error if data is corrupted (which is good - fails fast).

---

## Debugging

### To check if repeat days are being saved:

```php
// After creating/updating a class
$gig_id = 123;
$repeatDays = TeacherReapetDays::where('gig_id', $gig_id)->get();

dd($repeatDays);
// Should show array of days with start_time and end_time
```

### To check form data being submitted:

```php
// In ClassManagementController.php, add at line 577:
dd($request->day_repeat, $request->start_repeat, $request->end_repeat);
```

### To check delete is working on updates:

```php
// Before the delete, count rows
$before = TeacherReapetDays::where('gig_id', $request->gig_id)->count();

TeacherReapetDays::where('gig_id', $request->gig_id)->delete();

$after = TeacherReapetDays::where('gig_id', $request->gig_id)->count();

\Log::info("Repeat days deleted: $before rows, now $after rows");
// $after should be 0
```

---

## Deployment Notes

### Pre-Deployment:
1. Verify `teacher_reapet_days` table exists
2. Verify foreign key constraint on `gig_id`
3. Test in staging environment

### Deployment Steps:
1. Deploy controller changes
2. Clear application cache: `php artisan cache:clear`
3. No database migration needed (table already exists)

### Post-Deployment:
1. Create test OneDay class → Verify data in `teacher_reapet_days`
2. Create test Trial class → Verify data in `teacher_reapet_days`
3. Update existing class → Verify old data deleted, new data inserted
4. Monitor Laravel logs for any errors

---

## Support & Troubleshooting

### If repeat days still not saving:

1. **Check form submission:**
   - Open DevTools Network tab
   - Submit form
   - Check `day_repeat[]`, `start_repeat[]`, `end_repeat[]` in POST data

2. **Check controller is receiving data:**
   ```php
   dd($request->day_repeat);  // Add at line 577
   ```

3. **Check database permissions:**
   - Ensure app can INSERT into `teacher_reapet_days`
   - Ensure app can DELETE from `teacher_reapet_days`

4. **Check foreign key:**
   - Verify `gig_id` exists in `teacher_gigs` table before insert

### If getting duplicate entries:

- Verify DELETE is running before INSERT
- Check if `gig_id` is correct
- Ensure no multiple form submissions happening

---

## Summary

✅ **Fixed repeat days insertion** for OneDay and Trial classes

✅ **Moved logic outside conditional** so it runs for all class types

✅ **Added delete before insert** to handle updates properly

✅ **Maintained trial-specific logic** separately for clean code

✅ **100% backward compatible** with existing classes

✅ **Proper data cleanup** on updates

---

**Fix Complete:** ✅
**Ready for Testing:** ✅
**Ready for Deployment:** ✅

---

**Last Updated:** November 2, 2025
