<?php
require_once('render_table.php');
require_once('functions.php');

class Database {
   public string $db_name = "";
   public string $db_path = "";
   public $data = [];

   function __construct(string $name) {
        $this->db_name = $name;
        if (!is_dir($name)) {
            mkdir($name);
        }    
        $this->db_path = "./" . $name;
        if (is_file($name . '/' . '.json')) {
            $this->data = open_file_decode_json($this->db_name . '/' . '.json');
         
        }
   }

   private function update(){
        $this->data = open_file_decode_json($this->db_name . '/' . '.json');
        return $this;
   }

   function find(array $query){
        if($query === []) {
            return $this;
        }
        else {
            $result = find_by_query($this->data, $query);
            return $this;
        }
   }
   
   function findOne(array $query):stdClass{
    if($query === []) {
        return [];
    }
    else {
        $result = find_by_query($this->data, $query);
        return  $result[0];
    }
}
    function deleteMany(array $query):bool{
        $data = open_file_decode_json($this->db_path . '/' . '.json');
        if($query === []) {
            return False;
        }
        else {
            $file = fopen($this->db_path . '/' . '.json', 'w');
            fwrite($file, json_encode(delete_by_query($data, $query)));
            fclose($file);
            return True;
        }

     }


   function create(array $arr){
        $this->data = array_merge($this->data, $arr);
        return $this;
        $file = fopen($this->db_path . '/' . '.json', 'w');
        if(!$file) {
            return false;
        }
        $json_data = json_encode($this->data);
        fwrite($file, $json_data);

        fclose($file);
        return $this;
    }

    function findById(string $id){
        if($query === []) {
            return $this;
        }
        else {
            $result = find_by_query($this->data, ["id" => $id]);
            return $result;
        }
    }
    function updateById(string $id){
        if($query === []) {
            return $this;
        }
        else {
            $result = find_by_query($this->data, ["id" => $id]);
            return $result;
        }
    }


    function updateMany(array $query, array $update){
        if($query === []) {
            return $this;
        }
        else {
            $file = fopen($this->db_path . '/' . '.json', 'w');
            fwrite($file, json_encode(update_by_query($this->data, $query, $update)));
            fclose($file);
            return $this;
        }
    }


}

$test = new Database("test");


$test->create([['first_name' => 'leon  ', 'last_name' => 'russel', 'email' => 'bob.johnson@example.com']])
->updateMany(['first_name' => 'leon  '], ['first_name' => 'fritz  ']);

