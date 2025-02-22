<?php

namespace App\Controllers\Client;

use App\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function allProduct()
    {
        $heading1 = "Trang sản phẩm";
        $subHeading1 = "=====================";

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;

        $products = $this->product->paginateClient($page, $limit);
        //   debug($products);
        return view(
            'client.allProduct',
            compact('heading1', 'subHeading1', 'products')
        );
    }

    public function detailProduct($slug)
    {
        $heading1 = "Trang chi tiết sản phẩm";
        $subHeading1 = "=====================";

 
        $product = $this->product->detailProduct($slug);
                //  debug($product);
        return view(
            'client.detailProduct',
            compact('heading1', 'subHeading1','product')
        );
    }
}
