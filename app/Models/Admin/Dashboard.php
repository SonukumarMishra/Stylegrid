<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use DB;
/*
@author-Sunil Kumar Mishra
date:26-11-2022
*/
class Dashboard extends Model
{
    public $db;
	function adminLogin($where){
		if(count($where)){
			$this->db = DB::table('sg_member AS m');
			$this->select(["a.id","a.name","a.email","a.phone"]);
			$this->db->where($where);
			$result=$this->db->get();
			return $result;	
		}
	}
	function adminMemberListAjax($data,$count=false){
 		$this->db = DB::table('sg_member AS m');
		$this->db->select([
			"m.id",
			"m.full_name",
			"m.gender",
			"c.country_name",
			"m.email",
			"m.membership_cancelled",
			"m.phone",
			"m.id as spend",
			\DB::raw("DATE_FORMAT(m.added_date, '%m/%d/%Y %H:%i') as added_date"),
			"m.subscription",
			"m.slug",
		]);
		$this->db->join('sg_country as c', 'c.id', '=', 'm.country_id');
		if($data['search']!=''){
			$search=$data['search'];
            $this->db->where(function($query) use ($search) {
                $query->where('m.full_name', 'LIKE', '%'.$search.'%')
				->orWhere('m.phone', 'LIKE', '%'.$search.'%')
				->orWhere('m.gender', 'LIKE', '%'.$search.'%')
				->orWhere('c.country_name', 'LIKE', '%'.$search.'%')
				->orWhere('m.email', 'LIKE', '%'.$search.'%');
            });
		}
		if($data['order'][0]['column']!=''){
			$order_by = '';
				switch ($data['order'][0]['column']) {
					case 0:
					$order_by = 'm.full_name';
					break;
					
					case 1:
					$order_by = 'm.gender';
					break;
					
					case 2:
					$order_by = 'c.country_name';
					break;
					
					case 3:
					$order_by = 'm.email';
					break;
					
					case 4:
					$order_by = 'm.phone';
					break;
					
					case 5:
					$order_by = 'm.added_date';
					break;
					
					case 6:
					$order_by = 'm.id';
					break;
					
					case 7:
					$order_by = 'm.subscription';
					break;
					
					default:
					$order_by = 'm.id';
					break;
				}
			$dir_by = '';
			switch ($data['order'][0]['dir']) {
	
				case 'asc':
					$dir_by = 'asc';
					break;
				case 'desc':
					$dir_by = 'desc';
					break;
				default:
					$dir_by = 'asc';
					break;
			}
		}else{
			$order_by='m.id';
			$dir_by = 'asc';
		}
		$this->db->orderBy($order_by,$dir_by);
		
		if($count){
			$memberData=$this->db->get();
			return  count($memberData);
			
		}else{
			if($data['start']<0 || !isset($data['start'])){
				$data['start']=0; 
			}
			if($data['length']<0 || !isset($data['length'])){
				$data['length']=5; 
			}
			$this->db->offset($data['start']);
			$this->db->limit($data['length']);
			$memberData=$this->db->get();
			return $memberData;
		}
	}


	function adminStylistListAjax($data,$count=false){
		$this->db = DB::table('sg_stylist AS s');
	   $this->db->select([
		   "s.id",
		   "s.full_name",
		   "s.gender",
		   "c.country_name",
		   "s.email",
		   "s.phone",
		   "s.id as spend",
		   \DB::raw("DATE_FORMAT(s.added_date, '%m/%d/%Y %H:%i') as added_date"),
		   "s.id as subscription",
		   "s.slug",
	   ]);
	   $this->db->join('sg_country as c', 'c.id', '=', 's.country_id');
	   if($data['search']!=''){
		$search=$data['search'];
		$this->db->where(function($query) use ($search) {
			$query->where('s.full_name', 'LIKE', '%'.$search.'%')
					->orWhere('s.phone', 'LIKE', '%'.$search.'%')
					->orWhere('s.gender', 'LIKE', '%'.$search.'%')
					->orWhere('c.country_name', 'LIKE', '%'.$search.'%')
					->orWhere('s.email', 'LIKE', '%'.$search.'%');
		});
	}
	   if($data['order'][0]['column']!=''){
		   $order_by = '';
			   switch ($data['order'][0]['column']) {
				   case 0:
				   $order_by = 's.full_name';
				   break;
				   
				   case 1:
				   $order_by = 's.gender';
				   break;
				   
				   case 2:
				   $order_by = 'c.country_name';
				   break;
				   
				   case 3:
				   $order_by = 's.email';
				   break;
				   
				   case 4:
				   $order_by = 's.phone';
				   break;
				   
				   case 5:
				   $order_by = 's.added_date';
				   break;
				   
				   case 6:
				   $order_by = 's.id';
				   break;
				   
				   case 7:
				   $order_by = 's.id';
				   break;
				   
				   default:
				   $order_by = 's.id';
				   break;
			   }
		   $dir_by = '';
		   switch ($data['order'][0]['dir']) {
   
			   case 'asc':
				   $dir_by = 'asc';
				   break;
			   case 'desc':
				   $dir_by = 'desc';
				   break;
			   default:
				   $dir_by = 'asc';
				   break;
		   }
	   }else{
		   $order_by='s.id';
		   $dir_by = 'asc';
	   }
	   $this->db->orderBy($order_by,$dir_by);
	   
	   if($count){
		   $memberData=$this->db->get();
		   return  count($memberData);
		   
	   }else{
		   if($data['start']<0 || !isset($data['start'])){
			   $data['start']=0; 
		   }
		   if($data['length']<0 || !isset($data['length'])){
			   $data['length']=5; 
		   }
		   $this->db->offset($data['start']);
		   $this->db->limit($data['length']);
		   $memberData=$this->db->get();
		   return $memberData;
	   }
   }

	function getMemberDetails($where){
		if(count($where)){
			$this->db = DB::table('sg_member AS m');
			$this->db->select([
				"m.id",
				"m.full_name",
				"m.gender",
				"c.country_name",
				"m.email",
				"m.phone",
				"m.id as spend",
				\DB::raw("DATE_FORMAT(m.added_date, '%m/%d/%Y %H:%i') as added_date"),
				"m.subscription",
				"m.slug",
				"m.membership_cancelled",
				"m.reason_of_cancellation",
				\DB::raw("DATE_FORMAT(m.cancellation_datetime, '%m/%d/%Y %H:%i') as cancellation_datetime"),
				"s.full_name as stylist_name",
				"s.profile_image as stylist_profile_image",
			]);
			$this->db->join('sg_country as c', 'c.id', '=', 'm.country_id');
			$this->db->leftjoin('sg_stylist as s', 's.id', '=', 'm.assigned_stylist');
			$this->db->where($where);
			$result=$this->db->get()->first();
			return $result;
		}
	}

	function getstylistDetails($where){
		if(count($where)){
			$this->db = DB::table('sg_stylist AS s');
			$this->db->select([
				"s.id",
				"s.full_name",
				"c.country_name",
				"s.email",
				"s.gender",
				"s.phone",
				"s.profile_image",
				"s.id as spend",
				\DB::raw("DATE_FORMAT(s.added_date, '%m/%d/%Y %H:%i') as added_date"),
				"s.slug",
			]);
			$this->db->join('sg_country as c', 'c.id', '=', 's.country_id');
			$this->db->where($where);
			$result=$this->db->get()->first();
			return $result;
		}
	}

	function getMemberBrands($where){
		if(count($where)){
			$this->db = DB::table('sg_member_brand AS mb');
			$this->db->select([
				"mb.id",
				"mb.brand_id",
				"b.name",
				"b.logo"
			]);
			$this->db->join('sg_brand as b', 'b.id', '=', 'mb.brand_id');
			$this->db->where($where);
			$result=$this->db->get();
			return $result;
		}
	}

	function getStylistBrands($where){
		if(count($where)){
			$this->db = DB::table('sg_stylist_brand AS sb');
			$this->db->select([
				"sb.id",
				"sb.brand_id",
				"b.name",
				"b.logo"
			]);
			$this->db->join('sg_brand as b', 'b.id', '=', 'sb.brand_id');
			$this->db->where($where);
			$result=$this->db->get();
			return $result;
		}
	}

	function getStylistClients($where){
		if(count($where)){
			$this->db = DB::table('sg_member AS m');
			$this->db->select([
				"m.id",
				"m.full_name",
			]);
			$this->db->where($where);
			$result=$this->db->get();
			return $result;
		}
	}

	

	
	
}