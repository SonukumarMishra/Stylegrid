<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Dashboard;
use App\Repositories\UserRepository as UserRepo;
use App\Repositories\SubscriptionRepository as SubscriptionRepo;
use App\Repositories\PaymentRepository as PaymentRepo;
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
    public function adminCancelMembershipOld(Request $request){
        if($request->ajax()){
            $member=new Member();
            $response=$member->addUpdateData(['id'=>$request->member_id,'membership_cancelled'=>1,'reason_of_cancellation'=>$request->reason_for_cancellation,'cancellation_datetime'=>now()],'sg_member');
            
            UserRepo::cancel_user_subscription($request, $request->member_id, config('custom.user_type.member'));

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

     
    public function adminCancelMemberMembership(Request $request)
	{
        try{

            $user_data = [
                'user_id' => $request->user_id,
                'user_type' => $request->user_type
            ];

            $response_array = PaymentRepo::cancel_stripe_subscription($request, $user_data);
          
            return response()->json($response_array, 200);

        }catch(\Exception $e){

            Log::info("error adminCancelMemberMembership - ". $e->getMessage());
            
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

    public function adminCancelStylistMembership(Request $request){
        if($request->ajax()){
            $member=new Member();
            $response=$member->addUpdateData(['id'=>$request->stylist_id,'membership_cancelled'=>1,'reason_of_cancellation'=>$request->reason_for_cancellation,'cancellation_datetime'=>now()],'sg_stylist');
            
            UserRepo::cancel_user_subscription($request, $request->stylist_id, config('custom.user_type.stylist'));

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
                    'applied_date'=>date('m/d/Y',strtotime($result->added_date)),
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
                        'message'=>"Product removed successfully!",
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
                    $dashboard->deleteData(['id'=>$request->type_value],'sg_product');
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
                if($request->id>0){
                   
                    $dashboard=new Dashboard();
                    $product=$dashboard->getProducts(['p.id'=>$request->id]);
                    if(count($product)){
                       if(!empty($product_image_name)){
                        if (File::exists(public_path('attachments/products/'.strtolower($product[0]->type).'/'.$product[0]->image))) {
                            File::delete(public_path('attachments/products/'.strtolower($product[0]->type).'/'.$product[0]->image));
                        }
                       }else{
                        $product_image_name=$product[0]->image;
                    } 
                    }
                }
                if(empty($product_image_name)){
                    return json_encode(['status'=>0,'message'=>'Please select image']);
                }
                $response=$member->addUpdateData(
                    [
                        'id'=>$request->id?$request->id:0,
                        'name'=>$request->product_name,
                        'brand_name'=>$request->brand,
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

    public function adminSettings(Request $request){
        return view('admin.admin-settings');
    }
    public function adminProfileSettings(Request $request){
        $member=new Member();
        $country_list=$member->getCountryList();
        return view('admin.admin-profile-settings',compact('country_list'));
    }
    public function adminUpdateProfileSettingsAjax(Request $request){
        if($request->ajax()){
            $admin_image_name='';
            $admin_image= $request->file('admin_image');
             if(!empty($admin_image)){
                $new_name = rand() . '.' . $admin_image->getClientOriginalExtension();
                $admin_image->move(public_path('attachments/admin/profile'), $new_name);
                $admin_image_name=$new_name;
            }
            if (File::exists(public_path('attachments/admin/profile/'.Session::get("admin_data")->image)) && !empty($admin_image_name)) {
                File::delete(public_path('attachments/admin/profile/'.Session::get("admin_data")->image));
            }
            $update_data=[
                'id'=>Session::get("admin_data")->id,
                'currency'=>$request->admin_currency,
                'country_id'=>$request->admin_country_id,
                'admin_received_email'=>$request->admin_received_email,
                'email'=>$request->admin_email,
            ];
            if(!empty($admin_image_name)){
                $update_data['image']=$admin_image_name; 
            }
            $member=new Member();
            $member->addUpdateData($update_data,'sg_admin');
            $dashboard=new Dashboard();
            $response=$dashboard->adminLogin(['a.id'=>Session::get("admin_data")->id]);
            Session::put('admin_data',$response);
            return json_encode([
                'status'=>1,
                'message'=>'profile updated successfully'
                ]);
        }
    }  

    public function memberSubscriptionBillingDetails(Request $request)
	{
        try{

            $user_data = [
                'user_id' => $request->user_id,
                'user_type' => $request->user_type
            ];

            $result = SubscriptionRepo::get_subscription_billing_details($request, $user_data);
           
            $view = '';

            $view = view("admin.member.subscription.billing-content", compact('result'))->render();

            $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 
                                'data' => [
                                    'view' => $view,
                                ]  
                            ];

            return response()->json($response_array, 200);

        }catch(\Exception $e){

            Log::info("error memberSubscriptionBillingDetails - ". $e->getMessage());
            
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

    public function getMemberSubscriptioninvoiceHistory(Request $request)
	{
        try{

            $user_data = [
                'user_id' => $request->user_id,
                'user_type' => $request->user_type
            ];

            $invoice_history = SubscriptionRepo::get_subscription_invoice_history($request, $user_data);
          
            $response = array(
                "draw" => (int)$request->input('draw'),
                "recordsTotal" => $invoice_history['total'],
                "recordsFiltered" => $invoice_history['total'],
                "data" => $invoice_history['list'],
            );
           
            return response()->json($response, 200);

        }catch(\Exception $e){

            Log::info("error getMemberSubscriptioninvoiceHistory - ". $e->getMessage());
            
            $response_array = ['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage() ];

            return response()->json($response_array, 200);
        }

	}

}