<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Defect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GcaController;
use App\Http\Controllers\Api\PnaController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\QcosController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\QuizCategoryController;
use App\Http\Controllers\Api\UnitMovementController;
use App\Http\Controllers\Api\ApiScreenBoadController;
use App\Http\Controllers\appusers\AppUsersController;
use App\Http\Controllers\screenboard\ScreenboardController;

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

Route::middleware('auth:appUser')->get('/user', function (Request $request) {
    return $request->user();
});


        Route::group(['prefix' => 'user'], function () {

            //PNA
               Route::get('load_pna_data', [PnaController::class, 'load_pna_data']);
    Route::get('load_pna_data_by_model/{model_id}', [PnaController::class, 'load_pna_data_by_model']);
    Route::get('material_distribution_models', [PnaController::class, 'material_distribution_models']);


	    Route::group(['middleware' => ['auth:appUser']], function () {



	  	Route::get('home', [HomeController::class, 'apiHome']);
	  	Route::get('quizcategory/{id}/{model_id}/{vid}', [QuizCategoryController::class, 'quizcategory']);
	  	Route::get('quiz/{id}/{vid}/{shop_id}', [QuizController::class, 'quiz']);
	    Route::post('answerquery', [QuizController::class, 'answerquery']);
		 Route::post('answerquery2', [QuizController::class, 'answerquery2']);
	  	Route::get('loadquery/{cat_id}/{quiz_id}', [QuizController::class, 'loadquery']);
	  	Route::get('sheduledunits', [UnitMovementController::class, 'sheduledunits']);
	  	Route::post('moveunitfromstore', [UnitMovementController::class, 'moveunitfromstore']);
	  	Route::get('getcomponent/{route_id}/{vehicle_id}', [UnitMovementController::class, 'getcomponent']);
	    Route::post('moveunit', [UnitMovementController::class, 'moveunit']);
	    Route::get('qdefects/{vehicle_id}', [Defect::class, 'qdefects']);
	    Route::get('loaddefects/{defect_id}', [Defect::class, 'loaddefects']);
	    Route::get('unitswithdefects', [Defect::class, 'unitswithdefects']);
	    Route::post('correctdefect', [Defect::class, 'correctdefect']);
		Route::post('correctdefect2', [Defect::class, 'correctdefect2']);
		
	    Route::get('checkunitshop/{chasis}/{shop_id}', [UnitMovementController::class, 'checkunitshop']);

	     Route::post('profile/password/update', [AppUsersController::class,'password'])->name('password');

		 Route::get('unitsinshop/{shop_id}', [UnitMovementController::class, 'unitsinshop']);
		 Route::get('checktool/{tool_id}', [QcosController::class, 'checktool']);
		 Route::get('tooldetails/{toolid}', [QcosController::class, 'tooldetails']);
		 Route::get('validateunit/{vehicle_id}/{toolid}', [QcosController::class, 'validateunit']);
		 Route::get('loadvalidatedunits/{vehicle_id}/{toolid}', [QcosController::class, 'load_validated_units']);
		 Route::get('loadjoint/{vehicle_id}/{toolid}/{jointid}', [QcosController::class, 'load_joint']);
		 Route::post('checkqcos', [QcosController::class, 'checkqcos']);
		 Route::post('saveqcos', [QcosController::class, 'saveqcos']);
		 Route::get('loadmodelsfromtoolid/{toolid}', [QcosController::class, 'load_models_from_toolid']);
		 Route::get('loadvehicleformmodel/{vehicleid}', [QcosController::class, 'load_vehicle_form_model']);
		 Route::get('loadqcosactions', [QcosController::class, 'load_qcos_actions']);
		 Route::post('saveqcosaction', [QcosController::class, 'save_qcos_action']);
		 //PNA
		 Route::get('validateproduct/{case_number}', [ProductController::class, 'validateproduct']);
		 Route::get('listproductsscanned/{case_number}', [ProductController::class, 'listproductsscanned']);
		 //Gca
		 Route::get('validategcaunit/{chasis_number}/{unit_type}', [GcaController::class, 'validate_gca_unit']);
		 Route::get('loadgcacategory/{step_id}/{unit_type}/{vehicle_id}', [GcaController::class, 'load_gca_category']);
		 Route::get('loadgcaquery/{gca_audit_id}/{gca_query_id}/{vehicle_id}/{vehicle_type}', [GcaController::class, 'load_gca_query']);
		 Route::get('loadgcaqueryitem/{query_item_id}/template_id', [GcaController::class, 'load_gca_queryitem']);
		 Route::post('savegcarecord', [GcaController::class, 'savegcarecord']);
		 Route::get('loadGcaSteps/{gca_type}/{vehicle_id}', [GcaController::class, 'load_gca_steps']);
		 Route::get('loadZoneItems/{step_id}/{gca_type}', [GcaController::class, 'load_zone_items']);
		 Route::post('updateGcaStatus', [GcaController::class, 'updateGcaStatus']);
		 Route::get('loadgcaasactions', [GcaController::class, 'load_gca_actions']);
		 Route::post('savegcaaction', [GcaController::class, 'save_gca_action']);




















	  Route::get('profile', function (Request $request) {

	  	$master=array();
	  	$master['user']=$request->user();
	  	$master['shop']= $request->user()->shop;

             return $master;
        });




});

Route::post('apilogin', [AppUsersController::class,'login'])->name('apilogin');
Route::get('ApiLoadScreenboard', [ScreenboardController::class, 'screenboardindexReload']);
Route::get('ApiLoadShops', [ScreenboardController::class, 'ApiLoadShops']);
Route::get('ApiScreenboardpershopReload', [ScreenboardController::class, 'screenboardpershopReload']);


});



