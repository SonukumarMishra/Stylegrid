<?php
namespace App\Helpers;
use Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use File;
use Storage;
use Hash;
use DB;
use Log;

class Helper
{

  public static function upload_document($input_file, $directory, $name = '', $is_pdf = false){

    $result = '';

    try{

        if($is_pdf == false && isset($input_file) && !empty($input_file) && base64_decode($input_file) == true ){

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

                $result = $storage_folder_path;

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

                $result = $storage_folder_path;

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

}
