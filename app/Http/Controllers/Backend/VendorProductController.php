<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\MultiImg;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Image;

class VendorProductController extends Controller
{
   public function VendorAllProduct(){

    $id = Auth::user()->id;
    $products = Product::where('vendor_id',$id)->latest()->get();
    return view('vendor.backend.product.vendor_product_all',compact('products'));

   } // End Method

   public function VendorAddProduct(){
    $brands = Brand::latest()->get();
    $categories = Category::latest()->get();
    return view('vendor.backend.product.vendor_product_add',compact('brands','categories'));
   } // End Method

   public function VendorGetSubCategory($category_id){
    $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
    return json_encode($subcat); 

}// End method

public function VendorStoreProduct(Request $request){

        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $image->move(public_path('/upload/products/thambnail/'),$name_gen);
        $save_url = 'upload/products/thambnail/'.$name_gen;

        $product_id = Product::insertGetId([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,

            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc, 

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals, 
            'product_thambnail' => $save_url,
            'vendor_id' => Auth::user()->id,
            'status' => 1,
            'created_at' => Carbon::now(), 
        ]);
        //Multiple Image Upload//

        $images = $request->file('multi_img');
        foreach($images as $img){
        $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $img->move(public_path('/upload/products/multiImage/'),$make_name);
        $uploadPath = 'upload/products/multiImage/'.$make_name;

        MultiImg::insert([

            'product_id' => $product_id,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(), 
        ]);
        } // End Foreach
        //End MultiImage Parth

        $notification = array(
            'message' => 'Vendor Product Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('vendor.all.product')->with($notification);
} // End Method

public function VendorEditProduct($id){

        $multiImgs = MultiImg::where('product_id',$id)->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('vendor.backend.product.vendor_product_edit',compact('brands','categories','products','subcategory','multiImgs'));

} // End Method

public function VendorUpdateProduct(Request $request){

    $product_id = $request->id;

        Product::findOrfail($product_id)->update([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,

            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_desc' => $request->short_desc,
            'long_desc' => $request->long_desc, 

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals, 
            'status' => 1,
            'created_at' => Carbon::now(), 
        ]);
        $notification = array(
            'message' => 'Vendor Product Updated Without Image Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('vendor.all.product')->with($notification);
} // End Method

public function VendorUpdateProductThambnail(Request $request){

    $pro_id = $request->id;
    $oldImage = $request->old_img;

    $image = $request->file('product_thambnail');
    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    $image->move(public_path('/upload/products/thambnail/'),$name_gen);
    $save_url = 'upload/products/thambnail/'.$name_gen;

    if (file_exists($oldImage)) {
        unlink($oldImage);
    }

    Product::findOrFail($pro_id)->update([
        'product_thambnail' =>  $save_url,
        'created_at' => Carbon::now(),
    ]);
    $notification = array(
        'message' => 'Vendor Product Image Thambnail Updated Successfully',
        'alert-type' => 'success',
    );
    return redirect()->back()->with($notification);
} // End Method

//Vendor Multi Image Updated
public function VendorUpdateProductMultiimage(Request $request){

    $imgs = $request->multi_img;

       foreach($imgs as $id => $img){
        $imgDel = MultiImg::findOrFail($id);
        unlink($imgDel->photo_name);
        $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
        $img->move(public_path('/upload/products/multiImage/'),$make_name);
        $uploadPath = 'upload/products/multiImage/'.$make_name;

        MultiImg::where('id',$id)->update([
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(),
        ]);
       } // End Foreach

       $notification = array(
        'message' => 'Vendor Product Multi Image Updated Successfully',
        'alert-type' => 'success',
    );
    return redirect()->back()->with($notification);
} // End Method

public function VendorMultiImageDelete($id){

    $oldImg = MultiImg::findOrFail($id);
    unlink($oldImg->photo_name);

    MultiImg::findOrFail($id)->delete();

    $notification = array(
        'message' => 'Vendor Product Multi Image Deleted Successfully',
        'alert-type' => 'success',
    );
    return redirect()->back()->with($notification);
} // End Method

public function VendorInactiveProduct($id){

    Product::findOrFail($id)->update(['status' => 0]);
    $notification = array(
        'message' => 'Product Inactive Successfully',
        'alert-type' => 'success',
    );
    return redirect()->back()->with($notification);

    Product::findOrFail($id)->update(['status' =>0]);
    $notification = array(
        'message' => ' Vendor Product Inactive Succseefully',
        'alert-type' => 'success',
    );
    return redirect()->back()->with($notification);
} // End Method

public function VendorActiveProduct($id){

    Product::findOrFail($id)->update(['status' => 1]);

    $notification = array(
        'message' => 'Vendor Product Active Succseefully',
        'alert-type' => 'success',
    );
    return redirect()->back()->with($notification);
} // End Method

public function VendorDeleteProduct($id){

    $product = Product::findOrFail($id);
        unlink($product->product_thambnail);

        Product::findOrFail($id)->delete();
        $images = MultiImg::where('product_id',$id)->get();

        foreach($images as $img){
            unlink($img->photo_name);
            MultiImg::where('product_id',$id)->delete();
        }// End Foreach Method

        $notification = array(
            'message' => 'Vendor Product Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

} // End Method



}
