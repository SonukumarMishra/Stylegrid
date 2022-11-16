<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Str;
use Session;

/*
@author-Sunil Kumar Mishra
date:27-10-2022
*/
class MemberWebsiteController extends Controller
{
    public function index()
    {
        if(!Session::get('Memberloggedin')){
            $member=new Member();
            $country_list=$member->getCountryList();
            $brand_list=$member->getBrandList(['b.brand_mg' => 0]);
            return view('member.website.member-registration',compact('country_list','brand_list'));
        }
        return redirect('/member-dashboard');
    }
    public function memberLogout(){
        session_unset();
        Session::flush();
        return redirect("/member-login");
    }
    
    public function addMember(Request $request){
        if($request->ajax()){
            $member=new Member();
            if($member->checkMemberExistance(['m.email'=>$request->email])){
                return json_encode(['status'=>0,'message'=>'Email already exists!']);
            }
            if($member->checkMemberExistance(['m.phone'=>$request->phone])){
                return json_encode(['status'=>0,'message'=>'Phone already exists!']);
            }
            $save_data=array(
                'id'=>0,
                'full_name'=>$request->full_name,
                'slug'=>Str::slug($request->full_name, '-'),
                'email'=>$request->email,
                'phone'=>$request->phone,
                'subscription'=>'Trail',
                'gender'=>$request->gender,
                'country_id'=>$request->country_id,
                'password'=>sha1($request->password),
                'token'=>sha1(time().sha1($request->password.time())),
                'shop'=>$request->shop?$request->shop:'',
                'style'=>$request->style?$request->style:'',
                'source'=>$request->source?$request->source:'',
            );
            $response=$member->addUpdateData($save_data,'sg_member'); 
            if($response['reference_id']){
                $member->addUpdateData(['id'=>$response['reference_id'],'slug'=>$save_data['slug'].'-'.$response['reference_id']],'sg_member');   
                if(count($request->brands)>0){
                    foreach($request->brands as $brand){
                        $member->addUpdateData(['id'=>0,'member_id'=>$response['reference_id'],'brand_id'=>$brand],'sg_member_brand');   
                    }
                }
                $member->addUpdateData(['id'=>0,'member_id'=>$response['reference_id'],'start_date'=>date('Y-m-d'),'end_date'=>date('Y-m-d',strtotime ('30 day',strtotime(date('Y-m-d')))),'subscription'=>'Trail'],'sg_member_subscription');   
               // $verification_url=URL::to("/").'/member-account-verification/'.$save_data['token'];
                return json_encode(['status'=>1,'message'=>'Member Added Successfully!']);
            }
            return json_encode(['status'=>0,'message'=>'Something went wrong!']);
        }  
    }
    public function checkMemberExistance(Request $request){
        if($request->ajax()){
            $member=new Member();
            $key=$request->key;
            $value=$request->value;
            $status=$member->checkMemberExistance(['m.'.$key=>$value]);
            if(!$status){
                return json_encode(['status'=>1,'message'=>'Success']);
            }else{
                return json_encode(['status'=>0,'message'=>$key .' already exists!']);
            }
        }  
    }
    public function memberLogin(){
        if(!Session::get('Memberloggedin')){
            return view('member.website.member-login');
        }
        return redirect('/member-dashboard');
    }
    public function getBrandList(Request $request){
        if($request->ajax()){
            $member=new Member();
            $search_brand=$request->brand_search;
            $not_where_in=[];
           if(!empty($request->existing_data)){
                $existing_data=$request->existing_data;
                if(!empty($existing_data)){
                    $not_where_in=$existing_data;
                }
           }
           
            if(!empty($search_brand)){
                $brand_list=$member->getBrandList([],$search_brand,$not_where_in);
                if(count($brand_list)){
                    $response['status']=1;
                }else{
                    $response['status']=0;
                }
                $response['data']=$brand_list;
            }else{
                $response['status']=0;
            }
            return json_encode($response);
        }  
    }
    public function memberLoginPost(Request $request){
        if($request->ajax() && !Session::get('Memberloggedin')){
            $member=new Member();
            $email=$request->email;
            $password=sha1($request->password);
            $login_data=$member->checkMemberExistance(['m.email'=>$email,'m.password'=>$password]);
            if($login_data){
                if($login_data->verified){
                    Session::put('member_data', $login_data);
                    Session::put('member_id', $login_data->id);
                    Session::put('Memberloggedin',TRUE);
                    return json_encode(['status'=>1,'message'=>'you have successfully loggedin']);
                }
                return json_encode(
                    [
                    'status'=>0,
                    'message'=>'Account not verified',
                    'verification_url'=>\URL::to("/").'/member-account-verification/'.$login_data->token

                ]);
            }else{
                return json_encode(['status'=>0,'message'=>'Email Id or Password not correct!']);
            }
        }  
    }
    public function memberAccountVerification($token){
        if(!empty($token)){
            $member=new Member();
            $member_data=$member->checkMemberExistance(['m.token'=>$token]);
            if($member_data){
                if($member_data->verified){
                    echo "Your Account is already verified";
                }else{
                    echo "You have successfully verified you account";
                    $member->addUpdateData(['id'=>$member_data->id,'token'=>$token,'verified'=>1],'sg_member');
                }
            }
        }else{
            return redirect('/member-login');
        }
    }     
}
