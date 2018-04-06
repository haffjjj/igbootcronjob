<?php

class dbConfig
{
	private $dbDriver = "mysql"; 	//databaseOpo?
	private $host = "localhost"; 	//namaHost
	private $username = "root"; 	//username
	private $password = ""; 		//password
	private $database = "igboot";		//namaDatabaseNya
    protected $connection;
    
	public function __construct(){
		try{

		$this->connection = new PDO($this->dbDriver.':host='.$this->host.';dbname='.$this->database,$this->username,$this->password);
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }
		catch (PDOException $e){
        	die("Koneksi error: " . $e->getMessage());
    	}
	}
}

class dbmethod extends dbConfig
{
    public function __construct(){
		parent::__construct();
	}

    public function insertimg($imgname,$caption){
        $query = "INSERT INTO queue VALUES(:id,:imgname,:caption,:status)"; //query
		$result = $this->connection->prepare($query);
		try{
            $data = [
                ':id' => '',
                ':imgname' => $imgname,
                ':caption' => $caption,
                ':status'=> '0'
            ];
			$result->execute($data);
		}
		catch (PDOException $e){
        	die("Koneksi error: " . $e->getMessage());
    	}
    }

    public function readqueue(){
		$query = "SELECT * FROM queue where status = 0 limit 1"; //query
		try{
			$result = $this->connection->query($query);
		}
		catch (PDOException $e){
        	die("Koneksi error: " . $e->getMessage());
    	}
		$rows = [];
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$rows[] = $row;
		}
		return $rows;
    }

    public function readqueueall(){
		$query = "SELECT * FROM queue where status = 0"; //query
		try{
			$result = $this->connection->query($query);
		}
		catch (PDOException $e){
        	die("Koneksi error: " . $e->getMessage());
    	}
		$rows = [];
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$rows[] = $row;
		}
		return $rows;
    }
    
    public function updatequeue($id){
		$query = "UPDATE queue set status = 1 where id = $id"; //query
		$result = $this->connection->prepare($query);
		try{
			$result->execute();
		}
		catch (PDOException $e){
        	die("Koneksi error: " . $e->getMessage());
    	}
	}
}


?>