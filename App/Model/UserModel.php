<?php

namespace App\Model;

use App\Model;
use PDO;

class UserModel extends Models
{

    public function getAll()
    {
        $sql = "SELECT * FROM `user`";
        $stmt = $this->connect->prepare($sql);

    }

    public function getById($request)
    {
        $sql = "SELECT * FROM `user` WHERE `email` = ? AND `password` = ?;";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(1, $request['email']);
        $stmt->bindParam(2, $request['password']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($user)
    {
        $sql = "INSERT INTO `user`(`user_name`,`password`,`email`,`image`,`date_of_birth`,`phone_number`) 
VALUES(:user_name,:password,:email,:image,:date_of_birth,:phone_number) ";
        $stmt = $this->connect->prepare($sql);
        $phone = (int)$user->phone;
        $stmt->bindParam(':user_name', $user->name);
        $stmt->bindParam(':password', $user->password);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':image', $user->image);
        $stmt->bindParam(':date_of_birth', $user->date_of_birth);
        $stmt->bindParam(':phone_number', $phone);
        $stmt->execute();
    }

    public function checkValidateUser($name)
    {
        $sql = "SELECT `user_name` FROM `user` WHERE `user_name` = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(1, $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkValidateEmail($email)
    {
        $sql = "SELECT `email` FROM `user` WHERE `email` = ?";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function edit($data)
    {

        $sql = "UPDATE `user` SET `user_name`= :name,`password`= :password,
                      `email`= :email,`date_of_birth`= :date_of_birth,`phone_number`= :phone, `image`= :image Where  id = :id1";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(":id1", $data->id);
            $stmt->bindParam(':name', $data->name);
            $stmt->bindParam(':password', $data->password);
            $stmt->bindParam(':email', $data->email);
            $stmt->bindParam(':date_of_birth', $data->date_of_birth);
            $stmt->bindParam(':phone', $data->phone);
            $stmt->bindParam(':image', $data->image);
        return $stmt->execute();
    }

    public function getByidforEdit($id1)
    {
        $sql = "SELECT * FROM `user` where  id = :id1";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':id1', $id1);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByinIndex($id1)
    {
        $sql = "SELECT * FROM `user` where  id = :id1";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':id1', $id1);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}