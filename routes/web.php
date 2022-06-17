<?php

use App\Http\Controllers\Admin\AdminBlogCategoriesController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminDiscountController;
use App\Http\Controllers\Admin\AdminFucksController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Demo;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/',[HomeController::class, 'index'])->name('home');
Route::post('/',[HomeController::class, 'emailSubscribe'])->name('emailSubscribe');
Route::get('/privacy',[HomeController::class, 'privacy'])->name('privacy');
Route::get('/faq',[HomeController::class, 'faq'])->name('faq');

Route::get('/shop',[ShopController::class, 'index'])->name('shop');
//Route::get('/shop/{category?}/sort/{sort?}/show/{show?}',[ShopController::class, 'index'])->where(['show' => '[1,2,3]','sort' => '[1,2,3,4]'])->name('shop.wfilter');
Route::get('/shop/{category?}',[ShopController::class, 'index'])->name('shop.wfilter');

Route::get('/blog',[BlogController::class, 'index'])->name('blog');
Route::get('/blog/{category?}',[BlogController::class, 'index'])->name('blog.wfilter');
Route::get('/blog/{blog}/{slug}',[BlogController::class, 'blog'])->name('show.blogItem');

Route::get('/product/{product}/{slug}',[ShopController::class, 'product'])->name('product.show');


/*
შესვლა რეგისტრაცია
*/

Route::middleware(['guest'])->group(function () {
  Route::get('/login',[LoginController::class, 'index'])->name('login');
  Route::post('/login',[LoginController::class, 'authenticate'])->middleware("throttle:10,1");
  Route::get('/register',[RegisterController::class, 'index'])->name('register');
  Route::post('/register',[RegisterController::class, 'store']);
  Route::get('/reset/password',[ResetPasswordController::class, 'showPasswordRequestForm'])->name('showPasswordRequestForm');
  Route::post('/reset/password',[ResetPasswordController::class, 'send'])->name('password.email');
  Route::get('/reset/password/{token}',[ResetPasswordController::class, 'showResetForm'])->name('password.resetForm');
  Route::post('/update/password',[ResetPasswordController::class, 'store'])->name('password.update');
});

Route::get('/contact',[ContactController::class, 'index'])->name('contact');
Route::get('/newsletter/unsubscribe/{email}',[HomeController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::get('/verify/email/{slug}',[VerificationController::class, 'verifyEmail'])->name('verifyEmail');
Route::get('/guest/verify/email/{slug}',[VerificationController::class, 'verifyGuestEmail'])->name('verifyGuestEmail');

/*
პირადი გვერდი
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
*/

Route::middleware(['auth'])->group(function () {
  Route::prefix('user')->group(function () {
    Route::get('/',[DashboardController::class, 'index'])->name('user.profile');
    Route::get('/settings',[DashboardController::class, 'settings'])->name('user.settings');
    Route::get('/orders',[DashboardController::class, 'orders'])->name('user.orders');
    Route::get('/address',[DashboardController::class, 'address'])->name('user.address');
    Route::delete('/address/delete/{address}',[AddressController::class, 'destroy'])->name('address.destroy');
    Route::post('/address',[DashboardController::class, 'storeAddress']);
    Route::post('/logout',[LogoutController::class, 'store'])->name('logout');
    Route::post('/password/change',[ChangePasswordController::class,'changePassword'])->name('change.password');
    Route::post('/verification/resend',[ChangePasswordController::class,'verificationResend'])->name('verification.resend');
    Route::middleware(['verified','throttle:5,1'])->group(function (){
      Route::post('/settings/update/subscription',[DashboardController::class, 'toggleEmailSubscription'])->name('user.toggleEmailSubscription');
    });
    Route::get('email/notice/', function(){

      session()->flash('status', 'გთხოვთ დაადასტუროთ თქვენი ელ.ფოსტა.');
      return redirect()->route('user.profile');

    })->name('verification.notice');
  });

});

/*
კარტა
*/
Route::prefix('cart')->group(function () {
  Route::get('/',[CartController::class, 'index'])->name('cart.index');
  Route::post('/add',[CartController::class, 'store'])->name('cart.add');
  Route::post('/update',[CartController::class, 'update'])->name('cart.update');
  Route::delete('/remove',[CartController::class, 'remove'])->name('cart.remove');
});


/*
ადმინპანელი
*/
Route::middleware(['auth','admin'])->group(function () {

  Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/faq', [AdminFucksController::class, 'index'])->name('admin.fucks');
      Route::delete('/faq/delete', [AdminFucksController::class, 'delete'])->name('admin.deletefuck');
      Route::post('/faq/add', [AdminFucksController::class, 'store'])->name('admin.storeFaq');

      Route::get('/gallery', [AdminGalleryController::class, 'index'])->name('admin.gallery');
      Route::get('/gallery/download/{image}/{quality}', [AdminGalleryController::class, 'download_image'])->name('admin.downloadImage');
      Route::delete('/gallery/delete', [AdminGalleryController::class, 'delete'])->name('admin.deleteImage');
      Route::get('/gallery/pagination/ajax', [AdminGalleryController::class, 'imagesAjax'])->name('admin.getAjaxPaginationGallery');

    Route::prefix('blogs')->group(function () {
       Route::get('/', [AdminBlogController::class, 'index'])->name('admin.showPosts');
       Route::get('/new', [AdminBlogController::class, 'newBlogPost'])->name('admin.newBlogPost');
        Route::get('/edit/{blog}', [AdminBlogController::class, 'showEditForm'])->name('admin.editBlogPost');
       Route::post('/new', [AdminBlogController::class, 'store'])->name('admin.storeBlogPost');
        Route::post('/update', [AdminBlogController::class, 'update'])->name('admin.updateBlogPost');
       Route::delete('/delete', [AdminBlogController::class, 'delete'])->name('admin.removeBlog');
        Route::prefix('categories')->group(function(){
            Route::get('/', [AdminBlogCategoriesController::class, 'index'])->name('admin.showPostCategories');
            Route::post('/', [AdminBlogCategoriesController::class, 'store'])->name('admin.storePostCategories');
            Route::delete('/delete', [AdminBlogCategoriesController::class, 'delete'])->name('admin.deletePostCategory');
        });
      });

      Route::prefix('users')->group(function (){
          Route::get('/', [AdminUserController::class, 'index'])->name('admin.users');
          Route::get('/edit/{username}', [AdminUserController::class, 'edit'])->name('admin.editUser');
          Route::post('/edit', [AdminUserController::class, 'store'])->name('admin.updateUser');
      });
      Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductController::class, 'products'])->name('admin.products');
        Route::get('/new', [AdminProductController::class, 'newProductForm'])->name('admin.newProductForm');
        Route::post('/new', [AdminProductController::class, 'store'])->name('admin.storeProduct');
        Route::get('/edit/{product}', [AdminProductController::class, 'showEditForm'])->name('admin.showEditForm');
        Route::post('/edit/{product}', [AdminProductController::class, 'update'])->name('admin.updateProduct');
        Route::delete('/delete', [AdminProductController::class, 'removeProduct'])->name('admin.removeProduct');

          Route::prefix('categories')->group(function (){
              Route::get('/', [ProductCategoryController::class, 'index'])->name('admin.showCategories');
              Route::post('/new', [ProductCategoryController::class, 'store'])->name('admin.storeCategory');
              Route::delete('/delete', [ProductCategoryController::class, 'delete'])->name('admin.deleteCategory');
          });
        Route::prefix('discounts')->group(function () {
          Route::get('/', [AdminDiscountController::class, 'ProductsOffs'])->name('admin.ProductsOffs');
          Route::get('/new', [AdminDiscountController::class, 'newProductsOff'])->name('admin.newProductsOff');
          Route::post('/new', [AdminDiscountController::class, 'storeProductsOff'])->name('admin.newProductsOff');
          Route::delete('/delete', [AdminDiscountController::class, 'removeProductsOff'])->name('admin.removeProductsOff');
          });
      });
  });
});

