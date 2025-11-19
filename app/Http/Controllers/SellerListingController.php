<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExpertProfile;
use App\Models\KeywordSuggession;
use App\Models\Languages;
use App\Models\ServiceReviews;
use App\Models\ServicesFaqs;
use App\Models\SubCategory;
use App\Models\TeacherFaqs;
use App\Models\TeacherGig;
use App\Models\TeacherGigData;
use App\Models\TeacherGigPayment;
use App\Models\TeacherReapetDays;
use App\Models\TopSellerTag;
use App\Models\User;
use App\Models\WishList;
use Carbon\Carbon;
use Carbon\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class SellerListingController extends Controller
{

    protected $perPage;

    public function __construct()
    {
        $this->perPage = 12;
    }


    public function getKeywords(Request $request)
    {
        // Get the search term from the request
        $keyword = $request->query('keyword');

        // Fetch matching keywords from the database
        $keywords = KeywordSuggession::where('keyword', 'like', '%' . $keyword . '%')->pluck('keyword');

        // Return as JSON
        return response()->json($keywords);
    }

    public function SellerListing()
    {
        $tag = TopSellerTag::first();
        if ($tag) {
            // Default to 0 if any value is null, use the value from $tag otherwise
            $impressionsWeight = $tag->sorting_impressions ?? 0;
            $clicksWeight = $tag->sorting_clicks ?? 0;
            $ordersWeight = $tag->sorting_orders ?? 0;
            $reviewsWeight = $tag->sorting_reviews ?? 0;

            // Calculate total weight, prevent division by 0
            $totalWeight = $impressionsWeight + $clicksWeight + $ordersWeight + $reviewsWeight;
            if ($totalWeight == 0) {
                // Fallback if totalWeight is 0 (could avoid a divide by zero situation)
                $impressionsWeight = 0.10;
                $clicksWeight = 0.10;
                $ordersWeight = 0.20;
                $reviewsWeight = 0.60;
                $totalWeight = 1; // Standard default values sum to 1
            }

            // Normalize the weights if they don't sum to 100%
            $impressionsWeight /= $totalWeight;
            $clicksWeight /= $totalWeight;
            $ordersWeight /= $totalWeight;
            $reviewsWeight /= $totalWeight;

            $gigs = TeacherGig::query()
                ->withAvg('all_reviews', 'rating')
                ->where('status', 1)
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
            (COALESCE(impressions, 0) * ?) +
            (COALESCE(clicks, 0) * ?) +
            (COALESCE(orders, 0) * ?) +
            (COALESCE(reviews, 0) * ?) as score
        ', [
                    $impressionsWeight,
                    $clicksWeight,
                    $ordersWeight,
                    $reviewsWeight
                ])
                ->orderByDesc('score')
                ->paginate($this->perPage);

        } else {
            // Default values if $tag is not found
            $gigs = TeacherGig::query()
                ->withAvg('all_reviews', 'rating')
                ->where('status', 1)
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
            (COALESCE(impressions, 0) * 0.10) +
            (COALESCE(clicks, 0) * 0.10) +
            (COALESCE(orders, 0) * 0.20) +
            (COALESCE(reviews, 0) * 0.60) as score
        ')
                ->orderByDesc('score')
                ->paginate($this->perPage);
        }


        $languages = Languages::all();
        $heading = 'All Services';
        $service_role = 'All';
        $Data['service_role'] = 'All';
        $Data['service_type'] = 'All';
        $Data['sort_by'] = 'Relevence';
        $Data['category_type'] = null;
        $Data['category'] = null;


        $categories = Category::where('status', 1) // Only active categories
        ->select('category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();

        $categories_tab = Category::where('status', 1) // Only active categories
        ->select('category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();

        foreach ($gigs as $key => $value) {
            $impressions = $value->impressions + 1;
            $value->impressions = $impressions;
            $value->update();
        }

        return view("Seller-listing.seller-listing-new", compact(
            'gigs',
            'categories',
            'categories_tab',
            'languages',
            'heading',
            'service_role',
            'Data'
        ));
        // return view("Seller-listing.seller-listing", compact('gigs','categories','categories_tab','languages','heading','service_role'));
    }


    public function SellerListingOnlineServices()
    {


        $tag = TopSellerTag::first();

        if ($tag) {
            // Default to 0 if any value is null, use the value from $tag otherwise
            $impressionsWeight = $tag->sorting_impressions ?? 0;
            $clicksWeight = $tag->sorting_clicks ?? 0;
            $ordersWeight = $tag->sorting_orders ?? 0;
            $reviewsWeight = $tag->sorting_reviews ?? 0;

            // Calculate total weight, prevent division by 0
            $totalWeight = $impressionsWeight + $clicksWeight + $ordersWeight + $reviewsWeight;
            if ($totalWeight == 0) {
                // Fallback if totalWeight is 0 (avoid a divide by zero situation)
                $impressionsWeight = 0.10;
                $clicksWeight = 0.10;
                $ordersWeight = 0.20;
                $reviewsWeight = 0.60;
                $totalWeight = 1; // Standard default values sum to 1
            }

            // Normalize the weights if they don't sum to 100%
            $impressionsWeight /= $totalWeight;
            $clicksWeight /= $totalWeight;
            $ordersWeight /= $totalWeight;
            $reviewsWeight /= $totalWeight;

            // Query for TeacherGig where status=1 and service_type='Online'
            $gigs = TeacherGig::where(['status' => 1, 'service_type' => 'Online'])
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
                (COALESCE(impressions, 0) * ?) +
                (COALESCE(clicks, 0) * ?) +
                (COALESCE(orders, 0) * ?) +
                (COALESCE(reviews, 0) * ?) as score
            ', [
                    $impressionsWeight,
                    $clicksWeight,
                    $ordersWeight,
                    $reviewsWeight
                ])
                ->orderByDesc('score')
                ->paginate($this->perPage);

        } else {
            // Default values if $tag is not found
            $gigs = TeacherGig::where(['status' => 1, 'service_type' => 'Online'])
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
                (COALESCE(impressions, 0) * 0.10) +
                (COALESCE(clicks, 0) * 0.10) +
                (COALESCE(orders, 0) * 0.20) +
                (COALESCE(reviews, 0) * 0.60) as score
            ')
                ->orderByDesc('score')
                ->paginate($this->perPage);
        }


        $languages = Languages::all();
        $heading = 'Online Services';
        $service_role = 'All';
        $Data['service_role'] = 'All';
        $Data['service_type'] = 'Online';
        $Data['sort_by'] = 'Relevence';
        $Data['category_type'] = null;
        $Data['category'] = null;

        $categories = Category::where('status', 1)->where('service_type', 'Online') // Only active categories
        ->select('category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();

        $categories_tab = Category::where('status', 1)->where('service_type', 'Online') // Only active categories
        ->select('category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();


        foreach ($gigs as $key => $value) {
            $impressions = $value->impressions + 1;
            $value->impressions = $impressions;
            $value->update();
        }

        return view("Seller-listing.seller-listing-new", compact('gigs', 'categories', 'categories_tab', 'languages', 'heading', 'service_role', 'Data'));


    }


    public function SellerListingOnlineServicesCategory($category)
    {

        $tag = TopSellerTag::first();

        if ($tag && $tag->sorting_impressions && $tag->sorting_clicks && $tag->sorting_orders && $tag->sorting_reviews) {
            // Use sorting values from the $tag table
            $gigs = TeacherGig::where(['status' => 1, 'service_type' => 'Online', 'category_name' => $category])
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
                (COALESCE(impressions, 0) * ?) +
                (COALESCE(clicks, 0) * ?) +
                (COALESCE(orders, 0) * ?) +
                (COALESCE(reviews, 0) * ?) as score
            ', [
                    $tag->sorting_impressions / 100, // Divide by 100 to convert percentage
                    $tag->sorting_clicks / 100,
                    $tag->sorting_orders / 100,
                    $tag->sorting_reviews / 100
                ])
                ->orderByDesc('score')
                ->paginate($this->perPage);
        } else {
            // Default sorting if $tag is not available
            $gigs = TeacherGig::where(['status' => 1, 'service_type' => 'Online', 'category_name' => $category])
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
                (COALESCE(impressions, 0) * 0.10) +
                (COALESCE(clicks, 0) * 0.10) +
                (COALESCE(orders, 0) * 0.20) +
                (COALESCE(reviews, 0) * 0.60) as score
            ')
                ->orderByDesc('score')
                ->paginate($this->perPage);
        }


        $languages = Languages::all();
        $heading = $category . ' Services';
        $service_role = 'All';
        $Data['service_role'] = 'All';
        $Data['service_type'] = 'All';
        $Data['sort_by'] = 'Relevence';
        $Data['category_type'] = 'Category';
        $Data['category'] = $category;


        $category_ids = Category::where('status', 1)->where('service_type', 'Online')->where('category', $category)->select('id')->get();

        $categories = SubCategory::whereIn('cate_id', $category_ids) // Only active categories
        ->select('sub_category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();


        $categories_tab = SubCategory::whereIn('cate_id', $category_ids) // Only active categories
        ->select('sub_category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();


        foreach ($gigs as $key => $value) {
            $impressions = $value->impressions + 1;
            $value->impressions = $impressions;
            $value->update();
        }

        return view("Seller-listing.seller-listing-new", compact('gigs', 'categories', 'categories_tab', 'languages', 'heading', 'service_role', 'Data'));


    }


    public function SellerListingInpersonServices()
    {


        $tag = TopSellerTag::first();

        if ($tag && $tag->sorting_impressions && $tag->sorting_clicks && $tag->sorting_orders && $tag->sorting_reviews) {
            // Use sorting values from the $tag table for "Inperson" service type
            $gigs = TeacherGig::where(['status' => 1, 'service_type' => 'Inperson'])
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
            (COALESCE(impressions, 0) * ?) +
            (COALESCE(clicks, 0) * ?) +
            (COALESCE(orders, 0) * ?) +
            (COALESCE(reviews, 0) * ?) as score
        ', [
                    $tag->sorting_impressions / 100, // Divide by 100 to convert percentage
                    $tag->sorting_clicks / 100,
                    $tag->sorting_orders / 100,
                    $tag->sorting_reviews / 100
                ])
                ->orderByDesc('score')
                ->paginate($this->perPage);
        } else {
            // Default sorting if $tag is not available
            $gigs = TeacherGig::where(['status' => 1, 'service_type' => 'Inperson'])
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
            (COALESCE(impressions, 0) * 0.10) +
            (COALESCE(clicks, 0) * 0.10) +
            (COALESCE(orders, 0) * 0.20) +
            (COALESCE(reviews, 0) * 0.60) as score
        ')
                ->orderByDesc('score')
                ->paginate($this->perPage);
        }


        $languages = Languages::all();
        $heading = 'Inperson Services';
        $service_role = 'All';
        $Data['service_role'] = 'All';
        $Data['service_type'] = 'Inperson';
        $Data['sort_by'] = 'Relevence';
        $Data['category_type'] = null;
        $Data['category'] = null;

        $categories = Category::where('status', 1)->where('service_type', 'Inperson') // Only active categories
        ->select('category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();

        $categories_tab = Category::where('status', 1)->where('service_type', 'Inperson') // Only active categories
        ->select('category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();


        foreach ($gigs as $key => $value) {
            $impressions = $value->impressions + 1;
            $value->impressions = $impressions;
            $value->update();
        }

        return view("Seller-listing.seller-listing-new", compact('gigs', 'categories', 'categories_tab', 'languages', 'heading', 'service_role', 'Data'));


    }


    public function SellerListingInpersonServicesCategory($category)
    {

        $tag = TopSellerTag::first();

        if ($tag && $tag->sorting_impressions && $tag->sorting_clicks && $tag->sorting_orders && $tag->sorting_reviews) {
            // Use sorting values from the $tag table
            $gigs = TeacherGig::where(['status' => 1, 'service_type' => 'Inperson', 'category_name' => $category])
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
                (COALESCE(impressions, 0) * ?) +
                (COALESCE(clicks, 0) * ?) +
                (COALESCE(orders, 0) * ?) +
                (COALESCE(reviews, 0) * ?) as score
            ', [
                    $tag->sorting_impressions / 100, // Divide by 100 to convert percentage
                    $tag->sorting_clicks / 100,
                    $tag->sorting_orders / 100,
                    $tag->sorting_reviews / 100
                ])
                ->orderByDesc('score')
                ->paginate($this->perPage);
        } else {
            // Default sorting if $tag is not available
            $gigs = TeacherGig::where(['status' => 1, 'service_type' => 'Inperson', 'category_name' => $category])
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->select('*')
                ->selectRaw('
                (COALESCE(impressions, 0) * 0.10) +
                (COALESCE(clicks, 0) * 0.10) +
                (COALESCE(orders, 0) * 0.20) +
                (COALESCE(reviews, 0) * 0.60) as score
            ')
                ->orderByDesc('score')
                ->paginate($this->perPage);
        }


        $languages = Languages::all();
        $heading = $category . ' Services';
        $service_role = 'All';
        $Data['service_role'] = 'All';
        $Data['service_type'] = 'Inperson';
        $Data['sort_by'] = 'Relevence';
        $Data['category_type'] = 'Category';
        $Data['category'] = $category;

        $categories = Category::where('status', 1)->where('service_type', 'Inperson')->where('category', $category) // Only active categories
        ->select('category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();
        $category_ids = Category::where('status', 1)->where('service_type', 'Inperson')->where('category', $category)->select('id')->get();

        $categories_tab = SubCategory::whereIn('cate_id', $category_ids) // Only active categories
        ->select('sub_category')  // Select only the category field
        ->distinct()          // Ensure unique category names
        ->get();


        foreach ($gigs as $key => $value) {
            $impressions = $value->impressions + 1;
            $value->impressions = $impressions;
            $value->update();
        }

        return view("Seller-listing.seller-listing-new", compact('gigs', 'categories', 'categories_tab', 'languages', 'heading', 'service_role', 'Data'));


    }


// Search Service From Main ---------Start
    public function SellerListingServiceSearch(Request $request)
    {

        $category_type = $request->category_type;
        $category = $request->category_service;
        $keyword = $request->keyword;

        $tag = TopSellerTag::first();

        // Start the query
        $query = TeacherGig::where('status', 1)
            ->whereHas('user', function($q) {
                $q->whereNotNull('id'); // Only gigs with valid users
            });

        // Apply category filter only if $category_type is not null
        if ($category !== null) {
            $query->where('category_name', $category);
        }

        // Apply keyword filter only if keyword is provided
        if (!empty($keyword)) {
            $query->where('title', 'LIKE', '%' . $keyword . '%');
        }

        //     // Apply sorting based on $tag values
        //     if ($tag && $tag->sorting_impressions && $tag->sorting_clicks && $tag->sorting_orders && $tag->sorting_reviews) {
        //         $query->selectRaw('
        //     (COALESCE(impressions, 0) * ?) +
        //     (COALESCE(clicks, 0) * ?) +
        //     (COALESCE(orders, 0) * ?) +
        //     (COALESCE(reviews, 0) * ?) as score
        // ', [
        //             $tag->sorting_impressions / 100,
        //             $tag->sorting_clicks / 100,
        //             $tag->sorting_orders / 100,
        //             $tag->sorting_reviews / 100
        //         ]);
        //     } else {
        //         // Default sorting if $tag is missing
        //         $query->selectRaw('
        //     (COALESCE(impressions, 0) * 0.10) +
        //     (COALESCE(clicks, 0) * 0.10) +
        //     (COALESCE(orders, 0) * 0.20) +
        //     (COALESCE(reviews, 0) * 0.60) as score
        // ');
        //     }

        // Apply sorting based on $tag values
        if ($tag && $tag->sorting_impressions && $tag->sorting_clicks && $tag->sorting_orders && $tag->sorting_reviews) {
            // Ensure we select all columns (including id) and compute score
            $query->select('*')
                ->selectRaw('
            (COALESCE(impressions, 0) * ?) +
            (COALESCE(clicks, 0) * ?) +
            (COALESCE(orders, 0) * ?) +
            (COALESCE(reviews, 0) * ?) as score
        ', [
                    $tag->sorting_impressions / 100,
                    $tag->sorting_clicks / 100,
                    $tag->sorting_orders / 100,
                    $tag->sorting_reviews / 100
                ]);
        } else {
            // Default sorting if $tag is missing; select all columns including id
            $query->select('*')
                ->selectRaw('
            (COALESCE(impressions, 0) * 0.10) +
            (COALESCE(clicks, 0) * 0.10) +
            (COALESCE(orders, 0) * 0.20) +
            (COALESCE(reviews, 0) * 0.60) as score
        ');
        }

// Order by calculated score
        $gigs = $query->orderByDesc('score')->paginate($this->perPage);


        $languages = Languages::all();
        $heading = ($category !== null) ? $category . ' Services' : 'All Services';
        $service_role = 'All';
        $Data['service_role'] = 'All';
        $Data['service_type'] = 'All';
        $Data['sort_by'] = 'Relevence';
        $Data['category_type'] = ($category !== null) ? 'Category' : null;
        $Data['category'] = $category;


        // If category_type is not null, filter by category
        if (!empty($category)) {
            $categories = Category::where('status', 1)
                ->where('category', $category)
                ->select('category')
                ->distinct()
                ->get();

            $category_ids = Category::where('status', 1)
                ->where('category', $category)
                ->pluck('id'); // Using pluck to get an array of IDs directly

            $categories_tab = SubCategory::whereIn('cate_id', $category_ids)
                ->select('sub_category')
                ->distinct()
                ->get();
        } else {
            // If category_type is null, fetch all categories
            $categories = Category::where('status', 1)
                ->select('category')
                ->distinct()
                ->get();

            $categories_tab = Category::where('status', 1)
                ->select('category')
                ->distinct()
                ->get();
        }


        foreach ($gigs as $key => $value) {
            $impressions = $value->impressions + 1;
            $value->impressions = $impressions;
            $value->update();
        }

        return view("Seller-listing.seller-listing-new", compact('gigs', 'categories', 'categories_tab', 'languages', 'heading', 'service_role', 'Data'));


    }

// Search Service From Main ---------END


    public function SellerListingSearch(Request $request)
    {


        $profileQuery = ExpertProfile::query()->where('status', 1);

        // Filtering by Languages
        $language_selected = null;
        if ($request->has('languages') && !empty($request->languages)) {
            $languages = explode(',', $request->languages); // Convert to array
            $language_selected = implode(',', $languages);

            $profileQuery->where(function ($query) use ($languages) {
                foreach ($languages as $language) {
                    $query->orWhereRaw("FIND_IN_SET(?, primary_language)", [$language])
                        ->orWhereRaw("FIND_IN_SET(?, fluent_other_language)", [$language]);
                }
            });
        }


        // Filtering by Location
        if ($request->has('location') && !empty($request->location)) {
            $profileQuery->where('street_address', 'LIKE', '%' . $request->location . '%');
        }


        // Filtering by Distance (Only Miles)
        $miles_distance = null;

        if ($request->has('distance') && !empty($request->distance) &&
            $request->has('latitude') && $request->has('longitude')) {

            $distance = (float)$request->distance;
            $latitude = (float)$request->latitude;
            $longitude = (float)$request->longitude;

            // Convert Miles to Kilometers (Since Haversine Uses KM)
            if ($distance === 30) {
                $distance = 100; // Convert "30+ Miles" to 100 miles
            }

            $distance_km = $distance * 1.60934; // Convert Miles to KM

            // Apply distance filter using Haversine Formula
            $profileQuery->selectRaw("6371 * acos(
                cos(radians(?)) * cos(radians(latitude)) *
                cos(radians(longitude) - radians(?)) +
                sin(radians(?)) * sin(radians(latitude))
            ) AS distance", [$latitude, $longitude, $latitude])
                ->having('distance', '<=', $distance_km);

            $miles_distance = $distance; // Store the original distance in miles
        }


        // Fetch profiles
        $profiles = $profileQuery->get();
        $userIds = $profiles->pluck('user_id')->toArray();
        $users = $profiles;

        // Fetch matching Gigs
        $query = TeacherGig::whereIn('user_id', $userIds)->where('status', 1)
            ->whereHas('user', function($q) {
                $q->whereNotNull('id'); // Only gigs with valid users
            });
        $CatesQuery = Category::where('status', 1);

        // Filtering by Service Role
        $service_role = $request->service_role ?? 'All';
        if ($service_role != 'All') {
            $query->where('service_role', $service_role);
            $CatesQuery->where('service_role', $service_role);
        }

        // Filtering by Service Type
        $service_type = $request->service_type ?? 'All';
        if ($service_type != 'All') {
            $query->where('service_type', $service_type);
            $CatesQuery->where('service_type', $service_type);
        }

        // Filtering by Payment Type
        $payment_type = $request->payment_type ?? 'All';
        if ($payment_type != 'All') {
            $query->where('payment_type', $payment_type);
        }


        // Filtering by Date & Time
        $date = null;

        if ($request->class_type != 'Live') {
            if ($request->has('date_time') && !empty($request->date_time)) {
                try {
                    $dateTimeString = $request->date_time;
                    $parsedDateTime = null;

                    // Determine if time is included
                    if (strpos($dateTimeString, ' ') !== false) {
                        $parsedDateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString);
                    } else {
                        $parsedDateTime = Carbon::createFromFormat('Y-m-d', $dateTimeString)->startOfDay();
                    }

                    if ($parsedDateTime) {
                        $formattedDate = $parsedDateTime->format('Y-m-d');
                        $formattedTime = $parsedDateTime->format('H:i:s');
                        $dayName = $parsedDateTime->format('l'); // Get the day name (e.g., Monday)

                        // Apply filtering conditions
                        $query->where(function ($q) use ($formattedDate, $formattedTime, $dayName) {
                            // Case 1: Services with `start_date` matching the selected date
                            $q->whereDate('start_date', $formattedDate);

                            // Case 2: Services that repeat on the selected day
                            $q->orWhereHas('repeatDays', function ($subQuery) use ($dayName) {
                                $subQuery->whereRaw("FIND_IN_SET(?, day)", [$dayName]);
                            });

                            // Case 3: Services where `start_date` is NULL and `full_available = 1`
                            $q->orWhere(function ($subQ) {
                                $subQ->whereNull('start_date')->where('full_available', 1);
                            });

                            // Case 4: If time is provided, ensure services match the `start_time`
                            if ($formattedTime !== '00:00:00') {
                                $q->where(function ($subQ) use ($formattedTime, $dayName) {
                                    // Filter by time for services with a specific start time
                                    $subQ->whereTime('start_time', '<=', $formattedTime);

                                    // Also check repeat services with a valid start time
                                    $subQ->orWhereHas('repeatDays', function ($subQuery) use ($dayName, $formattedTime) {
                                        $subQuery->whereRaw("FIND_IN_SET(?, day)", [$dayName])
                                            ->whereTime('start_time', '<=', $formattedTime);
                                    });
                                });
                            }
                        });

                        $date = $request->date_time;
                    }
                } catch (\Exception $e) {
                    $date = 'kiii';
                    // \Log::error('Date parsing error: ' . $e->getMessage());
                }
            }
        }


        // Filtering by Price
        $min_price = $request->filled('min_price') ? (float)$request->min_price : null;
        $max_price = $request->filled('max_price') ? (float)$request->max_price : null;

        $query->when($min_price !== null, function ($q) use ($min_price) {
            $q->where(function ($subQuery) use ($min_price) {
                $subQuery->where('rate', '>=', $min_price)
                    ->orWhere('public_rate', '>=', $min_price)
                    ->orWhere('private_rate', '>=', $min_price);
            });
        });

        $query->when($max_price !== null, function ($q) use ($max_price) {
            $q->where(function ($subQuery) use ($max_price) {
                $subQuery->where('rate', '<=', $max_price)
                    ->orWhere('public_rate', '<=', $max_price)
                    ->orWhere('private_rate', '<=', $max_price);
            });
        });


        // Filtering by Keyword
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }


        // // Filtering by freelance type
        $freelance_type = 'All';
        $freelance_service = 'All';
        if ($service_role != 'Class') {

            if ($request->has('freelance_type') && $request->freelance_type != 'All') {
                $query->where('freelance_type', $request->freelance_type);
                $freelance_type = $request->freelance_type;
            }

            // // Filtering by freelance Service
            if ($request->has('freelance_service') && $request->freelance_service != 'All') {
                $query->where('freelance_service', $request->freelance_service);
                $freelance_service = $request->freelance_service;
            }
        }

        // Filtering by Delivery Time
        $delivery_time = $request->delivery_time ?? 'All';

        if ($delivery_time !== 'All') {
            $query->where(function ($q) use ($delivery_time) {
                $q->whereRaw("FIND_IN_SET(?, REPLACE(delivery_time, '|*|', ','))", [$delivery_time])
                    ->orWhere('delivery_time', '<=', $delivery_time);
            });
        }


        // Filtering by Revisions
        $revision = $request->revision ?? 'All';

        if ($revision !== 'All') {
            $query->where(function ($q) use ($revision) {
                if ($revision === 'Unlimited') {
                    $q->where('revision', 'Unlimited');
                } else {
                    // Convert revision range to numeric values
                    preg_match('/(\d+)\s*to\s*(\d+)/', $revision, $matches);
                    if (!empty($matches)) {
                        $q->whereRaw("FIND_IN_SET(?, REPLACE(revision, '|*|', ','))", [$matches[1]])
                            ->orWhereRaw("FIND_IN_SET(?, REPLACE(revision, '|*|', ','))", [$matches[2]])
                            ->orWhereBetween('revision', [(int)$matches[1], (int)$matches[2]]);
                    }
                }
            });
        }


        // // Filtering by class type
        $lesson_type = 'All';
        $class_type = 'All';

        if ($service_role != 'Freelance') {


            if ($request->has('lesson_type') && $request->lesson_type != 'All') {
                $query->where('lesson_type', $request->lesson_type);
                $lesson_type = $request->lesson_type;
            }

            // // Filtering by service type (Online or Inperson)
            if ($request->has('class_type') && $request->class_type != 'All') {
                $query->where('class_type', $request->class_type);
                $class_type = $request->class_type;
            }

        }

        // Filtering by Category (User can select multiple categories)
        if ($request->has('category_type')) {
            if ($request->has('category_service') && !empty($request->category_service)) {
                $categories = explode(',', $request->category_service); // Convert selected categories to an array

                $query->where(function ($q) use ($categories) {
                    foreach ($categories as $category) {
                        $q->orWhereRaw("FIND_IN_SET(?, category_name)", [$category]);
                    }
                });

                $CatesQuery->whereIn('category', $categories);
            }
        }

        // Filtering by Sub-Category (User can select multiple sub-categories)
        if ($request->has('category_type') && $request->category_type == 'Sub_Category') {
            if ($request->has('sub_category_service') && !empty($request->sub_category_service)) {
                $subCategories = explode(',', $request->sub_category_service); // Convert selected sub-categories into an array

                $query->where(function ($q) use ($subCategories) {
                    foreach ($subCategories as $subCategory) {
                        $q->orWhereRaw("FIND_IN_SET(?, sub_category)", [$subCategory]);
                    }
                });
            }
        }


        // Filtering by Service Role
        if ($request->has('seller_type') && $request->seller_type == 'High To Low') {
            $query->orderBy('rate', 'asc');
        }


        // Filtering by Service Role
        if ($request->has('seller_type') && $request->seller_type == 'Low To High') {
            $query->orderBy('rate', 'desc');
        }


        $tag = TopSellerTag::first();

        $sortingWeights = $tag
            ? [$tag->sorting_impressions / 100, $tag->sorting_clicks / 100, $tag->sorting_orders / 100, $tag->sorting_reviews / 100]
            : [0.10, 0.10, 0.20, 0.60]; // Default sorting values

        $gigs = $query->select('*')
            ->selectRaw('
        (COALESCE(impressions, 0) * ?) +
        (COALESCE(clicks, 0) * ?) +
        (COALESCE(orders, 0) * ?) +
        (COALESCE(reviews, 0) * ?) as score
    ', $sortingWeights)
            ->orderByDesc('score')
            ->paginate($this->perPage);


        $categories = $CatesQuery->select('category')->distinct()->get();
        $category_ids = $CatesQuery->select('id')->get();

// Fetch categories and languages for filters
        $category_type = $request->category_type;

        if ($request->has('category_service') && !empty($request->category_service) && !empty($request->category_type)) {
            // If category is selected, fetch the related subcategories
            $selected_category_ids = Category::whereIn('category', (array)$request->category_service)
                ->where('status', 1)
                ->pluck('id');

            $categories = SubCategory::whereIn('cate_id', $category_ids)
                ->select('sub_category')
                ->distinct()
                ->get();

            $category_type = 'Sub_Category';
        }


        foreach ($gigs as $key => $value) {
            $impressions = $value->impressions + 1;
            $value->impressions = $impressions;
            $value->update();
        }


        $languages = Languages::all();

        // Determine the Heading Based on Filters
        if ($request->has('category_service') && !empty($request->category_service)) {
            $selectedCategories = is_array($request->category_service) ? $request->category_service : explode(',', $request->category_service);

            // If only one category is selected, set it as the heading
            if (count($selectedCategories) === 1) {
                $heading = $selectedCategories[0] . ' Services';
            } else {
                // Multiple categories selected, apply service role/type-based heading
                $heading = ($service_role == 'Freelance' || $service_role == 'Class')
                    ? "$service_role Services"
                    : (($service_role == 'All' && $service_type != 'All')
                        ? "$service_type Services"
                        : "All Services");
            }
        } else {
            // If no category is selected, determine heading based on service role and type
            if ($service_role == 'Freelance' || $service_role == 'Class') {
                $heading = "$service_role Services";
            } elseif ($service_role == 'All' && $service_type != 'All') {
                $heading = "$service_type Services";
            } else {
                $heading = 'All Services';
            }
        }


        $wishlist = [];
        if (Auth::check()) {
            $wishlist = WishList::where('user_id', Auth::id())->pluck('gig_id')->toArray();
        }

// Modify gigs data to include wishlist status
        $gigs->getCollection()->transform(function ($gig) use ($wishlist) {
            $gig->isFavorited = in_array($gig->id, $wishlist);


            // Extract only the first value from the rate fields
            $extractFirstValue = function ($value) {
                return explode('|*|', $value)[0] ?? null;
            };

            $gig->final_rate = $extractFirstValue($gig->rate)
                ?? $extractFirstValue($gig->public_rate)
                ?? $extractFirstValue($gig->private_rate);


            return $gig;
        });


        return response()->json([
            'gigs' => $gigs->toArray(), // ✅ Use `toArray()` instead of `items()`
            'pagination' => [
                'current_page' => $gigs->currentPage(),
                'last_page' => $gigs->lastPage(),
                'next_page_url' => $gigs->nextPageUrl(),
                'prev_page_url' => $gigs->previousPageUrl(),
                'total' => $gigs->total(),
                'per_page' => $gigs->perPage(),
            ],
            'users' => $users,
            'wishlist' => $wishlist,
            'category_type' => $request->category_service,
            'categories' => $categories,
            'heading' => $heading,
            'date' => $date,
        ]);


    }


    public function CourseService($id)
    {
        $gig = TeacherGig::with('user')->find($id);

        // Check if gig exists and has a valid user
        if (!$gig || !$gig->user) {
            abort(404, 'Service not found or no longer available');
        }

        $profile = ExpertProfile::where(['user_id' => $gig->user_id, 'status' => 1])->first();
        $gigData = TeacherGigData::where(['gig_id' => $gig->id])->first();
        $gigPayment = TeacherGigPayment::where(['gig_id' => $gig->id])->first();
        $course = explode(',_,', $gigData->course);
        $resource = explode(',_,', $gigData->resource);

        $category = $gig->category; // Assuming gig has a 'category' field or relation

        $clicks = $gig->clicks + 1;
        $gig->clicks = $clicks;
        $gig->update();

        // Retrieve the existing recently viewed gigs from cookies (if any)
        $recentlyViewedGigs = json_decode(request()->cookie('recently_viewed_gigs', '[]'), true);

        // Remove any existing occurrence of the current gig ID
        $recentlyViewedGigs = array_filter($recentlyViewedGigs, function ($item) use ($id) {
            return $item !== $id;
        });

        // Add the new gig ID to the beginning of the array
        array_unshift($recentlyViewedGigs, $id);

        // Limit the list to the latest 10 gigs
        $recentlyViewedGigs = array_slice($recentlyViewedGigs, 0, 10);

        // Save the updated gig list back to the cookie
        Cookie::queue('recently_viewed_gigs', json_encode($recentlyViewedGigs), 60 * 24 * 30); // Cookie expires in 30 days

        // Save the most recent category in a separate cookie (replacing the old category)
        Cookie::queue('recently_viewed_category', json_encode($category), 60 * 24 * 30); // Only the latest category


        return view("Public-site.recorded-class", compact('gig', 'profile', 'gigData', 'gigPayment', 'course', 'resource'));
    }


    // Service Add to Wish List Function Start ====
    public function AddServiceToWishlist(Request $request)
    {

        if (!Auth::user()) {
            return response()->json(['error' => 'First Login to Your Account!']);
        }

        if (Auth::user()->role != 0) {
            return response()->json(['error' => 'Only users are able to add services in wishlist!']);
        }

        $wish = WishList::where(['user_id' => Auth::user()->id, 'gig_id' => $request->gig_id])->first();

        if ($wish) {
            $wish->delete();
            if ($wish) {
                return response()->json(['info' => 'This Service Removed From Wish List!']);
            } else {
                return response()->json(['error' => 'something Went Rong, Tryagain Latter!']);
            }


        } else {

            $wish = new WishList();

            $wish->user_id = Auth::user()->id;
            $wish->gig_id = $request->gig_id;

            if ($request->has('type') && $request->type == 'Profile') {
                $wish->type = $request->type;
            }

            $wish->save();

            if ($wish) {
                return response()->json(['success' => 'This Service Added to Wish List!']);
            } else {
                return response()->json(['error' => 'something Went Rong, Tryagain Latter!']);
            }
        }


    }

    // Service Add to Wish List Function END ====

    //Professional Profile Function Start ====
    public function ProfessionalProfile($id, $name)
    {
        $profile = ExpertProfile::find($id);
        $user = User::find($profile->user_id);
        if (Auth::user()) {
            $list = WishList::where(['user_id' => Auth::user()->id, 'gig_id' => $id, 'type' => 'Profile'])->first();
        } else {
            $list = null;
        }

        $all_reviews = ServiceReviews::query()->with(['replies', 'user'])->where(['teacher_id' => $user->id])->get();
        $faqs = TeacherFaqs::where(['user_id' => $user->id])->get();
        $teacher_services = TeacherGig::where(['user_id' => $user->id, 'service_type' => 'Online', 'status' => 1])
            ->whereHas('user', function($q) {
                $q->whereNotNull('id'); // Only gigs with valid users
            })
            ->get();
        $teacher_services_cls = TeacherGig::where(['user_id' => $user->id, 'service_role' => 'Class', 'lesson_type' => 'One', 'status' => 1])
            ->whereHas('user', function($q) {
                $q->whereNotNull('id'); // Only gigs with valid users
            })
            ->get();

        $teacher_services_fls = TeacherGig::where(['user_id' => $user->id, 'service_role' => 'Freelance', 'freelance_type' => 'Basic', 'status' => 1])
            ->whereHas('user', function($q) {
                $q->whereNotNull('id'); // Only gigs with valid users
            })
            ->get();

        // Retrieve the stored gig IDs from the cookie
        $recentlyViewed = json_decode(request()->cookie('recently_viewed_gigs', '[]'), true);

        // Fetch gigs based on the stored gig IDs
        $recentlyViewedGigs = TeacherGig::whereIn('id', $recentlyViewed)->where('status', 1)
            ->whereHas('user', function($q) {
                $q->whereNotNull('id'); // Only gigs with valid users
            })
            ->get();

        // Retrieve the most recent category from the cookie
        $recentlyViewedCategory = json_decode(request()->cookie('recently_viewed_category', 'null'), true);

        // Fetch services (gigs) with the same category as the most recently viewed gig
        $sameCategoryGigs = [];
        if ($recentlyViewedCategory) {
            $cate = Category::find($recentlyViewedCategory);
            $sameCategoryGigs = TeacherGig::where('category_name', $cate->category)
                ->where('status', 1) // Assuming you want to fetch only active gigs
                ->whereHas('user', function($q) {
                    $q->whereNotNull('id'); // Only gigs with valid users
                })
                ->latest()->take(10)->get();


        }

        return view('Public-site.services', compact(
            'profile',
            'user',
            'faqs',
            'recentlyViewedGigs',
            'sameCategoryGigs',
            'teacher_services',
            'list',
            'teacher_services_cls',
            'teacher_services_fls',
            'all_reviews',
        ));

    }
    //Professional Profile Function END ====


    // Professional Profile Function Start ====
    public function PortfolioGigsGet(Request $request)
    {
        $user = Auth::user();  // Get the authenticated user, if any
        $loggedIn = $user ? true : false;

        // Check if 'recent' type is requested
        if ($request->type == 'recent') {
            $recentlyViewed = json_decode($request->cookie('recently_viewed_gigs', '[]'), true);

            // Build the base query for recently viewed gigs
            $query = DB::table('teacher_gigs')
                ->leftJoin('expert_profiles', 'teacher_gigs.user_id', '=', 'expert_profiles.user_id')
                ->select(
                    'teacher_gigs.*',
                    'expert_profiles.first_name',
                    'expert_profiles.last_name',
                    'expert_profiles.profession',
                    'expert_profiles.profile_image'
                );

            // If the user is logged in, add the wishlist join and condition
            if ($loggedIn) {
                $query->leftJoin('wish_lists', function ($join) use ($user) {
                    $join->on('teacher_gigs.id', '=', 'wish_lists.gig_id')
                        ->where('wish_lists.user_id', '=', $user->id);
                })->selectRaw('IF(wish_lists.id IS NOT NULL, 1, 0) as is_wishlisted');
            }

            // Apply other conditions
            if (!empty($recentlyViewed)) {
                $query->whereIn('teacher_gigs.id', $recentlyViewed);
            }

            if ($request->service_role != 'All') {
                $query->where('teacher_gigs.service_role', $request->service_role);
            }

            // Get the results
            $services = $query->where('teacher_gigs.status', 1)->get();
        } // Handle case where the most recent category is requested
        else {

            $query = DB::table('teacher_gigs')
                ->leftJoin('expert_profiles', 'teacher_gigs.user_id', '=', 'expert_profiles.user_id')
                ->select(
                    'teacher_gigs.*',
                    'expert_profiles.first_name',
                    'expert_profiles.last_name',
                    'expert_profiles.profession',
                    'expert_profiles.profile_image'
                );

            if ($loggedIn) {
                $query->leftJoin('wish_lists', function ($join) use ($user) {
                    $join->on('teacher_gigs.id', '=', 'wish_lists.gig_id')
                        ->where('wish_lists.user_id', '=', $user->id);
                })->selectRaw('IF(wish_lists.id IS NOT NULL, 1, 0) as is_wishlisted');
            }

            if ($request->service_role != 'All') {
                $query->where('teacher_gigs.service_role', $request->service_role);
            }

            $services = $query->where('teacher_gigs.user_id', $request->teacher_id)
                ->where('teacher_gigs.status', 1)->get();

        }

        // Prepare the response
        $response['services'] = $services;
        $response['logged_in'] = $loggedIn;

        return response()->json($response);
    }
    //Professional Profile Function END ====

    // Profile Ajax Services Get Function Start ====
    public function GetProfileServices(Request $request)
    {
        $query = TeacherGig::where('user_id', $request->id)->where('status', 1)
            ->whereHas('user', function($q) {
                $q->whereNotNull('id'); // Only gigs with valid users
            });

        if ($request->has('role') && $request->role != 'All') {
            $query->where('service_role', $request->role);
        }

        if ($request->has('type')) {
            $query->where('service_type', $request->type);
        }

        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->has('payment_type') && $request->payment_type != '') {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->has('lesson_type')) {
            $query->where('lesson_type', $request->lesson_type);
        }

        if ($request->has('freelance_type')) {
            $query->where('freelance_type', $request->freelance_type);
        }

        $gigs = $query->get();
        $response['gigs'] = $gigs;
        return response()->json($response);
    }
    // Profile Ajax Services Get Function END ====


}