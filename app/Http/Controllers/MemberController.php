<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Str;
use Session;
/*
@author-Sunil Kumar Mishra
date:19-10-2022
*/
class MemberController extends Controller
{
 
    public function __construct(){
            $this->middleware(function ($request, $next) {
            if(!Session::get("Memberloggedin")) {
                return redirect("/member-login");
            }
            return $next($request);
        });
    }
    
    public function memberDashboard(Request $request){
        return view('member.dashboard.index');
    }

    public function memberGrid()
    {
        return view('member.dashboard.member-grid');
    }
    public function memberGridDetails()
    {
        return view('member.dashboard.member-grid-details');
    }

    public function memberOrders()
    {
        return view('member.dashboard.member-orders');
    }
    public function memberSourcing()
    {
        $member=new Member();
        $source_applicable=$member->sourceApplicable(['ms.member_id'=>Session::get("member_id")]);
        if($source_applicable){
            $day_left=$source_applicable->day_left;
        }else{
            $day_left=-1; 
        }
        $source_list=$member->getSourceList(['s.member_stylist_type'=>'0','s.member_stylist_id'=>Session::get("member_id")],['whereDate'=>['key'=>'s.p_deliver_date','condition'=>'>=','value'=>date('Y-m-d')]]);
        $source_list_data=[];
        foreach($source_list as $source){
            $data=array(
                'p_name'=>$source->p_name,
                'p_size'=>$source->p_size,
                'p_type'=>$source->p_type,
                'p_slug'=>$source->p_slug,
                'name'=>$source->name,
                'country_name'=>$source->country_name,
                'p_deliver_date'=>$source->p_deliver_date,
                'total_offer'=>$source->total_offer,
                'p_status'=>$source->p_status,
                'pending_offer'=>$source->total_offer,
                'accepted_offer'=>0,
                'decline_offer'=>0,
            );
            if($source->total_offer>0){
                $data['pending_offer'] =count($member->getOfferData(['so.sourcing_id'=>$source->id,'so.status'=>'0']));
                $data['accepted_offer'] =count($member->getOfferData(['so.sourcing_id'=>$source->id,'so.status'=>'1']));
                $data['decline_offer'] =count($member->getOfferData(['so.sourcing_id'=>$source->id,'so.status'=>'2']));
            }
            $source_list_data[]=$data;
        }
        $previous_source_list=$member->getSourceList(['s.member_stylist_type'=>'0','s.member_stylist_id'=>Session::get("member_id")],['whereDate'=>['key'=>'s.p_deliver_date','condition'=>'<','value'=>date('Y-m-d')]]);
        return view('member.dashboard.source-list',compact('source_list_data','previous_source_list','day_left'));
    }

    public function memberSubmitRequest(Request $request){
        $member=new Member();
        $source_applicable=$member->sourceApplicable(['ms.member_id'=>Session::get("member_id")]);
        if($source_applicable){
            $day_left=$source_applicable->day_left;
            if($day_left<0){
                return redirect("/member-sourcing");
            }
            $country_list=$member->getCountryList();
            $brand_list=$member->getBrandList();
            return view('member.dashboard.member-submit-request',compact('country_list','brand_list'));
        }
    }

    public function memberSubmitRequestPost(Request $request){
        if($request->ajax()){
            $member=new Member();
            if(!$member->sourceNameExistance(['p_name'=>$request->product_name])){
                $source_image_name='';
                $source_image= $request->file('source_image');
                if(!empty($source_image)){
                    $new_name = rand() . '.' . $source_image->getClientOriginalExtension();
                    $source_image->move(public_path('attachments/source'), $new_name);
                    $source_image_name=$new_name;
                }
                $member=new Member();
                $brand_data=$member->getBrandList(['b.name'=>$request->brand]);
                if(count($brand_data)){
                    $brand=$brand_data[0]->id;
                }else{
                    $brand_data=$member->addUpdateData(['id'=>0,'name'=>$request->brand,'brand_mg'=>1],'sg_brand');
                    $brand=$brand_data['reference_id'];
                }
                $product_name=$request->product_name;
                $product_type=$request->product_type;
                $product_size=$request->product_size;
                $country=$request->country;
                $deliver_date=$request->deliver_date;
                $add_update_data=array(
                    'id'=>0,
                    'p_image'=>$source_image_name,
                    'p_name'=>$product_name,
                    'p_slug'=>Str::slug($product_name, '-'),
                    'p_brand'=>$brand,
                    'p_type'=>$product_type,
                    'p_size'=>$product_size,
                    'p_code'=>'',
                    'p_status'=>'Pending',
                    'p_country_deliver'=>$country,
                    'p_deliver_date'=>date('Y-m-d',strtotime($deliver_date)),
                    'member_stylist_type'=>0,
                    'member_stylist_id'=>Session::get("member_id"),
                );
                
                $response=$member->addUpdateData($add_update_data,'sg_sourcing');   
                if($response['reference_id']>0){
                    $member->addUpdateData(['id'=>$response['reference_id'],'p_slug'=>$add_update_data['p_slug'].'-'.$response['reference_id']],'sg_sourcing');   
                }
            }else{
                $response['status']=0;
                $response['message']="source name already exists!";
            }
            return json_encode($response);
        }  
    }

    public function memberSubmitRequestComplete(Request $request){       
        return view('member.dashboard.member-submit-request-complete');
    }
    public function memberOfferReceived($id){
        $member=new Member();
        $offer_list=$member->memberOfferDetails(['s.p_slug'=>$id]);
        if(!count($offer_list)){
            return redirect('/member-sourcing');
        }
        return view('member.dashboard.multiple-offer-received',compact('offer_list'));
    }
    public function memberOfferAcceptedSuccessful(Request $request){
        return view('member.dashboard.member-offer-accepted');
    }

    public function memberAcceptOffer(Request $request){
        if($request->ajax()){
            $member=new Member();
            $selected_offer_id=$request->selected_offer_id;
            if(!empty($selected_offer_id)){
                $response['status']=$member->acceptOffer($selected_offer_id);
            }else{
                $response['status']=0;
            }
            return json_encode($response);
        }  
    }

    public function memberDeclineOffer(Request $request){
        if($request->ajax()){
            $member=new Member();
            $decline_offer_id=$request->decline_offer_id;
            if(!empty($decline_offer_id)){
                $response['status']=$member->declineOffer($decline_offer_id);
            }else{
                $response['status']=0;
            }
            return json_encode($response);
        }  
    }
    
    
    
}
