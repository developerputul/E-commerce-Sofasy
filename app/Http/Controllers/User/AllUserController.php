<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllUserController extends Controller
{
  public function UserAccountPage(){

    $id = Auth::user()->id;
    $userData = User::find($id);
    return view('frontend.userdashboard.account_details',compact('userData'));

  } // End Method
}
