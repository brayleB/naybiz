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
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\Api\Fileupload;
use App\Http\Controllers\Api\Payment;


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

 Route::post('/user/forgotpassword',[PasswordController::class,'forgotPassword']);
 Route::post('/user/resetpassword',[PasswordController::class,'resetPassword']);

 Route::get('/get/fileupload/{hoa}/{status}', [Fileupload::class, 'get_fileupload']);

// Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');

//AUTHENTICATED ROUTES
Route::group(['middleware'=>['auth:sanctum']], function(){
    //logout
    Route::post('/auth/logout',[AuthController::class,'logout']);   
    // change password
    Route::post('/user/changepassword',[PasswordController::class,'changePassword']);
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
    //remove property tenant
    Route::post('/property/tenant/remove', [PropertyController::class, 'removeTenant']);
    // get properties by landlord
    Route::post('/property/get', [PropertyController::class, 'getPropertyByLandlord']);
    //update property
    Route::post('/property/update', [PropertyController::class, 'update']);
    //get property by hoa
    Route::get('/property/get/hoa/available/{hoa}', [PropertyController::class, 'getPropertiesByHoaAvailable']);
    Route::get('/property/get/hoa/occupied/{hoa}', [PropertyController::class, 'getPropertiesByHoaOccupied']);
    Route::get('/property/view/{id}', [PropertyController::class, 'viewProperty']);

    //add question
    Route::post('/question/add', [QuestionController::class, 'createQuestions']);
    //delete question 
    Route::post('/question/delete', [QuestionController::class, 'deleteQuestion']);
    //update question 
    Route::post('/question/update', [QuestionController::class, 'updateQuestion']);
    //set question status to trash
    //Route::post('/question/trash', [QuestionController::class, 'trash']);

    //get tenants by landlord_id
    Route::post('/tenant/get', [TenantController::class, 'getTenantsByLandlord']);

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
    Route::get('/landlord/view/{id}', [LandlordController::class, 'viewLandLord']);

    // mails
    Route::post('/invite/tenant', [MailController::class, 'inviteTenant']);
    Route::post('/invite/landlord', [MailController::class, 'inviteLandlord']);
    
       //file upload
    Route::post('/fileupload', [Fileupload::class, 'store']);
   

});
 
//     // //get tenants by landlord_id (requested)
//     Route::post('/tenant/get/requested', [TenantController::class, 'getTenantsByLandlordRequested']);
//     // //get tenants by landlord_id (accepted)
//     Route::post('/tenant/get/accepted', [TenantController::class, 'getTenantsByLandlordAccepted']);

// Route::get('process-transaction/{trans_id}/{amount}', [PayPalController::class, 'processTransaction'])->name('processTransaction');
// Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
// Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');



Route::post('/getauth', [Payment::class, 'getauth'])->name('getauth');


Route::post('/create/product/subcription', [Payment::class, 'createProductSubcription'])->name('createProductSubcription');



Route::get('/detail/products', [Payment::class, 'showproductsDetail'])->name('showproductsDetail');



Route::get('/list/product/subcription', [Payment::class, 'listProductSubcription'])->name('createProductSubcription');


Route::post('/create/subcription/plan', [Payment::class, 'createSubcriptionPlan'])->name('createSubcriptionPlan');


Route::get('/list/subcription/plan', [Payment::class, 'listPlanSubcription'])->name('listPlanSubcription');


// Route::get('/detail/subcription/plan', [Payment::class, 'showSubcriptionDetail'])->name('showSubcriptionDetail');




Route::post('/deactivate/subcription/plan', [Payment::class, 'deactivatePlanSubcription'])->name('deactivatePlanSubcription');


Route::post('/subscribe/register', [Payment::class, 'subscribeRegister'])->name('subscribeRegister');



Route::get('/approve/registration', [Payment::class, 'subcriptionApprove'])->name('subcriptionApprove');


//require auth

Route::post('/trasaction/history', [Payment::class, 'trasactionhistoryuser'])->name('trasactionhistoryuser');


Route::post('/subcription/duedate', [Payment::class, 'paymentDuedate'])->name('paymentDuedate');




// Route::get('/list/trasaction', [Payment::class, 'Trasactionsubscription'])->name('Trasactionsubscription');




