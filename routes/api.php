<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Laravel\Fortify\RoutePath;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


$limiter = config('fortify.limiters.login');
$twoFactorLimiter = config('fortify.limiters.two-factor');
$verificationLimiter = config('fortify.limiters.verification', '6,1');

Route::post(RoutePath::for('login', '/login'), [AuthenticatedSessionController::class, 'store'])
->middleware(array_filter([
    'guest:'.config('fortify.guard'),
    $limiter ? 'throttle:'.$limiter : null,
]));
Route::post(RoutePath::for('logout', '/logout'), [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::apiResource('/users', UserController::class);
    Route::get('/user', [UserController::class, 'getUser']);
    Route::post('/addavatar', [UserController::class, 'addavatar']);
});
