<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Middleware\RedirectIfAuthenticated;

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\CompareController;
use App\Http\Controllers\User\WishlistController;

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

// Route::get('/', function () {
//     return view('frontend.index');
// });

Route::get('/',[IndexController::class, 'Index']);

Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard',[UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store',[UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout',[UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/update/password',[UserController::class, 'UserUpdatePassword'])->name('user.update.password');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//Admin Dashboard All Route
Route::middleware(['auth','role:admin'])->group(function(){

    Route::get('/admin/dashboard',[AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout',[AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile',[AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store',[AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password',[AdminController::class, 'AdminChangepassword'])->name('admin.change.password');
    Route::post('/admin/update/password',[AdminController::class, 'AdminUpdatepassword'])->name('update.password');

}); //End Admin All Group Route

//Vendor Dashboard All Route
Route::middleware(['auth','role:vendor'])->group(function(){

    Route::get('/vendor/dashboard',[VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile',[VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store',[VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/change/password',[VendorController::class, 'VendorChangepassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password',[VendorController::class, 'VendorUpdatepassword'])->name('vendor.update.password');


//Vendor All Route
Route::controller(VendorProductController::class)->group(function(){
    Route::get('/vendor/all/product', 'VendorAllProduct')->name('vendor.all.product');
    Route::get('/vendor/add/product', 'VendorAddProduct')->name('vendor.add.product');
    Route::post('/vendor/store/product', 'VendorStoreProduct')->name('vendor.store.product');
    Route::get('/vendor/edit/product/{id}', 'VendorEditProduct')->name('vendor.edit.product');
    Route::post('/vendor/update/product', 'VendorUpdateProduct')->name('vendor.update.product');
    Route::post('/vendor/update/product/thambnail', 'VendorUpdateProductThambnail')->name('vendor.update.product.thambnail');
    Route::post('/vendor/update/product/multiimage', 'VendorUpdateProductMultiimage')->name('vendor.update.product.multiimage');
    Route::get('/vendor/product/multiimage/delete/{id}', 'VendorMultiImageDelete')->name('vendor.product.multiimage.delete');
    Route::get('/vendor/product/inactive/{id}', 'VendorInactiveProduct')->name('vendor.product.inactive');
    Route::get('/vendor/product/active/{id}', 'VendorActiveProduct')->name('vendor.product.active');
    Route::get('/vendor/delete/product/{id}', 'VendorDeleteProduct')->name('vendor.delete.product');

    Route::get('/vendor/subcategory/ajax/{category_id}', 'VendorGetSubCategory');
});


});  //End Group Middleware

Route::get('/admin/login',[AdminController::class, 'AdminLogin'])
->middleware(RedirectIfAuthenticated::class);

Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])
->name('vendor.login')->middleware(RedirectIfAuthenticated::class);

Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');

Route::middleware(['auth','role:admin'])->group(function(){

//All Brand Route
Route::controller(BrandController::class)->group(function(){
    Route::get('/all/brand', 'AllBrand')->name('all.brand');
    Route::get('/add/brand', 'AddBrand')->name('add.brand');
    Route::post('/brand/store', 'BrandStore')->name('brand.store');
    Route::get('/edit/brand/{id}', 'EditBrand')->name('edit.brand');
    Route::post('/update/brand', 'UpdateBrand')->name('update.brand');
    Route::get('/delete/brand{id}', 'DeleteBrand')->name('delete.brand');
});

//All Category Route
Route::controller(CategoryController::class)->group(function(){
    Route::get('/all/category', 'AllCategory')->name('all.category');
    Route::get('/add/category', 'AddCategory')->name('add.category');
    Route::post('/category/store', 'CategoryStore')->name('category.store');
    Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
    Route::post('/update/category', 'UpdateCategory')->name('update.category');
    Route::get('/delete/category{id}', 'DeleteCategory')->name('delete.category');
});

//All SubCategory Route
Route::controller(SubCategoryController::class)->group(function(){
    Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory');
    Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory');
    Route::post('/subcategory/store', 'SubCategoryStore')->name('subcategory.store');

    Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
    Route::post('/update/subcategory', 'UpdateSubCategory')->name('update.subcategory');
    Route::get('/delete/subcategory{id}', 'DeleteSubCategory')->name('delete.subcategory');

    Route::get('/subcategory/ajax/{category_id}', 'GetSubCategory');
});

//All Vendor Active and Inactive Route
Route::controller(AdminController::class)->group(function(){
    Route::get('/inactive/vendor', 'InactiveVendor')->name('inactive.vendor');
    Route::get('/active/vendor', 'ActiveVendor')->name('active.vendor');
    Route::get('/inactive/vendor/details/{id}', 'InActiveVendorDetails')->name('inactive.vendor.details');
    Route::post('/active/vendor/approve', 'ActiveVendorApprove')->name('active.vendor.approve');
    Route::get('/active/vendor/details/{id}', 'ActiveVendorDetails')->name('active.vendor.details');
    Route::post('/inactive/vendor/approve', 'InActiveVendorApprove')->name('inactive.vendor.approve');
   
});

//Product Manage All Route
Route::controller(ProductController::class)->group(function(){

    Route::get('/all/product', 'AllProduct')->name('all.product');
    Route::get('/add/product', 'AddProduct')->name('add.product');
    Route::post('/store/product', 'StoreProduct')->name('store.product');
    Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
    Route::post('/update/product', 'UpdateProduct')->name('update.product');
    Route::post('/update/product/thambnail', 'UpdateProductThambnail')->name('update.product.thambnail');
    Route::post('/update/product/multiimage', 'UpdateProductMultiimage')->name('update.product.multiimage');
    Route::get('/product/multiimage/delete/{id}', 'MultiImageDelete')->name('product.multiimage.delete');
    Route::get('/product/inactive/{id}', 'ProductInactive')->name('product.inactive');
    Route::get('/product/active/{id}', 'ProductActive')->name('product.active');
    Route::get('/delete/product/{id}', 'ProductDelete')->name('delete.product');
    
});

//All Slider Route
Route::controller(SliderController::class)->group(function(){
    Route::get('/all/slider', 'AllSlider')->name('all.slider');
    Route::get('/add/slider', 'AddSlider')->name('add.slider');
    Route::post('/store/slider', 'StoreSlider')->name('store.slider');
    Route::get('/edit/slider/{id}', 'EditEdit')->name('edit.slider');
    Route::post('/update/slider', 'UpdateSlider')->name('update.slider');
    Route::get('/delete/slider{id}', 'DeleteSlider')->name('delete.slider');
});

//All Banner Route
Route::controller(BannerController::class)->group(function(){
    Route::get('/all/banner', 'AllBanner')->name('all.banner');
    Route::get('/add/banner', 'AddBanner')->name('add.banner');
    Route::post('/store/banner', 'StoreBanner')->name('store.banner');
    Route::get('/edit/banner/{id}', 'EditBanner')->name('edit.banner');
    Route::post('/update/banner', 'UpdateBanner')->name('update.banner');
    Route::get('/delete/banner{id}', 'DeleteBanner')->name('delete.banner');
});


//Coupon All Route
Route::controller(CouponController::class)->group(function(){
    Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
    Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
    Route::post('/store/coupon', 'StoreCoupon')->name('store.coupon');
    Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
    Route::post('/update/coupon', 'UpdateCoupon')->name('update.coupon');
    Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');
   
});

//Shiping Division All Route
Route::controller(ShippingAreaController::class)->group(function(){
    Route::get('/all/division', 'AllDivision')->name('all.division');
    Route::get('/add/division', 'AddDivision')->name('add.division');
    Route::post('/store/division', 'StoreDivision')->name('store.division');
    Route::get('/edit/division/{id}', 'EditDivision')->name('edit.division');
    Route::post('/update/division', 'UpdateDivision')->name('update.division');
    Route::get('/delete/division/{id}', 'DeleteDivision')->name('delete.division');
   
});

//Shiping district All Route
Route::controller(ShippingAreaController::class)->group(function(){
    Route::get('/all/district', 'AllDistrict')->name('all.district');
    Route::get('/add/district', 'AddDistrict')->name('add.district');
    Route::post('/store/district', 'StoreDistrict')->name('store.district');
    Route::get('/edit/district/{id}', 'EditDistrict')->name('edit.district');
    Route::post('/update/district', 'UpdateDistrict')->name('update.district');
    Route::get('/delete/district/{id}', 'DeleteDistrict')->name('delete.district');
   
});

//Shiping State All Route
Route::controller(ShippingAreaController::class)->group(function(){
    Route::get('/all/state', 'AllState')->name('all.state');
    Route::get('/add/state', 'AddState')->name('add.state');
    Route::post('/store/state', 'StoreState')->name('store.state');
    Route::get('/edit/state/{id}', 'EditState')->name('edit.state');
    Route::post('/update/state', 'UpdateState')->name('update.state');
    Route::get('/delete/state/{id}', 'DeleteState')->name('delete.state');

    Route::get('/district/ajax/{division_id}', 'GetDistrict');

   
});


}); //Admin End Middleware

//Frontend All Details Route

Route::get('/product/details/{id}/{slug}',[IndexController::class, 'ProductDetails']);
Route::get('/vendor/details/{id}',[IndexController::class, 'VendorDetails'])->name('vendor.details');
Route::get('/vendor/all',[IndexController::class, 'VendorAll'])->name('vendor.all');
Route::get('/product/category/{id}/{slug}',[IndexController::class, 'CatwiseProduct']);
Route::get('/product/subcategory/{id}/{slug}',[IndexController::class, 'SubCatwiseProduct']);

//Product View Modal with Ajax
Route::get('/product/view/modal/{id}',[IndexController::class, 'ProductViewAjax']);

//Add To Cart Stor Date
Route::post('/cart/data/store/{id}',[CartController::class, 'AddToCart']);

//Get Data from MiniCart
Route::get('/product/mini/cart',[CartController::class, 'AddMiniCart']);

//Get Data from MiniCart
Route::get('/minicart/product/remove/{rowId}',[CartController::class, 'MiniCartRemove']);

//Add To Cart Stor Date For product Details page
Route::post('/dcart/data/store/{id}',[CartController::class, 'AddToCartDetails']);

//Add To WishList Product
Route::post('/add-to-wishlist/{product_id}',[WishlistController::class, 'AddToWishList']);

//Add To Compare 
Route::post('/add-to-compare/{product_id}',[CompareController::class, 'AddToCompare']);

//Frontend Apply Coupon Option
Route::post('/coupon-apply', [CartController::class, 'CouponApply']);





//User All Route
Route::middleware(['auth','role:user'])->group(function(){
//All WishList Route
   Route::controller(WishlistController::class)->group(function(){

    Route::get('/wishlist', 'AllWishList')->name('wishlist');
    Route::get('/get-wishlist-product', 'GetWishlistProduct');
    Route::get('/wishlist-remove/{id}', 'WishlistRemove');
});

//All WishList Route
   Route::controller(CompareController::class)->group(function(){

    Route::get('/compare', 'AllCompare')->name('compare');
    Route::get('/get-compare-product', 'GetCompareProduct');
    Route::get('/compare-remove/{id}', 'CompareRemove');
    
});

//Cart All  Route
   Route::controller(CartController::class)->group(function(){

    Route::get('/mycart', 'MyCart')->name('mycart');
    Route::get('/get-cart-product', 'GetCartProduct');
    Route::get('/cart-remove/{rowId}', 'CartRemove');
    Route::get('/cart-decrement/{rowId}', 'CartDecrement');
    Route::get('/cart-increment/{rowId}', 'CartIncrement');
});


}); //End User Middleware

