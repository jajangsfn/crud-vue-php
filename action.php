<?php 
    //koneksi ke database dnegan PDO
    $connect = new PDO("mysql:host=localhost;dbname=vuedb", "root", "");
    $received_data = json_decode(file_get_contents("php://input"));

    //membuat variabel data
    //variabel ini akan digunakan untuk menampung data dari database nantinya
    $data = array();

    //script untuk menampilkan semua data
    if($received_data->action == 'fetchall')
    {
        //perintah untuk mengambil data dari database
        $query      = "SELECT * FROM user ORDER BY id DESC";
        $statement  = $connect->prepare($query);
        $statement->execute();

        //melakukan perulangan dan memasukan tiap data ke dalam variabel data
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        
        //menampilkan data dalam bentuk json
        echo json_encode($data);

    }

    if($received_data->action == 'insert')
    {
        $data = array(
            ':first_name' => $received_data->first_name,
            ':last_name' => $received_data->last_name
        );
            
        $query = "INSERT INTO user (first_name, last_name) VALUES (:first_name, :last_name)";
        $statement  = $connect->prepare($query);
        $statement->execute($data);

    }

    if($received_data->action == 'update')
    {
        $data = array(
            ':first_name'   => $received_data->first_name,
            ':last_name'    => $received_data->last_name,
            ':id'           => $received_data->id
        );
            
        $query = "UPDATE user SET first_name = :first_name, last_name = :last_name WHERE id = :id";
            
        $statement = $connect->prepare($query);
            
        $statement->execute($data);
    }

    if($received_data->action == 'delete')
    {
        $data = array(
            ':id'           => $received_data->id
        );
        $query = "DELETE FROM user WHERE id = :id";
            
        $statement = $connect->prepare($query);
            
        $statement->execute($data);
    }

?>