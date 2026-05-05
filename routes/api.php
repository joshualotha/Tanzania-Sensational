<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TrekkingRouteController;
use App\Http\Controllers\Api\DepartureController;
use App\Http\Controllers\Api\VisualAssetController;
use App\Http\Controllers\Api\SafariPackageController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PricingController;
use App\Http\Controllers\Api\GearItemsController;
use App\Http\Controllers\Api\GearRentalRequestController;
use App\Http\Controllers\Api\PagesController;

// Public Endpoints for the Frontend
Route::get('/visual-assets', [VisualAssetController::class, 'index']);
Route::get('/visual-assets/{key}', [VisualAssetController::class, 'show']);

Route::get('/trekking-routes', [TrekkingRouteController::class, 'index']);
Route::get('/trekking-routes/{identifier}', [TrekkingRouteController::class, 'show']);
Route::post('/contact', [\App\Http\Controllers\Api\ContactController::class, 'store'])
    ->middleware('throttle:10,1');

Route::get('/departures', [DepartureController::class, 'index']);
Route::get('/departures/{id}', [DepartureController::class, 'show']);

Route::get('/safari-packages', [SafariPackageController::class, 'index']);
Route::get('/safari-packages/{identifier}', [SafariPackageController::class, 'show']);

Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{identifier}', [DestinationController::class, 'show']);

Route::post('/bookings', [BookingController::class, 'store'])
    ->middleware('throttle:10,1');
Route::post('/bookings/safari', [BookingController::class, 'storeSafari'])
    ->middleware('throttle:10,1');

Route::get('/blog', [\App\Http\Controllers\Api\BlogController::class, 'index']);
Route::get('/blog/{slug}', [\App\Http\Controllers\Api\BlogController::class, 'show']);

Route::get('/pricing/trekking', [PricingController::class, 'trekking']);

Route::get('/gear-items', [GearItemsController::class, 'index']);
Route::post('/gear-rental-requests', [GearRentalRequestController::class, 'store'])
    ->middleware('throttle:10,1');

Route::get('/pages/{slug}', [PagesController::class, 'show']);

// Public settings endpoint (no auth required)
Route::get('/settings', [\App\Http\Controllers\Api\SiteSettingsController::class, 'publicIndex']);
