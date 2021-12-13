<?php

class Places
{

    public $connect;

    public function __construct()
    {
        require_once('database.php');

        $database = new Database;
        $this->connect = $database->connect();
    }

    public function add_place($data)
    {
        $name = $data['name'];
        $zameen_id = $data['zameen_id'];
        $parent_id = $data['parent_id'];
        $get_place = $this->get_place($zameen_id);
        if ($get_place) {
            // echo 'added already';
            // die();
            return true;
        } else {
            $query = "
			INSERT INTO places (name, zameen_id, parent_id) VALUES ('$name','$zameen_id','$parent_id')
			";
            if ($this->connect->query($query) === TRUE) {
                return $this->connect->insert_id;
            } else {
                return false;
            }
        }
    }

    public function get_place($id)
    {
        $query = "
		SELECT * FROM places WHERE zameen_id = '$id' 
		";
        $result = $this->connect->query($query);
        if ($this->connect->error) {
            die("Connection failed: " . $this->connect->error);
        }
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
}
