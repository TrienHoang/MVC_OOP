<?php 

namespace App\Controllers\Client;

use App\Controller;
use App\Models\Product;

class HomeController extends Controller {

    private Product $product;

    public function __construct(){
        $this->product = new Product();
    }
    public function index (){
        $heading1 = "Trang chủ";
        $subHeading1 = "=====================";

        $products = $this->product->getProductForHome();

        // debug($products);    
        return view('client.home', [
            'products' => $products,
            'heading1' => $heading1,
            'subHeading1' => $subHeading1
        ]);
    }

}