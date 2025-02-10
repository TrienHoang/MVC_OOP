<?php 

namespace App\Controllers\Admin;

use App\Models\User;

class UserController {

    private User $user;
    public function __construct(){
        $this->user = new User;
    }

    public function testBaseModel(){
        echo '<pre>';
        // print_r ($this->user);
        // $this->user->insert(['name' => 'JQK']);
        $this->user->update(2,[
            'name' => 'JQK ud',
            'email' => 'triendz@gmail.com',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
            'type'=> 'client'
        ]);

        // $delete = $this->user->delete(2);
        // echo $delete;

        $data = $this->user->findAll();
        print_r($data);


        // $newUserId = $this->user->insert([
        //     'name' => "Hoàng Tiến Triển",
        //     'email' => "trienhtph51464@gmail.com",
        //     'password' => password_hash("123456",PASSWORD_DEFAULT),
        //     'type'=> 'admin'
        // ]);
        // echo $newUserId;
    }
}