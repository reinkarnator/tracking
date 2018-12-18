<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Main extends Controller_Admin_Common {       
    // Главная страница
    public function action_index() {}

    public function action_nav()
    {
       $artname = $this->request->param('artname');
       $lang_count = $this->lang_path();
       $deflang = Kohana::$config->load('lang')->get('adminLang');

       $content = View::factory('admin/'.$artname.'/'.$artname)
                  ->bind('lang_count',$lang_count)
                  ->bind('lang',$deflang)
                  ->bind('type',$artname)
                  ->bind('menu_elements',$menu_elements);

       $menu_elements = Model::factory('Admin_'.$artname)->get_all();

       $this->template->content = $content;
    }
    public function action_logout()
    {
        Session::instance()->set('KCFINDER', array('disabled' => true)); 
        Auth::instance()->logout();     
        $this->request->redirect(URL::base(TRUE,TRUE).'admin');
    }
    public function action_login() {}    

}
