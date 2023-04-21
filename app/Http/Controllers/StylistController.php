<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Stylist;
use App\Models\ProductInvoice;
use App\Models\MemberTempInvoiceItems;
use App\Models\ProductInvoiceItems;
use App\Models\StyleGridProductDetails;
use Illuminate\Support\Str;
use App\Repositories\SourcingRepository as SourcingRepo;
use App\Repositories\CommonRepository as CommonRepo;
use App\Repositories\GridRepository as GridRepo;
use App\Models\StyleGrids;
use Session;
use Log;
use DB;

/*
@author-Sunil Kumar Mishra
date:09-11-2022
*/
class StylistController extends Controller
{
 
    public function __construct(){
            $this->middleware(function ($request, $next) {
            if(!Session::get("Stylistloggedin")) {
                return redirect("/stylist-login");
            }
            return $next($request);
        });
    }
    
    public function stylistDashboard(Request $request){

        $request = new \Illuminate\Http\Request();

        // $myRequest = new \Illuminate\Http\Request();
        $request->setMethod('POST');

        $request->request->add(['user_id' => Session::get("stylist_id")]);

        $grids = StyleGrids::from('sg_stylegrids as grid')
                            ->select('grid.*')
                            ->where([
                                'grid.is_active' => 1,
                                'grid.stylist_id' => Session::get("stylist_id")
                            ])
                            ->orderBy('grid.stylegrid_id', 'desc')
                            ->take(5)
                            ->get();

        $currentMonth = date('m');

        $monthly_product_invoice_dtls = ProductInvoice::from('sg_product_invoices as invoice')
                                                        ->where('invoice.stylist_id', Session::get("stylist_id"))
                                                        ->where('invoice.is_active', 1)
                                                        ->whereRaw('MONTH(invoice.created_at) = ?',[$currentMonth])
                                                        ->select( DB::raw('COUNT(invoice.product_invoice_id) AS invoice_count'),  DB::raw('SUM(invoice.invoice_amount) AS total_invoice_amount'))
                                                        ->first();

        $sourcing_list = SourcingRepo::getStylistSourcingLiveRequests($request);

        $weekly_total_sourcing = SourcingRepo::getStylistSourcingLiveRequestsWeeklyCount($request);
                    
        $clients_dtls = DB::table('sg_member AS m')
                            ->select(DB::raw('COUNT(m.id) AS client_count'))
                            ->where('m.assigned_stylist', Session::get("stylist_id"))
                            ->first();

        return view('stylist.postloginview.dashboard', compact('grids', 'monthly_product_invoice_dtls', 'sourcing_list', 'weekly_total_sourcing', 'clients_dtls'));
    }

    public function stylistSourcingOld()
    {
        $stylist=new Stylist();
        $member=new Member();
        $source_list=$stylist->getSourceList([],Session::get("stylist_id"));
        $source_data=[];
        foreach($source_list as $source){
            $ticket_data=array(
                'p_name'=>$source->p_name,
                'p_size'=>$source->p_size,
                'p_type'=>$source->p_type,
                'p_slug'=>$source->p_slug,
                'name'=>$source->name,
                'country_name'=>$source->country_name,
                'p_deliver_date'=>$source->p_deliver_date,
                'total_offer'=>$source->total_offer,
                'p_status'=>$source->p_status,
                'requested'=>0,
            );
            $ticket_data['requested'] =count($member->getOfferData(['so.sourcing_id'=>$source->id,'so.stylist_id'=>Session::get("stylist_id")]));
            $source_data[]=$ticket_data;
        }
        $my_source=$stylist->getSourceList(['s.member_stylist_type'=>1,'s.member_stylist_id'=>Session::get("stylist_id")]);
        $my_source_data=[];
        foreach($my_source as $source){
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
            $my_source_data[]=$data;
        }
        return view('stylist.postloginview.stylist-sourcing',compact('source_data','my_source_data'));
    }
    
    public function stylistSourcing()
    {
        try {

            return view('stylist.postloginview.sourcing.index');
            
        }catch(\Exception $e){

            Log::info("stylistSourcing error - ". $e->getMessage());
            return redirect()->back();
        }
    }

    public function getStylistSourcingRequests(Request $request)
    {
        if($request->type == 'my_sources'){

            $result = SourcingRepo::getStylistSourcingOwnRequests($request);

        }else{

            $result = SourcingRepo::getStylistSourcingLiveRequests($request);

        }

        $list_view = '';
        $grid_view = '';

        if(isset($result['list'])){

            $list = $result['list'];
            
            if($request->type == 'my_sources'){
                $list_view = view("stylist.postloginview.sourcing.my-requests-ui", compact('list'))->render();
                $grid_view = view("stylist.postloginview.sourcing.my-requests-ui-grid", compact('list'))->render();
            }else{
                $list_view = view("stylist.postloginview.sourcing.live-requests-ui", compact('list'))->render();
                $grid_view = view("stylist.postloginview.sourcing.live-requests-ui-grid", compact('list'))->render();
            }

        }
        
        // response.data.data.links
        $response_array = [ 'status' => 1, 'message' => trans('pages.action_success'), 
                            'data' => [
                                'list_view' => $list_view,
                                'grid_view' => $grid_view,
                                'json' => $result
                            ]  
                          ];

        return response()->json($response_array, 200);
    }

    public function stylistFulfillSourceRequest($id){
        $stylist=new Stylist();
        $source=$stylist->getSourceList(['s.p_slug'=>$id]);
        if(!count($source)){
            return redirect('/stylist-sourcing');
        }else{
            $source_data=$source[0];
            $member=new Member();
            $requested=count($member->getOfferData(['so.sourcing_id'=>$source_data->id,'so.stylist_id'=>Session::get("stylist_id")]));
            if($requested){
                return redirect('/stylist-sourcing');
            }
        }
        return view('stylist.postloginview.stylist-fulfill-source-request',compact('source_data'));
    }
    
    public function stylistFulfillSourceRequestPost(Request $request){
        if($request->ajax()){
            $member=new Member();
            $requested=count($member->getOfferData(['so.sourcing_id'=>$request->source_id,'so.stylist_id'=>Session::get("stylist_id")]));
            if(!$requested){
                $response=$member->addUpdateData(array(
                    'id'=>0,
                    'sourcing_id'=>$request->source_id,
                    'stylist_id'=>Session::get("stylist_id"),
                    'price'=>$request->source_price,
                    'offer_details'=>$request->offer_details,
                    'offer_date'=>now()
                ),'sg_sourcing_offer');
                if($response['reference_id']>0){

                    // trigger pusher event to notify memebr/stylist for thier sourcing

                    $ref_data = [
                        'sourcing_offer_id' => $response['reference_id']
                    ];

                    SourcingRepo::triggerPusherEventsForSourcingUpdates(config('custom.sourcing_pusher_action_type.offer_received'), $ref_data);

                    $response['status']=1;
                    $response['message']="Source request sent Successfully!";
                }else{
                    $response['status']=0;
                    $response['message']="something went wrong!";
                }
            }else{
                $response['status']=0;
                $response['message']="sorry, You have already requested for this source!";
            }
            
            return json_encode($response);
        }  
    }

    public function stylistSourceRequestSubmit()
    {
        return view('stylist.postloginview.stylist-source-request-submit');
    }

    public function stylistCreateSourceRequest(Request $request){
        $member=new Member();
        $country_list=$member->getCountryList();
        return view('stylist.postloginview.stylist-create-source-request',compact('country_list'));
    }

    public function stylistSubmitRequestPost(Request $request){
        if($request->ajax()){
            $member=new Member();
            if(!$member->sourceNameExistance(['p_name'=>ucfirst($request->product_name)])){
                $source_image_name='';
                $source_image= $request->file('source_image');
                if(!empty($source_image)){
                    $new_name = rand() . '.' . $source_image->getClientOriginalExtension();
                    $source_image->move(public_path('attachments/source'), $new_name);
                    $source_image_name=$new_name;
                }
                
                $brand_data=$member->getBrandList(['b.name'=>$request->brand]);
                if(count($brand_data)){
                    $brand=$brand_data[0]->id;
                }else{
                    $brand_data=$member->addUpdateData(['id'=>0,'name'=>$request->brand,'brand_mg'=>1],'sg_brand');
                    $brand=$brand_data['reference_id'];
                }
                $product_name=ucfirst($request->product_name);
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
                    'p_details'=>$request->p_details,
                    'p_code'=>'',
                    'p_status'=>'Pending',
                    'p_country_deliver'=>$country,
                    'p_deliver_date'=>date('Y-m-d',strtotime($deliver_date)),
                    'member_stylist_type'=>1,
                    'member_stylist_id'=>Session::get("stylist_id"),
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
    public function stylistSubmitRequestComplete(Request $request){
        return view('stylist.postloginview.stylist-source-request-submit');
    }

    public function stylistOfferReceived($id){
        $member=new Member();
        $offer_list=$member->memberOfferDetails(['s.p_slug'=>$id]);
        if(!count($offer_list)){
            return redirect('/stylist-sourcing');
        }
        return view('stylist.postloginview.stylist-multiple-offer-received',compact('offer_list'));
    }


    public function stylistOfferAcceptedSuccessful(Request $request){
        return view('stylist.postloginview.stylist-offer-accepted');
    }

    public function stylistAcceptOffer(Request $request){
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

    public function stylistDeclineOffer(Request $request){
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
                $response['status']=$member->memberAcceptOffer($selected_offer_id);
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
                $response['status']=$member->memberDeclineOffer($decline_offer_id);
            }else{
                $response['status']=0;
            }
            return json_encode($response);
        }  
    }
    
    public function notificationsIndex()
    {
        try {

            return view('stylist.postloginview.notifications.index');
            
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
                $view = view("stylist.postloginview.notifications.list-ui", compact('result'))->render();

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

    public function sourcingRequestView($slug){
        
        try {

            $sourcing_details = SourcingRepo::getSourcingRequestDetail($slug);

            return view('stylist.postloginview.sourcing.view', compact('sourcing_details'));
            
        }catch(\Exception $e){

            Log::info("sourcingRequestView error - ". $e->getMessage());
            return redirect()->back();
        }

    }

    public function sourcingRequestGenerateInvoice(Request $request){
        
        try {

            $result = SourcingRepo::generateSourcingInvoice($request);

            return response()->json($result, 200);
            
        }catch(\Exception $e){

            Log::info("sourcingRequestGenerateInvoice error - ". $e->getMessage());
            return redirect()->back();
        }

    }

    
    public function paymentsIndex()
    {
        try {

            return view('stylist.postloginview.payments.index');
            
        }catch(\Exception $e){

            Log::info("paymentsIndex error - ". $e->getMessage());
            return redirect()->back();
        }
    }    
    
    public function paymentsCreatePaymentIndex()
    {
        try {

            $customers = Member::select("member.full_name AS label", 'member.id as value')
                            ->from('sg_member as member')
                            ->where([
                                    'member.status' => 1,
                                    'member.verified' => 1,
                            ])
                            ->where('member.assigned_stylist', Session::get("stylist_id"))
                            ->get();


            return view('stylist.postloginview.payments.create', compact('customers'));
            
        }catch(\Exception $e){

            Log::info("paymentsCreatePaymentIndex error - ". $e->getMessage());
            return redirect()->back();
        }
    }    

    public function getMemberTempInvoiceItemsOld(Request $request)
    {
        try {

            $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

            $limit = (int)$request->input('length') > 0 ? $request->input('length') : config('custom.default_page_limit');
            $columnIndex = $request->input('order')[0]['column']; // Column index
            $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
            $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

            $main_query = MemberTempInvoiceItems::select('temp_item.temp_invoice_item_id', 'grid.stylegrid_id', 'temp_item.stylegrid_product_id', 'grid.title as stylegrid_title', 'temp_item.amount', 'product.product_name', 'product.product_brand', 'product.product_type', 'product.product_size', 'product.product_image')
                                                ->from('sg_member_temp_invoice_items as temp_item')
                                                ->where([
                                                        'temp_item.association_id' => $request->member_id,
                                                        'temp_item.association_type_term' => config('custom.user_type.member'),
                                                ])
                                                ->join('sg_stylegrids as grid', function($join) {
                                                    $join->on('grid.stylegrid_id', '=', 'temp_item.stylegrid_id');
                                                })
                                                ->leftjoin('sg_stylegrid_product_details as product', 'product.stylegrid_product_id', '=', 'temp_item.stylegrid_product_id')
                                                ->orderBy('temp_item.temp_invoice_item_id', 'desc');
          
            $temp_invoice_item_ids = json_decode($request->temp_invoice_item_ids, true);

            if(isset($temp_invoice_item_ids) && is_array($temp_invoice_item_ids)){

                $main_query = $main_query->whereNotIn('temp_item.temp_invoice_item_id', $temp_invoice_item_ids);

            }

            if(!empty($request->input('search.value'))){

                $search = $request->input('search.value'); 
            
                $main_query = $main_query->where(function ($query) use ($search) {
                                            $query->where('grid.title', 'LIKE',"%{$search}%")
                                                ->orwhere('product.product_name', 'LIKE',"%{$search}%");
                                        });
            
            }
             
            $list = $main_query->paginate($limit, ['*'], 'page', $page_index);

            $response = array(
                "draw" => (int)$request->input('draw'),
                "recordsTotal" => $list->total(),
                "recordsFiltered" => $list->total(),
                "data" => $list->getCollection(),
            );
           
            return response()->json($response, 200);
 
        }catch(\Exception $e) {

            $response = array(
                "draw" => (int)$request->input('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
            );

            Log::info("error getMemberTempInvoiceItems ". print_r($e->getMessage(), true));
        
            return response()->json($response, 200);

        }
    }

    public function getMemberTempInvoiceItems(Request $request)
    {
        try {

            $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

            $limit = (int)$request->input('length') > 0 ? $request->input('length') : config('custom.default_page_limit');
            $columnIndex = $request->input('order')[0]['column']; // Column index
            $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
            $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

            $main_query = StyleGridProductDetails::select('grid.stylegrid_id', 'product.stylegrid_product_id', 'grid.title as stylegrid_title', 'product.product_price as amount', 'product.product_name', 'product.product_brand', 'product.product_type', 'product.product_size', 'product.product_image')
                                                ->from('sg_stylegrid_product_details as product')
                                                ->where([
                                                        'product.created_by' => $request->user_id
                                                ])
                                                ->join('sg_stylegrids as grid', function($join) {
                                                    $join->on('grid.stylegrid_id', '=', 'product.stylegrid_id');
                                                })
                                                // ->leftjoin('sg_stylegrid_product_details as product', 'product.stylegrid_product_id', '=', 'temp_item.stylegrid_product_id')
                                                ->orderBy('product.stylegrid_product_id', 'desc');
          
          
            $temp_invoice_item_ids = json_decode($request->temp_invoice_item_ids, true);

            if(isset($temp_invoice_item_ids) && is_array($temp_invoice_item_ids)){

                $main_query = $main_query->whereNotIn('product.stylegrid_product_id', $temp_invoice_item_ids);

            }

            if(!empty($request->input('search.value'))){

                $search = $request->input('search.value'); 
            
                $main_query = $main_query->where(function ($query) use ($search) {
                                            $query->where('grid.title', 'LIKE',"%{$search}%")
                                                ->orwhere('product.product_name', 'LIKE',"%{$search}%");
                                        });
            
            }
             
            $list = $main_query->paginate($limit, ['*'], 'page', $page_index);

            $response = array(
                "draw" => (int)$request->input('draw'),
                "recordsTotal" => $list->total(),
                "recordsFiltered" => $list->total(),
                "data" => $list->getCollection(),
            );
           
            return response()->json($response, 200);
 
        }catch(\Exception $e) {

            $response = array(
                "draw" => (int)$request->input('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
            );

            Log::info("error getMemberTempInvoiceItems ". print_r($e->getMessage(), true));
        
            return response()->json($response, 200);

        }
    }

    public function createProductInvoice(Request $request) {
		
		$result = ['status' => 0, 'message' => trans('pages.something_wrong')];

		try {
            
            $items = json_decode($request->items, true);
           
			$invoice = new ProductInvoice;
            $invoice->stylist_id = $request->stylist_id;
            $invoice->member_id = $request->member_id;
            $invoice->invoice_no = \Helper::generate_product_invoice_no();
            $invoice->invoice_amount = $request->invoice_amount;
            $invoice->paid_amount = $request->invoice_amount;
            $invoice->no_of_items = count($items);
            $invoice->invoice_status = config('custom.product_invoice.status.pending');
            $invoice->save();

            if($invoice){
                
                // $remove_temp_ids = [];

                foreach ($items as $key => $value) {
                    
                    $invoice_item = new ProductInvoiceItems;
                    $invoice_item->stylegrid_id = $value['stylegrid_id'];
                    $invoice_item->stylegrid_product_id = $value['stylegrid_product_id'];
                    $invoice_item->product_invoice_id = $invoice->product_invoice_id;
                    $invoice_item->price = $value['amount'];
                    $invoice_item->save();
                    
                    // $remove_temp_ids[] = $value['temp_invoice_item_id'];

                }

                // if(count($remove_temp_ids)){

                //     MemberTempInvoiceItems::whereIn('temp_invoice_item_id', $remove_temp_ids)->delete();

                // }

                $notify_users = [[
                    'association_id' => $request->member_id,
                    'association_type_term' => config('custom.user_type.member')
                ]];

                if(count($notify_users)){

                    $notification_obj = [
                        'type' => config('custom.notification_types.product_invoice_generated'),
                        'title' => trans('pages.notifications.product_invoice_generated_title'),
                        'description' => trans('pages.notifications.product_invoice_generated_des', ['amount' => $invoice->invoice_amount, 'title' => $invoice->invoice_no ]),
                        'data' => [
                            'product_invoice_id' => $invoice->product_invoice_id,
                        ],
                        'users' => $notify_users
                    ];

                    CommonRepo::save_notification($notification_obj);

                }

                $result['status'] = 1;
                $result['message'] = trans('pages.sourcing_invoice_generated');

            }	

			return $result;

		}catch(\Exception $e) {

            Log::info("error createProductInvoice ". print_r($e->getMessage(), true));

			return $result;

        }

	}   
    
    public function getProductPaymentsJson(Request $request)
    {
        $result = GridRepo::getUserProductPaymentsJson($request);
        
        $view = '';

        if(isset($result['list'])){

            $list = $result['list'];
            
            $view = view("stylist.postloginview.payments.list-ui", compact('list'))->render();

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

      
    public function clientIndex()
    {
        try {

            return view('stylist.postloginview.client.index');
            
        }catch(\Exception $e){

            Log::info("clientIndex error - ". $e->getMessage());
            return redirect()->back();
        }
    }  

    public function getClientsJson(Request $request)
    {
        $result = [ 'list' => [] ];
        
        $page_index = isset($request->page) ? $request->page : 1;
			
        $list = DB::table('sg_member AS m')
                    ->select(["m.id", "m.full_name", "m.gender", "c.country_name", "m.email", "m.membership_cancelled", "m.phone", "m.id as spend", \DB::raw("DATE_FORMAT(m.added_date, '%m/%d/%Y %H:%i') as added_date"), "m.slug", "m.default_stylist_total_payment"])
                    ->join('sg_country as c', 'c.id', '=', 'm.country_id')
                    ->where('m.assigned_stylist', $request->stylist_id)
                    ->orderBy('m.id', 'desc');
            
        $list = $list->paginate(10, ['*'], 'page', $page_index);

        $result['list'] = $list;

        $view = '';

        if(isset($result['list'])){

            $list = $result['list'];
            
            $view = view("stylist.postloginview.client.list-ui", compact('list'))->render();

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

}
