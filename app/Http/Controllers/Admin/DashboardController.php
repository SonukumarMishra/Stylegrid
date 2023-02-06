<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Dashboard;
use App\Models\Member;
use Session;
use Config;
use Illuminate\Support\Facades\File; 

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

    public function adminCancelStylistMembership(Request $request){
        if($request->ajax()){
            $member=new Member();
            $response=$member->addUpdateData(['id'=>$request->stylist_id,'membership_cancelled'=>1,'reason_of_cancellation'=>$request->reason_for_cancellation,'cancellation_datetime'=>now()],'sg_stylist');
            if($response['reference_id']>0){
                $response['status']=1;
                $response['message']="Stylist Membership cancelled successfully";
            }else{
                $response['status']=0;
                $response['message']="something went wrong!";
            }
            return json_encode($response);
        }
    }
    
    
    public function adminReviewStylist(Request $request){
        return view('admin.admin-review-stylist');
    }
    public function adminReviewStylistAjax(Request $request){
        if($request->ajax()){
              $dashboard=new Dashboard();
              $total_data= $dashboard->adminReviewStylistAjax($request,true);
              $result_data= $dashboard->adminReviewStylistAjax($request);
              $response_data=[];
              foreach($result_data as $result){
                $applied_to_cover='';
                if(!empty($result->shop)){
                    $applied_to_cover .=$result->shop.', ';
                }
                if(!empty($result->style)){
                    $applied_to_cover .=$result->style.', ';
                }
                if(!empty($result->source)){
                    $applied_to_cover .=$result->source.', ';
                }

                $response_data[]=array(
                    'full_name'=>$result->full_name,
                    'country_name'=>$result->country_name,
                    'applied_to_cover'=>ucwords(rtrim($applied_to_cover,', ')),
                    'shop_style_source'=>$result->shop_style_source,
                    'email'=>$result->email,
                    'phone'=>$result->phone,
                    'applied_date'=>date('d-m-Y',strtotime($result->added_date)),
                    'spend'=>$result->spend,
                    'subscription'=>$result->subscription,
                    'status'=>$result->status,
                    'slug'=>$result->slug,
                    'id'=>$result->id,
                );
              }
              $json_data = array(
                "recordsTotal"    =>$total_data,  
                "recordsFiltered" => $total_data,
                "data"            => $response_data 
            );
            return $json_data;
        }
    }

    public function adminReviewStylistDetails($id){
        if(!empty($id)){
            $dashboard=new Dashboard();
            $stylist_details=$dashboard->getstylistDetails(['s.slug'=>$id]);
            if($stylist_details){
                return view('admin.admin-review-stylist-details',compact('stylist_details'));
            }
        }
        return redirect("/admin-review-stylist");
    }
    public function adminUpdateStylistStatus(Request $request){
        if($request->ajax()){
            $member=new Member();
            $response=$member->addUpdateData(['id'=>$request->stylist_id,'status'=>$request->status],'sg_stylist');
            if($response['reference_id']>0){
                $response['status']=1;
                $response['message']="Stylist status updated successfully";
            }else{
                $response['status']=0;
                $response['message']="something went wrong!";
            }
            return json_encode($response);
        }
    }
    
    public function adminUploadProduct(Request $request){
        $member=new Member();
        $brand_list=$member->getBrandList();
        return view('admin.admin-upload-product',compact('brand_list'));
    }
    public function adminShowProductListAjax(Request $request){
        if($request->ajax()){
            $dashboard=new Dashboard();
            $products=$dashboard->getProducts([]);
            $fashion_products=[];
            $home_products=[];
            $beauty_products=[];
            foreach($products as $product){
                if($product->type=='Fashion'){
                    $fashion_products[]=$product;
                }
                if($product->type=='Home'){
                    $home_products[]=$product;
                }
                if($product->type=='Beauty'){
                    $beauty_products[]=$product;
                }
            }
            return json_encode([
                'status'=>1,
                'fashion_products'=>$fashion_products,
                'home_products'=>$home_products,
                'beauty_products'=>$beauty_products,
            ]);
        }
    }
    public function adminViewProductAjax(Request $request){
        if($request->ajax()){
            $dashboard=new Dashboard();
            $product=$dashboard->getProducts(['p.id'=>$request->id]);
            return json_encode([
                'status'=>1,
                'product'=>$product?$product[0]:[],
            ]);
        }
    }
    public function adminRemoveProductAjax(Request $request){
        if($request->ajax()){
            $dashboard=new Dashboard();
            $type_name=$request->type_name;
            $type_value=$request->type_value;
            if(!$type_name){
                $products=$dashboard->getProducts(['p.type'=>$type_value]);
                if(count($products)){
                    foreach($products as $product){
                        if (File::exists(public_path('attachments/products/'.strtolower($product->type).'/'.$product->image))) {
                            File::delete(public_path('attachments/products/'.strtolower($product->type).'/'.$product->image));
                        }
                        $dashboard->deleteData(['id'=>$product->id],'sg_product');
                    }
                    return json_encode([
                        'status'=>1,
                        'message'=>"Product removed successfullyqqqq!",
                    ]);
                }else{
                    return json_encode([
                        'status'=>0,
                        'message'=>"Something went wrong!",
                    ]);  
                }
            }else{
                $product=$dashboard->getProducts(['p.id'=>$request->type_value]);
                if(count($product)){
                    if (File::exists(public_path('attachments/products/'.strtolower($product[0]->type).'/'.$product[0]->image))) {
                        File::delete(public_path('attachments/products/'.strtolower($product[0]->type).'/'.$product[0]->image));
                    }
                    $dashboard->deleteData(['id'=>$request->id],'sg_product');
                    return json_encode([
                        'status'=>1,
                        'message'=>"Product removed successfully!",
                    ]);
                }else{
                    return json_encode([
                        'status'=>0,
                        'message'=>"Something went wrong!",
                    ]); 
                }
                
            }
            
            
        }
    }
    
    public function adminUploadProductAjax(Request $request){
        if($request->ajax()){
            $member=new Member();
            $product_image_name='';
                $product_image= $request->file('product_image');
                if(!empty($product_image)){
                    $new_name = rand() . '.' . $product_image->getClientOriginalExtension();
                    $product_image->move(public_path('attachments/products/'.strtolower($request->product_type)), $new_name);
                    $product_image_name=$new_name;
                }
                $brand_data=$member->getBrandList(['b.name'=>$request->brand]);
                $brand_id=0;
                if(count($brand_data)){
                    $brand_id=$brand_data[0]->id;
                }
                $response=$member->addUpdateData(
                    [
                        'id'=>0,
                        'name'=>$request->product_name,
                        'brand_id'=>$brand_id,
                        'type'=>$request->product_type,
                        'size'=>$request->product_size,
                        'description'=>$request->product_description,
                        'image'=>$product_image_name,
                        'status'=>1,
                        'added_date'=>now()
                    ],'sg_product');
                    $response['status']=1;

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

    public function adminMemberOrderDetails($id){
        if(!empty($id)){
            return view('admin.admin-member-order-details');
        }
        return redirect("/admin-member-list");  
    }

    public function adminStylistOrderDetails($id){
        if(!empty($id)){
            return view('admin.admin-stylist-order-details');
        }
        return redirect("/admin-stylist");  
    }
    
}