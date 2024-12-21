<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function PendingOrder(){

        $orders = Order::where('status','pending')->orderBy('id','DESC')->get();
        return view('backend.orders.pending_orders',compact('orders'));
    }// End Method

    public function AdminOrderDetails($order_id){

        $order = Order::with('division','district','state','user')
        ->where('id',$order_id)->first();

        $orderItem = OrderItem::with('product')->where('order_id',$order_id)
                    ->orderBy('id','DESC')->get();
              return view('backend.orders.admin_order_details',compact('order','orderItem'));
    } // End Method

    public function AdminConfirmOrder(){

        $orders = Order::where('status','confirm')->orderBy('id','DESC')->get();
        return view('backend.orders.confirm_orders',compact('orders'));
    }//End Method

    public function AdminProcessingOrder(){

        $orders = Order::where('status','processing')->orderBy('id','DESC')->get();
        return view('backend.orders.processing_orders',compact('orders'));
    }// End Method

    public function AdminDeliveredOrder(){

        $orders = Order::where('status','delivered')->orderBy('id','DESC')->get();
        return view('backend.orders.delivered_orders',compact('orders'));
    } // End Method

    public function PendingToConfirm($order_id){

        Order::findOrfail($order_id)->update(['status' => 'confirm']);

        $notification = array(
            'message' => 'Order Confirm Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.confirm.order')->with($notification);
    }//End Method

    public function ConfirmToProcessing($order_id){

        Order::findOrfail($order_id)->update(['status' => 'processing']);

        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.processing.order')->with($notification);
    }// End Method

    public function ProcessingToDelivered($order_id){

        Order::findOrfail($order_id)->update(['status' => 'delivered']);

        $notification = array(
            'message' => 'Order Delivered Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.delivered.order')->with($notification);
    }// End Method
}
