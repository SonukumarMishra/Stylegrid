<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Str;
use Session;

/*
@author-Sunil Kumar Mishra
date:5-11-2022
*/
class StylistWebsiteController extends Controller
{
    public function index(){
        return view('stylist.website.website-home-page');
    }
    public function stylistRegistration()
    {
        if(!Session::get('Stylistloggedin')){
            $member=new Member();
            $country_list=$member->getCountryList();
            return view('stylist.website.stylist-registration',compact('country_list'));
        }
        return redirect('/stylist-dashboard');
        
    }  
    public function checkStylistExistance(Request $request){
        if($request->ajax()){
            $member=new Member();
            $key=$request->key;
            $value=$request->value;
            $status=$member->checkStylistExistance(['s.'.$key=>$value]);
            if(!$status){
                return json_encode(['status'=>1,'message'=>'Success']);
            }else{
                return json_encode(['status'=>0,'message'=>$key .' already exists!']);
            }
        }  
    }
    public function addStylist(Request $request){
        if($request->ajax()){
            $member=new Member();
            if($member->checkStylistExistance(['s.email'=>$request->email])){
                return json_encode(['status'=>0,'message'=>'Email already exists!','url'=>'']);
            }
            if($member->checkStylistExistance(['s.phone'=>$request->phone])){
                return json_encode(['status'=>0,'message'=>'Phone already exists!','url'=>'']);
            }
            $save_data=array(
                'id'=>0,
                'full_name'=>$request->full_name,
                'slug'=>Str::slug($request->full_name, '-'),
                'email'=>$request->email,
                'phone'=>$request->phone,
                'country_id'=>$request->country_id,
                'token'=>sha1(time().sha1(Str::slug($request->full_name, '-').time())),
                'shop'=>$request->shop?$request->shop:'',
                'style'=>$request->style?$request->style:'',
                'source'=>$request->source?$request->source:'',
                'verified'=>1
            );
            $response=$member->addUpdateData($save_data,'sg_stylist'); 
            if($response['reference_id']){
                $member->addUpdateData(['id'=>$response['reference_id'],'slug'=>$save_data['slug'].'-'.$response['reference_id']],'sg_stylist');   
                return json_encode(['status'=>1,'message'=>'Stylist Added Successfully!','url'=>\URL::to("/").'/stylist-account-confirmation/'.$save_data['token']]);
            }
            return json_encode(['status'=>0,'message'=>'Something went wrong!','url'=>'']);
        }  
    }
    public function addStylistSecondProcess(Request $request){
        if($request->ajax()){
            if(Session::get('processed_stylist_id')>0){
                $member=new Member();
                $member_data=$member->checkStylistExistance(['s.id'=>Session::get('processed_stylist_id')]);
                if($member_data){
                    if($member_data->verified){
                        $profile_image_name='';
                        $profile_image= $request->file('profile_image');
                        if(!empty($profile_image)){
                            $new_name = rand() . '.' . $profile_image->getClientOriginalExtension();
                            $profile_image->move(public_path('stylist/attachments/profileImage'), $new_name);
                            $profile_image_name=$new_name;
                        }
                        $save_data=array(
                            'id'=>Session::get('processed_stylist_id'),
                            'user_name'=>$request->user_name,
                            'profile_image'=>$profile_image_name,
                            'password'=>sha1($request->password),
                            'short_bio'=>$request->short_bio,
                            //'favourite_brands'=>$request->favourite_brands,
                            'preferred_style'=>$request->preferred_style,
                            'token'=>'',
                            );
                        $response=$member->addUpdateData($save_data,'sg_stylist'); 
                        if($response['reference_id']){
                            $favourite_brand_list=explode(',',$request->favourite_brand_list);
                            if(count($favourite_brand_list)>0){
                                foreach($favourite_brand_list as $favourite_brand){
                                    $member->addUpdateData([
                                        'id'=>0,
                                        'stylist_id'=>$response['reference_id'],
                                        'brand_id'=>$favourite_brand,
                                    ],'sg_stylist_brand'); 
                                }
                            }
                            return json_encode(['status'=>1,'message'=>'Stylist Added Successfully!']);
                        }
                    }
                }
            }
            return json_encode(['status'=>0,'message'=>'Something went wrong!']);
        }  
    }

    public function stylistAccountConfirmation($token){
        if(!empty($token)){
            $member=new Member();
            $stylist_data=$member->checkStylistExistance(['s.token'=>$token]);
            if($stylist_data){
                if($stylist_data->verified){
                    Session::put('processed_stylist_id', $stylist_data->id);
                    return view('stylist.website.stylist-registration-final-step',compact('stylist_data'));
                }else{
                    return view('stylist.website.stylist-registration-final-step-without-verification');
                }
            }else{
                return redirect('/stylist-login');
            }
        }else{
            return redirect('/stylist-login');
        }
    }
    function stylistLogin(Request $request){
        if(!Session::get('Stylistloggedin')){
            return view('stylist.website.stylist-login');
        }
        return redirect('/stylist-dashboard');
    }
    public function stylistLogout(){
        session_unset();
        Session::flush();
        return redirect("/stylist-login");
    }

    public function stylistLoginPost(Request $request){
        if($request->ajax() && !Session::get('Stylistloggedin')){
            $member=new Member();
            $email=$request->email;
            $password=sha1($request->password);
            $login_data=$member->checkStylistExistance(['s.email'=>$email,'s.password'=>$password]);
            if($login_data){
                if($login_data->verified){
                    Session::put('stylist_data', $login_data);
                    Session::put('stylist_id', $login_data->id);
                    Session::put('Stylistloggedin',TRUE);
                    return json_encode(['status'=>1,'message'=>'you have successfully loggedin']);
                }
                return json_encode(
                    [
                    'status'=>0,
                    'message'=>'Account not verified',
                    //'verification_url'=>\URL::to("/").'/member-account-verification/'.$login_data->token
                ]);
            }else{
                return json_encode(['status'=>0,'message'=>'Email Id or Password not correct!']);
            }
        }  
    }
    
    
    
    
    
}
