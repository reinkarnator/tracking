<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_Invoices extends Model_Admin_ModelPresets {

    protected $_table_name = 'invoice_lists';
    protected $_device = 'devices';

      public function get_all($filter='',$get_sts=''){

          if ($filter) {
              if ($get_sts == '1') {
                $val = 'DESC';
              } else {
                $val = 'ASC';
              }
              $query = DB::select()->from($this->_table_name)
                      ->order_by($filter,$val) 
                      //->order_by(`status`, `ASC`)
                      ->param(':filter', $filter)
                      ->execute();
          } else {
              $query = DB::select()->from($this->_table_name)
                      ->order_by('FIELD(`status`, 0)','DESC') 
                      ->order_by('id','DESC') 
                      ->execute();        
          }            

          $result = $query->as_array();

          if($result)
              return $result;
          else
              return FALSE;

      }  

      /* public function filterby($filter){
      
          $query = DB::select()->from($this->_table_name)

                  ->execute();

          $result = $query->as_array();

          if($result)
              return $result;
          else
              return FALSE;

      } */        

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

      public function get_locations(){

          $query = DB::select('location')->from($this->_device)
                   ->group_by('location')
                   ->execute();

          $result = $query->as_array();

          if($result)
             return $result;
          else
             return FALSE;
      }

      public function get_parent() {
          $query = DB::select('parent_id')->from($this->_table_name) 
                   ->execute();

          $result = $query->as_array();

          if($result)
             return $result;
          else
             return FALSE;        
      }

      public function get_device($location) {
          $query = DB::select('name')->from($this->_device)
                   ->where('location','=',':id')
                   ->param(':id', $location) 
                   ->execute();

          $result = $query->as_array();

          if($result)
             return $result;
          else
             return FALSE;        
      }   

      public function search($search) {
          $query = DB::select()->from($this->_table_name)
                   ->where('location','LIKE', '%'.$search.'%')
                   ->or_where('device','LIKE', '%'.$search.'%')
                   ->or_where('date','LIKE', '%'.$search.'%')
                   ->or_where('subject','LIKE', '%'.$search.'%')
                   ->or_where('description','LIKE', '%'.$search.'%')
                   ->or_where('mails','LIKE', '%'.$search.'%')
                   ->or_where('pdf','LIKE', '%'.$search.'%')
                   ->or_where('change_date','LIKE', '%'.$search.'%')
                   ->or_where('user_added','LIKE', '%'.$search.'%')
                   ->execute();

                   //die('Nooooo');

          $result = $query->as_array();

          if($result) {
            foreach ($result as $key => $invoice) {
             if ($invoice['status'] == 0) {  
                echo '<tr class="temp-line">';
             } else { 
                echo '<tr>';
             }        
                    echo '<td class="val-id">'.$invoice['id'].'</td>
                    <td class="val-date">'.$invoice['date'].'</td>                                    
                    <td class="val-location">'.$invoice['location'].'</td>                                    
                    <td class="val-device">'.$invoice['device'].'</td>                                    
                    <td class="val-subject">';
                    if($invoice['status']=='2') { echo '<b style="color:red;">(Closed)</b>'; } 
                    echo $invoice['subject'].'</td>';                                                                                                                                                                                 
                    echo '<td align="center">'.$invoice['user_added'].'</td>';                                                                                                         
                    echo '<td align="center">';
                    if ($invoice['change_date'] != '0000-00-00 00:00:00') { 
                      echo date("Y-m-d", strtotime($invoice['change_date'])); 
                    }else{ 
                      FALSE; 
                    }
                    echo '</td>';                                                                                                         
                    echo '<td align="center" class="val-status">';
                    if (($invoice['user_added'] == Auth::instance()->get_user()->username) && ($invoice['status'] == 0 || $invoice['status'] == 1)) {  
                        echo '<a href="'.URL::base(TRUE,TRUE).'admin/Invoices/'.$invoice['id'].'-m/edit"><img src="'.URL::base().'html/admin/images/pencil.gif" width="16" height="16" /></a>';
                    }
                    echo '<img src="'.URL::base().'html/admin/images/status'.$invoice['status'].'.png" width="16" height="16" />
                        <a class="view-item" data-attr="'.$invoice['id'].'" style="cursor:pointer;"><img src="'.URL::base().'html/admin/images/eye.png" width="16" height="16" /></a>
                    </td>                                                                         
                </tr>'; 

echo "<script>
$('.view-item').click(function(){
    var view_id = $(this).attr('data-attr');
    var dialog1 = $( '#dialog' ).dialog({ 
          height: 600,
          width: 800
    }); 
    dialog1.load('/admin/Invoices/'+view_id+'-m/view/ .module-body').dialog('open');
});
</script>";
            }
            // return $result;
          }else{
             return FALSE;  
          }         
      }          

      public function get_latest() {
          $query = DB::select(array(DB::expr('MAX(id)'), 'id'))->from($this->_table_name) 
                      ->execute();

          $result = $query->as_array();

          if($result)
             return $result[0];
          else
             return FALSE;        
      }      


      public function update_element($id,$date,$location,$device,$subject,$description,$pdf,$mails,$status,$parent_id){

        $update = DB::update($this->_table_name)
                    ->set(array('date'=>$date))
                    ->set(array('location'=>$location))
                    ->set(array('device'=>$device))
                    ->set(array('description'=>$description))
                    ->set(array('pdf'=>$pdf))
                    ->set(array('mails'=>$mails))
                    ->set(array('status'=>$status))
                    ->set(array('parent_id'=>(int)$parent_id))
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

      public function approve_element($id,$date,$location,$device,$subject,$description,$pdf,$mails,$status,$parent_id){
        $update = DB::update($this->_table_name)
                    ->set(array('date'=>$date))
                    ->set(array('location'=>$location))
                    ->set(array('device'=>$device))
                    ->set(array('description'=>$description))
                    ->set(array('pdf'=>$pdf))
                    ->set(array('mails'=>$mails))
                    ->set(array('status'=>$status))
                    ->set(array('parent_id'=>(int)$parent_id))
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


      public function save_element($date,$location,$device,$subject,$description,$mails,$pdf,$status,$user_created,$date_created,$parent_id){
if (is_array($mails)) {
   $mails = implode('++',$mails);
}
         $sql = DB::insert($this->_table_name);
         $col = array('date','location','device','subject','description','mails','pdf','status','change_date','user_added','parent_id');
         $val = array($date,$location,$device,$subject,$description,$mails,$pdf,$status,$date_created,Session::instance()->get('usr'),$parent_id);

         $sql->columns($col); 
         $sql->values($val); 

         return $sql->execute();

      }
}

