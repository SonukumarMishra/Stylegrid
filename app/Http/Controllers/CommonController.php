<?php
// namespace App\Http\Controllers\Api;
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Member;
use Validator,Redirect;
use Config;
use Storage;

class CommonController extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
            
    }
	  
    public function get_stylist_clients_list(Request $request)
    {
        try {

            $list = Member::select("member.full_name AS label", 'member.id as value')
                                ->from('sg_member as member')
                                ->where([
                                        'member.status' => 1,
                                        'member.verified' => 1,
                                ]);

            if($request->filter){

                $member_ids = json_decode($request->member_ids, true);

                if(isset($member_ids) && is_array($member_ids)){

                    $list = $list->whereNotIn('member.id', $member_ids);

                }

                if(isset($request->stylist_id) && !empty($request->stylist_id)){

                    $list = $list->where('member.assigned_stylist', $request->stylist_id);

                }

                if(isset($request->search) && !empty($request->search)){

                    $search = $request->search;
                    $list = $list->where('member.full_name','LIKE',"%{$search}%");

                }

            }

            $list = $list->get();

            $response_array = array('status' => 1,  'message' => trans('pages.action_success'), 'data' => [ 'list' => $list] );

            return response()->json($response_array);

        }catch(\Exception $e) {

            Log::info("error get_stylist_clients_list ". print_r($e->getMessage(), true));
        
            return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

        }
    }

}
