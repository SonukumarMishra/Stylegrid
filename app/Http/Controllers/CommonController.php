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

            $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

            $limit = (int)$request->input('length') > 0 ? $request->input('length') : config('custom.default_page_limit');
            $columnIndex = $request->input('order')[0]['column']; // Column index
            $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
            $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

            $main_query = Member::select("member.full_name AS label", 'member.id as value')
                                ->from('sg_member as member')
                                ->where([
                                        'member.status' => 1,
                                        'member.verified' => 1,
                                ])
                                ->whereNotIn('member.id', function ($query) use($request) {
                                    $query->select('client.member_id')
                                            ->from('sg_grid_clients as client')
                                            ->where('client.is_active', 1)
                                            ->where('client.stylegrid_id', $request->stylegrid_id);
                                })
                                ->orderBy('member.id');

            if(isset($request->stylist_id) && !empty($request->stylist_id)){

                $main_query = $main_query->where('member.assigned_stylist', $request->stylist_id);

            }
                
            // $member_ids = json_decode(@$request->member_ids, true);

            // if(isset($member_ids) && is_array($member_ids)){

            //     $main_query = $main_query->whereNotIn('member.id', $member_ids);

            // }
                     
            if(!empty($request->input('search.value'))){

                $search = $request->input('search.value'); 
            
                $main_query = $main_query->where(function ($query) use ($search) {
                                            $query->where('member.full_name', 'LIKE',"%{$search}%");
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
