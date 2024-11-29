<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipDivision;
use App\Models\ShipDistrict;
use App\Models\ShipState;
use Carbon\Carbon;


class ShippingAreaController extends Controller
{
    public function AllDivision(){

        $division = ShipDivision::latest()->get();
        return view('backend.ship.division.all_division',compact('division'));
    }// End Method

    public function AddDivision(){

        return view('backend.ship.division.add_division');
    } // End Method

    public function StoreDivision(Request $request){

        ShipDivision::insert([
           
            'division_name' => $request->division_name,
        ]);
        $notification = array(
            'message' => 'ShipDivision Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.division')->with($notification);
    } // End Method

    public function EditDivision($id){

        $division = ShipDivision::findOrfail($id);
        return view('backend.ship.division.edit_division',compact('division'));
    } // End Method

    public function UpdateDivision(Request $request){

        $division_id = $request->id;

        ShipDivision::findOrFail($division_id)->update([
            'division_name' =>$request->division_name,
        ]);
        $notification = array(
            'message' => 'Division Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.division')->with($notification);
    }// End Method

    public function DeleteDivision($id){

        ShipDivision::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Division Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }// End Method

    //===================================================District Area==================================

    public function AllDistrict(){

        $district = ShipDistrict::latest()->get();
        return view('backend.ship.district.all_district',compact('district'));
    }// End Method
    
    public function AddDistrict(){
        $divisions = ShipDivision::orderBy('division_name','ASC')->get();
        return view('backend.ship.district.add_district',compact('divisions'));
    }// End Method

    public function StoreDistrict(Request $request){

       ShipDistrict::insert([
        'division_id' => $request->division_id,
        'district_name' => $request->district_name,
       ]);

       $notification = array(
        'message' => 'ShipDistrict Inserted Successfully',
        'alert-type' => 'success',
       );

       return redirect()->route('all.district')->with($notification);
    }// End Method 

    public function EditDistrict($id){

        $divisions = ShipDivision::orderBy('division_name','ASC')->get();
        $district = ShipDistrict::findOrFail($id);
        return view('backend.ship.district.edit_district',compact('district','divisions'));
    }// End Method

    public function UpdateDistrict(Request $request){

        $district_id = $request->id;

        ShipDistrict::findOrfail($district_id)->update([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
        ]);

        $notification = array(
            'message' => 'ShipDistrict Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.district')->with($notification);

    }// End Method

    public function DeleteDistrict($id){

        ShipDistrict::findOrFail($id)->delete();

        $notification = array(
            'message' => 'ShipDistrict Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }// End Method
}
