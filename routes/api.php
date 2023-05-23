<?php


use App\Http\Controllers\MovieController;
use App\Models\User;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('/movies',MovieController::class)->middleware('auth:sanctum');
Route::post('/tokens/create', function (Request $request) {
    $request->validate([
        'email'=>'required',
        'password'=>'required'
    ]);
    $user= User::whereEmail($request->email)->first();
    if($user){
        $token = $user->createToken('movies');
    }

    return ['token' => $token->plainTextToken];
});
