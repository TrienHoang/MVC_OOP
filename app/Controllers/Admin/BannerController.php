<?php

namespace App\Controllers\Admin;

use App\Controller;
use App\Models\Banner;
use Rakit\Validation\Validator;

class BannerController extends Controller
{
    private Banner $banner;

    public function __construct()
    {
        $this->banner = new Banner();
    }

    public function index()
    {
        $title = 'Trang danh sách banner';

        $data = $this->banner->findAll();

        return view(
            'admin.banners.index',
            [
                'title' => $title,
                'data' => $data
            ]
        );
    }

    public function show($id)
    {
        $banner = $this->banner->find($id);

        if (empty($banner)) {
            redirect404();
        }

        $title = "Chi tiết banner";
        return view(
            'admin.banners.show',
            compact('banner', 'title')
        );
    }

    public function delete($id)
    {
        $banner = $this->banner->find($id);

        if (empty($banner)) {
            redirect404();
        }

        $this->banner->delete($id);
        if ($banner['img'] && file_exists($banner['img'])) {
            unlink($banner['img']);
        }

        $_SESSION['status'] = true;
        $_SESSION['msg'] = "Thao tác thành công";

        redirect('/admin/banners');
    }

    public function create()
    {
        $title = 'Trang tạo mới';

        return view(
            'admin.banners.create',
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
                    'name' => ['required', 'max:50'],
                    'img' => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'     => [$validator('in', [0, 1])]
                ]
            );

            if (!empty($errors)) {
                $_SESSION['status'] = false;
                $_SESSION['msg'] = 'Thao tác Khong thành công';
                $_SESSION['data'] = $_POST;
                $_SESSION['errors']     = $errors;

                redirect('/admin/banners/create');
            } else {
                $_SESSION['data'] = null;
            }

            // Upload file 
            if (is_upload('img')) {
                $data['img'] = $this->uploadFile($data['img'], 'banners');
            } else {
                $data['img'] = null;
            }

            // Điểu chỉnh dữ liệu
            $data['is_active'] = $data['is_active'] ?? 0;

            //Thêm vào db
            $this->banner->insert($data);

            $_SESSION['status'] = true;
            $_SESSION['msg'] = "Thao tác thành công";

            redirect('/admin/banners');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';
            $_SESSION['data'] = $_POST;

            redirect('/admin/banners/create');
        }
    }

    public function edit($id)
    {
        $banner = $this->banner->find($id);

        if (empty($banner)) {
            redirect404();
        }

        $title = 'Trang chỉnh sửa banner';
        return view(
            'admin.banners.edit',
            compact('banner', 'title')
        );
    }

    public function update($id){
        $banner = $this->banner->find($id);

        if (empty($banner)) {
            redirect404();
        }
        try {
            $data = $_POST + $_FILES;

            $validator = new Validator();

            $errors = $this->validate(
                $validator,
                $data,
                [
                    'name' => ['required', 'max:50'],
                    'img' => 'nullable|uploaded_file:0,2048K,png,jpeg,jpg',
                    'is_active'     => [$validator('in', [0, 1])]
                ]
            );

            if (!empty($errors)) {
                $_SESSION['status'] = false;
                $_SESSION['msg'] = 'Thao tác Khong thành công';
                $_SESSION['errors']  = $errors;

                redirect('/admin/banners/edit/' . $id);
            } else {
                $_SESSION['data'] = null;
            }

            // Upload file 
            if (is_upload('img')) {
                $data['img'] = $this->uploadFile($data['img'], 'banners');
            } else {
                $data['img'] = null;
            }

            // Điểu chỉnh dữ liệu
            $data['is_active'] = $data['is_active'] ?? 0;
            $data['updated_at'] = date('Y-m-d H:i:s');

            //Chỉnh sửa
            $this->banner->update($id,$data);

            if (
                $data['img'] != $banner['img']
                && $banner['img']
                && file_exists($banner['img'])
            ) {
                unlink($banner['img']);
            }

            $_SESSION['status'] = true;
            $_SESSION['msg'] = "Thao tác thành công";

            redirect('/admin/banners');
        } catch (\Throwable $th) {
            $this->logError($th->__tostring());

            $_SESSION['status'] = false;
            $_SESSION['msg'] = 'Thao tác KHÔNG thành công!';

            redirect('/admin/banners/edit/'  . $id);
        }
    }
}
