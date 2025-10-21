<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::controller(AuthController::class)->group(function () {
    Route::post('/create-account', 'CreateAccount');
    Route::post('/login', 'Login');
    // Sign With Google ================
    Route::get('/google/redirect', 'redirectToGoogle')->name('google.redirect');
    Route::get('/google/callback', 'handleGoogleCallback')->name('google.callback');
    // Sign With Google ================
    //Start ==== With Facebook account =====
    Route::get('/facebook/redirect', 'facebookRedirect');
    Route::get('/auth/facebook/callback', 'facebookCallback');
    //End ==== With Facebook account =====
    Route::get('/logout', 'LogOut');
    Route::get('/switch-account', 'SwitchAccount');
    Route::get('/verify-email/{token}', 'VerifyEmail');
    Route::post('/forgot-password', 'ForgotPassword');
    Route::get('/forgot-password-verify/{token}', 'ForgotPasswordVerify');
    Route::post('/new-forgot-password', 'NewForgotPassword');

    // Get Current Location =====
    Route::get('/get-current-location', 'GetCurrentLocation');
    // Get Current Location =====
});


Route::controller(PublicWebController::class)->group(function () {
    Route::get('/', 'Index');
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
    Route::get('/admin-dashboard', 'AdminDashboard');
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
    // Admin Management =========
    Route::get('/admin-management', 'AdminManagement');
    Route::post('/create-admin', 'CreateAdmin');
    Route::post('/update-admin', 'UpdateAdmin');
    Route::get('/delete-admin/{id}', 'DeleteAdmin');
    Route::get('/block-admin/{id}', 'BlockAdmin');
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


Route::controller(TeacherController::class)->group(function () {
    Route::get('/teacher-dashboard', 'TeacherDashboard');
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
    // Order Actions Routes Start =========
    Route::get('/active-order/{id}', 'ActiveOrder');
    Route::post('/cancel-order', 'CancelOrder');
    Route::get('/deliver-order/{id}', 'DeliverOrder');
    Route::post('/freelance-order-deliver', 'FreelanceOrderDeliver');
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
    Route::post('/dispute-order', 'DisputeOrder');
    Route::get('/back-to-active/{id}', 'BackToActive');
    Route::post('/unsetissfied-delivery', 'UnSetisfiedDelivery');
    Route::get('/accept-disputed-order/{id}', 'AcceptDisputedOrder');
    Route::get('/start-job-active/{id}', 'StartJobActive');
    Route::get('/reviews', 'getAllReviews');
    Route::post('/submit-review', 'SubmitReview');
    Route::get('/delete-review/{review_id}', 'deleteReview');
    Route::get('/get-single-reviews/{review_id}', 'getSingleReview');
    Route::put('/reviews/{review_id}', 'updateReview');
    // Order Actions Routes END =========
});


Route::controller(UserController::class)->group(function () {
    Route::get('/user-dashboard', 'UserDashboard');
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

});