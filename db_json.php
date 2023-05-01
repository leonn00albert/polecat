<?php
require_once('render_table.php');
require_once('functions.php');

class Database {
   public string $db_name = "";
   public string $db_path = "";
   function __construct(string $name) {
        $this->db_name = $name;
        if (!is_dir($name)) {
            mkdir($name);
            $this->db_path = "./" . $name;
    
        }    
   }

   function find(array $query):array | stdClass {
        $data = open_file_decode_json($this->db_path . '/' . '.json');
        if($query === []) {
            return $data;
        }
        else {
            $result = find_by_query($data, $query);
            return  $result;
        }
   }
   function findOne(array $query):stdClass{
    $data = open_file_decode_json($this->db_path . '/' . '.json');
    if($query === []) {
        return [];
    }
    else {
        $result = find_by_query($data, $query);
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


   function create(array $arr):bool{
        $file = fopen($this->db_path . '/' . '.json', 'w');
        if($file == False) {
            return False;
        }
        $data = open_file_decode_json($this->db_path . '/' . '.json');

        foreach ($arr as $elm) {
            array_push((array) $data, $elm);
        
        }
        print_r($data);
        fwrite($file, json_encode($data));
        fclose($file);
        return True;
    }

    function updateMany(array $query, array $update):bool{
        $data = (array) open_file_decode_json($this->db_path . '/' . '.json');
        if($query === []) {
            return False;
        }
        else {
        
            $file = fopen($this->db_path . '/' . '.json', 'w');
            fwrite($file, json_encode(update_by_query($data, $query, $update)));
            fclose($file);
            return True;
        }
    }


}

$test = new Database("test");

$test->create([
    ['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john.doe@example.com'],
    ['first_name' => 'Jane', 'last_name' => 'Smith', 'email' => 'jane.smith@example.com'],
    ['first_name' => 'John', 'last_name' => 'Johnson', 'email' => 'bob.johnson@example.com']
]);


