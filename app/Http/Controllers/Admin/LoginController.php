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
        if(!Session::get("adminLoggedin")) {
            return view('admin.admin-login'); 
        }
       return redirect("/admin-dashboard");
    }

    public function adminLoginPost(Request $request){
        if($request->ajax()){
            
            $dashboard=new Dashboard();
            $where['a.email']=$request->email;
            $where['a.password']=sha1($request->password);
            $response=$dashboard->adminLogin($where);
            if($response){
                Session::put('admin_data',$response);
                Session::put('adminLoggedin',TRUE);
                echo json_encode(['status'=>1,'message'=>'You are being redirected to Dashboard']);
            }else{
                echo json_encode(['status'=>0,'message'=>'Invalid Email Id or Password!']);
            }
        }
    }

    public function adminLogout(Request $request){
        session_unset();
        Session::flush();
        return redirect("/admin");
    }

     

    
}