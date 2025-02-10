<?php 

namespace App;

class Controller{
    public function logError($message){
        $date = date('d-m-Y');
        error_log($message,3,"storage/logs/$date.log"); //ghi lỗi vào tệp log, type là 3
    }

    public function uploadFile (array $file, $folder = null){
        $fileTmpPath = $file['tmp_name']; //Đường dẫn tạm thời của file 
        $fileName = time() . '-' . $file['name']; // đặt têm file 

        $uploadDir = 'storage/uploads/' . $folder . '/';

        //Tạo thư mục nếu chưa tồn tại 
        if(!is_dir($uploadDir)){
            mkdir($uploadDir,0755,true);
        }

        //Đường dẫn để lưu file 
        $destPath = $uploadDir . $fileName;
        
        if(move_uploaded_file($fileTmpPath,$destPath)){
            return  $destPath ;
        }
        //di chuyển file từ thư mục tạm thời đến thư mục đích 
        throw new \Exception('Lỗi upload file');
    }
}

