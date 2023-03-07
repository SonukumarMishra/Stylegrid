<?php
namespace App\Helpers;
use Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Repositories\CartRepository as CartRepo;
use File;
use Mail;
use Storage;
use Hash;
use DB;
use URL;
use Log;

class Helper
{

  public static function upload_document($input_file, $directory, $name = '', $is_pdf = false, $save_url_path = false, $input_file_url=false){

    $result = '';

    try{

        if($is_pdf == false && $input_file_url == false && isset($input_file) && !empty($input_file) && base64_decode($input_file) == true ){

            $base64_image_tmp = $input_file;

            $image_parts = explode(";base64,", $base64_image_tmp);

            $content_array = explode(':', $image_parts[0]);

            $extension_explode = explode('/', $content_array[1]);

            $extension = $extension_explode[1];

            $excel_mimetypes = array(
                'vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );

            $csv_mimetypes = array(
                'csv',
            );

            $doc_mimetypes = array(
                'vnd.openxmlformats-officedocument.wordprocessingml.document',
            );

            if(in_array($extension, $excel_mimetypes)){

                $extension = 'xlsx';

            }else if (in_array($extension, $csv_mimetypes)) {

                $extension = 'csv';

            }else if (in_array($extension, $doc_mimetypes)) {

                $extension = 'docx';

            }else{

                $extension = explode('/', mime_content_type($base64_image_tmp))[1];

            }

            $filename = time();

            $filename =  (!empty($name) ? $name : $filename).".".$extension;

            $default_storage = config('filesystems.default');

            $default_storage_driver = config('filesystems.disks.'.$default_storage.'.driver');

            if($default_storage == 'public'){

                if(!File::isDirectory($directory)){

                    File::makeDirectory($directory, 0777, true, true);

                }
            }

            $base64_content = base64_decode($image_parts[1]);

            $cloudResponse =  Storage::disk($default_storage_driver)->put($directory . '/' . $filename, $base64_content);

            $storage_folder_path = $directory . '/' . $filename;

            if($cloudResponse){

                if($save_url_path){
                    $result = URL::asset($storage_folder_path);
                }else{
                    $result = $storage_folder_path;
                }

                if($default_storage != 'public'){

                    $fileUrl = Storage::url($directory . '/' . $filename);

                    $result = $fileUrl;

                }

            }

        }else if($is_pdf){

            $filename = time();

            $filename =  (!empty($name) ? $name : $filename).".pdf";

            $default_storage = config('filesystems.default');

            $default_storage_driver = config('filesystems.disks.'.$default_storage.'.driver');

            if($default_storage == 'public'){

                if(!File::isDirectory($directory)){

                    File::makeDirectory($directory, 0777, true, true);

                }
            }

            $cloudResponse =  Storage::disk($default_storage_driver)->put($directory . '/' . $filename, $input_file);

            $storage_folder_path = $directory . '/' . $filename;

            if($cloudResponse){

                if($save_url_path){
                    $result = URL::asset($storage_folder_path);
                }else{
                    $result = $storage_folder_path;
                }
                
                if($default_storage != 'public'){

                    $fileUrl = Storage::url($directory . '/' . $filename);

                    $result = $fileUrl;

                }

            }

        }else if($input_file_url){

            $filename = time();

            $extension = pathinfo($input_file, PATHINFO_EXTENSION);

            $filename =  (!empty($name) ? $name : $filename).".".$extension;

            $default_storage = config('filesystems.default');

            $default_storage_driver = config('filesystems.disks.'.$default_storage.'.driver');

            if($default_storage == 'public'){

                if(!File::isDirectory($directory)){

                    File::makeDirectory($directory, 0777, true, true);

                }
            }

            $cloudResponse =  Storage::disk($default_storage_driver)->put($directory . '/' . $filename,  file_get_contents($input_file));

            $storage_folder_path = $directory . '/' . $filename;
          
            if($cloudResponse){

                if($save_url_path){
                    $result = URL::asset($storage_folder_path);
                }else{
                    $result = $storage_folder_path;
                }
                
                if($default_storage != 'public'){

                    $fileUrl = Storage::url($directory . '/' . $filename);

                    $result = $fileUrl;

                }

            }

        }

        return $result;

    }catch(\Exception $e) {

        Log::info("upload_document error ". $e->getMessage());
        return $result;

    }
  }


  public static function unlink_document($doc_path){

        try{

            File::delete(public_path($doc_path));

        }catch(\Exception $e) {
            Log::info("unlink_document error ". $e->getMessage());
        }

    }

    public static function generateRandomString($title, $length = 10) {
        
        return substr(str_shuffle(str_repeat($title, 10)), 0, 10);
    }

    public static function getUserCartItemsCount($auth_user) {
        
        return CartRepo::get_user_cart_items_count($auth_user);

    }

    
    public static function format_number($number){
        return number_format((float)$number, 2, '.', '');
    }

    public static function defaultImage(){
        return url('/') . "/common/images/no_image.jpg";
    }

    
    public static function send_email($email, $subject, $page_view, $email_data) {

        if( env('MAIL_USERNAME') &&  env('MAIL_PASSWORD')) {

            try {

                $mail = Mail::send($page_view, array('data' => $email_data), function ($message) use ($email, $subject, $email_data) {

                        $message->to($email)->subject($subject);

                        if(isset($email_data['attachments']) && count($email_data['attachments']) > 0) {

                            foreach($email_data['attachments'] as $file) {

                                if(!empty($file)){
                                    $message->attach($file->attachment_url);
                                }
                            }
                        }

                });

            } catch(\Exception $e) {

                Log::info('email send error '.print_r($e->getMessage() , true));

            }

        }

    }

    public static function update_active_subscription_count($subscription_id){

        try{

            $total_users = UserSubscription::where([
                                                'subscription_id' => $subscription_id,
                                                'subscription_status' => config('custom.subscription.status.active'),
                                                'is_active' => 1,
                                            ])->count();

            Subscription::where([
                'subscription_id' => $subscription_id,
            ])->update([ 'total_users' => $total_users ]);

        } catch(\Exception $e) {

            Log::info('error update_active_subscription_count error '.print_r($e->getMessage() , true));

        }
    }
}
