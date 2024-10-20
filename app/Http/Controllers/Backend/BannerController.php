<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Arr;
use Image;

class BannerController extends Controller
{
   public function AllBanner(){

    $banner = Banner::latest()->get();
    return view('backend.banner.banner_all',compact('banner'));
   } // End Method

   public function AddBanner(){

    return view('backend.banner.banner_add');
   } // End Method

   public function StoreBanner(Request $request){

    $image = $request->file('banner_image');
    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    $image->move(public_path('upload/banner'), $name_gen);
    $save_url = 'upload/banner/'.$name_gen;

    Banner::insert([
        'banner_title' => $request->banner_title,
        'banner_url' => $request->banner_url,
        'banner_image' => $save_url,
    ]);

    $notification = array(
        'message' => 'Banner Inserted Successfully',
        'alert-type' => 'info',
    );
    return redirect()->route('all.banner')->with($notification);
   } // End Method

   public function EditBanner($id){

    $banners = Banner::findOrFail($id);
    return view('backend.banner.banner_edit',compact('banners'));
   } // End Method

   public function UpdateBanner(Request $request){

    $banner_id = $request->id;
    $old_img = $request->old_image;

    if ($request->file('banner_image')) {

    $image = $request->file('banner_image');
    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension(); 
    $image->move(public_path('upload/banner'), $name_gen);
    $save_url = 'upload/banner/'.$name_gen;
    
    if (file_exists($old_img)) {
        unlink($old_img);
    }

    Banner::findOrFail($banner_id)->update([
        'banner_title' => $request->banner_title,
        'banner_url' => $request->banner_url,
        'banner_image' => $save_url,
    ]);

    $notification = array(
        'message' => 'Banner Updated With Image Successfully',
        'alert-type' => 'success'
    );
    return redirect()->route('all.banner')->with($notification);
    } else {

        Banner::findOrFail($banner_id)->update([
            'banner_title' => $request->banner_title,
            'banner_url' => $request->banner_url,
            
        ]);
        $notification = array(
            'message' => 'Banner Updated Without Image Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.banner')->with($notification);
    } // End Else
   } // End Method

   public function DeleteBanner($id){

    $banner = Banner::findOrFail($id);
    $image = $banner->banner_image;
    if ($image) {
        unlink($image);
    }
    $banner->delete();
    $notification = array(
        'message' => 'Banner Deleted Successfully',
        'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);

   } // End Method
} 
