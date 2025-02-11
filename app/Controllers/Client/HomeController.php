<?php 

namespace App\Controllers\Client;

use App\Controller;
use App\Models\Product;

class HomeController extends Controller {
    public function index (){
        $heading1 = "Trang chủ";
        $subHeading1 = "=====================";

        return view('client.home', [
            'heading1' => $heading1,
            'subHeading1' => $subHeading1
        ]);
    }
}