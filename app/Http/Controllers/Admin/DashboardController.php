<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Dashboard;
use App\Models\Member;
use Session;
use Config;
/*
@author-Sunil Kumar Mishra
date:26-11-2022
*/
class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
        if(!Session::get("adminLoggedin")) {
            return redirect("/admin");
        }
        return $next($request);
        });
    }
    public function adminDashboard(Request $request){
        return view('admin.admin-dashboard');
    }
    public function adminMemberList(Request $request){
        return view('admin.admin-members');
    }
    public function adminMemberListAjax(Request $request){
        if($request->ajax()){
              $dashboard=new Dashboard();
              $total_data= $dashboard->adminMemberListAjax($request,true);
              $result_data= $dashboard->adminMemberListAjax($request);
              $json_data = array(
                  "recordsTotal"    =>$total_data,  
                  "recordsFiltered" => $total_data,
                  "data"            => $result_data 
            );
            return $json_data;
        }
    }

    public function adminMemberDetails($id){
        if(!empty($id)){
            $dashboard=new Dashboard();
            $member_details=$dashboard->getMemberDetails(['m.slug'=>$id]);
            if($member_details){
                $member_brands=$dashboard->getMemberBrands(['mb.member_id'=>$member_details->id]);
                return view('admin.admin-member-details',compact('member_details','member_brands'));
            }
        }
        return redirect("/admin-member-list");
    }
    public function adminCancelMembership(Request $request){
        if($request->ajax()){
            $member=new Member();
            $response=$member->addUpdateData(['id'=>$request->member_id,'membership_cancelled'=>1,'reason_of_cancellation'=>$request->reason_for_cancellation,'cancellation_datetime'=>now()],'sg_member');
            if($response['reference_id']>0){
                $response['status']=1;
                $response['message']="Membership cancelled successfully";
            }else{
                $response['status']=0;
                $response['message']="something went wrong!";
            }
            return json_encode($response);
        }
    }

    public function adminStylist(Request $request){
        return view('admin.admin-stylist');
    }
    
    public function adminStylistListAjax(Request $request){
        if($request->ajax()){
              $dashboard=new Dashboard();
              $total_data= $dashboard->adminStylistListAjax($request,true);
              $result_data= $dashboard->adminStylistListAjax($request);
              $json_data = array(
                "recordsTotal"    =>$total_data,  
                "recordsFiltered" => $total_data,
                "data"            => $result_data 
            );
            return $json_data;
        }
    }

    public function adminStylistDetails($id){
        if(!empty($id)){
            $dashboard=new Dashboard();
            $stylist_details=$dashboard->getStylistDetails(['s.slug'=>$id]);
            if($stylist_details){
                $stylist_brands=$dashboard->getStylistBrands(['sb.stylist_id'=>$stylist_details->id]);
                $stylist_clients=$dashboard->getStylistClients(['m.assigned_stylist'=>$stylist_details->id]);
                return view('admin.admin-stylist-details',compact('stylist_details','stylist_brands','stylist_clients'));
            }
        }
        return redirect("/admin-stylist");
    }
}