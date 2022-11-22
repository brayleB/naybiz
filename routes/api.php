<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LandlordController;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\RuleController;
use App\Http\Controllers\Api\TenantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//PUBLIC ROUTES
//auth
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

//tenant
Route::post('/tenant/add', [TenantController::class, 'createTenant']);

//questionaire
Route::post('/tenant/questionaire', [QuestionController::class, 'questionaire']);

//get user details
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 //get questions by landlord_id and defaults
 Route::post('/question/get', [QuestionController::class, 'getQuestionsByHoa']);

 //get rule by id
 Route::get('/rule/get/{rule}',[RuleController::class,'getRuleById']);

//get all HOA
Route::get('/hoa/get',[AuthController::class,'getAllHoa']);

 //get user by id
 Route::get('/user/get/{user}',[AuthController::class,'getUserById']);

// Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');

//AUTHENTICATED ROUTES
Route::group(['middleware'=>['auth:sanctum']], function(){
    //logout
    Route::post('/auth/logout',[AuthController::class,'logout']);
    //update user profile
    Route::post('/user/{user}',[AuthController::class,'updateUserProfile']);
    
    //add properties
    Route::post('/property/add', [PropertyController::class, 'addProperty']);
    //delete property
    Route::post('/property/delete', [PropertyController::class, 'deleteProperty']);
    //trash properties
    //Route::post('/property/trash', [PropertyController::class, 'trash']);
    //set property tenant
    Route::post('/property/tenant/set', [PropertyController::class, 'setTenant']);
    // get properties by landlord
    Route::post('/property/get', [PropertyController::class, 'getPropertyByLandlord']);
    //update property
    Route::post('/property/update', [PropertyController::class, 'update']);
    //get property by hoa
    Route::get('/property/get/hoa/available/{hoa}', [PropertyController::class, 'getPropertiesByHoaAvailable']);
    Route::get('/property/get/hoa/occupied/{hoa}', [PropertyController::class, 'getPropertiesByHoaOccupied']);

    //add question
    Route::post('/question/add', [QuestionController::class, 'createQuestions']);
    //delete question 
    Route::post('/question/delete', [QuestionController::class, 'deleteQuestion']);
    //set question status to trash
    //Route::post('/question/trash', [QuestionController::class, 'trash']);

    //get tenants by landlord_id
    Route::post('/tenant/get', [TenantController::class, 'getTenantsByLandlord']);
    //get tenants by landlord_id (requested)
    Route::post('/tenant/get/requested', [TenantController::class, 'getTenantsByLandlordRequested']);
    //get tenants by landlord_id (accepted)
    Route::post('/tenant/get/accepted', [TenantController::class, 'getTenantsByLandlordAccepted']);
    //update tenant status
    Route::post('/tenant/update', [TenantController::class, 'updateTenant']);
    //set tenant to accepted
    Route::post('/tenant/accept', [TenantController::class, 'toAccept']);
    //get by id
    Route::post('/tenant/get/id', [TenantController::class, 'getTenantById']);
    //get tenants by HOA
    Route::get('/tenant/get/hoa/requested/{hoa}', [TenantController::class, 'getTenantsByHoaRequested']);
    Route::get('/tenant/get/hoa/accepted/{hoa}', [TenantController::class, 'getTenantsByHoaAccepted']);
    //delete tenant
    Route::post('/tenant/delete', [TenantController::class, 'deleteTenant']);

    //add rule
    Route::post('/rule/add',[RuleController::class,'createRule']);

    // get landlords by HOA
    Route::get('/landlord/get/hoa/requested/{hoa}', [LandlordController::class, 'getLandlordsByHoaRequested']);
    Route::get('/landlord/get/hoa/accepted/{hoa}', [LandlordController::class, 'getLandlordsByHoaAccepted']);

    // mails
    Route::post('/invite/tenant', [MailController::class, 'inviteTenant']);
    Route::post('/invite/landlord', [MailController::class, 'inviteLandlord']);
});