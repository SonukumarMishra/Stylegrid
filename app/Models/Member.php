<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
/*
@author-Sunil Kumar Mishra
date:19-10-2022
*/
class Member extends Model
{
    public $db;
	function getCountryList($where=[]){
		$this->db = DB::table('sg_country AS c');
		$this->db->select([
			"c.id",
			"c.country_code",
            "c.country_name",
			"c.status"
		]);
        if(count($where)){
			$this->db->where($where);
        }
		$response_data=$this->db->get();
		return $response_data;
	}
	function checkMemberExistance($where){
		if(count($where)){
			$this->db = DB::table('sg_member as m');
			$this->db->select([
				"m.id",
				"m.full_name as name",
				"m.email",
            	"m.phone",
            	"m.token",
				"m.verified"
			]);
			$this->db->where($where);
			$response_data=$this->db->get()->first();
			return $response_data;
		}
	}

	function checkStylistExistance($where){
		if(count($where)){
			$this->db = DB::table('sg_stylist as s');
			$this->db->select([
				"s.id",
				"s.full_name as name",
				"s.email",
            	"s.phone",
				"s.verified"
			]);
			$this->db->where($where);
			$response_data=$this->db->get()->first();
			return $response_data;
		}
	}
	function sourceApplicable($where){
		if(count($where)){
			$this->db = DB::table('sg_member_subscription as ms');
			$this->db->select([
				"ms.id",
				"ms.start_date",
				"ms.end_date",
				"ms.subscription",
				DB::raw("DATEDIFF(ms.end_date,'".date('Y-m-d')."') as day_left")
			]);
			$this->db->where($where);
			$this->db->orderBy("ms.id","DESC");
			$response_data=$this->db->get()->first();
			return $response_data;
		}
	}
	
	
	function getBrandList($where=[],$search='',$not_where_in=[]){
		$this->db = DB::table('sg_brand AS b');
		$this->db->select([
			"b.id",
			"b.name",
            "b.logo",
			"b.status"
		]);
        if(count($where)){
			$this->db->where($where);
        }
		/*$this->db->where(['b.brand_mg' => 0]);		*/
		if(!empty($search)){
			$this->db->where('b.name', 'LIKE', '%'.$search.'%');
		}
		if(!empty($not_where_in)){
			//$this->db->whereNotIn('b.id',$not_where_in[0]);
			$this->db->whereNotIn('b.id',$not_where_in);
		}
		$response_data=$this->db->get();
		return $response_data;
	}
	function addUpdateData($add_update_data,$table){
		if(count($add_update_data)>0){
			if(!empty($table)){
				if($add_update_data['id']>0){
					DB::table($table)
					->where(array('id'=>$add_update_data['id']))
					->update($add_update_data);
					$reference_id= $add_update_data['id'];
					$response=['status'=>1,'reference_id'=>$reference_id,'message'=>'Data successfully updated'];
				}else{
					DB::table($table)
					->insert($add_update_data);
					$reference_id= DB::getPdo()->lastInsertId();
					$response=['status'=>1,'reference_id'=>$reference_id,'message'=>'Data successfully added'];
				}
			}else{
				$response=['status'=>1,'reference_id'=>0,'message'=>'table missing'];
			}
		}else{
			$response=['status'=>1,'reference_id'=>0,'message'=>'Request data missing'];
		}
		return $response;
	}
	function getOfferData($where){
		if(count($where)){
        	$this->db = DB::table('sg_sourcing_offer as so');
			$this->db->select([
				"so.id",
				"so.sourcing_id",
				"so.stylist_id",
				"so.price",
				"so.status",
			]);
			$this->db->join('sg_sourcing AS s', 's.id', '=', 'so.sourcing_id');
			$this->db->where($where);
			$this->db->orderBy("so.id","DESC");
			$response_data=$this->db->get();
			return $response_data;
		}
	}
	function getSourceList($where=[],$where_date=[]){
        $this->db = DB::table('sg_sourcing AS s');
		$this->db->select([
			"s.id",
			"s.member_stylist_id",
			"s.member_stylist_type",
			"s.p_image",
			"s.p_name",
			"s.p_slug",
			"s.p_code",
			"b.name",
			"s.p_type",
			"s.p_size",
			"c.country_name",
			"s.p_deliver_date",
            "s.p_status",
			\DB::raw("COUNT(so.id) as total_offer"),
		]);
		$this->db->join('sg_country AS c', 'c.id', '=', 's.p_country_deliver');
		$this->db->join('sg_brand AS b', 'b.id', '=', 's.p_brand');
		$this->db->leftjoin('sg_sourcing_offer as so', 'so.sourcing_id', '=', 's.id');
        if(count($where)){
			$this->db->where($where);
        }
		if(count($where_date['whereDate'])){
			$this->db->whereDate($where_date['whereDate']['key'], $where_date['whereDate']['condition'], $where_date['whereDate']['value']);
		}
		$this->db->groupBy("s.id");
		$this->db->orderBy("s.id","DESC");
		$response_data=$this->db->get();
		return $response_data;
    }

	public function memberOfferDetails($where){
		if(count($where)){
			$this->db = DB::table('sg_sourcing_offer AS so');
			$this->db->select([
				"so.id",
				"so.sourcing_id",
				"so.stylist_id",
				"so.price",
				"so.status",
				"s.p_image",
				"s.p_name",
				"s.p_slug",
				"s.p_code",
				"b.name",
				"s.p_type",
				"s.p_size",
				"s.p_deliver_date",
			]);
			$this->db->join('sg_sourcing AS s', 's.id', '=', 'so.sourcing_id');
			$this->db->join('sg_brand AS b', 'b.id', '=', 's.p_brand');
			if(count($where)){
				$this->db->where($where);
			}
			$this->db->where('s.p_status', '<>', 'Fulfilled');
			$this->db->orderBy("so.id","DESC");
			$response_data=$this->db->get();
			return $response_data;
		}
	}

	function acceptOffer($offer_id){
		$this->db = DB::table('sg_sourcing_offer');
        $this->db->select(["sourcing_id"]);
        $this->db->where(['id'=>$offer_id]);
        $result=$this->db->get()->first();
		if($result){
			$sourcing_id=$result->sourcing_id;
			$this->db = DB::table('sg_sourcing');
			$this->db->where(array('id'=>$sourcing_id));
			$this->db->update(['p_status'=>'Fulfilled']);
			$this->db = DB::table('sg_sourcing_offer');
			$this->db->where(array('id'=>$offer_id));
			$this->db->update(['status'=>1]);
			return true;
		}
		return false;
	}

	function declineOffer($offer_id){
		$this->db = DB::table('sg_sourcing_offer');
        $this->db->select(["sourcing_id"]);
        $this->db->where(['id'=>$offer_id]);
        $result=$this->db->get()->first();
		if($result){
			$this->db = DB::table('sg_sourcing_offer');
			$this->db->where(array('id'=>$offer_id));
			$this->db->update(['status'=>2]);
			return true;
		}
		return false;
	}

	public function sourceNameExistance($where){
		if(count($where)){
			$this->db = DB::table('sg_sourcing');
        	$this->db->select(["id"]);
        	$this->db->where($where);
        	$result=$this->db->get()->first();
			return $result;
		}
		
	}
}