<?php
namespace Model;

class CustomerDB
{
    public $connection;

    public function __construct($connection)
    {
      $this->connection = $connection;
    }

    public function create($customer){
      $sql = "INSERT INTO customer(name,ngaysinh,email) VALUES (?, ?, ?)";
      $statement = $this->connection->prepare($sql);
      $statement->bindParam(1, $customer->name);
      $statement->bindParam(2, $customer->ngaysinh);
      $statement->bindParam(3, $customer->email);
          return $statement->execute();
      }
      public function getAll()
      {
      $sql = "SELECT * FROM customer";
      $statement = $this->connection->prepare($sql);
      $statement->execute();
      $result = $statement->fetchAll();
      $customers = [];
      foreach ($result as $row) {
          $customer = new Customer($row['name'], $row['email'], $row['ngaysinh']);
          $customer->id = $row['id'];
          $customers[] = $customer;
        }
          return $customers;
      }
      public function get($id){
        $sql = "SELECT * FROM customer WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $id);
        $statement->execute();
        $row = $statement->fetch();
        $customer = new Customer($row['name'], $row['email'], $row['ngaysinh']);
        $customer->id = $row['id'];
        return $customer;
      }
      
      public function delete($id){
        $sql = "DELETE FROM customer WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
      }

      public function search($prefix){
        $spl = "SELECT * FROM table WHERE customer LIKE ?.'%'";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $prefix);
        return $statement->execute();
      }
}
