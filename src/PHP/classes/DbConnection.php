<?php
namespace classes;

use PDO;

class DbConnection{
   private $server = 'fdb28.awardspace.net';
    private $dbname = '4254785_scandiweb';
    private $username = '4254785_scandiweb';
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
