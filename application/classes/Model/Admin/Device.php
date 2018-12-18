<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Device extends Model_Admin_ModelPresets {

    protected $_table_name = 'devices';

      public function get_all(){

          $query = DB::select()->from($this->_table_name)
                  ->order_by('id','ASC') 
                  ->execute();        
                   
          $result = $query->as_array();

          if($result)
              return $result;
          else
              return FALSE;

      }  
        

    /*---------------------------- GET EDIT DELETE -----------------------------*/      

      public function get_element($id){

        $query = DB::select()->from($this->_table_name)->where('id','=',':id')
                 ->param(':id', (int)$id) 
                 ->execute();

        $result = $query->as_array();

        if($result)
           return $result[0];
        else
           return FALSE;
      }


      public function update_element($id,$name,$location){
   
        $update = DB::update($this->_table_name)
                    ->set(array('name'=>$name))
                    ->set(array('location'=>$location))
                    ->where('id','=',':id')
                    ->param(':id', (int)$id)
                    ->execute();

        $query = DB::select()->from($this->_table_name)->where('id','=',':id')
                   ->param(':id', (int)$id)
                   ->execute();

        $result = $query->as_array();


        if($result)
            return $result[0];
        else
            return FALSE;

      }


      public function remove_element($id){

        return $sql = DB::delete($this->_table_name)->where('id','=',':id')
                        ->param(':id', (int)$id)
                        ->execute();

      }


      public function add_element(){}


      public function save_element($name,$location){

         $sql = DB::insert($this->_table_name);
         $col = array('name','location');
         $val = array($name,$location);

         $sql->columns($col); 
         $sql->values($val); 

         return $sql->execute();

      }
}

