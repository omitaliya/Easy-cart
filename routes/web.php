<?php

use App\Models\brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\address;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\shopController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\productSubCategory;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\brandController;
use App\Http\Controllers\admin\productController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\discountController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\homeController as home_page;
use App\Http\Controllers\productController as product_home;

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

Route::get('/shop/{CategorySlug?}/{SubCategorySlug?}',[shopController::class,'index'])->name('shop');
Route::get('/product/{id}',[product_home::class,'index'])->name('product');
Route::post('/addToCart',[CartController::class,'addToCart'])->name('addToCart');
Route::get('/cart',[CartController::class,'cart'])->name('cart');
Route::post('/updateCart',[CartController::class,'updateCart'])->name('updateCart');
Route::post('/deleteCart',[CartController::class,'deleteCart'])->name('deleteCart');

Route::group(['prefix'=>'account','middleware'=>'guest'],function()
{
    Route::get('/register',[authController::class,'registration'])->name('register');
    Route::post('/registerData',[authController::class,'registerData'])->name('registerData');
    Route::get('/login',[authController::class,'login'])->name('login');
    Route::post('/login/user',[authController::class,'loginUser'])->name('login.user');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('/checkout',[CartController::class,'checkout'])->name('checkout');
    Route::post('/applyCoupon',[CartController::class,'applyCoupon'])->name('applyCoupon');
    Route::post('/order',[orderController::class,'save'])->name('order');
    Route::post('/address',[address::class,'save'])->name('address');
    Route::get('/logout',[authController::class,'logout'])->name('logout');
    Route::get('/myprofile',[authController::class,'myprofile'])->name('myprofile');
    Route::get('/changePassword',[authController::class,'changePassword'])->name('changePassword');
});

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
            
            Route::get('discount-index',[discountController::class,'index'])->name('discount.index');
            Route::get('discount-create',[discountController::class,'create'])->name('discount.create');
            Route::post('discount-store',[discountController::class,'store'])->name('discount.store');
            Route::get('discount-edit/{id}',[discountController::class,'edit'])->name('discount.edit');
            Route::post('discount-update/{id}',[discountController::class,'update'])->name('discount.update');
            Route::get('discount-delete/{id}',[discountController::class,'delete'])->name('discount.delete');
           
           
           
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
