<?php

namespace App\Controller;

use App\Model\CateModel;
use App\Model\RoomModel;
use App\Room;

class RoomController
{
    public RoomModel $roomDB;
    public CateModel $cateModel;

    public function __construct()
    {
        $this->roomDB = new RoomModel();
        $this->cateModel = new CateModel();
    }

    public function getDataCheckIn()
    {

    }


    function index()
    {
        $rooms = $this->roomDB->getAll();
        include 'View/room/list.php';
    }

    function getStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $status = $_GET['status'];
            $rooms = $this->roomDB->getByStatus($status);
            include 'View/room/list.php';
        }
    }

    function countByStatus()
    {
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        } else {
            $status = "ERROR";
        }
        return $this->roomDB->countByStatus($status);

    }

    public function getImage()
    {
        $fileError = [];
        $target_dir = "Public/Image/";
        $target_name = basename($_FILES["image"]["name"]);

        $target_file = $target_dir . $target_name;

        if ($_FILES["image"]["size"] > 5000000) {
            $fileError["fileUpload"] = "Chỉ được upload file dưới 5MB";
        }

        $file_type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

        $file_type_allow = ["jpg", "png", "jpeg", "gif"];

        if (!in_array(strtolower($file_type), $file_type_allow)) {
            $fileError["fileUpload"] = "Chỉ được upload file ảnh";
        }

        if (file_exists($target_file)) {
            $fileError["fileUpload"] = "File đã tồn tại trên hệ thống";
        }

        if (empty($fileError)) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        }
        return $target_name;
    }

    public function error(): array
    {
        $error = [];
        $fields = ["name", "description", "unit_price", "cateName"];
        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                $error[$field] = "Không được để trống";
            }
        }

        return $error;
    }

    public function getDataRoom()
    {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $unit_price = $_POST["unit_price"];
        $category = $_POST["cateName"];
        $image = $this->getImage();

        $data = [

            "name" => $name,
            "description" => $description,
            "unit_price" => $unit_price,
            "cateName" => $category,
            "image" => $image
        ];

        return new Room($data);
    }

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $cates = $this->cateModel->getAll();
            include "View/room/add.php";
        } else {
            $error = $this->error();
            if (empty($error)) {
                $room = $this->getDataRoom();
                $this->roomDB->add($room);
                header("location:index.php?page=room&action=show-list");

            } else {
                include "View/room/add.php";
            }
        }
    }

    public function checkIn()
    {
        $id = $_GET["id"];
        $rooms = $this->roomDB->getById($id);
        $room = $rooms[0];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            include "View/room/check_in.php";
        } else {

            $fields = ["timeCheckIn", "timeCheckOut", "price"];
            foreach ($fields as $field) {
                if (empty($_POST[$field])) {
                    $error[$field] = "Không được để trống";
                }
            }
            if (empty($error)) {
                $checkIn = $_POST["timeCheckIn"];
                $checkOut = $_POST["timeCheckOut"];
                $price = $_POST["price"];
                $roomName = $_POST["roomName"];
                $roomId = $_POST['id'];

                $dataCheckIn = [
                    "roomName" => $roomName,
                    "checkIn" => $checkIn,
                    "checkOut" => $checkOut,
                    "price" => $price,
                    "roomId" => $roomId
                ];
                $this->roomDB->checkIn($dataCheckIn);
                header("location:index.php?page=room&action=show-list");
            } else {
                include "View/room/check_in.php";
            }
        }

    }

    function delete()
    {
        $id = $_GET['id'];
        $room = $this->roomDB->getById($id);
        unlink("Public/Image/" . $room[0]->image);
        $this->roomDB->delete($id);
        header('location:index.php?page=room&action=show-list');
    }

    function update()
    {

        $id = $_GET['id'];
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $room = $this->roomDB->getById($id);
            $cates = $this->cateModel->getAll();
            include "View/room/update.php";
        } else {
            $error = $this->error();
            if (empty($this->error())) {
                $rooms = $this->getDataRoom();
                if ($rooms->image != "") {
                    $room = $this->roomDB->getById($id);
                    unlink("Public/Image/" . $room[0]->image);
                    $this->roomDB->update($id, $rooms);
                } else {
                    $this->roomDB->update($id, $rooms);
                }
                header("location:index.php?page=room&action=show-list");
            } else {
                include "View/room/update.php";
            }

        }
    }

    public function checkOut()
    {
        $id = $_GET["id"];
        $room = $this->roomDB->getById($id);
        $this->roomDB->checkOut($id , $room);
        header("location:index.php?page=room&action=show-list");
    }

    public function search()
    {
        $search = $_POST["search"];
        if (empty($search)) {
            $rooms = $this->roomDB->getAll();
        } else {
            $rooms = $this->roomDB->search($search);
        }
        include "View/room/list.php";
    }

    public function statistical()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET"){
            include "View/room/statistical.php";
        }else{
            if ($_POST["year"] == ""){
                $error = "nhập năm cần xem thống kê";
            }

            if (!isset($error)){
                $year = $_POST["year"];
                $payments = $this->roomDB->statistical($year);
            }
            include "View/room/statistical.php";

        }
    }

    public function home()
    {
        include "View/core/home.php";
    }

    public function detail()
    {
        $id = $_GET["id"];
        $room = $this->roomDB->getById($id);
        $cates = $this->cateModel->getAll();
        include "View/room/detail.php";
    }
}