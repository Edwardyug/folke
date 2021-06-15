<?php

use App\Http\Controllers\API\APICategoryController;
use App\Http\Controllers\API\APICityController;
use App\Http\Controllers\API\APIGetCity;
use App\Http\Controllers\API\APIMapMarkerController;
use App\Http\Controllers\API\APIPublicationDetailController;
use App\Http\Controllers\API\APItemplates_undercategory;
use App\Http\Controllers\API\APItemplatesCategoryController;
use App\Http\Controllers\API\APIUnderCategoryController;
use App\Http\Controllers\API\APIundercitiesController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\API\templates_properties_controller;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/city',[APICityController::class,'index']);

Route::apiResource('/categories', 'App\Http\Controllers\API\APICategoryController');
Route::apiResource('/publications/category', 'App\Http\Controllers\API\APIPublicationsListController');
Route::get('/publication/detail', [APIPublicationDetailController::class, 'index']);
//Route::apiResource('/publication/detail', 'App\Http\Controllers\API\APIPublicationDetailController');
Route::apiResource('/Advertising/city', 'App\Http\Controllers\API\APIAdvertisingController');

Route::get('getcity', [APIGetCity::class, 'GetCity']);
Route::get('GetUnderCategory', [APIUnderCategoryController::class, 'GetUnderCategory']);
Route::get('GetProperties', [templates_properties_controller::class, 'GetPropertiesFromUnderCategroy']);
Route::get('publications/getallmapmarkerfromcity',[APIMapMarkerController::class,'GetAllMapMarkerFromCity']);
Route::get('templatecategory',[APItemplatesCategoryController::class,'GetAllCategory']);
Route::get('templateundercategory',[APItemplates_undercategory::class,'index']);
Route::get('undercity',[APIundercitiesController::class,'index']);

Route::middleware('auth:api')->group(function (){

    //{admin
    Route::match(['post'],'/city', [APICityController::class,'store']);
    Route::match(['delete'],'/city', [APICityController::class,'destroy']);
    Route::match(['post'],'/categories', [APICategoryController::class,'store']);
    Route::match(['delete'],'/categories', [APICategoryController::class,'destroy']);
    Route::post('AddUndercategory', [APIUnderCategoryController::class, 'AddUnderCategory']);
    Route::delete('deleteundercategory', [APIUnderCategoryController::class, 'deleteUnderCategory']);
    Route::post('undercity',[APIundercitiesController::class,'store']);
    Route::delete('undercity',[APIundercitiesController::class,'destroy']);
    //admin}
    Route::post('GetUserInfo', [UserController::class, 'GetUserInfo']);
    Route::post('Publish', [APIPublicationDetailController::class, 'store']);
    Route::post('geteditpublication', [APIPublicationDetailController::class, 'edit']);
    Route::post('updatepublication', [APIPublicationDetailController::class, 'update']);
    Route::post('updateuser',[UserController::class,'UpdateUser']);

    //Route::post('insertcity',[])
});

Route::post('/register', 'App\Http\Controllers\API\RegisterController');
Route::post('/login', 'App\Http\Controllers\API\LoginController');
Route::post('/logout', 'App\Http\Controllers\API\LogoutController')->middleware('auth:api');
