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
}
