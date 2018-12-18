<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Invoices extends Controller_Admin_Common {

public function action_index()
{

        $action = HTML::chars($this->request->param('method'));
        $id = HTML::chars($this->request->param('id'));
        $artname = HTML::chars($this->request->param('artname'));
        $type = HTML::chars($this->request->controller());
        Session::instance()->set('usr', Auth::instance()->get_user()->username);

        $date = HTML::chars($this->request->post('date'));
        $location = HTML::chars($this->request->post('location'));
        $device = HTML::chars($this->request->post('device'));
        $subject = HTML::chars($this->request->post('subject'));
        $description = $this->request->post('description');
        $pdf = HTML::chars($this->request->post('pdf'));
        $mails = $this->request->post('mails');
        $conf = Kohana::$config->load('email')->as_array();


        if (is_array($mails)) {
            $mails = implode(",", $mails);
        } 
        $user_created = Auth::instance()->get_user()->username;
        $date_created = date('Y-m-d');  
        $status = HTML::chars($this->request->post('status'));


        switch ($action){

            case 'edit':
                $content = View::factory('admin/'.$type.'/'.$type.'_edit')
                                ->bind('category',$categories)
                                ->bind('locations',$locations)
                                ->bind('devices',$devices)
                                ->bind('type',$type)
                                ->bind('artname',$artname)
                                ->bind('action',$action)
                                ->bind('id',$id);

                $categories = Model::factory('Admin_'.$type)->get_element($id);
                $locations = Model::factory('Admin_'.$type)->get_locations();
                $devices = Model::factory('Admin_'.$type)->get_device($categories['location']);
                $this->template->content = $content;
            break;

            case 'preview':
                $content = View::factory('admin/'.$type.'/'.$type.'_preview')
                                ->bind('category',$categories)
                                ->bind('type',$type)
                                ->bind('artname',$artname)
                                ->bind('users_list',$users_list)
                                ->bind('action',$action)
                                ->bind('id',$id); 
                $users_list = Model::factory('Admin_users')->get_all();
                $categories = Model::factory('Admin_'.$type)->get_element($id);
                $this->template->content = $content;                     
            break; 

            case 'view':
                $content = View::factory('admin/'.$type.'/'.$type.'_preview')
                                ->bind('category',$categories)
                                ->bind('type',$type)
                                ->bind('artname',$artname)
                                ->bind('mails_name_list',$mails_filtered)
                                ->bind('action',$action)
                                ->bind('id',$id); 
                $categories = Model::factory('Admin_'.$type)->get_element($id);
                $users_list = Model::factory('Admin_users')->get_all();
                $mails = explode(',',$categories['mails']);
                $mails = array_flip($mails);

                $mails_name_list = array_column($users_list, 'name', 'email');
                $mails_filtered = array_intersect_key($mails_name_list, $mails);

                $this->template->content = $content;                      
            break;     

            case 'approve':
                $content = View::factory('admin/'.$type.'/'.$type.'_edit')
                    ->bind('type',$type)
                    ->bind('artname',$artname)
                    ->bind('action',$action)
                    ->bind('id',$id);

                Model::factory('Admin_'.$type)->approve_element($id,$date,$location,$device,$subject,$description,$pdf,$mails,$status,'0');


                $mail_elem = Model::factory('Admin_'.$type)->get_element($id);

                if ($mail_elem) {
                      $mails = explode(',',$mail_elem['mails']);

                      if($mail_elem['mails']) {
                         if ($mails) {
                            $title = $subject; 

                            $message = '
                            Created by: '.$user_created.'
                            Device: '.$device.'
                            Location: '.$location.'
                            Creation date: '.$date_created.'
                            Description: '.$description;

                             $email = Email::factory($title, $message)
                            ->to($mails)
                            ->from($conf['options']['username'], 'Change Management System')
                            ->send(); 
                        }                      
                     }
                }
                
                $url = URL::base(TRUE,TRUE).'admin';
                $this->request->redirect($url);  

            break;       

            case 'edit_device':
                if($this->request->is_ajax()) //available in kohana repository
                {
                    $devices = Model::factory('Admin_'.$type)->get_device($location);
                    echo json_encode($devices);
                    $this->auto_render = false; //will disable template rendering
                } 

            break;     

            case 'update':
                $content = View::factory('admin/'.$type.'/'.$type.'_edit')
                    ->bind('category',$categories)
                    ->bind('type',$type)
                    ->bind('artname',$artname)
                    ->bind('action',$action)
                    ->bind('id',$id);

                Model::factory('Admin_'.$type)->update_element($id,$date,$location,$device,$subject,$description,$pdf,$mails,'1','0');
                
                $mail_elem = Model::factory('Admin_'.$type)->get_element($id);

                if ($mail_elem) {
                   if($mail_elem['mails']) {
                     $mails = explode(',',$mail_elem['mails']);

                        if ($mails) {
                            $title = $subject.' record was changed!'; 

                            $message = '
                            Created by: '.$user_created.'
                            Device: '.$device.'
                            Location: '.$location.'
                            Creation date: '.$date_created.'
                            Description: '.$description;

                             $email = Email::factory($title, $message)
                            ->to($mails)
                            ->from($conf['options']['username'], 'Change Management System')
                            ->send(); 
                        }   
                    }                   
                }

                $parent = Model::factory('Admin_'.$type)->get_parent();

                foreach ($parent as $k => $par) {
                    $arr[$k] = $par['parent_id']; 
                }
    
                if (!in_array($id,$arr)) {
                     Model::factory('Admin_'.$type)->save_element($date,$location,$device,$subject,$description,$mails,$pdf,'2',$user_created,$date_created,$id);
                }
                $url = URL::base(TRUE,TRUE).'admin';
                $this->request->redirect($url);
            break;
           /* case 'remove':
                $categories = Model::factory('Admin_'.$type)->remove_element($id);
                $url=URL::base(TRUE,TRUE).'admin';
                $this->request->redirect($url);
            break; */
        } 


}

public function action_addremove()
{

        $action = HTML::chars($this->request->param('method'));
        $id = HTML::chars($this->request->param('id'));
        $artname = HTML::chars($this->request->param('artname'));
        $type = HTML::chars($this->request->controller());
        Session::instance()->set('usr', Auth::instance()->get_user()->username);        

        $date = HTML::chars($this->request->post('date'));
        $location = HTML::chars($this->request->post('location'));
        $device = HTML::chars($this->request->post('device'));
        $subject = HTML::chars($this->request->post('subject'));
        $description = $this->request->post('description');
        $pdf = HTML::chars($this->request->post('pdf'));
        $mails = $this->request->post('mails');
        if (is_array($mails)) {
         $mails = implode(",", $mails);
        }  
        $status = HTML::chars($this->request->post('status'));
        $user_created = Auth::instance()->get_user()->username;  
        $date_created = date('Y-m-d'); 
           


        switch ($action){

            case 'add':
                 $content = View::factory('admin/'.$type.'/'.$type.'_edit')
                                ->bind('category',$categories)
                                ->bind('locations',$locations)
                                ->bind('type',$type)
                                ->bind('artname',$artname)
                                ->bind('action',$action)
                                ->bind('id',$id); 

                 $locations = Model::factory('Admin_'.$type)->get_locations();
                 $this->template->content = $content;
            break;  

            case 'search':
                if($this->request->is_ajax()) //available in kohana repository
                {   
                     $search1 = HTML::chars($this->request->post('search'));      
                     Model::factory('Admin_'.$type)->search($search1);
                     $this->auto_render = false; //will disable template rendering
                }    

            break;   

            case 'save':
                $categories = Model::factory('Admin_'.$type)->save_element($date,$location,$device,$subject,$description,$mails,$pdf,$status,$user_created,$date_created,'0');  

                $latest = Model::factory('Admin_'.$type)->get_latest();           
                
                $url=URL::base(TRUE,TRUE).'admin/'.$type.'/'.$latest['id'].'-m/preview';
                $this->request->redirect($url);

            break;

            case 'add_device':
                if($this->request->is_ajax()) //available in kohana repository
                {
                    $devices = Model::factory('Admin_'.$type)->get_device($location);
                    echo json_encode($devices);
                    $this->auto_render = false; //will disable template rendering
                } 

            break;                
        }

}   


}
