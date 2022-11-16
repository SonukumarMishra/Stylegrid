<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
/*
@author-Sunil Kumar Mishra
date:10-11-2022
*/
class Stylist extends Model
{
    public $db;	
	function getOfferData($where){
		if(count($where)){
        	$this->db = DB::table('sg_sourcing_offer as so');
			$this->db->select([
				"so.id",
				"so.sourcing_id",
				"so.sourcing_id",
				"so.stylelist_id",
				"so.price",
				"so.status",
				//\DB::raw("COUNT(so.id) as total_offer"),
			]);
			$this->db->join('sg_sourcing AS s', 's.id', '=', 'so.sourcing_id');
			$this->db->where($where);
			$this->db->orderBy("so.id","DESC");
			$response_data=$this->db->get();
			return $response_data;
		}
	}
	function getSourceList($where=[],$stylist_id=0,$where_date=[]){
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
		if($stylist_id>0){
			$this->db->where('s.member_stylist_id', '<>', $stylist_id);
		}

		//if(count($where_date['whereDate'])){
			//$this->db->whereDate($where_date['whereDate']['key'], $where_date['whereDate']['condition'], $where_date['whereDate']['value']);
		//}
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
				"so.stylelist_id",
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

	function memberAcceptOffer($offer_id){
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

	function memberDeclineOffer($offer_id){
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
}