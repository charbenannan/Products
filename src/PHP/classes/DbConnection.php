<?php
namespace classes;

use PDO;

class DbConnection{
   private $server = '127.0.0.1:3306';
    private $dbname = 'u186986090_scand';
    private $username = 'u186986090_scandiweb';
    private $password = 'C-hor4se';

    public function connect(){
        try{
            $conn = new PDO('mysql:host='.$this->server .'; dbname='.$this->dbname, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(\Exception $e){
            echo "Database Error: " .$e->getMessage();
        }

    }
}



?>
