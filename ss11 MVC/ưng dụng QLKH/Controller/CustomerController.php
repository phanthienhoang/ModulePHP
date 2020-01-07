<?php
    namespace Controller;

    use Model\Customer;
    use Model\CustomerDB;
    use Model\DBConnection;

    class CustomerController
    {

        public $customerDB;

        public function __construct()
        {
            $connection = new DBConnection("mysql:host=localhost;dbname=ban_hang_online", "root", "");
            $this->customerDB = new CustomerDB($connection->connect());
        }

        public function add()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                include 'view/add.php';
            } else {

                $name = $_POST['name'];
                $email = $_POST['email'];
                $ngaysinh = $_POST['ngaysinh'];

                $customer = new Customer($name, $email, $ngaysinh);
                $this->customerDB->create($customer);
                $message = 'Customer created';
                include 'view/add.php';
            }
        }
        public function index()
        {   
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $customers = $this->customerDB->getAll();
            include 'view/list.php';
            }
        }
        public function delete()
        {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $customer = $this->customerDB->get($id);
            include 'view/delete.php';
        } else {
            $id = $_POST['id'];
            $this->customerDB->delete($id);
            header('Location: index.php');
        }
        }
}