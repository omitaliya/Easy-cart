<?php

use App\Models\brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController as home_page;
use App\Http\Controllers\productSubCategory;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\brandController;
use App\Http\Controllers\admin\productController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\SubCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[home_page::class,'index'])->name('home');


Route::group(['prefix'=>'admin'],function()
{

        Route::group(['middleware'=>'admin.guest'],function()
        {
            Route::get('login',[AdminLoginController::class,'index'])->name('admin.login');
            Route::post('authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');

        });

        Route::group(['middleware'=>'admin.auth'],function()
        {
            Route::get('Home',[HomeController::class,'index'])->name('admin.home');
            Route::get('logout',[HomeController::class,'logout'])->name('admin.logout');

            Route::get('category-create',[CategoryController::class,'create'])->name('category.create');
            Route::get('category-list',[CategoryController::class,'index'])->name('category.list');
            Route::post('category-store',[CategoryController::class,'store'])->name('category.store');
            Route::get('category-edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
            Route::post('category-update/{id}',[CategoryController::class,'update'])->name('category.update');
            Route::post('category-delete/{id}',[CategoryController::class,'delete'])->name('category.delete');
            
            Route::get('sub-category-index',[SubCategoryController::class,'index'])->name('sub-category.index');
            Route::get('sub-category-create',[SubCategoryController::class,'create'])->name('sub-category.create');
            Route::get('sub-category-edit/{id}',[SubCategoryController::class,'edit'])->name('sub-category.edit');
            Route::post('sub-category-update/{id}',[SubCategoryController::class,'update'])->name('sub-category.update');
            Route::get('sub-category-delete/{id}',[SubCategoryController::class,'delete'])->name('sub-category.delete');
            Route::post('sub-category-store',[SubCategoryController::class,'store'])->name('sub-category.store');
            
            Route::get('brand-index',[brandController::class,'index'])->name('brand.index');
            Route::get('brand-create',[brandController::class,'create'])->name('brand.create');
            Route::post('brand-store',[brandController::class,'store'])->name('brand.store');
            Route::get('brand-delete/{id}',[brandController::class,'delete'])->name('brand.delete');
            Route::get('brand-edit/{id}',[brandController::class,'edit'])->name('brand.edit');
            Route::post('brand-update/{id}',[brandController::class,'update'])->name('brand.update');
            
            Route::get('product-index',[productController::class,'index'])->name('product.index');
            Route::get('product-create',[productController::class,'create'])->name('product.create');
            Route::get('product-edit/{id}',[productController::class,'edit'])->name('product.edit');
            Route::post('product-update/{id}',[productController::class,'update'])->name('product.update');
            Route::post('product-store',[productController::class,'store'])->name('product.store');
            Route::get('product-delete/{id}',[productController::class,'delete'])->name('product.delete');
            Route::get('product-delete-image/{id}',[productController::class,'deleteImage'])->name('product.deleteImage');
           
            Route::get('getSlug',function(Request $request){
                $slug='';

                if(!empty($request->title))
                {
                    $slug=Str::slug($request->title);
                }
                
                return response()->json([
                    'status'=>true,
                    'slug'=>$slug
                ]);
            })->name('getSlug');
        });

        Route::get('find-sub-category',[productSubCategory::class,'index'])->name('getSubCategory');

});
