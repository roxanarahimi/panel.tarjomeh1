<?php

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


//Route::middleware('auth:admin')->group(function () {
//    Route::get('/panel/admin','currentAdmin');
//    Route::post('/panel/admin/logout','adminLogout');
//});


use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

//all
Route::controller(App\Http\Controllers\AuthController::class)->group(function () {
    Route::prefix('panel')->group(function () {
        Route::get('/user', 'currentUser');

        Route::get('/user/logout/{user}', 'logout');

        Route::post('/admin/login', 'login');
        Route::post('/admin/register', 'register');
        Route::post('/check/admin/token', 'updateLastActivity');

        Route::post('/user/login', 'login');
        Route::post('/user/register', 'register');
        Route::post('/check/user/token', 'updateLastActivity');
    });


    Route::post('/user/login', 'login');
    Route::post('/user/register', 'register');
    Route::post('/check/user/token', 'updateLastActivity');
    Route::get('/user/logout/{user}', 'logout');
    Route::post('/user/logout', 'logout');
});
Route::controller(App\Http\Controllers\UserController::class)->group(function () {

    Route::post('/update/user', 'updateProfile');
    Route::get('/user', 'indexUsers');
    Route::get('/admins', 'indexAdmins');
    Route::get('/user/{user}', 'show');
    Route::post('/user', 'store');
    Route::post('/user/{user}', 'update');
    Route::get('/delete/user/{user}', 'destroy');


    Route::get('/get/otp/{mobile}', 'getOtpNoRedis');//getOtp
    Route::post('/verify/otp', 'verifyOtp');
    Route::get('/login/otp/{user}', 'loginOtp');

    Route::get('/otp1', 'otp1');
    Route::get('/otp2', 'otp2');


    Route::prefix('panel')->group(function () {

        Route::post('/update/user', 'updateProfile');
        Route::get('/user', 'indexUsers');
        Route::get('/user/{user}', 'show');
        Route::post('/user', 'store');
        Route::post('/user/{user}', 'update');
        Route::post('/delete/user', 'destroy');

        Route::post('/update/admin', 'updateProfile');
        Route::get('/admin', 'indexAdmins');
        Route::get('/admin/{admin}', 'show');
        Route::post('/admin', 'store');
        Route::post('/admin/{admin}', 'update');
        Route::get('/delete/admin/{admin}', 'destroy');
    });
});
Route::controller(App\Http\Controllers\UserAddressController::class)->group(function () {

    Route::get('/address/user', 'index');
    Route::get('/address/user/{userAddress}', 'show');
    Route::post('/address/user', 'store');
    Route::post('/address/user/{clientAddress}', 'update');
    Route::post('/delete/address/user', 'destroy');

});
Route::controller(App\Http\Controllers\ArticleController::class)->group(function () {

    Route::get('/article', 'indexSite');
    Route::get('/article/{article}', 'show');
    Route::get('/latest/article', 'latestSite');

    Route::prefix('panel')->group(function () {

        Route::get('/article', 'index');
        Route::get('/article/{article}', 'show');
        Route::post('/article', 'store');
        Route::post('/article/{article}', 'update');
        Route::post('/delete/article', 'destroy');

        Route::get('/active/article/{article}', 'activeToggle');
        Route::get('/latest/article', 'latest');
    });
});
Route::controller(App\Http\Controllers\ArticleCategoryController::class)->group(function () {

    Route::get('/category/article', 'indexSite');
    Route::get('/category/article/{articleCategory}', 'show');

    Route::prefix('panel')->group(function () {
        Route::get('/category/article', 'index');
        Route::get('/category/article/{articleCategory}', 'show');
        Route::post('/category/article', 'store');
        Route::post('/category/article/{articleCategory}', 'update');
        Route::post('/delete/category/article', 'destroy');
        Route::get('/active/category/article/{articleCategory}', 'activeToggle');
    });
});
Route::controller(App\Http\Controllers\SlideController::class)->group(function () {

    Route::get('/slide', 'indexSite');
    Route::prefix('panel')->group(function () {
        Route::get('/slide', 'index');
        Route::get('/slide/{slide}', 'show');
        Route::post('/slide', 'store');
        Route::post('/slide/{slide}', 'update');
        Route::post('/delete/slide', 'destroy');
        Route::get('/active/slide/{slide}', 'activeToggle');
    });
});

Route::controller(App\Http\Controllers\ImageController::class)->group(function () {

    Route::prefix('panel')->group(function () {
//        Route::get('/icon', 'index');
//        Route::get('/icon/{icon}', 'show');
//        Route::post('/icon', 'store');
        Route::post('/icon', 'makeIconPack');
        Route::post('/upload/editor/image', 'uploadEditorImage');
//        Route::post('/panel/upload/editor/image',[\App\Http\Controllers\ImageController::class, 'uploadEditorImage']);

    });
});
//shop
Route::controller(App\Http\Controllers\ProductController::class)->group(function () {

    Route::get('/product', 'indexSite');
    Route::get('/product/{product}', 'show');
    Route::get('/latest/product', 'latestSite');
    Route::get('/stock/product', 'stockSite');
    Route::get('/sizes/product/{id}/{color}', 'getSizes');

    Route::prefix('panel')->group(function () {
        Route::get('/product', 'index');
        Route::get('/product/{product}', 'show');
        Route::post('/product', 'store');
        Route::post('/product/{product}', 'update');
        Route::get('/delete/product/{product}', 'destroy');

        Route::get('/active/product/{product}', 'activeToggle');
        Route::get('/latest/product', 'latest');

        Route::post('/images/reorder/product/{product}', 'updateOrder');
    });
});
Route::controller(App\Http\Controllers\ProductCategoryController::class)->group(function () {

    Route::get('/category/product', 'indexSite');
    Route::get('/category/product/{productCategory}', 'show');

    Route::prefix('panel')->group(function () {
        Route::get('/category/product', 'index');
        Route::get('/category/product/{productCategory}', 'show');
        Route::post('/category/product', 'store');
        Route::post('/category/product/{productCategory}', 'update');
        Route::post('/delete/category/product', 'destroy');
        Route::get('/active/category/product/{productCategory}', 'activeToggle');
    });
});
Route::controller(App\Http\Controllers\OrderController::class)->group(function () {

    Route::get('/order', 'index');
    Route::get('/order/{order}', 'show');
    Route::post('/order', 'store');
    Route::post('/order/{order}', 'update');
    Route::post('/delete/order', 'destroy');

    Route::post('/pay/order/{order}', 'userToGateway');
    Route::get('/verify/order/{order}', 'verify');
    Route::post('/confirm/order/{order}', 'confirm');

    Route::post('/remove/order/item/{orderItem}', 'removeItem');

    Route::post('/cancel/order', 'cancelByUser');
    Route::get('/userOrders/{user}', 'userOrders');

    Route::get('/cart/{user}', 'cart');
    Route::post('/item/quantity/update', 'updateItemQuantity');
    Route::post('/item/remove', 'removeItem');

    Route::prefix('panel')->group(function () {
        Route::get('/order', 'index');
        Route::get('/order/{order}', 'showPanel');
        Route::post('/order', 'store');
        Route::post('/order/{order}', 'update');
        Route::post('/delete/order', 'destroy');

    });
});
Route::controller(App\Http\Controllers\FinanceController::class)->group(function () {

    Route::prefix('panel')->group(function () {
        Route::get('/finance', 'index');
        Route::get('/finance/{finance}', 'show');
        Route::post('/finance', 'store');
        Route::post('/finance/{finance}', 'update');
        Route::post('/delete/finance', 'destroy');
//    Route::get('/active/finance/{finance}','activeToggle');

    });
});
//office
Route::controller(App\Http\Controllers\ProjectController::class)->group(function () {

    Route::prefix('panel')->group(function () {
        Route::get('/project', 'index');
        Route::get('/project/{project}', 'show');
        Route::post('/project', 'store');
        Route::post('/project/{project}', 'update');
        Route::get('/delete/project/{project}', 'destroy');
    });
});
Route::controller(App\Http\Controllers\ResumeController::class)->group(function () {
    Route::prefix('panel')->group(function () {
        Route::get('/resume', 'index');
        Route::get('/resume/{resume}', 'show');
        Route::post('/resume', 'store');
        Route::post('/resume/{resume}', 'update');
        Route::get('/delete/resume/{resume}', 'destroy');
    });
});
//school
Route::controller(App\Http\Controllers\CourseController::class)->group(function () {

    Route::get('/course', 'indexSite');
    Route::get('/course/{course}', 'show');
    Route::post('/course', 'store');
    Route::post('/course/{course}', 'update');
    Route::post('/delete/course', 'destroy');
    Route::get('/active/course/{course}', 'activeToggle');
    Route::get('/latest/course', 'latest');

    Route::prefix('panel')->group(function () {
        Route::get('/course', 'index');
        Route::get('/course/{course}', 'show');
        Route::post('/course', 'store');
        Route::post('/course/{course}', 'update');
        Route::post('/delete/course', 'destroy');
        Route::get('/active/course/{course}', 'activeToggle');
        Route::get('/latest/course', 'latest');
    });
});
Route::controller(App\Http\Controllers\CourseCategoryController::class)->group(function () {

    Route::prefix('panel')->group(function () {

        Route::get('/category/course', 'index');
        Route::get('/category/course/{courseCategory}', 'show');
        Route::post('/category/course', 'store');
        Route::post('/category/course/{courseCategory}', 'update');
        Route::post('/delete/category/course', 'destroy');
        Route::get('/active/category/course/{courseCategory}', 'activeToggle');
    });
});
Route::controller(App\Http\Controllers\TeacherController::class)->group(function () {

    Route::prefix('panel')->group(function () {
        Route::get('/teacher', 'index');
        Route::get('/teacher/{teacher}', 'show');
        Route::post('/teacher', 'store');
        Route::post('/teacher/{teacher}', 'update');
        Route::get('/delete/teacher/{teacher}', 'destroy');
        Route::get('/active/teacher/{teacher}', 'activeToggle');
        Route::get('/latest/teacher', 'latest');
    });
});
Route::controller(App\Http\Controllers\LanguageController::class)->group(function () {

    Route::prefix('panel')->group(function () {
        Route::get('/language', 'index');
        Route::get('/language/{language}', 'show');
        Route::post('/language', 'store');
        Route::post('/language/{language}', 'update');
        Route::get('/delete/language/{language}', 'destroy');
        Route::get('/active/language/{language}', 'activeToggle');
        Route::get('/latest/language', 'latest');
        Route::get('/test/language', 'tst');
    });
    Route::get('/language', 'indexSite');
});
Route::controller(App\Http\Controllers\LanguageNameTranslateController::class)->group(function () {

    Route::prefix('panel')->group(function () {
        Route::get('/translate/language', 'index');
        Route::get('/translate/language/{languageNameTranslate}', 'show');
        Route::post('/translate/language', 'store');
        Route::post('/translate/language/{languageNameTranslate}', 'update');
        Route::get('/delete/translate/language/{languageNameTranslate}', 'destroy');
        Route::get('/active/translate/language/{languageNameTranslate}', 'activeToggle');
        Route::get('/latest/translate/language', 'latest');
        Route::get('/test/translate/language', 'tst');
    });
    Route::get('/translate/language', 'indexSite');

});

//Route::post('/panel/upload/editor/image',[\App\Http\Controllers\ImageController::class, 'uploadEditorImage']);


//other API'S

//food api
Route::get('/foods', [ApiController::class, 'foods']);
Route::get('/food/{food}', [ApiController::class, 'food']);


Route::post('/upload/file', [\App\Http\Controllers\FileController::class, 'upload']);
Route::get('/tst1', [\App\Http\Controllers\FileController::class, 'tst']);
Route::get('/tst2', [\App\Http\Controllers\FileController::class, 'tst2']);

