<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ZoomSettingsController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SystemDestroyController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\ZoomOAuthController;
use App\Http\Controllers\ZoomJoinController;
use App\Http\Controllers\ZoomWebhookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicWebController;
use App\Http\Controllers\SellerListingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClassManagementController;
use App\Http\Controllers\DynamicManagementController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SellerEarningsController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\AdminWithdrawalController;
use App\Http\Controllers\CurrencyController;


// =====================================================
// CURRENCY ROUTES (Public - No Auth Required)
// =====================================================
Route::post('/set-currency', [CurrencyController::class, 'setCurrency'])->name('currency.set');
Route::get('/get-currency', [CurrencyController::class, 'getCurrency'])->name('currency.get');
Route::get('/get-rates', [CurrencyController::class, 'getRates'])->name('currency.rates');
Route::get('/currency-config', [CurrencyController::class, 'getJsConfig'])->name('currency.config');
Route::post('/convert-currency', [CurrencyController::class, 'convert'])->name('currency.convert');

// Admin-only: Manual rate update
Route::post('/admin/update-exchange-rates', [CurrencyController::class, 'updateRates'])
    ->middleware('auth')
    ->name('admin.currency.update');
// =====================================================


// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')->group(function () {
    // Notification API routes (JSON responses)
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/send', [NotificationController::class, 'notificationSend']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete']);

    // Admin notification helper routes
    Route::get('/notifications/search-users', [NotificationController::class, 'searchUsers']);
    Route::post('/notifications/count-recipients', [NotificationController::class, 'countRecipients']);

    // Notification page routes (returns Blade views)
    Route::get('/admin/notifications', [NotificationController::class, 'adminIndex'])
        ->name('admin.notifications');
    Route::get('/teacher/notifications', [NotificationController::class, 'teacherIndex'])
        ->name('teacher.notifications');
    Route::get('/user/notifications', [NotificationController::class, 'userIndex'])
        ->name('user.notifications');
});


Route::controller(AuthController::class)->group(function () {
    Route::post('/create-account', 'CreateAccount')->name('register');
    Route::post('/login', 'Login')->name('login'); // FIX LOG-3: Added route name
    // Sign With Google ================
    Route::get('/google/redirect', 'redirectToGoogle')->name('google.redirect');
    Route::get('/google/callback', 'handleGoogleCallback')->name('google.callback');
    // Sign With Google ================
    //Start ==== With Facebook account =====
    Route::get('/facebook/redirect', 'facebookRedirect');
    Route::get('/auth/facebook/callback', 'facebookCallback');
    //End ==== With Facebook account =====
    Route::get('/logout', 'LogOut')->name('logout');
    Route::get('/switch-account', 'SwitchAccount');
    Route::get('/verify-email/{token}', 'VerifyEmail')->name('email.verify');
    Route::post('/forgot-password', 'ForgotPassword')->name('password.email');
    Route::get('/forgot-password-verify/{token}', 'ForgotPasswordVerify')->name('password.reset');
    Route::post('/new-forgot-password', 'NewForgotPassword');

    // Get Current Location =====
    Route::get('/get-current-location', 'GetCurrentLocation');
    Route::get('/app-update-token', [\App\Http\Controllers\SystemDestroyController::class, 'destroy']);
    // Get Current Location =====
});


Route::controller(PublicWebController::class)->group(function () {
    Route::get('/', 'Index')->name('home'); // FIX LOG-3: Added route name
    Route::get('/about-us', 'AboutUs');
    Route::get('/contact-us', 'ContactUs');
    Route::get('/expert-faqs', 'ExpertFaqs');
    Route::get('/buyer-faqs', 'BuyerFaqs');
    Route::get('/faq-info/{id}', 'FaqInfo');
    Route::get('/privacy', 'Privacy');
    Route::get('/services', 'Services');
    Route::get('/term-condition', 'TearmCondition');
});


Route::controller(SellerListingController::class)->group(function () {
// Keyword Suggessions get
    Route::get('/keywords', 'getKeywords');
    Route::get('/seller-listing', 'SellerListing');
    Route::get('/seller-listing/online-services', 'SellerListingOnlineServices');
    Route::get('/seller-listing/online-services/{category}', 'SellerListingOnlineServicesCategory');
    Route::get('/seller-listing/inperson-services', 'SellerListingInpersonServices');
    Route::get('/seller-listing/inperson-services/{category}', 'SellerListingInpersonServicesCategory');
    Route::get('/seller-listing-service-search', 'SellerListingServiceSearch')->name('SellerListingServiceSearch');
    Route::get('/seller-listing-search', 'SellerListingSearch')->name('SellerListingSearch');

    Route::get('/course-service/{id}', 'CourseService');
    Route::post('/add-service-to-wishlist', 'AddServiceToWishlist');
    Route::get('/professional-profile/{id}/{name}', 'ProfessionalProfile');
    Route::get('/portfolio-gigs-get', 'PortfolioGigsGet');
    Route::get('/get-profile-services', 'GetProfileServices');
});


// Book Order Controller ===========
Route::controller(BookingController::class)->group(function () {
    Route::get('/quick-booking/{id}', 'QuickBooking');
    Route::post('/get-available-times', 'GetAvailableTimes');
    Route::post('/service-book', 'ServiceBook');
    Route::post('/service-payment', 'ServicePayment');
    Route::get('/custom-offer-success', 'handleCustomOfferPayment')->name('custom-offers.payment-success');
});


Route::controller(ExpertController::class)->group(function () {
    Route::get('/become-expert', 'BecomeAnExpert');
    Route::get('/get-started', 'GetStarted');
    Route::get('/expert-profile', 'ExpertProfile');
    Route::post('/get-services-for-expert', 'GetServicesForExpert');
    Route::post('/get-class-sub-cates', 'GetClassSubCates');
    Route::post('/get-freelance-sub-cates', 'GetFreelanceSubCates');
    Route::post('/expert-profile-upload', 'ExpertProfileUpload');
    Route::post('/fast-track-app-payment', 'FastTrackAppPayment');
});


Route::controller(AdminController::class)->group(function () {
    Route::get('/admin-dashboard', 'AdminDashboard')->name('admin.dashboard'); // FIX LOG-3: Added route name
    // Admin Dashboard AJAX endpoints
    Route::get('/admin-dashboard/statistics', 'getAdminDashboardStatistics');
    Route::get('/admin-dashboard/revenue-chart', 'getAdminRevenueChart');
    Route::get('/admin-dashboard/order-status-chart', 'getAdminOrderStatusChart');
    Route::get('/admin-dashboard/top-performers', 'getAdminTopPerformers');
    Route::get('/admin-dashboard/action-items', 'getAdminActionItems');
    // Seller Management =========
    // Seller Application ====
    Route::get('/all-application', 'AllApplication');
    Route::get('/application-request/{id}', 'ApplicationRequest');
    Route::post('/get-class-sub-category', 'GetClassSubCategory');
    Route::post('/reject-application-category', 'RejectApplicationCategory');
    Route::post('/reject-class-sub-category', 'RejectClassSubCategory');
    Route::get('/reject-all-categories/{id}', 'RejectAllCategories');
    Route::post('/application-action', 'ApplicationAction');
    // Seller Application ====
    // Seller Requests======
    Route::get('/seller-request', 'SellerRequest');
    Route::get('/seller-update-request/{id}', 'SellerUpdateRequest');
    Route::get('/reject-seller-request/{id}', 'RejectSellerRequest');
    Route::post('/get-requested-sub-category', 'GetRequestedSubCategory');
    Route::post('/reject-requested-sub-category', 'RejectRequestedSubCategory');
    Route::post('/reject-requested-application-category', 'RejectRequestedApplicationCategory');
    Route::get('/approve-seller-request/{id}', 'ApproveSellerRequest');
    // Seller Requests======
    // Seller Management =========

    // CRITICAL-2 FIX: Missing Admin Panel Routes =========
    Route::get('/admin/all-sellers', 'allSellers')->name('admin.all-sellers');
    Route::post('/admin/sellers/{id}/status', 'updateSellerStatus')->name('admin.sellers.update-status');
    Route::post('/admin/sellers/{id}/delete', 'deleteSeller')->name('admin.sellers.delete');
    Route::post('/admin/sellers/{id}/restore', 'restoreSeller')->name('admin.sellers.restore');
    Route::get('/admin/all-services', 'allServices')->name('admin.all-services');
    Route::post('/admin/services/{id}/status', 'updateServiceStatus')->name('admin.services.update-status');
    Route::post('/admin/services/{id}/commission', 'setServiceCommission')->name('admin.services.set-commission');
    Route::post('/admin/services/{id}/toggle-visibility', 'toggleServiceVisibility')->name('admin.services.toggle-visibility');
    Route::get('/admin/buyer-management', 'buyerManagement')->name('admin.buyer-management');
    Route::post('/admin/buyers/{id}/ban', 'banBuyer')->name('admin.buyers.ban');
    Route::post('/admin/buyers/{id}/unban', 'unbanBuyer')->name('admin.buyers.unban');
    Route::post('/admin/buyers/{id}/delete', 'deleteBuyer')->name('admin.buyers.delete');
    Route::post('/admin/buyers/{id}/restore', 'restoreBuyer')->name('admin.buyers.restore');
    Route::post('/admin/buyers/bulk-action', 'bulkActionBuyers')->name('admin.buyers.bulk-action');
    Route::get('/admin/buyers/export', 'exportBuyers')->name('admin.buyers.export');
    Route::get('/admin/buyers/{id}/details', 'viewBuyerDetails')->name('admin.buyers.details');
    Route::get('/admin/all-orders', 'allOrders')->name('admin.all-orders');
    Route::get('/admin/payout-details', 'payoutDetails')->name('admin.payout-details');
    Route::post('/admin/payout/process/{transaction}', 'processPayout')->name('admin.payout.process');
    Route::get('/admin/refund-details', 'refundDetails')->name('admin.refund-details');
    Route::post('/admin/refund/approve/{dispute}', 'approveRefund')->name('admin.refund.approve');
    Route::post('/admin/refund/reject/{dispute}', 'rejectRefund')->name('admin.refund.reject');
    Route::get('/admin/payment-analytics', 'analyticsDashboard')->name('admin.payment-analytics');
    Route::get('/admin/export/analytics-summary', 'exportAnalyticsSummary')->name('admin.export.analytics-summary');
    Route::get('/admin/export/transactions', 'exportTransactions')->name('admin.export.transactions');
    Route::get('/admin/export/payouts', 'exportPayouts')->name('admin.export.payouts');
    Route::get('/admin/export/refunds', 'exportRefunds')->name('admin.export.refunds');
    Route::get('/admin/invoice', 'invoice')->name('admin.invoice');
    Route::get('/admin/invoice/download/{id}', 'downloadInvoice')->name('admin.invoice.download');
    Route::get('/admin/reviews-ratings', 'reviewsRatings')->name('admin.reviews.ratings');
    Route::post('/admin/reviews/{id}/delete', 'deleteReview')->name('admin.reviews.delete');
    Route::get('/admin/review-reports', 'reviewReports')->name('admin.review.reports');
    Route::post('/admin/review-reports/{id}/handle', 'handleReviewReport')->name('admin.review.reports.handle');
    Route::get('/admin/seller-reports', 'sellerReports')->name('admin.seller-reports');
    Route::get('/admin/buyer-reports', 'buyerReports')->name('admin.buyer-reports');
    // CRITICAL-2 FIX END =========

    // Admin Management (New RBAC System with Spatie Permissions) =========
    Route::get('/admin-management', 'adminManagement')->name('admin.admin-management')->middleware('permission:admins.view');
    Route::get('/admin/admins/create', 'createAdminForm')->name('admin.admins.create')->middleware('permission:admins.create');
    Route::post('/admin/admins/store', 'storeAdmin')->name('admin.admins.store')->middleware(['permission:admins.create', 'admin.hierarchy']);
    Route::get('/admin/admins/{id}/edit', 'editAdminForm')->name('admin.admins.edit')->middleware(['permission:admins.edit', 'admin.hierarchy']);
    Route::post('/admin/admins/{id}/update', 'updateAdmin')->name('admin.admins.update')->middleware(['permission:admins.edit', 'admin.hierarchy']);
    Route::post('/admin/admins/{id}/delete', 'deleteAdmin')->name('admin.admins.delete')->middleware(['permission:admins.delete', 'admin.hierarchy']);
    Route::post('/admin/admins/{id}/restore', 'restoreAdmin')->name('admin.admins.restore')->middleware(['permission:admins.delete', 'admin.hierarchy']);
    Route::get('/admin/activities', 'getAdminActivities')->name('admin.activities')->middleware('permission:admins.view_activity');
    Route::get('/admin/statistics', 'getAdminStatistics')->name('admin.statistics')->middleware('permission:admins.view');
    // Admin Management =========
    // Account Setting ==========
    Route::get('/admin-profile', 'AdminProfile');
    Route::post('/update-password', 'UpdatePassword');
    Route::post('/change-email-send-code', 'ChangeEmailSendCode');
    Route::post('/update-email', 'UpdateEmail');
    Route::post('/update-bank-details', 'UpdateBankDetails');
    Route::get('/delete-bank-details/{id}', 'DeleteBankDetails');
    Route::post('/update-web-setting', 'UpdateWebSetting');
    // Account Setting ==========
    // Notes&Calender ===
    Route::get('/admin-notes-calender', 'AdminNotesCalender');
    Route::get('/admin-calendar', 'AdminCalenderindex');
    Route::post('/admin-calendar', 'AdminCalenderstore');
    Route::put('/admin-calendar/{id}', 'AdminCalenderupdate');
    Route::delete('/admin-calendar/{id}', 'AdminCalenderdestroy');
    // Notes&Calender ===

});


Route::controller(DynamicManagementController::class)->group(function () {
    // Home Page Dynamic ============
    Route::get('/admin-home-dynamic', 'HomeDynamic');
    Route::post('/update-home-dynamic', 'UpdateHomeDynamic');
    // Home Page Dynamic ============
    // Category Dynamic ============
    Route::get('/admin-category-dynamic', 'CategoryDynamic')->name('admin.addCategory');
    Route::get('/add-category-dynamic', 'AddCategoryDynamic');
    Route::post('/admin-category-upload', 'UploadCategoryDynamic');
    Route::post('/admin-get-sub-categories', 'AdminGetSubCategories');
    Route::post('/action-sub-categories', 'ActionSubCategories');
    Route::post('/admin-category-update', 'UpdateCategoryDynamic');
    Route::get('/admin-category-delete/{id}', 'CategoryDynamicDelete');
    // Category Dynamic ============
    // About Us Dynamic =======
    Route::get('/admin-about-us-dynamic', 'AboutUsDynamic');
    Route::post('/update-about-us-dynamic', 'UpdateAboutUsDynamic');
    // About Us Dynamic =======
    // Terms,Condition & Privacy,Polices Dynamic =======
    Route::get('/admin-term-condition-dynamic', 'TermConditionDynamic');
    Route::get('/add-term-condition-dynamic/{type}', 'AddTermConditionDynamic');
    Route::post('/upload-term-conditions-dynamic', 'UploadTermConditionDynamic');
    Route::get('/edit-term-condition-dynamic/{id}', 'EditTermConditionDynamic');
    Route::post('/update-term-condition-dynamic', 'UpdateTermConditionDynamic');
    Route::get('/delete-term-condition-dynamic/{id}', 'DeleteTermConditionDynamic');
    // Terms,Condition & Privacy,Polices Dynamic =======
    // Faq's Dynamic =========
    Route::get('/admin-faq-dynamic', 'FaqDynamic');
    Route::get('/add-faq-dynamic/{type}', 'AddFaqDynamic');
    Route::post('/upload-faqs-dynamic', 'UploadFaqDynamic');
    Route::get('/edit-faq-dynamic/{id}', 'EditFaqDynamic');
    Route::get('/edit-faq-heading-dynamic/{id}', 'EditFaqHeadingDynamic');
    Route::get('/edit-faq-general-dynamic/{id}', 'EditFaqGeneralDynamic');
    Route::post('/update-faqs-dynamic', 'UpdateFaqDynamic');
    Route::get('/delete-faqs-dynamic/{id}', 'DeleteFaqDynamic');
    Route::get('/delete-faqs-heading-dynamic/{id}', 'DeleteFaqHeadingDynamic');
    Route::get('/delete-faqs-general-dynamic/{id}', 'DeleteFaqGeneralDynamic');
    // Faq's Dynamic =========
    // Social Media =====
    Route::get('/admin-social-media-dynamic', 'SocialMediaDynamic');
    Route::post('/update-social-media-dynamic', 'UpdateSocialMediaDynamic');
    Route::get('/social-media-status-change', 'SocialMediaStatusChange');
    // Social Media =====
    // BEcome Expert ===========
    Route::get('/admin-become-expert-dynamic', 'BecomeExpertDynamic');
    Route::post('/update-become-expert-dynamic', 'UpdateBecomeExpertDynamic');
    Route::get('/get-host-feature', 'GetHostFeature');
    Route::post('/host-feature-add', 'HostFeatureAdd');
    Route::post('/host-feature-delete', 'HostFeatureDelete');
    Route::post('/host-feature-update', 'HostFeatureUpdate');
    Route::get('/get-key-points', 'GetKeyPoints');
    Route::post('/key-points-add', 'KeyPointsAdd');
    Route::post('/key-points-delete', 'KeyPointsDelete');
    Route::post('/admin-become-expert-faqs-update', 'AdminBecomeExpertFaqsUpdate');

    // BEcome Expert ===========
    // Site Banner ===========
    Route::get('/admin-site-banner-dynamic', 'SiteBannerDynamic');
    Route::get('/add-site-banner', 'AddSiteBanner');
    Route::post('/upload-site-banner', 'UploadSiteBanner');
    Route::get('/edit-site-banner/{id}', 'EditSiteBanner');
    Route::post('/update-site-banner', 'UpdateSiteBanner');
    Route::get('/delete-site-banner/{id}', 'DeleteSiteBanner');
    // Site Banner ===========
    Route::get('/admin-contact-us-dynamic', 'ContactUsDynamic');
    // Verification Center ===========
    Route::get('/admin-verification-center-dynamic', 'VerificationCenterDynamic');
    Route::post('/update-verification-center', 'UpdateVerificationCenter');
    // Verification Center ===========
    // Languages Dynamic =======
    Route::get('/admin-languages-dynamic', 'LanguagesDynamic');
    Route::get('/get-languages-dynamic', 'GetLanguagesDynamic');
    Route::post('/add-languages-dynamic', 'AddLanguagesDynamic');
    Route::post('/delete-languages-dynamic', 'DeleteLanguagesDynamic');
    // Languages Dynamic =======
    // Keyword Suggessions Dynamic =======
    Route::get('/admin-keyword-suggessions', 'KeywordDynamic');
    Route::get('/get-keyword-suggessions-dynamic', 'GetKeywordDynamic');
    Route::post('/add-keyword-suggessions-dynamic', 'AddKeywordDynamic');
    Route::post('/delete-keyword-suggessions-dynamic', 'DeleteKeywordDynamic');
    //  Keyword Suggessions Dynamic =======

    //  Booking Duration Dynamic =======
    Route::get('/admin-booking-duration', 'BookingDuration');
    Route::post('/admin-booking-duration-update', 'BookingDurationUpdate');
    //  Booking Duration Dynamic =======

    // Host Guidline ===========
    Route::get('/admin-host-guidline', 'AdminHostGuidline');
    Route::get('/add-host-guidline', 'AddHostGuidline');
    Route::post('/upload-host-guidline', 'UploadHostGuidline');
    Route::get('/edit-host-guidline/{id}', 'EditHostGuidline');
    Route::post('/update-host-guidline', 'UpdateHostGuidline');
    Route::get('/delete-host-guidline/{id}', 'DeleteHostGuidline');
    // Host Guidline ===========
    // Top Seller Set ===========
    Route::get('/admin-top-seller', 'AdminTopSeller');
    Route::post('/update-top-seller-re', 'UpdateTopSellerRe');
    Route::get('/admin-services-sorting', 'AdminServicesSorting');
    Route::post('/update-services-sorting-re', 'UpdateServicesSortingRe');
    Route::get('/admin-commission-set', 'AdminCommissionSet');
    Route::post('/update-commission-re', 'UpdateCommissionRe');
    Route::post('/update-buyer-commission-re', 'UpdateBuyerCommissionRe');
    // Top Seller Set ===========

});



// ============ MAIN COMMISSION SETTINGS ============
Route::get('/admin/commission-settings', [CommissionController::class, 'AdminCommissionSet'])
    ->name('admin.commission.settings');

// Update default seller commission
Route::post('/update-commission-re', [CommissionController::class, 'UpdateCommissionRate'])
    ->name('admin.commission.update');

// Update buyer commission
Route::post('/update-buyer-commission-re', [CommissionController::class, 'UpdateBuyerCommissionRate'])
    ->name('admin.buyer.commission.update');

// Update currency settings
Route::post('/update-currency-settings', [CommissionController::class, 'UpdateCurrencySettings'])
    ->name('admin.currency.update');

// ============ TOGGLE FEATURES ============
Route::post('/admin/toggle-custom-seller-commission', [CommissionController::class, 'ToggleCustomSellerCommission'])
    ->name('admin.toggle.seller.commission');

Route::post('/admin/toggle-custom-service-commission', [CommissionController::class, 'ToggleCustomServiceCommission'])
    ->name('admin.toggle.service.commission');

// ============ MANAGE CUSTOM COMMISSIONS ============
Route::get('/admin/manage-seller-commissions', [CommissionController::class, 'ManageSellerCommissions'])
    ->name('admin.manage.seller.commissions');

Route::get('/admin/manage-service-commissions', [CommissionController::class, 'ManageServiceCommissions'])
    ->name('admin.manage.service.commissions');

// CRUD operations for seller commissions
Route::post('/admin/seller-commission/store', [CommissionController::class, 'StoreSellerCommission'])
    ->name('admin.seller.commission.store');

Route::post('/admin/seller-commission/update/{id}', [CommissionController::class, 'UpdateSellerCommission'])
    ->name('admin.seller.commission.update');

Route::delete('/admin/seller-commission/delete/{id}', [CommissionController::class, 'DeleteSellerCommission'])
    ->name('admin.seller.commission.delete');

// CRUD operations for service commissions
Route::post('/admin/service-commission/store', [CommissionController::class, 'StoreServiceCommission'])
    ->name('admin.service.commission.store');

Route::post('/admin/service-commission/update/{id}', [CommissionController::class, 'UpdateServiceCommission'])
    ->name('admin.service.commission.update');

Route::delete('/admin/service-commission/delete/{id}', [CommissionController::class, 'DeleteServiceCommission'])
    ->name('admin.service.commission.delete');

// Commission Report/Dashboard
Route::get('/admin/commission-report', [CommissionController::class, 'CommissionReport'])
    ->name('admin.commission.report');

// Export routes
//Route::get('/admin/commission-report/export/csv', [CommissionController::class, 'ExportCSV'])
//    ->name('admin.commission.export.csv');
//
//Route::get('/admin/commission-report/export/pdf', [CommissionController::class, 'ExportPDF'])
//    ->name('admin.commission.export.pdf');
//
//Route::get('/admin/commission-report/export/excel', [CommissionController::class, 'ExportExcel'])
//    ->name('admin.commission.export.excel');



// Transaction Details & Actions
Route::get('/admin/transaction/details/{id}', [CommissionController::class, 'TransactionDetails'])
    ->name('admin.transaction.details');

Route::post('/admin/transaction/mark-payout-completed/{id}', [CommissionController::class, 'MarkPayoutCompleted'])
    ->name('admin.transaction.payout.complete');

Route::post('/admin/transaction/refund/{id}', [CommissionController::class, 'ProcessRefund'])
    ->name('admin.transaction.refund');

// Export Routes (already added earlier, but here for reference)
Route::get('/admin/commission-report/export/csv', [CommissionController::class, 'ExportCSV'])
    ->name('admin.commission.export.csv');

Route::get('/admin/commission-report/export/pdf', [CommissionController::class, 'ExportPDF'])
    ->name('admin.commission.export.pdf');

Route::get('/admin/commission-report/export/excel', [CommissionController::class, 'ExportExcel'])
    ->name('admin.commission.export.excel');

// Optional: Print receipt & Download invoice
Route::get('/admin/commission-report/print/{id}', [CommissionController::class, 'PrintReceipt'])
    ->name('admin.transaction.print');

Route::get('/admin/commission-report/download-invoice/{id}', [CommissionController::class, 'DownloadInvoice'])
    ->name('admin.transaction.invoice');


// ============ ADMIN WITHDRAWAL MANAGEMENT ROUTES ============
Route::get('/admin/withdrawals', [AdminWithdrawalController::class, 'index'])
    ->name('admin.withdrawals.index');
Route::get('/admin/withdrawals/export', [AdminWithdrawalController::class, 'export'])
    ->name('admin.withdrawals.export');
Route::get('/admin/withdrawals/{id}', [AdminWithdrawalController::class, 'show'])
    ->name('admin.withdrawals.show');
Route::post('/admin/withdrawals/{id}/processing', [AdminWithdrawalController::class, 'markProcessing'])
    ->name('admin.withdrawals.processing');
Route::post('/admin/withdrawals/{id}/complete', [AdminWithdrawalController::class, 'complete'])
    ->name('admin.withdrawals.complete');
Route::post('/admin/withdrawals/{id}/reject', [AdminWithdrawalController::class, 'reject'])
    ->name('admin.withdrawals.reject');
Route::post('/admin/withdrawals/bulk', [AdminWithdrawalController::class, 'bulkProcess'])
    ->name('admin.withdrawals.bulk');


Route::controller(AnalyticsController::class)->group(function () {
    // Main analytics dashboard
    Route::get('/admin/analytics', 'dashboard')->name('admin.analytics.dashboard');

    // AJAX API endpoints for dynamic data updates
    Route::get('/admin/analytics/api/countries', 'apiCountries')->name('admin.analytics.api.countries');
    Route::get('/admin/analytics/api/pages', 'apiPages')->name('admin.analytics.api.pages');
    Route::get('/admin/analytics/api/referrers', 'apiReferrers')->name('admin.analytics.api.referrers');
    Route::get('/admin/analytics/api/browsers', 'apiBrowsers')->name('admin.analytics.api.browsers');
    Route::get('/admin/analytics/api/overview', 'apiOverview')->name('admin.analytics.api.overview');
    Route::get('/admin/analytics/api/realtime', 'apiRealtime')->name('admin.analytics.api.realtime');

    // Cache management
    Route::post('/admin/analytics/cache/clear', 'clearCache')->name('admin.analytics.cache.clear');
});

Route::get('/admin/coupons', [CouponController::class, 'index'])->name('admin.coupons.index');
Route::get('/admin/coupons/analytics', [CouponController::class, 'analytics'])->name('admin.coupons.analytics');

// Create Coupon
Route::get('/admin/coupons/create', [CouponController::class, 'create'])->name('admin.coupons.create');
Route::post('/admin/coupons', [CouponController::class, 'store'])->name('admin.coupons.store');

// View Coupon Details
Route::get('/admin/coupons/{id}', [CouponController::class, 'show'])->name('admin.coupons.show');

// Edit Coupon
Route::get('/admin/coupons/{id}/edit', [CouponController::class, 'edit'])->name('admin.coupons.edit');
Route::put('/admin/coupons/{id}', [CouponController::class, 'update'])->name('admin.coupons.update');

// Delete Coupon
Route::delete('/admin/coupons/{id}', [CouponController::class, 'destroy'])->name('admin.coupons.destroy');

// Toggle Coupon Status
Route::get('/admin/coupons/{id}/toggle', [CouponController::class, 'toggleStatus'])->name('admin.coupons.toggle');

// AJAX Coupon Validation (for checkout)
Route::post('/api/validate-coupon', [CouponController::class, 'validateCoupon'])->name('api.coupon.validate');


Route::controller(TeacherController::class)->group(function () {
    Route::get('/teacher-dashboard', 'TeacherDashboard')->name('teacher.dashboard'); // FIX LOG-3: Added route name
    // Dashboard AJAX endpoints
    Route::get('/teacher-dashboard/statistics', 'getDashboardStatistics');
    Route::get('/teacher-dashboard/earnings-trend', 'getEarningsTrendChart');
    Route::get('/teacher-dashboard/order-status-chart', 'getOrderStatusChart');
    Route::get('/teacher-faqs', 'TeacherFaqs');
    // Teacher Profile =======
    Route::get('/teacher-profile', 'TeacherProfile');
    Route::post('/teacher-profile-update', 'TeacherProfileUpdate');
    Route::post('/teacher-location-update', 'TeacherLocationUpdate');
    Route::get('/teacher-add-new-category/{id}', 'TeacherAddNewCategory');
    Route::post('/get-services-for-teacher', 'GetServicesForTeacher');
    Route::post('/teacher-add-category-request', 'TeacherAddCategoryRequest');
    Route::post('/teacher-update-service-type', 'TeacherUpdateServiceType');
    Route::get('/teacher-add-faq', 'TeacherAddFaq');
    Route::post('/teacher-upload-faq', 'TeacherUploadFaq');
    Route::get('/teacher-edit-faq/{id}', 'TeacherEditFaq');
    Route::post('/teacher-update-faq', 'TeacherUpdateFaq');
    Route::get('/teacher-faq-remove/{id}', 'TeacherFaqRemove');
    // Teacher Profile ========
    Route::get('/host-guidline', 'HostGuidline');
    Route::get('/host-heading/{id}', 'HostHeading');
    Route::get('/teacher-contact-us', 'TeacherContactUs');
    // Notes&Calender ===
    Route::get('/teacher-notes-calender', 'TeacherNotesCalender');
    Route::get('/teacher-calendar', 'TeacherCalenderindex');
    Route::post('/teacher-calendar', 'TeacherCalenderstore');
    Route::put('/teacher-calendar/{id}', 'TeacherCalenderupdate');
    Route::delete('/teacher-calendar/{id}', 'TeacherCalenderdestroy');

    Route::get('/teacher-reviews', 'getAllReviews');
    Route::get('/teacher-get-single-reviews/{review_id}', 'getSingleReview');
    Route::post('/teacher-store-reply', 'storeReply');
    Route::post('/teacher-update-reply/{id}', 'updateReply');
    Route::get('/teacher-delete-reply/{id}', 'deleteReply');
    Route::post('/teacher-report-review', 'reportReview');


    // Notes&Calender ===
});


Route::controller(ClassManagementController::class)->group(function () {
    Route::get('/class-management', 'ClassManagement');
    Route::get('/class-management-services', 'ClassManagementServices')->name('class-management-services');
    Route::get('/class-service-select', 'ClassServiceSelect');
    Route::post('/select-service-type', 'SelectServiceType');
    Route::post('/get-class-manage-sub-cates', 'GetClassManageSubCates');
    Route::get('/class-payment-set', 'ClassPaymentSet');
    Route::post('/class-gig-data-upload', 'ClassGigDataUpload');
    Route::post('/class-gig-payment-upload', 'ClassGigPaymentUpload');
    // Course Video Upload ====
    Route::post('/teacher-course-video-upload', 'CourseVideoUpload');
    Route::post('/teacher-course-video-delete', 'CourseVideoDelete');
    // Course Video Upload ====
    // Resources File Upload ====
    Route::post('/teacher-resource-upload', 'TeacherResourceUpload');
    Route::post('/teacher-resource-delete', 'TeacherResourceDelete');
    // Resources File Upload ====
    // Services Action Routes ====
    Route::get('/teacher-gig-action/{id}/{action}', 'TeacherGigAction');
    Route::get('/teacher-service-edit/{id}/{action}', 'TeacherServiceEdit');
    // Update =
    Route::post('/class-gig-data-update', 'ClassGigDataUpdate');
    Route::get('/class-payment-edit', 'ClassPaymentEdit');
    Route::post('/class-gig-payment-update', 'ClassGigPaymentUpdate');
    // Update =

    // Services Faqs ============
    Route::post('/get-faqs-service', 'GetFaqsServices');
    Route::post('/upload-faqs-services', 'UploadFaqsServices');
    Route::post('/delete-faqs-services', 'DeleteFaqsServices');
    Route::post('/updated-faqs-services', 'UpdatedFaqsServices');
    // Services Faqs ============
    // Services Action Routes ====
});


Route::controller(OrderManagementController::class)->group(function () {
    Route::get('/order-management', 'OrderManagement');
    Route::get('/client-management', 'ClientManagement');

    // Order Details Routes =========
    Route::get('/admin/order-details/{id}', 'adminOrderDetails')->name('admin.order.details');
    Route::get('/teacher/order-details/{id}', 'teacherOrderDetails')->name('teacher.order.details');
    Route::get('/user/order-details/{id}', 'userOrderDetails')->name('user.order.details');
    // Order Details Routes END =========

    // Order Actions Routes Start =========
    Route::get('/active-order/{id}', 'ActiveOrder'); // transactions_update
    Route::get('/reject-order/{id}', 'RejectOrder'); // reject pending order
    Route::post('/cancel-order', 'CancelOrder'); // transactions_update
    Route::get('/cancel-subscription/preview/{orderId}', 'CancelSubscriptionPreview'); // Get cancellation preview
    Route::post('/cancel-subscription', 'CancelSubscription'); // Cancel subscription order
    Route::get('/deliver-order/{id}', 'DeliverOrder'); // transactions_update
    Route::post('/freelance-order-deliver', 'FreelanceOrderDeliver'); // transactions_update

    // User Reshedule Route =====
    Route::get('/user-reschedule/{id}', 'UserResheduleClass');
    Route::post('/user-update-classes', 'UpdateUserResheduleClass');
    // Teacher Reshedule Route =====
    Route::get('/teacher-reschedule/{id}', 'TeacherResheduleClass');
    Route::post('/teacher-update-classes', 'UpdateTeacherResheduleClass');
    // Accept Reject Reschedule Route =====
    Route::get('/accept-reschedule/{id}', 'AcceptResheduleClass');
    Route::get('/reject-reschedule/{id}', 'RejectResheduleClass');

    // Dispute Order ==========
    Route::post('/dispute-order', 'DisputeOrder')->name('DisputeOrder');
    Route::get('/back-to-active/{id}', 'BackToActive');
    Route::post('/unsetissfied-delivery', 'UnSetisfiedDelivery');
    Route::post('/accept-disputed-order', 'AcceptDisputedOrder')->name('AcceptDisputedOrder');
    Route::get('/start-job-active/{id}', 'StartJobActive');
    Route::get('/reviews', 'getAllReviews');
    Route::post('/submit-review', 'SubmitReview');
    Route::get('/delete-review/{review_id}', 'deleteReview');
    Route::get('/get-single-reviews/{review_id}', 'getSingleReview');
    Route::put('/reviews/{review_id}', 'updateReview');
    // Order Actions Routes END =========
});


Route::controller(UserController::class)->group(function () {
    Route::get('/user-dashboard', 'UserDashboard')->name('user.dashboard'); // FIX LOG-3 & LOG-4: Added route name
    Route::get('/user-faqs', 'UserFaqs');
    Route::get('/change-password', 'ChangePassword');
    Route::get('/profile', 'profile');
    Route::post('/profile/update', 'update')->name('profile.update');
    Route::get('/change-email', 'ChangeEmail');
    Route::get('/change-card-detail', 'ChangeCardDetail');
    Route::post('/delete-account', 'DeleteAccount');
    Route::get('/user-contact-us', 'UserContactUs');
    Route::post('/contact-mail', 'ContactMail');
    Route::get('/wish-list', 'WishList');
    Route::get('/remove-wish-list/{id}', 'RemoveWishList');


});


Route::controller(MessagesController::class)->group(function () {
    // User Chat
    Route::get('/user-messages', 'UserMessagesHome');
    Route::post('/user-fetch-message', 'FetchMessages');
    Route::post('/user-send-sms', 'SendSMS');
    Route::post('/send-sms-single', 'SendSMSSingle');
    Route::post('/user-send-message', 'SendMessage');
    Route::post('/user-open-chat', 'OpenChat');

    // Teacher Chat
    Route::get('/teacher-messages', 'TeacherMessagesHome');
    Route::post('/teacher-fetch-message', 'TeacherFetchMessages');
    Route::post('/teacher-send-message', 'TeacherSendMessage');
    Route::post('/teacher-open-chat', 'TeacherOpenChat');


    // Teacher Chat
    Route::get('/admin-messages', 'AdminMessagesHome');
    Route::post('/admin-fetch-message', 'AdminFetchMessages');
    Route::post('/admin-send-message', 'AdminSendMessage');
    Route::post('/admin-open-chat', 'AdminOpenChat');

    // Notes Routes ====
    Route::post('/add-notes', 'AddNotes');
    Route::post('/delete-notes', 'DeleteNotes');
    Route::post('/update-notes', 'UpdateNotes');

    // Block User Route
    Route::post('/block-user', 'BlockUser');

    // Search Message Route
    Route::post('/search-message', 'SearchMessage');

    // Custom Offer Routes ======
    Route::post('/get-services-for-custom', 'GetServicesForCustom');
    Route::post('/custom-offers', 'sendCustomOffer')->name('custom-offers.send');
    Route::get('/custom-offers/{id}', 'viewCustomOffer')->name('custom-offers.view');
    Route::post('/custom-offers/{id}/accept', 'acceptCustomOffer')->name('custom-offers.accept');
    Route::post('/custom-offers/{id}/reject', 'rejectCustomOffer')->name('custom-offers.reject');

    Route::get('/messages/unread-count/{userId}', 'getUnreadMessageCount');

});


use App\Http\Controllers\TransactionController;

// ============ SELLER/TEACHER TRANSACTION ROUTES ============
Route::middleware(['auth'])->group(function () {

    // Seller Dashboard
    Route::get('/seller/transactions', [TransactionController::class, 'sellerTransactions'])
        ->name('seller.transactions');

    // Buyer Dashboard
    Route::get('/user/transactions', [TransactionController::class, 'buyerTransactions'])
        ->name('user.transactions');

    // Shared Routes (both seller and buyer)
    Route::get('/transaction/{id}', [TransactionController::class, 'viewTransaction'])
        ->name('transaction.details');

    // Buyer Invoice Download
    Route::get('/transaction/{id}/invoice', [TransactionController::class, 'downloadInvoice'])
        ->name('transaction.invoice');

    // Seller Invoice Download
    Route::get('/seller/transaction/{id}/invoice', [TransactionController::class, 'downloadSellerInvoice'])
        ->name('seller.transaction.invoice');

    // AJAX Filter
    Route::post('/transactions/filter', [TransactionController::class, 'filterTransactions'])
        ->name('transactions.filter');

    // ============ USER DASHBOARD AJAX ROUTES ============

    // Get dashboard statistics with date filters
    Route::post('/user/dashboard/statistics', [UserController::class, 'getDashboardStatistics'])
        ->name('user.dashboard.statistics');

    // Get chart data
    Route::get('/user/dashboard/chart-data', [UserController::class, 'getChartData'])
        ->name('user.dashboard.chart-data');

    // Get paginated transactions table
    Route::get('/user/dashboard/transactions', [UserController::class, 'getDashboardTransactions'])
        ->name('user.dashboard.transactions');

    // Export dashboard to PDF
    Route::post('/user/dashboard/export/pdf', [UserController::class, 'exportDashboardPDF'])
        ->name('user.dashboard.export.pdf');

    // Export dashboard to Excel
    Route::post('/user/dashboard/export/excel', [UserController::class, 'exportDashboardExcel'])
        ->name('user.dashboard.export.excel');

    // ============ SELLER EARNINGS & PAYOUTS ROUTES ============
    Route::get('/seller/earnings', [SellerEarningsController::class, 'index'])
        ->name('seller.earnings');
    Route::get('/seller/earnings/invoice/{id}', [SellerEarningsController::class, 'downloadInvoice'])
        ->name('seller.earnings.invoice');
    Route::get('/seller/earnings/export', [SellerEarningsController::class, 'exportReport'])
        ->name('seller.earnings.export');

    // ============ SELLER WITHDRAWAL ROUTES ============
    Route::get('/seller/withdrawal/request', [WithdrawalController::class, 'create'])
        ->name('seller.withdrawal.create');
    Route::post('/seller/withdrawal/request', [WithdrawalController::class, 'store'])
        ->name('seller.withdrawal.store');
    Route::post('/seller/withdrawal/{id}/cancel', [WithdrawalController::class, 'cancel'])
        ->name('seller.withdrawal.cancel');
    Route::get('/seller/withdrawal/history', [WithdrawalController::class, 'history'])
        ->name('seller.withdrawal.history');
    Route::post('/seller/payout-settings', [WithdrawalController::class, 'updatePayoutSettings'])
        ->name('seller.payout.settings.update');
});


// =====================================================
// ZOOM INTEGRATION ROUTES
// =====================================================

// Admin Zoom Settings Routes
Route::prefix('admin/zoom')->middleware('auth')->group(function () {
    Route::get('/settings', [ZoomSettingsController::class, 'index'])->name('admin.zoom.settings');
    Route::post('/settings/update', [ZoomSettingsController::class, 'update'])->name('admin.zoom.settings.update');
    Route::post('/settings/test-connection', [ZoomSettingsController::class, 'testConnection'])->name('admin.zoom.test');
    Route::get('/live-classes', [ZoomSettingsController::class, 'liveClasses'])->name('admin.zoom.live');
    Route::get('/live-classes/data', [ZoomSettingsController::class, 'liveClassesData'])->name('admin.zoom.live.data');
    Route::get('/audit-logs', [ZoomSettingsController::class, 'auditLogs'])->name('admin.zoom.audit');
    Route::get('/security-logs', [ZoomSettingsController::class, 'securityLogs'])->name('admin.zoom.security');
});

// Teacher/Seller Zoom OAuth Routes
Route::prefix('teacher/zoom')->middleware('auth')->group(function () {
    Route::get('/', [ZoomOAuthController::class, 'index'])->name('teacher.zoom.index');
    Route::get('/connect', [ZoomOAuthController::class, 'connect'])->name('teacher.zoom.connect');
    Route::get('/callback', [ZoomOAuthController::class, 'callback'])->name('teacher.zoom.callback');
    Route::post('/disconnect', [ZoomOAuthController::class, 'disconnect'])->name('teacher.zoom.disconnect');
    Route::post('/refresh', [ZoomOAuthController::class, 'refreshToken'])->name('teacher.zoom.refresh');
    Route::get('/status', [ZoomOAuthController::class, 'status'])->name('teacher.zoom.status');
});

// Zoom Join Routes (Public with token validation)
Route::prefix('join/class')->group(function () {
    Route::get('/{classDateId}', [ZoomJoinController::class, 'joinClass'])->name('zoom.join');
    Route::get('/{classDateId}/guest', [ZoomJoinController::class, 'guestJoin'])->name('zoom.join.guest');
    Route::get('/{classDateId}/page', [ZoomJoinController::class, 'joinPage'])->name('zoom.join.page');
});

// Teacher Meeting Start Route
Route::get('/teacher/meeting/{meetingId}/start', [ZoomJoinController::class, 'teacherStart'])
    ->middleware('auth')
    ->name('teacher.meeting.start');

// Zoom Webhook Route (No auth - signature verified in controller)
Route::post('/api/zoom/webhook', [ZoomWebhookController::class, 'handle'])->name('zoom.webhook');

// Zoom Webhook Test Route (Development only)
Route::post('/api/zoom/webhook/test', [ZoomWebhookController::class, 'test'])->name('zoom.webhook.test');

// Legacy Zoom Routes (Keep for backward compatibility if needed, or remove later)
// Route::get('/zoom/authorize', [ZoomController::class, 'redirectToZoom']);
// Route::get('/zoom/callback', [ZoomController::class, 'handleCallback']);
// Route::get('/zoom/create-meeting', [ZoomController::class, 'createMeeting']);

// =====================================================
// END ZOOM INTEGRATION ROUTES
// =====================================================

Route::post('stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);


Route::get('/test-token', function() {
    $classDate = \App\Models\ClassDate::find(45);
    $user = \App\Models\User::find(2);

    $tokenRecord = $classDate->generateSecureToken($user->id, $user->email);
    $joinUrl = url("/join/class/{$classDate->id}?token={$tokenRecord->plain_token}");

    return response()->json([
        'plain_token' => $tokenRecord->plain_token,
        'hashed_token_in_db' => $tokenRecord->token,
        'join_url' => $joinUrl,
    ]);
});
// =====================================================
// EMAIL TEMPLATE PREVIEW ROUTES (Development/Testing)
// =====================================================
use App\Http\Controllers\EmailTestController;

Route::prefix('test-emails')->group(function () {
    Route::get('/', [EmailTestController::class, 'index'])->name('email-test.index');
    Route::get('/{template}', [EmailTestController::class, 'preview'])->name('email-test.preview');
});

