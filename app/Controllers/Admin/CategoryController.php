<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\Category;
use Rakit\Validation\Validator;

class CategoryController extends Controller
{
    private Category $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function index()
    {

        $data = $this->category->findAll();
        $title = "Trang danh mục sản phẩm";

        return view(
            'admin.categories.index',
            compact('title', 'data')
        );
    }

    public function show($id)
    {
        $category = $this->category->find($id);

        if (!empty($data)) {
            redirect404();
        }

        $title = 'Trang xem chi tiết danh mục sản phẩm';

        return view(
            'admin.categories.show',
            compact('title', 'category')
        );
    }

    public function create()
    {
        $title = "Trang tạo mới danh mục sản phẩm";

        return view(
            'admin.categories.create',
            compact('title')
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
                    'name' => [
                        'required',
                        'max:50',
                        function ($value) {
                            $flag = (new Category())->checkExistsNameForCreate($value);

                            if ($flag) {
                                return ":attribute has existed";
                            }
                        }
                    ],
                    'img'                   => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'             => [$validator('in', [0, 1])]
                ]
            );

            if (!empty($errors)) {
                $_SESSION['status'] = false;
                $_SESSION['msg'] = "Thao tác không thành công";
                $_SESSION['data'] = $_POST;
                $_SESSION['errors']     = $errors;

                redirect('/admin/categories/create');
            } else {
                $_SESSION['data'] = null;
            }

            //upload file
            if (is_upload('img')) {
                $data['img'] = $this->uploadFile($data['img'], 'categories');
            } else {
                $data['img'] = null;
            }

            //điều chỉnh dữ liệu
            $data['is_active'] = $data['is_active'] ?? 0;

            //thêm
            $this->category->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = "Thao tác thành công";

            redirect('/admin/categories');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;

            redirect('/admin/categories/create');
        }
    }

    public function edit($id)
    {
        $category = $this->category->find($id);

        if (empty($category)) {
            redirect404();
        }

        $title = 'Trang chỉnh sửa danh sách sản phẩm';

        return view(
            'admin.categories.edit',
            compact('title', 'category')
        );
    }

    public function update($id)
    {
        $category = $this->category->find($id);

        if (empty($category)) {
            redirect404();
        }

        try {
            $data = $_POST + $_FILES;

            $validator = new Validator();

            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name' => [
                        'required',
                        'max:50',
                        function ($value) use ($id) {
                            $flag = (new Category())->checkExistsNameForUpdate($id, $value);

                            if ($flag) {
                                return ":attribute has existed";
                            }
                        }
                    ],
                    'img'                   => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'             => [$validator('in', [0, 1])]
                ]
            );

            if (!empty($errors)) {
                $_SESSION['status'] = false;
                $_SESSION['msg'] = "Thao tác không thành công";
                $_SESSION['errors']     = $errors;

                redirect('/admin/categories/edit' . $id);
            }

            //upload file
            if (is_upload('img')) {
                $data['img'] = $this->uploadFile($data['img'], 'categories');
            } else {
                $data['img'] = $category['img'];
            }

            //điều chỉnh dữ liệu
            $data['is_active'] = $data['is_active'] ?? 0;
            $data['updated_at'] = date('Y-m-d H:i:s');

            //thêm
            $this->category->update($id,$data);

            if (
                $data['img'] != $category['img']
                && $category['img']
                && file_exists($category['img'])
            ) {
                unlink($category['img']);
            }

            $_SESSION['status'] = true;
            $_SESSION['msg'] = "Thao tác thành công";

            redirect('/admin/categories');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;

            redirect('/admin/categories/edit' . $id);
        }
    }

    public function delete($id){
        $category = $this->category->find($id);

        if (empty($category)) {
            redirect404();
        }

        $this->category->delete($id);

        if ($category['img'] && file_exists($category['img'])) {
            unlink($category['img']);
        }

        $_SESSION['status'] = true;
        $_SESSION['msg'] = "Thao tác thành công";

        redirect('/admin/categories');

    }
}
