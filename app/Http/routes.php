<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|fdd
*/
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


Route::get('/widget', function () {
    $inputs = Input::all();
    if (isset($inputs["company"]) && $inputs["company"] == "31743c95-4979-4739-a944-b06de7007843") {
        return redirect()->action('\Meritocracy\Http\Controllers\FrontendController@getMeritocracyBox', ["Moleskine", "40", "company"]);
    } elseif (isset($inputs["event"]) && $inputs["event"] != "56156048d4c6b16486ffdaab") {
        return redirect()->action('\Meritocracy\Http\Controllers\FrontendController@getMeritocracyBox', [str_replace('%2F', '%252F', urlencode(isset($inputs["utm_campaign"]) ? $inputs["utm_campaign"] : '')), $inputs["event"], "event"]);
    } else {
        return redirect("http://meritocracy.jobs/widget?" . http_build_query($inputs));
    }
});
Route::get('/v', function () {
    return currentVersion();
});
Route::get('/box-test', function () {
    return View::make('box-test', array("route" => "Box Test", "title" => "Box Test", "description" => ""));
});
Route::get('/get-visible-vacancies', function () {
    return make_get("https://api.meritocracy.is/api/vacancy?isVisible=true&status=1&count=true");
});
Route::get('/get-vacancies-active{params}', function ($params) {
    return make_get("https://api.meritocracy.is/api/vacancy?isActive=true&orderBy[]=openDate,DESC" . $params);
});
//Do not delete this
Route::get('/rand', function () {
    return "Online";
});


Route::get('/it/privacy', function () {

    return View::make('privacy-it', array("route" => "privacy", "title" => "Privacy", "description" => ""));

});


Route::get('/it/cookies', function () {

    return View::make('cookies-it', array("route" => "cookies", "title" => "Cookies", "description" => ""));

});

Route::get('/it/tos', function () {

    return View::make('tos-it', array("route" => "tos", "title" => "Tos", "description" => ""));

});


Route::get('/en/privacy', function () {

    return View::make('privacy-en', array("route" => "privacy", "title" => "Privacy", "description" => ""));

});


Route::get('/en/cookies', function () {

    return View::make('cookies-en', array("route" => "cookies", "title" => "Cookies", "description" => ""));

});

Route::get('/en/tos', function () {

    return View::make('tos-en', array("route" => "tos", "title" => "Tos", "description" => ""));

});
Route::get('/isLogged', function () {

    return response()->json(["message" => (string)Auth::check(), "mail" => (Auth::check()) ? Auth::user()->email : null, "name" => (Auth::check()) ? Auth::user()->first_name : null], 200);

});

Route::get('/profile', function () {

    return response()->redirectTo("/user");
});
Route::get('/close', function () {

    return View::make('logged-s1s1t1', array("route" => "close", "title" => "Close", "description" => ""));
});


/*
 * CRUD ROUTES START
 */
Route::get('/application/{id}', '\Meritocracy\Http\Controllers\CrudController@getApplication');

Route::patch('/company/{id}', '\Meritocracy\Http\Controllers\CrudController@patchCompany');
Route::patch('/company/{id}/sliders', '\Meritocracy\Http\Controllers\CrudController@patchSliderCompany');
Route::patch('/event/requestCv/{id}', '\Meritocracy\Http\Controllers\CrudController@requestCv');
Route::post('/event/comment/{applicationId}', '\Meritocracy\Http\Controllers\CrudController@addCommentApplication');
Route::patch('/event/{type}/{id}', '\Meritocracy\Http\Controllers\CrudController@updateEventApplication');
Route::patch('/user', '\Meritocracy\Http\Controllers\CrudController@patchUser');
Route::post('/company', '\Meritocracy\Http\Controllers\CrudController@createCompany');
Route::post('/sliders', '\Meritocracy\Http\Controllers\CrudController@createSlideCompany');
Route::post('/work-experience', '\Meritocracy\Http\Controllers\CrudController@createWorkExperience');
Route::post('/education', '\Meritocracy\Http\Controllers\CrudController@createEducation');
Route::patch('/education', '\Meritocracy\Http\Controllers\CrudController@updateEducation');
Route::post('/language', '\Meritocracy\Http\Controllers\CrudController@createLanguageUser');
Route::post('/attachment', '\Meritocracy\Http\Controllers\CrudController@createAttachment');
Route::post('/application/{id}', '\Meritocracy\Http\Controllers\CrudController@updateApplication');
Route::patch('/work-experience', '\Meritocracy\Http\Controllers\CrudController@updateWorkExperience');

Route::post('/register/{type}', '\Meritocracy\Http\Controllers\CrudController@registerUserOrCompanyUser');
Route::post('/contact/{type}', '\Meritocracy\Http\Controllers\CrudController@createContactRequest');

Route::get('/elimina/{type}/{id}', '\Meritocracy\Http\Controllers\CrudController@deleteEntity');
Route::delete('/event/comment/{id}', '\Meritocracy\Http\Controllers\CrudController@deleteCommentEvent');
Route::delete('/category/application/{id}', '\Meritocracy\Http\Controllers\CrudController@deleteApplicationFromCategory');
Route::get('/codice-sconto/search', '\Meritocracy\Http\Controllers\CrudController@searchCodiceSconto');

Route::post('/company/{id}/add-video', '\Meritocracy\Http\Controllers\CrudController@addVideo');
Route::post('/company/{id}/add-member', '\Meritocracy\Http\Controllers\CrudController@addMemberCompany');
Route::post('/company/{id}/add-benefit', '\Meritocracy\Http\Controllers\CrudController@addBenefit');

Route::post('/event/{type}', '\Meritocracy\Http\Controllers\CrudController@addEvent');
Route::patch('/company/member/{id}', '\Meritocracy\Http\Controllers\CrudController@updateMemberCompany');
Route::patch('/company/video/{id}', '\Meritocracy\Http\Controllers\CrudController@updateVideo');
Route::patch('/attachment/{id}', '\Meritocracy\Http\Controllers\FrontendController@updateAttachment');

Route::get('/vacancy/{id}/applications/wait-feedback/{type}', '\Meritocracy\Http\Controllers\CrudController@getWaitingFeedbackList');

/*
 * CRUD ROUTES END
 */


/*
 * SEARCH, ELASTIC, UTILITIES ROUTES START
 */

Route::get('/search/{routeName}', '\Meritocracy\Http\Controllers\UtilityController@search');

/*
 * SEARCH, ELASTIC, UTILITIES ROUTES END
 */


/*

 HR ROUTES START

 */
Route::post('/hr/feedback/{id}/remove', '\Meritocracy\Http\Controllers\HrController@removeFeedback');
Route::delete('/hr/category/{id}', '\Meritocracy\Http\Controllers\HrController@deteleCategory');
Route::get('/hr', '\Meritocracy\Http\Controllers\HrController@getHrDashboard');
Route::get('/hr/team', '\Meritocracy\Http\Controllers\HrController@getTeam');
Route::get('/hr/benefits', '\Meritocracy\Http\Controllers\HrController@getBenefitsView');
Route::get('/hr/benefits/list', '\Meritocracy\Http\Controllers\HrController@getBenefits');
Route::get('/hr/payments', '\Meritocracy\Http\Controllers\HrController@getPaymentsPage');
Route::get('/hr/billing-data', '\Meritocracy\Http\Controllers\HrController@getBillingDataPage');
Route::get('/hr/benefits/remove/{benefitId}/{companyId}', '\Meritocracy\Http\Controllers\HrController@removeBenefit');
Route::get('/hr/videos', '\Meritocracy\Http\Controllers\HrController@getVideos');
Route::get('/hr/photogallery', '\Meritocracy\Http\Controllers\HrController@getPhotogallery');
Route::get('/hr/archive-vacancies', '\Meritocracy\Http\Controllers\HrController@getArchiveVacancies');
Route::get('/hr/company-page', '\Meritocracy\Http\Controllers\HrController@getCompanyPage');
Route::get('/hr/company/vacancies', '\Meritocracy\Http\Controllers\HrController@getCompanyVacanciesList');
Route::get('/hr/application/{id}', '\Meritocracy\Http\Controllers\HrController@getApplicationDetail');
Route::get('/hr/application/{id}/cv', '\Meritocracy\Http\Controllers\HrController@getApplicationCv');
Route::post('/hr/application/{id}/{type}', '\Meritocracy\Http\Controllers\HrController@updateStatusApplication');
Route::post('/hr/feedback/add', '\Meritocracy\Http\Controllers\HrController@addFeedback');
Route::post('/hr/category/{id}/add', '\Meritocracy\Http\Controllers\HrController@addApplicationToCategory');
Route::post('/hr/category/add', '\Meritocracy\Http\Controllers\HrController@addCategory');
Route::post('/hr/job/add', '\Meritocracy\Http\Controllers\HrController@addVacancy');
Route::post('/hr/enqueue/complete-page', '\Meritocracy\Http\Controllers\HrController@enqueueCompletePage');
Route::post('/hr/{id}/open', '\Meritocracy\Http\Controllers\HrController@openVacancy');
Route::post('/hr/{id}/close', '\Meritocracy\Http\Controllers\HrController@closeVacancy');
Route::post('/hr/{id}/edit', '\Meritocracy\Http\Controllers\HrController@editVacancy');
Route::post('/hr/job/sort', '\Meritocracy\Http\Controllers\HrController@sortVacancies');
Route::get('/hr/{permalink}', '\Meritocracy\Http\Controllers\HrController@getHrVacancy');
Route::get('/hr/db/candidates/{id}', '\Meritocracy\Http\Controllers\HrController@getDbCandidates');
Route::get('/hr/db/categories', '\Meritocracy\Http\Controllers\HrController@getDbCategories');
Route::get('/hr/search-candidates/{filter}/{id}', '\Meritocracy\Http\Controllers\HrController@searchCandidates');
Route::get('/category/{id}/applications', '\Meritocracy\Http\Controllers\HrController@getApplicationsByCategory');
Route::get('/vacancy/{id}/applications/{type}', '\Meritocracy\Http\Controllers\HrController@getApplicationsByType');
Route::get('/cv/{id}', '\Meritocracy\Http\Controllers\HrController@getCv');
Route::get('/hr/vacancy/{id}', '\Meritocracy\Http\Controllers\HrController@getHrPartialVacancy');


/*

 HR ROUTES END

 */


/*
 *
 * ANALYTICS ROUTES START
 *
 *
 */

Route::get('/{type}/{id}/topScoreReferral', '\Meritocracy\Http\Controllers\AnalyticsController@getTopScoreReferral');
Route::get('/{type}/{id}/referral', '\Meritocracy\Http\Controllers\AnalyticsController@getReferral');
Route::get('/{type}/{id}/applications', '\Meritocracy\Http\Controllers\AnalyticsController@getApplicationsTrend');
Route::get('/analytics/{type}/compare', '\Meritocracy\Http\Controllers\AnalyticsController@compareApplicationsPeriods');
Route::get('/analytics', '\Meritocracy\Http\Controllers\AnalyticsController@getAnalytics');
Route::get('/company/{id}/analytics', '\Meritocracy\Http\Controllers\AnalyticsController@getCompanyAnalytics');

/*
 * SEARCH, ELASTIC, UTILITIES ROUTES END
 */


/*
 ADMIN ROUTES START
 */

Route::get('/admin/dashboard', '\Meritocracy\Http\Controllers\AdminController@getAdminDashboard');
Route::get('/admin/statistics', '\Meritocracy\Http\Controllers\AdminController@getStatisticsPage');
Route::get('/admin/codici-sconto', '\Meritocracy\Http\Controllers\AdminController@getCodiciScontoPage');
Route::post('/admin/codici-sconto', '\Meritocracy\Http\Controllers\AdminController@createCodiceSconto');
Route::patch('/admin/codici-sconto/{id}', '\Meritocracy\Http\Controllers\AdminController@updateCodiceSconto');

Route::get('/admin/tags', '\Meritocracy\Http\Controllers\AdminController@getTagsPage');
Route::get('/admin/tags/list', '\Meritocracy\Http\Controllers\AdminController@getTagsJson');
Route::get('/admin/{permalink}', '\Meritocracy\Http\Controllers\AdminController@getAdminCompany');
Route::get('/admin/{permalink}/statistics', '\Meritocracy\Http\Controllers\AdminController@getCompanyStatisticsPage');
Route::get('/admin/{company}/{permalink}', '\Meritocracy\Http\Controllers\AdminController@getAdminVacancy');
/*
 ADMIN ROUTES END
 */


/*
 AUTH ROUTES START
 */
Route::get('/auth/linkedin', '\Meritocracy\Http\Controllers\AuthController@getLinkedinAuth');
Route::get('/auth/linkedin/callback', '\Meritocracy\Http\Controllers\AuthController@getLinkedinCallback');

Route::get('/auth/facebook', '\Meritocracy\Http\Controllers\AuthController@getAuthFacebook');
Route::get('/auth/facebook/callback', '\Meritocracy\Http\Controllers\AuthController@getAuthFacebookCallback');
Route::post('/login', '\Meritocracy\Http\Controllers\AuthController@postLogin');
Route::post('/recover-password', '\Meritocracy\Http\Controllers\AuthController@postRecoverPassword');
Route::post('/password/reset', '\Meritocracy\Http\Controllers\AuthController@postPasswordReset');
Route::post('/password/modify', '\Meritocracy\Http\Controllers\AuthController@postPasswordModify');
Route::get('/password/reset/{token}', '\Meritocracy\Http\Controllers\AuthController@getPasswordReset');
Route::post('/password/recovery/{email}', '\Meritocracy\Http\Controllers\AuthController@passwordRecovery');
Route::get('/logout', '\Meritocracy\Http\Controllers\AuthController@logout');

/*
 AUTH ROUTES END
 */

/*
 USER ROUTES START
 */

Route::delete('/user/{id}/delete', '\Meritocracy\Http\Controllers\UserController@deleteUser');

Route::get('/user', '\Meritocracy\Http\Controllers\UserController@getUser');
Route::get('/user/dashboard', '\Meritocracy\Http\Controllers\UserController@getUserDashboard');
Route::get('/user/activities', '\Meritocracy\Http\Controllers\UserController@getUserActivities');
Route::get('/user/settings', '\Meritocracy\Http\Controllers\UserController@getUserSettings');
Route::get('/user/applications', '\Meritocracy\Http\Controllers\UserController@getUserApplications');
Route::get('/user/attachments', '\Meritocracy\Http\Controllers\UserController@getUserAttachments');
Route::get('/user/application/{appId}', '\Meritocracy\Http\Controllers\UserController@getUserApplicationDetail');
Route::get('/user/profile', '\Meritocracy\Http\Controllers\UserController@getUserProfile');
Route::get('/user/education', '\Meritocracy\Http\Controllers\UserController@getEducation');
Route::get('/user/work-experiences', '\Meritocracy\Http\Controllers\UserController@getWorkExperiences');
Route::get('/user/languages', '\Meritocracy\Http\Controllers\UserController@getLanguages');

Route::patch('/user/{id}', '\Meritocracy\Http\Controllers\UserController@updateUser');
Route::post('/user/setPushId', '\Meritocracy\Http\Controllers\UserController@setOneSignalPushId');
Route::get('/language/{id}', '\Meritocracy\Http\Controllers\UserController@getUserLanguage');
Route::get('/education/{id}', '\Meritocracy\Http\Controllers\UserController@getUserEducation');
Route::get('/work-experience/{id}', '\Meritocracy\Http\Controllers\UserController@getUserWorkExperience');

/*
 USER ROUTES END
 */

/*
 * FRONTEND ROUTES
 */


Route::group(['middleware' => 'auth'], function () {
    Route::post('/apply', '\Meritocracy\Http\Controllers\FrontendController@apply');
});

Route::get('/sitemap', '\Meritocracy\Http\Controllers\FrontendController@getSitemapXml');

Route::post('/checkout/paypal', '\Meritocracy\Http\Controllers\FrontendController@checkoutPaypal');
Route::get('/checkout/paypal/done', '\Meritocracy\Http\Controllers\FrontendController@getDone');
Route::get('/checkout/paypal/cancel', '\Meritocracy\Http\Controllers\FrontendController@getCancel');


Route::get('/statwolf', '\Meritocracy\Http\Controllers\FrontendController@getStatwolf');
Route::get('/sitemap.xml', '\Meritocracy\Http\Controllers\FrontendController@getSitemap');
Route::get('/signup', '\Meritocracy\Http\Controllers\FrontendController@redirectRegisterCompanyPage');
Route::get('/promotional/employer-brand', '\Meritocracy\Http\Controllers\FrontendController@getPromotionalEmployerBrand');
Route::get('/jobs-feed', '\Meritocracy\Http\Controllers\JobsFeedController@index');
Route::get('/jobs/feed', '\Meritocracy\Http\Controllers\JobsFeedController@index');

Route::get('/jobs-feed-trovit', '\Meritocracy\Http\Controllers\FrontendController@getJobsFeedTrovit');
Route::get('/email/{permalink}', '\Meritocracy\Http\Controllers\FrontendController@getEmailHtml');


Route::get('/l/attrai-nuovi-talenti', '\Meritocracy\Http\Controllers\FrontendController@getLandingAttraiTalenti');
Route::get('/l/attract-your-talents', '\Meritocracy\Http\Controllers\FrontendController@getLandingAttractTalents');

Route::get('/annunci-lavoro/citta/{city}', '\Meritocracy\Http\Controllers\FrontendController@getAnnunciLavoroCittaPage');
Route::get('/job-opportunities/location/{city}', '\Meritocracy\Http\Controllers\FrontendController@getAnnunciLavoroCittaPage');

Route::get('/annunci-lavoro/{city}/{permalink}', '\Meritocracy\Http\Controllers\FrontendController@getAnnunciLavoroCittaCategoriaPage');
Route::get('/job-opportunities/{city}/{permalink}', '\Meritocracy\Http\Controllers\FrontendController@getAnnunciLavoroCittaCategoriaPage');


Route::get('/annunci-lavoro/{permalink}', '\Meritocracy\Http\Controllers\FrontendController@getAnnunciLavoroPage');
Route::get('/job-opportunities/{permalink}', '\Meritocracy\Http\Controllers\FrontendController@getJobOpportunitiesPage');


Route::group([
    'middleware' => ['referer', 'localeSessionRedirect', 'localizationRedirect'],
    'prefix' => LaravelLocalization::setLocale()], function () {

    Route::get('/404', function () {
        return View::make('404', array("route" => "Error", "title" => "Page not found", "description" => "404", "whiteLogo" => 1));
    });
    Route::get('/500', function () {
        return View::make('500', array("route" => "Error", "title" => "Error 500", "description" => "", "whiteLogo" => 1));
    });

    Route::get('/redirect/{key}', '\Meritocracy\Http\Controllers\FrontendController@getRedirect');
    Route::get('/', '\Meritocracy\Http\Controllers\FrontendController@getHomepage');
    Route::get('/search', '\Meritocracy\Http\Controllers\FrontendController@getSearchPage');

    Route::get('/jobs', '\Meritocracy\Http\Controllers\FrontendController@getJobsPage');
    Route::get('/company', '\Meritocracy\Http\Controllers\FrontendController@getAreYouCompanyPage');
    Route::get('/manifesto', '\Meritocracy\Http\Controllers\FrontendController@getManifestoPage');
    Route::get('/application-thankyou', '\Meritocracy\Http\Controllers\FrontendController@getApplicationThankYouPage');
    Route::get('/user/wizard', '\Meritocracy\Http\Controllers\FrontendController@goToWizard');

    Route::get('/register/completed', '\Meritocracy\Http\Controllers\FrontendController@getRegistrationCompletedPage');
    Route::get('/technology', '\Meritocracy\Http\Controllers\FrontendController@getTechnologyPage');
    Route::get('/register/company', '\Meritocracy\Http\Controllers\FrontendController@getRegisterCompanyPage');
    Route::get('/register/user', '\Meritocracy\Http\Controllers\FrontendController@getRegisterUserPage');
    Route::get('/signup', '\Meritocracy\Http\Controllers\FrontendController@getRegisterUserPage');
    Route::get('/password/recovery', '\Meritocracy\Http\Controllers\FrontendController@getPasswordRecoveryPage');
    Route::get('/login', '\Meritocracy\Http\Controllers\AuthController@getLogin');

    Route::get('/get-home-companies/{all}', '\Meritocracy\Http\Controllers\FrontendController@getHomeCompanies');
    Route::get('/{company}/{permalink}', '\Meritocracy\Http\Controllers\FrontendController@getVacancyPage');
    Route::get('/{company}/{companyId}/{type}/vacancies/box', '\Meritocracy\Http\Controllers\FrontendController@getMeritocracyBox');
    Route::get('/{permalink}', '\Meritocracy\Http\Controllers\FrontendController@getCompanyPage');

});
