<?php

namespace App;

use Doctrine\DBAL\DriverManager;

class Model
{
    protected $connection;
    protected $tableName;

    public function __construct()
    {
        $connectionParams = [
            'dbname'    => $_ENV['DB_NAME'],
            'user'      => $_ENV['DB_USERNAME'],
            'password'  => $_ENV['DB_PASSWORD'],
            'host'      => $_ENV['DB_HOST'],
            'driver'    => $_ENV['DB_DRIVER']
        ];
        $this->connection = DriverManager::getConnection($connectionParams);
    }

    public function __destruct()
    {
        $this->connection->close();
    }


    public function findAll()
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('*')->from($this->tableName);

        return $queryBuilder->fetchAllAssociative();
    }

    public function paginate($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select('*')
            ->from($this->tableName)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $data = $queryBuilder->fetchAllAssociative();
        $totalPage = ceil($this->count() / $limit); //Làm tròn;


        return [
            'data' => $data,
            'page' => $page,
            'limit' => $limit,
            'total' => $totalPage
        ];
    }


    //Đếm số lượng bản ghi 
    public function count()
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select("COUNT(*) as total")->from($this->tableName);

        return $queryBuilder->fetchOne();
    }

    public function find($id)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->select("*")
            ->from($this->tableName)
            ->where('id = :id')
            ->setParameter('id', $id);

        return $queryBuilder->fetchAssociative();
    }

    //Phương thức thêm bản ghi mới và trả về id
    public function insert(array $data)
    {
        $this->connection->insert($this->tableName, $data);

        return $this->connection->lastInsertId();
    }

    //Phương thức cập nhật bản ghi theo id
    public function update($id, array $data)
    {
        $this->connection->update($this->tableName, $data, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->connection->delete($this->tableName, ['id' => $id]);
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function commit()
    {
        $this->connection->commit();
    }

    public function rollback()
    {
        $this->connection->rollBack();
    }
}
