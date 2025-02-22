<?php

use eftec\bladeone\BladeOne;

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        $views = __DIR__ . '/views';
        $cache = __DIR__ . '/storage/compiles';

        // MODE_DEBUG allows to pinpoint troubles.
        $blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

        echo $blade->run($view, $data);
    }
    // if (!function_exists('slug')) {
    //     function slug($string, $separator = '-')
    //     {
    //         //chuyển đổi chuỗi sang chữ thường
    //         $string = mb_strtolower($string, 'UTF-8');

    //         //thay thế các ký tự đặc biệt và dấu tiếng Việt
    //         $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $string);
    //         $string = preg_replace('/[\s]+/', $separator, $string);

    //         // Loại bỏ các ký tự phân cách ở đầu và cuối chuỗi
    //         $string = trim($string, $separator) . '-' . random_string(6);

    //         return $string;
    //     }
    // }

    if (!function_exists('middleware_auth')) {
        function middleware_auth()
        {
            $currentUrl = $_SERVER['REQUEST_URI'];
            $authRegex = '/^\/(auth|login|register)$/';
            $adminUrlRegex = '/^\/admin/';

            // nếu ngdunng chưa đăng nhập
            if (empty($_SESSION['user'])) {
                // chuyển hướng trang
                if (
                    !preg_match($authRegex, $currentUrl)
                    && preg_match($adminUrlRegex, $currentUrl)
                ) {
                    redirect('/auth');
                }
            } else {
                // nếu người dùng đã đăng nhập và đang truy cập vào trang đăng kí đăng nhập
                if (preg_match($authRegex, $currentUrl)) {
                    $redirectTo = ($_SESSION['user']['type'] == 'admin') ? '/admin' : '/';
                    redirect($redirectTo);
                }

                //kiểm tra quyền truy cập bào trang admin 
                if (preg_match($adminUrlRegex, $currentUrl) && $_SESSION['user']['type'] != 'admin') {
                    redirect('/');
                }
            }
        }
    }

    if (!function_exists('file_url')) {
        function file_url($path)
        {
            if (!file_exists($path)) {
                return null;
            }

            return $_ENV['APP_URL'] . $path;
        }
    }

    if (!function_exists('debug')) {
        function debug(...$data)
        {
            echo '<pre>';

            print_r($data);
            die;
        }
    }
    function remove_accents($str) {
        $accents = [
            'à' => 'a', 'á' => 'a', 'ạ' => 'a', 'ả' => 'a', 'ã' => 'a',
            'â' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ậ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a',
            'ă' => 'a', 'ằ' => 'a', 'ắ' => 'a', 'ặ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a',
            'è' => 'e', 'é' => 'e', 'ẹ' => 'e', 'ẻ' => 'e', 'ẽ' => 'e',
            'ê' => 'e', 'ề' => 'e', 'ế' => 'e', 'ệ' => 'e', 'ể' => 'e', 'ễ' => 'e',
            'ì' => 'i', 'í' => 'i', 'ị' => 'i', 'ỉ' => 'i', 'ĩ' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ọ' => 'o', 'ỏ' => 'o', 'õ' => 'o',
            'ô' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ộ' => 'o', 'ổ' => 'o', 'ỗ' => 'o',
            'ơ' => 'o', 'ờ' => 'o', 'ớ' => 'o', 'ợ' => 'o', 'ở' => 'o', 'ỡ' => 'o',
            'ù' => 'u', 'ú' => 'u', 'ụ' => 'u', 'ủ' => 'u', 'ũ' => 'u',
            'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ự' => 'u', 'ử' => 'u', 'ữ' => 'u',
            'ỳ' => 'y', 'ý' => 'y', 'ỵ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y',
            'đ' => 'd', 'À' => 'A', 'Á' => 'A', 'Ạ' => 'A', 'Ả' => 'A', 'Ã' => 'A',
            'Â' => 'A', 'Ầ' => 'A', 'Ấ' => 'A', 'Ậ' => 'A', 'Ẩ' => 'A', 'Ẫ' => 'A',
            'Ă' => 'A', 'Ằ' => 'A', 'Ắ' => 'A', 'Ặ' => 'A', 'Ẳ' => 'A', 'Ẵ' => 'A',
            'È' => 'E', 'É' => 'E', 'Ẹ' => 'E', 'Ẻ' => 'E', 'Ẽ' => 'E',
            'Ê' => 'E', 'Ề' => 'E', 'Ế' => 'E', 'Ệ' => 'E', 'Ể' => 'E', 'Ễ' => 'E',
            'Ì' => 'I', 'Í' => 'I', 'Ị' => 'I', 'Ỉ' => 'I', 'Ĩ' => 'I',
            'Ò' => 'O', 'Ó' => 'O', 'Ọ' => 'O', 'Ỏ' => 'O', 'Õ' => 'O',
            'Ô' => 'O', 'Ồ' => 'O', 'Ố' => 'O', 'Ộ' => 'O', 'Ổ' => 'O', 'Ỗ' => 'O',
            'Ơ' => 'O', 'Ờ' => 'O', 'Ớ' => 'O', 'Ợ' => 'O', 'Ở' => 'O', 'Ỡ' => 'O',
            'Ù' => 'U', 'Ú' => 'U', 'Ụ' => 'U', 'Ủ' => 'U', 'Ũ' => 'U',
            'Ư' => 'U', 'Ừ' => 'U', 'Ứ' => 'U', 'Ự' => 'U', 'Ử' => 'U', 'Ữ' => 'U',
            'Ỳ' => 'Y', 'Ý' => 'Y', 'Ỵ' => 'Y', 'Ỷ' => 'Y', 'Ỹ' => 'Y',
            'Đ' => 'D'
        ];
        return strtr($str, $accents);
    }
    if (!function_exists('slug')) {

        function slug($string, $separator = '-') {
            // Loại bỏ dấu tiếng Việt
            $string = remove_accents($string);
        
            // // Chuyển sang chữ thường
            $string = mb_strtolower($string, 'UTF-8');
        
            // Loại bỏ ký tự đặc biệt (giữ lại chữ cái, số và khoảng trắng)
            $string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $string);
        
            // Chuyển khoảng trắng thành dấu phân cách
            $string = preg_replace('/\s+/', $separator, $string);
        
            // Loại bỏ dấu phân cách ở đầu và cuối chuỗi
            $string = trim($string, $separator);
        
            // Thêm phần random để tránh trùng lặp
            $string .= "-" . random_string(5);
        
            
            return $string;
        }
    
    }
    if (!function_exists('random_string')) {
        function random_string($length = 10)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            return $randomString;
        }
    }

    if (!function_exists('is_upload')) {
        function is_upload($key)
        {
            return isset($_FILES[$key]) && $_FILES[$key]['size'] > 0;
        }
    }

    if (!function_exists('redirect')) {
        function redirect($path)
        {
            header("Location:" . $path);
            exit();
        }
    }
    if (!function_exists('redirect404')) {
        function redirect404()
        {
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }
}
