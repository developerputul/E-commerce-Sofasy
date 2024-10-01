<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function AllBrand(){
        $brands = Brand::latest()->get();
        return view('backend.brand.brand_all',compact('brands'));
    } // End Method

    public function AddBrand(){
        return view('backend.brand.brand_add');
    } // End Method

    public function BrandStore(Request $request){

        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); 
        $image->move(public_path('upload/brand_image'), $name_gen);
        $save_url = 'upload/brand_image/'.$name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ', '-',$request->brand_name)),
            'brand_image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.brand')->with($notification);
    } // End Method

    public function EditBrand($id){
        $brand = Brand::findOrFail($id);
        return view('backend.brand.edit_brand',compact('brand'));
    } // End Method

    public function UpdateBrand(Request $request){
        
        $brand_id = $request->id;
        $old_img = $request->old_image;

        if ($request->file('brand_image')) {

        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); 
        $image->move(public_path('upload/brand_image'), $name_gen);
        $save_url = 'upload/brand_image/'.$name_gen;
        
        if (file_exists($old_img)) {
            unlink($old_img);
        }

        Brand::findOrFail($brand_id)->update([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ', '-',$request->brand_name)),
            'brand_image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Brand Updated With Image Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.brand')->with($notification);
        } else {
            Brand::findOrFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-',$request->brand_name)),
                
            ]);
    
            $notification = array(
                'message' => 'Brand Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.brand')->with($notification);
        } // End Else

    } // End Method

    public function DeleteBrand($id){

        $brand = Brand::findOrFail($id);
        $img = $brand->brand_image;
        unlink($img);

        Brand::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    } // End Method

}
