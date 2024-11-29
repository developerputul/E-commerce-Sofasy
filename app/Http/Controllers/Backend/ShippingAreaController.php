<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShipDivision;
use App\Models\ShipDistrict;
use App\Models\ShipState;
use Carbon\Carbon;
use NunoMaduro\Collision\Adapters\Phpunit\State;

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
    //=====================================================================================

    public function AllState(){

        $state = ShipState::latest()->get();
        return view('backend.ship.state.all_state',compact('state'));
    }// End Method

    public function AddState(){

        $divisions = ShipDivision::orderBy('division_name','ASC')->get();
        $districts = ShipDistrict::orderBy('district_name','ASC')->get();
        return view('backend.ship.state.add_state',compact('divisions','districts'));
    }// End Method

    public function GetDistrict($division_id){

        $dist = ShipDistrict::where('division_id',$division_id)->orderBy('district_name','ASC')->get();
        return json_encode($dist); 
    }//End Method

    public function StoreState(Request $request){

        ShipState::insert([
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
        ]);
        $notification = array(
            'message' => 'ShipState Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.state')->with($notification);
    }// End Method

    public function EditState($id){

        $divisions = ShipDivision::orderBy('division_name','ASC')->get();
        $districts = ShipDistrict::orderBy('district_name','ASC')->get();
        $states = ShipState::findOrfail($id);
        return view('backend.ship.state.edit_state',compact('divisions','districts','states'));
    }// End Method

    public function UpdateState(Request $request){

        $state_id = $request->id;

        ShipState::findOrFail($state_id)->update([

            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'state_name' => $request->state_name,
        ]);
        $notification = array(
            'message' => 'ShipState Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.state')->with($notification);
    }// End Method

    public function DeleteState($id){

        ShipState::findOrfail($id)->delete();

        $notification = array(
            'message' => 'ShipState Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);


    } //End Method
}
