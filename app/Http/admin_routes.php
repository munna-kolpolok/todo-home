<?php
/* ================== Language ================== */
Route::get('language/{locale}', 'LA\DashboardController@language');

/* ================== Homepage ================== */
//Route::get('/', 'LA\DashboardController@index');

/* ================== Homepage ================== */
Route::get('/session_info', 'LA\DashboardController@session_info');

//Route::get('/', 'HomeController@index');
//Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');


/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if (\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
    $as = config('laraadmin.adminRoute') . '.';

    // Routes for Laravel 5.3
    Route::get('/logout', 'Auth\LoginController@logout');
}

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

Route::group(['as' => $as, 'middleware' => ['auth', 'locale', 'revalidate']], function () {
    /* ================== Send Mail ================== */
    Route::resource(config('laraadmin.adminRoute') . '/send_mail', 'Admin\SendEmailController');
    Route::post(config('laraadmin.adminRoute') . '/send-donor-mail', 'Admin\SendEmailController@sendDonorMail');
    Route::post(config('laraadmin.adminRoute') . '/recipientWiseDonorLoad', 'Admin\SendEmailController@recipientWiseDonorLoad');

    /* ================== Dashboard ================== */
    Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
    Route::get(config('laraadmin.adminRoute') . '/dashboard/{id?}', 'LA\DashboardController@index');

    /* ================== Parent menu to sub menu ================== */
    Route::get(config('laraadmin.adminRoute') . '/module/{id}', 'LA\DashboardController@module');

    /* ================== Users ================== */
    Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
    Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');

    /* ================== Uploads ================== */
    Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
    Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
    Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
    Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
    Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
    Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
    Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');

    /* ================== Roles ================== */
    Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
    Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
    Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');

    /* ================== Role_Users ================== */
    Route::resource(config('laraadmin.adminRoute') . '/role_users', 'LA\Role_UsersController');
    Route::get(config('laraadmin.adminRoute') . '/role_user_dt_ajax', 'LA\Role_UsersController@dtajax');


    /* ================== Menu_Pemissions ================== */
    Route::resource(config('laraadmin.adminRoute') . '/menu_permissions',
        'Configuration\MenuPermissionController@index');
    Route::post(config('laraadmin.adminRoute') . '/store_role_permission', 'Configuration\MenuPermissionController@store');
    Route::post(config('laraadmin.adminRoute') . '/edit_role_permissions', 'Configuration\MenuPermissionController@action');


    /* ================== User_Levels ================== */
    Route::resource(config('laraadmin.adminRoute') . '/user_levels', 'LA\User_LevelsController');
    Route::get(config('laraadmin.adminRoute') . '/user_level_dt_ajax', 'LA\User_LevelsController@dtajax');

    /* ================== Religions ================== */
    Route::resource(config('laraadmin.adminRoute') . '/religions', 'LA\ReligionsController');
    Route::get(config('laraadmin.adminRoute') . '/religion_dt_ajax', 'LA\ReligionsController@dtajax');

    /* ================== Classes ================== */
    Route::resource(config('laraadmin.adminRoute') . '/classes', 'LA\ClassesController');
    Route::get(config('laraadmin.adminRoute') . '/class_dt_ajax', 'LA\ClassesController@dtajax');

    /* ================== Genders ================== */
    Route::resource(config('laraadmin.adminRoute') . '/genders', 'LA\GendersController');
    Route::get(config('laraadmin.adminRoute') . '/gender_dt_ajax', 'LA\GendersController@dtajax');

    /* ================== Sections ================== */
    Route::resource(config('laraadmin.adminRoute') . '/sections', 'LA\SectionsController');
    Route::get(config('laraadmin.adminRoute') . '/section_dt_ajax', 'LA\SectionsController@dtajax');


    /* ================== Scholarships ================== */
    Route::resource(config('laraadmin.adminRoute') . '/scholarships', 'Admin\ScholarshipsController');
    Route::get(config('laraadmin.adminRoute') . '/section_dt_ajax', 'LA\SectionsController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/scholarships/donations/{id}', 'Admin\ScholarshipsController@donations');

    Route::post(config('laraadmin.adminRoute') . '/scholarships/donation_save', 'Admin\ScholarshipsController@donation_save');
    Route::post(config('laraadmin.adminRoute') . '/studentWiseDonorLoad', 'Admin\ScholarshipsController@studentWiseDonorLoad');

    Route::post(config('laraadmin.adminRoute') . '/scholarships/donation_delete', 'Admin\ScholarshipsController@donation_delete');


    /* ================== Disabilities ================== */
    Route::resource(config('laraadmin.adminRoute') . '/disabilities', 'LA\DisabilitiesController');
    Route::get(config('laraadmin.adminRoute') . '/disability_dt_ajax', 'LA\DisabilitiesController@dtajax');

    /* ================== Students ================== */
    Route::resource(config('laraadmin.adminRoute') . '/students', 'Admin\StudentController');
    Route::get(config('laraadmin.adminRoute') . '/students/{id}/image', 'Admin\StudentController@image');
    Route::post(config('laraadmin.adminRoute') . '/students/{id}/updateImage', 'Admin\StudentController@updateImage');
    Route::get(config('laraadmin.adminRoute') . '/students/details/{id}', ['as' => 'students.details', 'uses' => 'Admin\StudentController@studentDetails']);
    Route::get(config('laraadmin.adminRoute') . '/students/details/{id}/{detail_id}', 'Admin\StudentController@detailUpdate');
    Route::delete(config('laraadmin.adminRoute') . '/students/details/destroy/{id}/{detail_id}', 'Admin\StudentController@detailDelete');
    Route::post(config('laraadmin.adminRoute') . '/students/details-store', 'Admin\StudentController@detailsStore');
    Route::post(config('laraadmin.adminRoute') . '/students/details-update', 'Admin\StudentController@detailUpdateStore');

    /* ================== Volunteer ================== */
    Route::resource(config('laraadmin.adminRoute') . '/volunteers', 'Admin\VolunteerController');


    /* ================== Projects ================== */
    Route::resource(config('laraadmin.adminRoute') . '/projects', 'Admin\ProjectController');
    Route::get(config('laraadmin.adminRoute') . '/projects/{id}/image', 'Admin\ProjectController@image');
    Route::post(config('laraadmin.adminRoute') . '/projects/{id}/updateImage', 'Admin\ProjectController@updateImage');
    Route::get(config('laraadmin.adminRoute') . '/projects/details/{id}', 'Admin\ProjectController@studentDetails')->name('projects.details');
    Route::get(config('laraadmin.adminRoute') . '/projects/details/{id}/{detail_id}', 'Admin\ProjectController@detailUpdate');
    Route::delete(config('laraadmin.adminRoute') . '/projects/details/destroy/{id}/{detail_id}', 'Admin\ProjectController@detailDelete');
    Route::post(config('laraadmin.adminRoute') . '/projects/details-store', 'Admin\ProjectController@detailsStore');
    Route::post(config('laraadmin.adminRoute') . '/projects/details-update', 'Admin\ProjectController@detailUpdateStore');
    Route::get(config('laraadmin.adminRoute') . '/projects/order/change', 'Admin\ProjectController@projectOrder');
    Route::post(config('laraadmin.adminRoute') . '/projects/project-order-update', 'Admin\ProjectController@projectOrderUpdate');

    /* ================== Projects  Images================== */
    Route::resource(config('laraadmin.adminRoute') . '/project_images', 'Admin\ProjectImagesController');
    Route::get(config('laraadmin.adminRoute') . '/project_images/order/change/{id}', 'Admin\ProjectImagesController@projectImageOrder');
    Route::post(config('laraadmin.adminRoute') . '/project_images/image-order-update', 'Admin\ProjectImagesController@projectImageOrderUpdate');

    /* ================== Campaign================== */
    Route::resource(config('laraadmin.adminRoute') . '/campaigns', 'Admin\CampaignController');
    Route::get(config('laraadmin.adminRoute') . '/campaigns/order/change', 'Admin\CampaignController@order');
    Route::post(config('laraadmin.adminRoute') . '/campaigns/order-update', 'Admin\CampaignController@orderUpdate');

    /* ================== Campaign Images================== */
    Route::resource(config('laraadmin.adminRoute') . '/camapaign_images', 'Admin\CampaignImagesController');
    Route::get(config('laraadmin.adminRoute') . '/camapaign_images/order/change/{id}', 'Admin\CampaignImagesController@order');
    Route::post(config('laraadmin.adminRoute') . '/camapaign_images/order-update', 'Admin\CampaignImagesController@orderUpdate');

    /* ================== Donor ================== */
    Route::resource(config('laraadmin.adminRoute') . '/donors', 'Admin\DonorController');

    /* ================== Scholarship_Donors ================== */
    Route::resource(config('laraadmin.adminRoute') . '/scholarship_donors', 'LA\Scholarship_DonorsController');
    Route::get(config('laraadmin.adminRoute') . '/scholarship_donor_dt_ajax', 'LA\Scholarship_DonorsController@dtajax');

    /* ================== Sectors ================== */
    Route::resource(config('laraadmin.adminRoute') . '/sectors', 'LA\SectorsController');
    Route::get(config('laraadmin.adminRoute') . '/sector_dt_ajax', 'LA\SectorsController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/sectors/order/change', 'LA\SectorsController@sectorOrder');
    Route::post(config('laraadmin.adminRoute') . '/sectors/sector-order-update', 'LA\SectorsController@sectorOrderUpdate');

    /* ================== Payment_Methods ================== */
    Route::resource(config('laraadmin.adminRoute') . '/payment_methods', 'LA\Payment_MethodsController');
    Route::get(config('laraadmin.adminRoute') . '/payment_method_dt_ajax', 'LA\Payment_MethodsController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/payment_methods/order/change', 'LA\Payment_MethodsController@paymentsOrder');
    Route::post(config('laraadmin.adminRoute') . '/payment_methods/payment-order-update', 'LA\Payment_MethodsController@paymentsOrderUpdate');

    /* ================== inboxes ================== */
    Route::resource(config('laraadmin.adminRoute') . '/inboxes', 'Admin\InboxesController');
    Route::get(config('laraadmin.adminRoute') . '/inboxes/{type}/{id}', 'Admin\InboxesController@show_inbox');
    Route::post(config('laraadmin.adminRoute') . '/inboxes/get_inboxes', 'Admin\InboxesController@getInboxes');

    Route::get(config('laraadmin.adminRoute') . '/inboxes_receipt/{id}', 'Admin\InboxesController@receipt');
    // Route::get(config('laraadmin.adminRoute') . '/inboxes/comments/{id}', 'Admin\InboxesController@commentsDependOnProject');

    Route::get(config('laraadmin.adminRoute') . '/inboxes/status/{status}/{id}', 'Admin\InboxesController@status');


    Route::get(config('laraadmin.adminRoute') . '/inboxes/{type}/{id}/{user_id}', 'Admin\InboxesController@sponsor');
    Route::post(config('laraadmin.adminRoute') . '/c_scholarship_store', 'Admin\InboxesController@c_scholarship_store');
    Route::get(config('laraadmin.adminRoute') . '/service/{type}/{id}/{user_id}', 'Admin\InboxesController@service');
    Route::post(config('laraadmin.adminRoute') . '/service_store', 'Admin\InboxesController@service_store');

    /* ================== Transaction ================== */
    Route::resource(config('laraadmin.adminRoute') . '/transactions', 'Admin\TransactionsController');
    Route::post(config('laraadmin.adminRoute') . '/transactions/get-inboxes', 'Admin\TransactionsController@getInboxs');
    Route::get(config('laraadmin.adminRoute') . '/transactions/details/{type}/{id}', 'Admin\TransactionsController@transactionDetail');
    Route::get(config('laraadmin.adminRoute') . '/transactions/download/{type}/{id}', 'Admin\TransactionsController@pdfDownload');

    /* ================== donations ================== */
    Route::resource(config('laraadmin.adminRoute') . '/donations', 'Admin\DonationsController');


    /* ================== Project_Types ================== */
    Route::resource(config('laraadmin.adminRoute') . '/project_types', 'LA\Project_TypesController');
    Route::get(config('laraadmin.adminRoute') . '/project_type_dt_ajax', 'LA\Project_TypesController@dtajax');

    /* ================== FAQs ================== */
    Route::resource(config('laraadmin.adminRoute') . '/faqs', 'LA\FAQsController');
    Route::get(config('laraadmin.adminRoute') . '/faq_dt_ajax', 'LA\FAQsController@dtajax');

    /* ================== Contacts ================== */
    Route::resource(config('laraadmin.adminRoute') . '/contacts', 'LA\ContactsController');
    Route::get(config('laraadmin.adminRoute') . '/contact_dt_ajax', 'LA\ContactsController@dtajax');

    /* ================== Donation_Amounts ================== */
    Route::resource(config('laraadmin.adminRoute') . '/donation_amounts', 'LA\Donation_AmountsController');
    Route::get(config('laraadmin.adminRoute') . '/donation_amount_dt_ajax', 'LA\Donation_AmountsController@dtajax');

    /* ================== Currencies ================== */
    Route::resource(config('laraadmin.adminRoute') . '/currencies', 'LA\CurrenciesController');
    Route::get(config('laraadmin.adminRoute') . '/currency_dt_ajax', 'LA\CurrenciesController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/currencies/order/change', 'LA\CurrenciesController@currenciesOrder');
    Route::post(config('laraadmin.adminRoute') . '/currencies/currencies-order-update', 'LA\CurrenciesController@currenciesOrderUpdate');

    /* ==================  Bidyanondo Site Settings ================== */
    Route::resource(config('laraadmin.adminRoute') . '/settings', 'Admin\SiteSettingController');
    Route::get(config('laraadmin.adminRoute') . '/bn_bidya_settings', 'Admin\SiteSettingController@bn_bidya_settings_index');

    /* ================== Payment list ================== */
    Route::resource(config('laraadmin.adminRoute') . '/paypal_payments', 'Admin\PaypalController');
    Route::resource(config('laraadmin.adminRoute') . '/ssl_payments', 'Admin\SslController');

    /* ================== Contact Message ================== */
    Route::resource(config('laraadmin.adminRoute') . '/contact_messages', 'Admin\ContactMessageController');

    /* ================== Scholarship Donation ================== */
    Route::get(config('laraadmin.adminRoute') . '/scholarship_donations', 'Admin\ScholarshipDonationController@index');


    /* ================== Video_Categories ================== */
    Route::resource(config('laraadmin.adminRoute') . '/video_categories', 'LA\Video_CategoriesController');
    Route::get(config('laraadmin.adminRoute') . '/video_category_dt_ajax', 'LA\Video_CategoriesController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/video_categories/order/change', 'LA\Video_CategoriesController@videoOrder');
    Route::post(config('laraadmin.adminRoute') . '/video_categories/food-projects-order-update', 'LA\Video_CategoriesController@videoOrderUpdate');

    /* ================== Press_Categories ================== */
    Route::resource(config('laraadmin.adminRoute') . '/press_categories', 'LA\Press_CategoriesController');
    Route::get(config('laraadmin.adminRoute') . '/press_category_dt_ajax', 'LA\Press_CategoriesController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/get_press_cat_ajax', 'LA\Press_CategoriesController@get_press_cat_ajax');
    Route::get(config('laraadmin.adminRoute') . '/press_categories/order/change', 'LA\Press_CategoriesController@pressOrder');
    Route::post(config('laraadmin.adminRoute') . '/press_categories/press-categories-order-update', 'LA\Press_CategoriesController@pressOrderUpdate');

    /* ================== Press ================== */
    Route::resource(config('laraadmin.adminRoute') . '/presses', 'Admin\PressController');
    Route::get(config('laraadmin.adminRoute') . '/presses/order/change', 'Admin\PressController@pressOrder');
    Route::post(config('laraadmin.adminRoute') . '/presses/press-order-update', 'Admin\PressController@pressOrderUpdate');

    /* ================== Videos ================== */
    Route::resource(config('laraadmin.adminRoute') . '/videos', 'Admin\VideosController');
    Route::resource(config('laraadmin.adminRoute') . '/get_video_cat_ajax', 'Admin\VideosController@get_video_cat_ajax');

    /* ================== Gallery_Categories ================== */
    Route::resource(config('laraadmin.adminRoute') . '/gallery_categories', 'LA\Gallery_CategoriesController');
    Route::get(config('laraadmin.adminRoute') . '/gallery_category_dt_ajax', 'LA\Gallery_CategoriesController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/gallery_categories/order/change', 'LA\Gallery_CategoriesController@galleryOrder');
    Route::post(config('laraadmin.adminRoute') . '/gallery_categories/gallery-categories-order-update', 'LA\Gallery_CategoriesController@galleryOrderUpdate');

    /* ================== Gallery ================== */
    Route::resource(config('laraadmin.adminRoute') . '/galleries', 'Admin\GalleryController');
    Route::get(config('laraadmin.adminRoute') . '/get_gallery_cat_ajax', 'Admin\GalleryController@get_gallery_cat_ajax');


    /* ================== Sliders ================== */
    Route::resource(config('laraadmin.adminRoute') . '/sliders', 'Admin\SlidersController');
    Route::get(config('laraadmin.adminRoute') . '/sliders/order/change', 'Admin\SlidersController@slidersOrder');
    Route::post(config('laraadmin.adminRoute') . '/sliders/sliders-order-update', 'Admin\SlidersController@slidersOrderUpdate');


    /* ================== Meals ================== */
    Route::resource(config('laraadmin.adminRoute') . '/meals', 'LA\MealsController');
    Route::get(config('laraadmin.adminRoute') . '/meal_dt_ajax', 'LA\MealsController@dtajax');

    /* ================== Food_Categories ================== */
    Route::resource(config('laraadmin.adminRoute') . '/food_categories', 'LA\Food_CategoriesController');
    Route::get(config('laraadmin.adminRoute') . '/food_category_dt_ajax', 'LA\Food_CategoriesController@dtajax');

    /* ================== Foods ================== */
    Route::resource(config('laraadmin.adminRoute') . '/foods', 'LA\FoodsController');
    Route::get(config('laraadmin.adminRoute') . '/food_dt_ajax', 'LA\FoodsController@dtajax');

    /* ================== Foods Projects================== */
    Route::resource(config('laraadmin.adminRoute') . '/food_projects', 'Admin\Foods_ProjectsController');
    Route::get(config('laraadmin.adminRoute') . '/food_projects_ajax', 'Admin\Foods_ProjectsController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/food_projects/order/change', 'Admin\Foods_ProjectsController@foodProjectOrder');
    Route::post(config('laraadmin.adminRoute') . '/food_projects/food-projects-order-update', 'Admin\Foods_ProjectsController@foodProjectOrderUpdate');

    /* ================== Person_Nos ================== */
    Route::resource(config('laraadmin.adminRoute') . '/person_nos', 'LA\Person_NosController');
    Route::get(config('laraadmin.adminRoute') . '/person_no_dt_ajax', 'LA\Person_NosController@dtajax');

    /* ================== Orphanges ================== */
    Route::resource(config('laraadmin.adminRoute') . '/orphanges', 'LA\OrphangesController');
    Route::get(config('laraadmin.adminRoute') . '/orphange_dt_ajax', 'LA\OrphangesController@dtajax');

    /* ================== Blood_Groups ================== */
    Route::resource(config('laraadmin.adminRoute') . '/blood_groups', 'LA\Blood_GroupsController');
    Route::get(config('laraadmin.adminRoute') . '/blood_group_dt_ajax', 'LA\Blood_GroupsController@dtajax');

    /* ================== Units ================== */
    Route::resource(config('laraadmin.adminRoute') . '/units', 'LA\UnitsController');
    Route::get(config('laraadmin.adminRoute') . '/unit_dt_ajax', 'LA\UnitsController@dtajax');

    /* ================== Food_Items ================== */
    Route::resource(config('laraadmin.adminRoute') . '/food_items', 'LA\Food_ItemsController');
    Route::get(config('laraadmin.adminRoute') . '/food_item_dt_ajax', 'LA\Food_ItemsController@dtajax');

    /* ================== Donation Packages ================== */
    Route::resource(config('laraadmin.adminRoute') . '/donation_packages', 'Admin\Donation_PackageController');

    /* ==================  1Taka Ahar Settings ================== */
    Route::resource(config('laraadmin.adminRoute') . '/ahar_settings', 'Admin\Ahar_SiteSettingController');
    Route::get(config('laraadmin.adminRoute') . '/bn_ahar_settings', 'Admin\Ahar_SiteSettingController@bn_ahar_settings');

	/* ================== Websites ================== */
	Route::resource(config('laraadmin.adminRoute') . '/websites', 'LA\WebsitesController');
	Route::get(config('laraadmin.adminRoute') . '/website_dt_ajax', 'LA\WebsitesController@dtajax');

	/* ================== Sr_Videos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/sr_videos', 'LA\Sr_VideosController');
	Route::get(config('laraadmin.adminRoute') . '/sr_video_dt_ajax', 'LA\Sr_VideosController@dtajax');

	/* ================== Languages ================== */
	Route::resource(config('laraadmin.adminRoute') . '/languages', 'LA\LanguagesController');
	Route::get(config('laraadmin.adminRoute') . '/language_dt_ajax', 'LA\LanguagesController@dtajax');


	/* ================== Sr_Donation_Amounts ================== */
	Route::resource(config('laraadmin.adminRoute') . '/sr_donation_amounts', 'LA\Sr_Donation_AmountsController');
	Route::get(config('laraadmin.adminRoute') . '/sr_donation_amount_dt_ajax', 'LA\Sr_Donation_AmountsController@dtajax');


    /*======================================================================================================================
                                        Save the refugee start
    =======================================================================================================================*/
   
        //Project story
        Route::resource(config('laraadmin.adminRoute') . '/sr_project_story', 'Admin\Save_Refugee\ProjectsStoryController');
        Route::resource(config('laraadmin.adminRoute') . '/sr_project_story_translation', 'Admin\Save_Refugee\ProjectStoryTranslationController');
        Route::post(config('laraadmin.adminRoute') . '/get-project-story-translation', 'Admin\Save_Refugee\ProjectStoryTranslationController@getTranslation');

        //Galleries
        Route::resource(config('laraadmin.adminRoute') . '/sr_galleries', 'Admin\Save_Refugee\GalleriesController');
        Route::resource(config('laraadmin.adminRoute') . '/sr_galleries_translation', 'Admin\Save_Refugee\GalleryTranslationsController');
        Route::resource(config('laraadmin.adminRoute') . '/get-gallery-translation', 'Admin\Save_Refugee\GalleryTranslationsController@getTranslation');
  

        //Projects
        Route::resource(config('laraadmin.adminRoute') . '/sr_projects', 'ProjectsController');
        Route::resource(config('laraadmin.adminRoute') . '/sr_projects_tranlation', 'ProjectsTrnaslationController');
        Route::post(config('laraadmin.adminRoute') . '/get-project-lang', 'ProjectsTrnaslationController@getProjectLang');

        //Sliders
        Route::resource(config('laraadmin.adminRoute') . '/sr_sliders', 'SlidersController');
        Route::resource(config('laraadmin.adminRoute') . '/sr_sliders_tranlation', 'SlidersTrnaslationController');
        Route::post(config('laraadmin.adminRoute') . '/get-slider-lang', 'SlidersTrnaslationController@getSliderLang');

        //Videos
        Route::resource(config('laraadmin.adminRoute') . '/sr_video', 'VideosController');
        Route::post(config('laraadmin.adminRoute') . '/get-video', 'VideosController@getVideo');

        //FAQs
        Route::resource(config('laraadmin.adminRoute') . '/sr_project_faqs', 'ProjectFaqController');
        Route::post(config('laraadmin.adminRoute') . '/get-faq', 'ProjectFaqController@getFaqData');

        //Project Slider
        Route::resource(config('laraadmin.adminRoute') . '/sr_project_sliders', 'ProjectSlidersController');
        Route::post(config('laraadmin.adminRoute') . '/get-project-slide-image', 'ProjectSlidersController@getProjectSlideImage');

        //Project Objectiove
        Route::resource(config('laraadmin.adminRoute') . '/sr_project_objectives', 'ProjectObjectivesController');
        Route::post(config('laraadmin.adminRoute') . '/get-project-obj', 'ProjectObjectivesController@getObjData');

        //Site Settings
        Route::resource(config('laraadmin.adminRoute') . '/sr_settings', 'SiteSettingController');
        Route::resource(config('laraadmin.adminRoute') . '/setting_languages', 'SiteSettingTranlationsController');
        //Route::post(config('laraadmin.adminRoute') . '/createLang', 'SiteSettingTranlationsController@createLang');


    

    /*======================================================================================================================
                                      Save the refugee end
    =======================================================================================================================*/


	/* ================== Latest_News ================== */
	Route::resource(config('laraadmin.adminRoute') . '/latest_news', 'LA\Latest_NewsController');
	Route::get(config('laraadmin.adminRoute') . '/latest_news_dt_ajax', 'LA\Latest_NewsController@dtajax');
    Route::get(config('laraadmin.adminRoute') . '/latest_news/order/change', 'LA\Latest_NewsController@newsOrder');
    Route::post(config('laraadmin.adminRoute') . '/latest_news/news-order-update', 'LA\Latest_NewsController@newsOrderUpdate');

	/* ================== Accounts ================== */
	Route::resource(config('laraadmin.adminRoute') . '/accounts', 'LA\AccountsController');
	Route::get(config('laraadmin.adminRoute') . '/account_dt_ajax', 'LA\AccountsController@dtajax');

	/* ================== Subscribers ================== */
	Route::resource(config('laraadmin.adminRoute') . '/subscribers', 'LA\SubscribersController');
	Route::get(config('laraadmin.adminRoute') . '/subscriber_dt_ajax', 'LA\SubscribersController@dtajax');


    /*======================================================================================================================
                                      Marriage Management start
    =======================================================================================================================*/
    /* ================== Applications ================== */
    Route::resource(config('laraadmin.adminRoute') . '/applications', 'Admin\Marriage_Management\ApplicationController');
    Route::get(config('laraadmin.adminRoute') . '/applications/{id}/need-verify/{status}', 'Admin\Marriage_Management\ApplicationController@verify');
    Route::get(config('laraadmin.adminRoute') . '/applications/{id}/show/{status}', 'Admin\Marriage_Management\ApplicationController@isShow');

    /* ================== Gift ================== */
    Route::resource(config('laraadmin.adminRoute') . '/gifts', 'Admin\Marriage_Management\GiftsController');
    Route::get(config('laraadmin.adminRoute') . '/gifts/order/change', 'Admin\Marriage_Management\GiftsController@order');
    Route::post(config('laraadmin.adminRoute') . '/gifts/order-update', 'Admin\Marriage_Management\GiftsController@orderUpdate');

    /* ================== Settings ================== */
    Route::resource(config('laraadmin.adminRoute') . '/wedding_settings', 'Admin\Marriage_Management\MarriageSettingController');

    /* ================== Slider ================== */
    Route::resource(config('laraadmin.adminRoute') . '/wedding_sliders', 'Admin\Marriage_Management\MarriageSliderController');
    Route::get(config('laraadmin.adminRoute') . '/wedding_sliders/order/change', 'Admin\Marriage_Management\MarriageSliderController@slidersOrder');
    Route::post(config('laraadmin.adminRoute') . '/wedding_sliders/sliders-order-update', 'Admin\Marriage_Management\MarriageSliderController@slidersOrderUpdate');

    /* ================== Gift Report ================== */
    Route::get(config('laraadmin.adminRoute') . '/gift_report/{id?}', 'Admin\Marriage_Management\GiftsReportController@gift_report');
    Route::post(config('laraadmin.adminRoute') . '/gift_donor_list', 'Admin\Marriage_Management\GiftsReportController@gift_donor_list');

    /* ================== Donation List ================== */
    Route::get(config('laraadmin.adminRoute') . '/donation_list/{id?}', 'Admin\Marriage_Management\DonationListController@donation_list');
    /*======================================================================================================================
                                      Marriage Management end
    =======================================================================================================================*/
});
