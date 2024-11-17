<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;

use function PHPUnit\Framework\returnValue;

class CouponController extends Controller
{
    public function AllCoupon(){

        $coupon = Coupon::latest()->get();
        return view('backend.coupon.all_coupon',compact('coupon'));
    }// End Method

    public function AddCoupon(){

        return view('backend.coupon.add_coupon');
    } // End Method

    public function StoreCoupon(Request $request){

        Coupon::insert([
            'coupon_name' => $request->coupon_name,
            'coupon_discount' => $request->coupon_discount,
            'coupon_validity' => $request->coupon_validity,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Coupon Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.coupon')->with($notification);

    } // End Method
}
