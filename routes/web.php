<?php

use App\Http\Controllers\Backend\BackEndController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\PostCountController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'lang'], static function(){

    Route::get('/', [FrontendController::class, 'index'])->name('front.index');
    Route::get('/all-post', [FrontendController::class, 'all_post'])->name('front.all_post');
    Route::get('/search', [FrontendController::class, 'search'])->name('front.search');
    Route::get('/category/{slug}', [FrontendController::class, 'category'])->name('front.category');
    Route::get('/category/{cat_slug}/{sub_cat_slug}', [FrontendController::class, 'sub_category'])->name('front.sub_category');
    Route::get('/tag/{slug}', [FrontendController::class, 'tag'])->name('front.tag');
    Route::get('/single-post/{slug}', [FrontendController::class, 'single'])->name('front.single');
    Route::get('contact-us', [FrontendController::class, 'contact_us'])->name('front.contact');
    Route::post('contact-us', [ContactController::class, 'store'])->name('contact.store');
    Route::get('get-districts/{division_id}', [ProfileController::class, 'getDistrict']);
    Route::get('get-thanas/{district_id}', [ProfileController::class, 'getThana']);
    Route::get('post-count/{post_id}', [FrontendController::class, 'postReadCount']);

    Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {

        Route::resource('post', PostController::class);
        Route::resource('comment', CommentController::class);
        Route::resource('profile', ProfileController::class);
        Route::get('/', [BackEndController::class, 'index'])->name('back.index');
        Route::post('upload-photo', [ProfileController::class, 'upload_photo']);
        Route::get('get-subcategory/{id}', [SubCategoryController::class, 'getSubCategoryByCategoryId']);

        Route::group(['middleware'=> 'admin'], static function(){
            Route::resource('category', CategoryController::class);
            Route::resource('sub-category', SubCategoryController::class);
            Route::resource('tag', TagController::class);
        });
    });
    
    require __DIR__ . '/auth.php';
});



//localization, pdf, file manager, API, Service Provider & container
