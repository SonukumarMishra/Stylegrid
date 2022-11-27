<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Config;


class LoginController extends Controller
{
    public function adminLogin(){
        Session::put('admin_data',['a'=>1,'b'=>2]);
        Session::put('adminLoggedin',TRUE);
        return redirect("/admin-dashboard");
    }

    public function adminLogout(Request $request){
        session_unset();
        Session::flush();
        return redirect("/admin");
    }

     

    
}