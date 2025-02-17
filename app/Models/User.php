<?php 

namespace App\Models;

use App\Model;

class User extends Model{
    protected $tableName = 'users';

    public function checkExistsEmailForCreate($email){
        // khởi tạo
        $queryBuilder = $this->connection->createQueryBuilder();

        //tạo query
        $queryBuilder->select('COUNT(*)')
        ->from($this->tableName)
        ->where('email = :email')
        ->setParameter('email', $email);

        // thực thi và lấy kết quả
        $result = $queryBuilder->fetchOne();

        return $result; //nếu >0, emaill đã tồn tại
    }

    public function checkExistsEmailForUpdate($id ,$email){
        // khởi tạo
        $queryBuilder = $this->connection->createQueryBuilder();

        //tạo query
        $queryBuilder->select('COUNT(*)')
            ->from($this->tableName)
            ->where('email = :email')
            ->andWhere('id != :id')  // Điều kiện id khác với giá trị id được cung cấp
            ->setParameter('email', $email)
            ->setParameter('id', $id);

        // thực thi và lấy kết quả
        $result = $queryBuilder->fetchOne();

        return $result > 0; //nếu >0, emaill đã tồn tại
    }
}