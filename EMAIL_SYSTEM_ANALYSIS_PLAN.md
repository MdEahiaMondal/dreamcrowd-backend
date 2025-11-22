# Email System Analysis Plan

**Project:** DreamCrowd Email System Documentation & Variable Verification
**Date:** 2025-11-22
**Purpose:** Document all email templates, identify where they are sent from, verify all required variables are passed correctly

---

## Objectives

1. Create comprehensive documentation of the entire email system
2. Map each email template to its usage location in the codebase
3. Verify that all variables expected by templates are provided by the calling code
4. Identify any missing variables, unused templates, or data mismatches
5. Provide recommendations for fixes

---

## Phase 1: Discovery & Analysis

### 1.1 Find All Email Templates
**Location:** `resources/views/emails/`

**Templates to analyze (21 total):**
1. notification.blade.php
2. order-approved.blade.php
3. order-rejected.blade.php
4. order-delivered.blade.php
5. reschedule-request-buyer.blade.php
6. reschedule-request-seller.blade.php
7. reschedule-approved.blade.php
8. reschedule-rejected.blade.php
9. verify-email.blade.php
10. forgot-password.blade.php
11. change-email.blade.php
12. trial-booking-confirmation.blade.php
13. trial-class-reminder.blade.php
14. class-start-reminder.blade.php
15. custom-offer-sent.blade.php
16. custom-offer-accepted.blade.php
17. custom-offer-rejected.blade.php
18. custom-offer-expired.blade.php
19. guest-class-invitation.blade.php
20. contact-email.blade.php
21. daily-system-report.blade.php

### 1.2 Extract Variables from Each Template

For each template, identify:
- **Direct variables:** `$userName`, `$orderId`, `$teacherName`
- **Array access:** `$mailData['email']`, `$notification['title']`
- **Object properties:** `$order->title`, `$user->first_name`
- **Required vs Optional:** Based on `@if`, `@isset`, `??` usage
- **Variable types:** String, Array, Object, Boolean

**Method:**
- Use `grep` to find all `{{` and `{!!` patterns
- Extract variable names using regex
- Categorize by access pattern

### 1.3 Find Email Sending Locations

**Search patterns:**
```bash
# Mailable classes
app/Mail/*.php

# Controllers
app/Http/Controllers/*.php

# Console commands
app/Console/Commands/*.php

# Jobs
app/Jobs/*.php

# Notifications
app/Notifications/*.php

# Direct Mail facade usage
grep -r "Mail::" app/

# Email view rendering
grep -r "view('emails\." app/
grep -r 'view("emails.' app/
```

### 1.4 Map Templates to Usage

For each template, document:
- **Sender:** Class name and method (e.g., `BookingController@approveOrder`)
- **Trigger:** User action or scheduled event
- **Route/Endpoint:** If triggered by HTTP request
- **File Location:** `app/Http/Controllers/BookingController.php:line_number`
- **Data Passed:** Array of variables/objects passed to the view

### 1.5 Verify Variable Completeness

For each template:
1. List all variables it expects
2. List all variables actually passed from sender
3. Identify:
   - ✅ **Matched:** Variable is provided
   - ⚠️ **Missing:** Template expects but sender doesn't provide
   - ℹ️ **Extra:** Sender provides but template doesn't use
   - 🔴 **Critical:** Required variable is missing (no default/fallback)

---

## Phase 2: Documentation Creation

### 2.1 Create: EMAIL_SYSTEM_DOCUMENTATION.md

**Structure:**

```markdown
# Email System Documentation

## Overview
- Total Templates: 21
- Base Layout: resources/views/emails/layouts/base.blade.php
- Email Sending Mechanism: [Laravel Mail/Mailable/Notifications]
- Privacy Protection: NameHelper for masked names

## System Architecture
[Diagram or description of email flow]

## Email Template Registry

### Template: notification.blade.php
**Purpose:** General system notifications with privacy protection

**Usage:**
- **Sent From:** Multiple locations (admin notifications, system alerts)
- **Triggered By:** Various events
- **File Locations:**
  - `app/Http/Controllers/AdminController.php:245`
  - `app/Console/Commands/AutoHandleDisputes.php:78`

**Expected Variables:**
| Variable | Type | Required | Default | Description |
|----------|------|----------|---------|-------------|
| `$notification['title']` | string | ✓ | - | Notification title |
| `$notification['message']` | string | ✓ | - | Main message |
| `$notification['is_emergency']` | boolean | ✗ | false | Show as urgent |
| `$notification['data']` | array | ✗ | null | Additional data |

**Variables Passed (Example from AdminController):**
```php
[
    'notification' => [
        'title' => 'Order Approved',
        'message' => 'Your order has been approved...',
        'is_emergency' => false,
        'data' => ['order_id' => 123]
    ]
]
```

**Verification Status:** ✅ All required variables provided

**Code Example:**
```php
Mail::to($user->email)->send(new NotificationMail([
    'notification' => [
        'title' => 'Your Title',
        'message' => 'Your message here',
    ]
]));
```

---

[Repeat for all 21 templates]

---

## Summary Tables

### All Templates Overview
| Template | Used | Locations | Status |
|----------|------|-----------|--------|
| notification.blade.php | ✓ | 5 | ✅ Complete |
| order-approved.blade.php | ✓ | 1 | ⚠️ Missing var |
| ... | ... | ... | ... |

### Templates by Status
- ✅ Complete (all variables provided): X templates
- ⚠️ Missing variables: X templates
- 🔴 Critical issues: X templates
- ❌ Not used in production: X templates

### Templates by Category
- **Order Management:** 4 templates
- **Rescheduling:** 4 templates
- **Authentication:** 3 templates
- **Trial Classes:** 3 templates
- **Custom Offers:** 4 templates
- **System/Admin:** 3 templates
```

### 2.2 Create: EMAIL_VARIABLE_VERIFICATION_REPORT.md

**Structure:**

```markdown
# Email Variable Verification Report

**Analysis Date:** 2025-11-22
**Templates Analyzed:** 21
**Issues Found:** [Number]

---

## Executive Summary

- **Critical Issues:** X (Missing required variables)
- **Warnings:** X (Missing optional variables)
- **Information:** X (Extra unused variables)
- **Templates with Issues:** X out of 21
- **Overall Health:** [Good/Fair/Poor]

---

## Critical Issues

### 1. order-approved.blade.php
**Severity:** 🔴 Critical
**Issue:** Missing required variable `$sellerName`

**Template expects:**
- Line 15: `{{ $sellerName }}`

**Actually passed:**
- `$orderId` ✓
- `$serviceName` ✓
- `$amount` ✓
- `$sellerName` ❌ MISSING

**Impact:** Email will throw error when sent

**Recommendation:**
```php
// In BookingController.php:approveOrder()
// ADD this variable:
$data['sellerName'] = NameHelper::maskName($order->seller->name);
```

**File to fix:** `app/Http/Controllers/BookingController.php:line_number`

---

## Warnings

### 1. trial-class-reminder.blade.php
**Severity:** ⚠️ Warning
**Issue:** Optional variable `$personalMessage` not provided

**Template expects:**
- Line 45: `{{ $personalMessage ?? 'Looking forward to seeing you!' }}`

**Actually passed:**
- Has fallback, but personalization opportunity missed

**Recommendation:** Consider adding personalized message from booking

---

## Information

### 1. forgot-password.blade.php
**Severity:** ℹ️ Info
**Issue:** Extra variable `$app_name` passed but not used

**Variables passed but unused:**
- `$app_name` - Not referenced in template

**Recommendation:** Remove from sender to reduce data transfer

---

## Templates Not Used in Production

### 1. daily-system-report.blade.php
**Status:** ❌ Not found in codebase
**Risk:** Low (appears to be planned feature)

**Recommendation:** Either implement or remove template

---

## Detailed Verification Table

| Template | Expected Vars | Passed Vars | Missing | Extra | Status |
|----------|--------------|-------------|---------|-------|--------|
| notification.blade.php | 4 | 4 | 0 | 0 | ✅ |
| order-approved.blade.php | 5 | 4 | 1 | 0 | 🔴 |
| order-rejected.blade.php | 5 | 5 | 0 | 0 | ✅ |
| ... | ... | ... | ... | ... | ... |

---

## Recommendations

### Immediate Actions Required
1. Fix missing `$sellerName` in order-approved email
2. Fix missing `$xyz` in [template name]

### Suggested Improvements
1. Add personalization to trial-class-reminder
2. Remove unused variables to optimize performance
3. Implement daily-system-report or remove template

### Best Practices
1. Always pass all required variables
2. Use NameHelper::maskName() for privacy
3. Provide meaningful defaults for optional variables
4. Document all new email templates
```

---

## Phase 3: Search & Analysis Commands

### Search for Email Sending Code

```bash
# Find all Mailable classes
find app/Mail -name "*.php"

# Find Mail facade usage
grep -r "Mail::" app/ --include="*.php"

# Find view() calls for emails
grep -r "view('emails\." app/ --include="*.php"
grep -r 'view("emails\.' app/ --include="*.php"

# Find Notification classes
find app/Notifications -name "*.php"

# Search in controllers
grep -r "emails\." app/Http/Controllers/ --include="*.php"

# Search in commands
grep -r "emails\." app/Console/Commands/ --include="*.php"

# Search for specific templates
grep -r "notification.blade" app/ --include="*.php"
grep -r "order-approved" app/ --include="*.php"
# ... (repeat for all templates)
```

### Extract Variables from Templates

```bash
# Find all Blade variable usage
grep -r "{{" resources/views/emails/*.blade.php
grep -r "{!!" resources/views/emails/*.blade.php

# Find @if statements (conditional variables)
grep -r "@if" resources/views/emails/*.blade.php

# Find isset checks (optional variables)
grep -r "@isset" resources/views/emails/*.blade.php

# Find null coalescing (default values)
grep -r "??" resources/views/emails/*.blade.php
```

---

## Phase 4: Variable Extraction Method

For each template, we'll extract variables using this approach:

### Pattern Matching
1. **Direct variables:** `{{ $variableName }}`
2. **Array access:** `{{ $array['key'] }}`
3. **Object properties:** `{{ $object->property }}`
4. **Function calls:** `{{ functionName($var) }}`
5. **Conditionals:** `@if($variable)`, `@isset($variable)`

### Analysis Script Concept
```php
// Pseudocode for variable extraction
function extractVariables($templatePath) {
    $content = file_get_contents($templatePath);

    // Find all {{ }} and {!! !!} blocks
    preg_match_all('/\{\{(.+?)\}\}/', $content, $matches);
    preg_match_all('/\{!!(.+?)!!\}/', $content, $matches2);

    // Extract variable names
    // Categorize by type (direct, array, object)
    // Identify required vs optional

    return [
        'direct' => [...],
        'arrays' => [...],
        'objects' => [...],
        'required' => [...],
        'optional' => [...]
    ];
}
```

---

## Expected Deliverables

### 1. EMAIL_SYSTEM_DOCUMENTATION.md
- **Size:** ~800-1500 lines
- **Content:** Complete documentation of all 21 templates
- **Format:** Markdown with tables, code examples, structure overview

### 2. EMAIL_VARIABLE_VERIFICATION_REPORT.md
- **Size:** ~200-400 lines
- **Content:** All verification results, issues, recommendations
- **Format:** Markdown with severity ratings, tables, fix suggestions

### 3. Optional: EMAIL_FIXES.md
- **Content:** Concrete code patches for all identified issues
- **Format:** Markdown with code snippets ready to copy-paste

---

## Success Criteria

- ✅ All 21 templates documented
- ✅ Every template mapped to its usage location(s)
- ✅ All expected variables identified
- ✅ All passed variables verified
- ✅ All mismatches documented with severity
- ✅ Recommendations provided for fixes
- ✅ Documentation is clear and maintainable

---

## Timeline Estimate

1. **Discovery Phase:** 10-15 minutes
   - Search codebase for email sending code
   - Extract variables from all templates

2. **Analysis Phase:** 15-20 minutes
   - Map templates to usage
   - Compare expected vs passed variables
   - Categorize issues

3. **Documentation Phase:** 20-30 minutes
   - Write comprehensive documentation
   - Create verification report
   - Format and organize

**Total Estimated Time:** 45-65 minutes

---

## Next Steps

**AWAITING APPROVAL TO PROCEED**

Once approved, I will:
1. Execute search commands to find all email usage
2. Extract variables from all 21 templates
3. Map each template to its sender(s)
4. Verify variable completeness
5. Create both documentation files
6. Provide summary of findings

---

## Notes & Assumptions

- Assuming Laravel Mail/Mailable system is used
- Assuming NameHelper::maskName() is used for privacy
- EmailTestController is for preview only, not production
- Will focus on production code, not test/preview code
- Will check app/Mail, app/Http/Controllers, app/Console, app/Notifications
- Will verify both Blade syntax and data structures

---

**Status:** 📋 Planning Complete - Ready for Execution
