<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackagePurchaseListController;
use App\Http\Controllers\PaymentHistoryController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\AboutAppController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PushNotificationController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//core apis
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    //rank count
    
    Route::post('/make-rank', [RankController::class, 'makeRank']);
 

    //payment
    Route::post('/my-payments', [PaymentHistoryController::class, 'myallpayments']);
    Route::post('/make-payment', [PaymentHistoryController::class, 'makePayment']);
    Route::post('/purchase-package', [PackagePurchaseListController::class, 'purchasePackage']);
    //purchase list
    Route::get('/mypackage-list', [PackagePurchaseListController::class, 'getMyPurchasePackageList']);
    Route::get('/mypackage-list-id', [PackagePurchaseListController::class, 'getMyPurchasePackageIds']);
    //profile update
    Route::post('/profile-update', [AuthController::class, 'profileupdate']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //update performace
    Route::post('/add-performace', [AuthController::class, 'updatePerformance']);
    //fcm routes

Route::post('/store-device-token', [PushNotificationController::class, 'storeDeviceToken']);
});
Route::get('/get-exam-rank/{exam_id}', [RankController::class, 'getRanksOnExamId']);
// Package id to catagory
Route::get('/pack-id-category/{id}', [PackageController::class, 'getcata']);
Route::get('/category-id-subcategory/{id}', [PackageController::class, 'setsub']);
Route::get('/subcategory-id-exam/{id}', [PackageController::class, 'exam']);
Route::get('/exam-id-mcq/{id}', [PackageController::class, 'getmcq']);
Route::get('/all-package-list', [PackageController::class, 'getAllPackageList']);
Route::get('/about-us', [AboutAppController::class, 'getAbouts']);
Route::get('/notice', [NoticeController::class, 'getNotice']);


Route::post('/pustnoti', [PushNotificationController::class, 'sendNotification']);

