<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Dashboard;
use Session;
use Config;


class LoginController extends Controller
{
    public function adminLogin(){
        Session::put('admin_data',['a'=>1,'b'=>2]);
        Session::put('adminLoggedin',TRUE);
        return redirect("/admin-dashboard");
    }

    public function adminLoginPost(Request $request){
        if($request->ajax()){
            $dashboard=new Dashboard();
            $where['a.email']=$request->email;
            $where['a.password']=$request->password;
            $response=$dashboard->adminLogin($where);
            if($response['status']){
                Session::put('admin_data',$response);
                Session::put('adminLoggedin',TRUE);
                echo json_encode(['status'=>1,'message'=>'Success']);
            }else{
                echo json_encode(['status'=>0,'message'=>'Failure']);
            }
        }
    }

    public function adminLogout(Request $request){
        session_unset();
        Session::flush();
        return redirect("/admin");
    }

     

    
}