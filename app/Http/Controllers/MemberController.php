<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\ChatRoom;
use App\Models\Stylist;
use Illuminate\Support\Str;
use App\Repositories\SourcingRepository as SourcingRepo;
use App\Repositories\CommonRepository as CommonRepo;
use DB;
use Log;
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

        $auth_id = Session::get("member_id");
        
        $assigned_stylist = $chat_room_dtls = false;

        if($auth_id){

            $member_dtls = Member::find($auth_id);

            if($member_dtls && !empty($member_dtls->assigned_stylist) && $member_dtls->assigned_stylist > 0){

                $assigned_stylist = Stylist::from('sg_stylist as stylist')
                                            ->where([
                                                'stylist.id' => $member_dtls->assigned_stylist
                                            ])
                                            ->leftjoin('sg_chat_room as room', function($leftJoin)use($auth_id){
                                                
                                                    $leftJoin->where(function ($q) use($auth_id) {
                                                            $q->where('room.sender_id', $auth_id)
                                                            ->where('room.sender_user', 'member');
                                                        })
                                                        ->orwhere(function ($q) use($auth_id) {
                                                            $q->where('room.receiver_id', $auth_id)
                                                            ->where('room.receiver_user', 'member');
                                                        })
                                                        ->where([
                                                            'module' => config('custom.chat_module.private'),
                                                            'is_active' => 1
                                                        ]);
                                            })
                                            ->select('stylist.*', 'room.chat_room_id')
                                            ->first();
            }
        }

        return view('member.dashboard.index', compact('assigned_stylist', 'chat_room_dtls'));
    
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

    public function memberSourcingOld()
    {
        $member=new Member();
        $source_applicable=$member->sourceApplicable(['ms.member_stylist_id'=>Session::get("member_id"),'ms.type_s_m'=>0]);
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

    public function memberSourcing()
    {
        try {

            $member = new Member();

            $source_applicable = $member->sourceApplicable(['ms.member_stylist_id'=>Session::get("member_id"),'ms.type_s_m'=>0]);
            
            if($source_applicable){
                $day_left=$source_applicable->day_left;
            }else{
                $day_left=-1; 
            }
           
            return view('member.dashboard.sourcing.index', compact('day_left'));
            
        }catch(\Exception $e){

            Log::info("memberSourcing error - ". $e->getMessage());
            return redirect()->back();
        }
    }

    public function getMemberSourcingLiveRequests(Request $request)
    {
        $result = SourcingRepo::getMemberSourcingLiveRequests($request);
        $view = '';

        if(isset($result['list'])){

            $list = $result['list'];
            $view = view("member.dashboard.sourcing.live-requests-ui", compact('list'))->render();

        }
        
        // response.data.data.links
        $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 
                            'data' => [
                                'view' => $view,
                                'json' => $result
                            ]  
                          ];

        return response()->json($response_array, 200);
    }

    public function memberSubmitRequest(Request $request){
        $member=new Member();
        $source_applicable=$member->sourceApplicable(['ms.member_stylist_id'=>Session::get("member_id"),'ms.type_s_m'=>0]);
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

                    // trigger pusher event to notify all stylist
                    $ref_data = [
                        'sourcing_id' => $response['reference_id']
                    ];

                    SourcingRepo::triggerPusherEventsForSourcingUpdates(config('custom.sourcing_pusher_action_type.new_request'), $ref_data);

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
    
     
    public function notificationsIndex()
    {
        try {

            return view('member.dashboard.notifications.index');
            
        }catch(\Exception $e){

            Log::info("stylistNotificationsIndex error - ". $e->getMessage());
            return redirect()->back();
        }
    }    
    
    public function notificationsList(Request $request) {
       
        try{

            $result = CommonRepo::get_all_notifications($request);

            $view = '';

            if(isset($result['list'])){

                $list = $result['list'];
                $view = view("member.dashboard.notifications.list-ui", compact('list'))->render();

            }

            // response.data.data.links
            $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 
                                'data' => [
                                    'view' => $view,
                                    'total_page' => $result['total_page']
                                ]  
                            ];

            return response()->json($response_array, 200);

        }catch(\Exception $e) {   

            return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

        }
    }
    
    public function unreadNotificationsList(Request $request) {
       
        try{

            $result = CommonRepo::get_unread_notifications($request);

            $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'),  'data' => $result ];

            return response()->json($response_array, 200);

        }catch(\Exception $e) {   

            return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

        }
    }

    public function readNotifications(Request $request) {
       
        try{

            $result = CommonRepo::mark_as_read_notifications($request);

            $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'),  'data' => $result ];

            return response()->json($response_array, 200);

        }catch(\Exception $e) {   

            return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

        }
    }
}
