<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\MechanicController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ServiceDetailController;
use App\Http\Controllers\Api\V1\ServiceRegistrationController;
use App\Http\Controllers\Api\V1\SparepartController;
use App\Http\Controllers\Api\V1\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - MOTOVEL REST API v1
|--------------------------------------------------------------------------
|
| 35 Endpoints across 7 Core Resources:
| 1. /api/v1/customers        (GET, POST, GET {id}, PUT {id}, DELETE {id})
| 2. /api/v1/vehicles         (GET, POST, GET {id}, PUT {id}, DELETE {id})
| 3. /api/v1/mechanics        (GET, POST, GET {id}, PUT {id}, DELETE {id})
| 4. /api/v1/services         (GET, POST, GET {id}, PUT {id}, DELETE {id})
| 5. /api/v1/service-details  (GET, POST, GET {id}, PUT {id}, DELETE {id})
| 6. /api/v1/spareparts       (GET, POST, GET {id}, PUT {id}, DELETE {id})
| 7. /api/v1/payments         (GET, POST, GET {id}, PUT {id}, DELETE {id})
|
*/

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('vehicles', VehicleController::class);
    Route::apiResource('mechanics', MechanicController::class);
    Route::apiResource('services', ServiceRegistrationController::class);
    Route::apiResource('service-details', ServiceDetailController::class);
    Route::apiResource('spareparts', SparepartController::class);
    Route::apiResource('payments', PaymentController::class);
});
