<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\Category;
use App\Models\Product;
use Rakit\Validation\Validator;

class ProductController extends Controller
{
    private Product $product;
    private Category $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
    }

    public function index()
    {
        $data = $this->product->paginate($_GET['page'] ?? 1, $_GET['limit'] ?? 10);

        $data['title'] = 'Trang danh sách sản phẩm';
        //  debug($data);
        return view(
            'admin.products.index',
            $data
        );
    }

    public function show($id)
    {
        $product = $this->product->find($id);

        if (empty($product)) {
            redirect404();
        }

        $title = 'Trang chi tiết sản phẩm';
        // debug($product);
        return view(
            'admin.products.show',
            compact('title', 'product')
        );
    }

    public function delete($id)
    {
        $product = $this->product->find($id);

        if (empty($product)) {
            redirect404();
        }

        $this->product->delete($id);

        if (!empty($product['img_thumbnail']) && is_string($product['img_thumbnail']) && file_exists($product['img_thumbnail'])) {
            unlink($product['img_thumbnail']);
        }

        $_SESSION['status'] = true;
        $_SESSION['msg'] = 'Thao tác thành công!';

        redirect('/admin/products');
    }

    public function create()
    {
        $title = "Trang thêm mới sản phẩm";

        $categories = $this->category->getCategoryOnlyActive();

        return view(
            'admin.products.create',
            compact('title', 'categories')
        );
    }

    public function store()
    {
        try {
            $data = $_POST + $_FILES;

            $validator = new Validator();

            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name'          => ['required', 'max:50'],
                    'category_id'   => ['required'],
                    'overview'      => ['required', 'max:255'],
                    'content'       => ['required', 'max:60000'],
                    'price'         => ['required', 'numeric'],
                    'price_sale'    => ['required', 'numeric'],
                    'img_thumbnail' => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'     => [$validator('in', [0, 1])],
                    'is_sale'       => [$validator('in', [0, 1])],
                    'is_show_home'  => [$validator('in', [0, 1])],

                ]
            );
            // debug($data);

            if (!empty($errors)) {

                $_SESSION['status'] = false;
                $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
                $_SESSION['data'] = $_POST;
                $_SESSION['errors'] = $errors;

                redirect('/admin/products/create');
            } else {
                $_SESSION['data'] = null;
            }

            // Upload file 
            if (is_upload('img_thumbnail')) {
                $data['img_thumbnail'] = $this->uploadFile($data['img_thumbnail'], 'products');
            } else {
                $data['img_thumbnail'] = null;
            }
            // điều chỉnh dữ liệu
            $data['is_active']      = $data['is_active']    ?? 0;
            $data['is_sale']      = $data['is_sale']    ?? 0;
            $data['is_show_home']      = $data['is_show_home']    ?? 0;
            $data['slug'] = slug($data['name']);

            // Insert
            $this->product->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công!';

            redirect('/admin/products');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;

            redirect('/admin/products/create');
        }
    }

    public function edit($id)
    {
        $product = $this->product->find($id);

        if (empty($product)) {
            redirect404();
        }
        $title = "Trang cập nhật sản phẩm";
        $categories = $this->category->getCategoryOnlyActive();

        return view(
            'admin.products.edit',
            compact('title', 'categories','product')
        );
    }

    public function update($id){
        $product = $this->product->find($id);

        if (empty($product)) {
            redirect404();
        }
        try {
            $data = $_POST + $_FILES;

            $validator = new Validator();
            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name'          => ['required', 'max:50'],
                    'category_id'   => ['required'],
                    'overview'      => ['required', 'max:255'],
                    'content'       => ['required', 'max:60000'],
                    'price'         => ['required', 'numeric'],
                    'price_sale'    => ['required', 'numeric'],
                    'img_thumbnail' => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'     => [$validator('in', [0, 1])],
                    'is_sale'       => [$validator('in', [0, 1])],
                    'is_show_home'  => [$validator('in', [0, 1])],
                ]
                );
                if (!empty($errors)) {

                    $_SESSION['status'] = false;
                    $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
                    $_SESSION['data'] = $_POST;
                    $_SESSION['errors'] = $errors;
    
                    redirect('/admin/products/edit/'.$id);
                } else {
                    $_SESSION['data'] = null;
                }

            // Upload file 
            if (is_upload('img_thumbnail')) {
                $data['img_thumbnail'] = $this->uploadFile($data['img_thumbnail'], 'products');
            } else {
                $data['img_thumbnail'] = $product['p_img_thumbnail'];
            }


            // điều chỉnh dữ liệu
            $data['is_active']      = $data['is_active']    ?? 0;
            $data['is_sale']      = $data['is_sale']    ?? 0;
            $data['is_show_home']      = $data['is_show_home']    ?? 0;
            $data['updated_at']     = date('Y-m-d H:i:s');
            
            $this->product->update($id, $data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao tác thành công!';

            redirect('/admin/products/edit/' . $id);

        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;

            redirect('/admin/products/edit/' .$id);
        }
    }
}
