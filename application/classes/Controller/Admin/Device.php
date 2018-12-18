<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Device extends Controller_Admin_Common {

public function action_index()
{

        $action = HTML::chars($this->request->param('method'));
        $id = HTML::chars($this->request->param('id'));
        $artname = HTML::chars($this->request->param('artname'));
        $type = HTML::chars($this->request->controller());


        $name = HTML::chars($this->request->post('name'));
        $location = HTML::chars($this->request->post('location'));

        switch ($action){
            case 'edit':
                $content = View::factory('admin/'.$type.'/'.$type.'_edit')
                    ->bind('category',$categories)
                    ->bind('type',$type)
                    ->bind('artname',$artname)
                    ->bind('action',$action)
                    ->bind('id',$id);
                $categories = Model::factory('Admin_'.$type)->get_element($id);
                $this->template->content = $content;
                break;
            case 'update':
                $content = View::factory('admin/'.$type.'/'.$type.'_edit')
                    ->bind('category',$categories)
                    ->bind('type',$type)
                    ->bind('artname',$artname)
                    ->bind('action',$action)
                    ->bind('id',$id);
                $categories = Model::factory('Admin_'.$type)->update_element($id,$name,$location);
                $this->template->content = $content;
            break;
            case 'remove':
                $categories = Model::factory('Admin_'.$type)->remove_element($id);
                $url=URL::base(TRUE,TRUE).'admin/'.$type;
                $this->request->redirect($url);
            break;
        }
}

public function action_addremove()
{

        $action = HTML::chars($this->request->param('method'));
        $id = HTML::chars($this->request->param('id'));
        $artname = HTML::chars($this->request->param('artname'));
        $type = HTML::chars($this->request->controller());


        $name = HTML::chars($this->request->post('name')); 
        $location = HTML::chars($this->request->post('location'));    

        switch ($action){
            case 'add':
        		 $content = View::factory('admin/'.$type.'/'.$type.'_edit')
                                ->bind('category',$categories)
                                ->bind('type',$type)
                                ->bind('artname',$artname)
                                ->bind('action',$action)
                                ->bind('id',$id);

                 $categories = Model::factory('Admin_'.$type)->add_element();
        		 $this->template->content = $content;
            break;
            case 'save':
        		 $categories = Model::factory('Admin_'.$type)->save_element($name,$location);
        		 $url=URL::base(TRUE,TRUE).'admin/'.$type;
        		 $this->request->redirect($url);
            break;
         }

}   


}
