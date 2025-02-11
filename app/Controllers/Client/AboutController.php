<?php 

namespace App\Controllers\Client;

use App\Controller;
use App\Models\Product;

class AboutController extends Controller {
    public function index (){
        $heading1 = "Trang giới thiệu";
        $subHeading1 = "=====================";


        return view('client.about',
        [
            'heading1' => $heading1,
            'subHeading1' => $subHeading1
        ]);
    }
}