<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin_Common extends Controller_Template {

    public $template;
    public $sessionId;
    public $auth;
    public $user;
    public $class_id;
    public $user_roles = array();

    public function lang_path() {
     if (is_dir(APPPATH.'i18n')) {
        if ($handle = opendir(APPPATH.'i18n')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $langs_count[] = $entry;
                    sort($langs_count); 
                 }
            }
        return $langs_count;    
        closedir($handle);
        }     
      } 
    }


    public function before()
    {  
      if (Request::current()->action() == 'login'){
            $this->template='admin/login';
      } else {
            $this->template='admin/main';  
      }        
    
      parent::before(); 

       $artname = $this->request->param('artname');
       $site_config = Kohana::$config->load('lang');
       $lang  = $site_config->get('adminLang');
       I18n::lang($lang.'-'.$lang);

        $this->auth = Auth::instance();
        $this->user = $this->auth->get_user();
        $this->class_id = Get_class($this);

                

        if ($this->auth->logged_in())
        { 
            $filter = HTML::chars($this->request->post('filter'));
            $get_sts = HTML::chars($this->request->post('get_sts'));
            
	        Session::instance()->set('KCFINDER', array('disabled'=>false));  

            $invoices = Model::factory('Admin_Invoices')->get_all($filter, $get_sts);

            $invoicemodule = View::factory('admin/invoices')
                                   //->bind("companies",$companies)
                                   ->bind("invoices",$invoices);

            //$companies = Model::factory('Admin_Company')->get_all();

            $content = View::factory('admin/admin')
                       ->bind("account",$account)
                       ->bind("invoicemodule",$invoicemodule)
                       ->bind("menus",$menus);


            $this->user = $this->auth->get_user();
            $this->user_roles = $this->user->roles->find_all()->as_array(NULL,'name');   

            if ($this->user->has('roles', ORM::factory('role', array('name' => 'admin'))))
            {
                $menus = array(__("Главная",null)=>'',
                               __("Пользователи",null)=>'Users',
                               __("Device",null)=>'Device',          
                               __("Add record",null)=>'Invoices/add');          
            } else {
               $menus = array(__("Главная",null)=>'',
                              __("Add record",null)=>'Invoices/add'); 
           }                                

        }elseif ($_POST){
            $post = Arr::extract($_POST, array('username','password'));
                 if($this->auth->login($post['username'], $post['password'], FALSE))
                 {
                       $this->request->redirect(URL::base(TRUE,TRUE).'admin');        
                 }else{
                       $this->request->redirect(URL::base(TRUE,TRUE).'admin/login');                            
                 }
        }else{
            if(Request::current()->action() != 'login')
                  $this->request->redirect(URL::base(TRUE,TRUE).'admin/login');
        }

         $this->_check_permission();


         $this->template->menus = $menus;
         $this->template->content = $content;

    } 

    private function _check_permission()
    {
        $check_permission = FALSE;

        $config_security = Kohana::$config->load('security')->as_array();
        $action = Request::current()->action();

        if(isset($config_security[$this->class_id][$action]))
        {
            foreach($config_security[$this->class_id][$action] as $users_role)
                if(in_array($users_role, $this->user_roles) || in_array($users_role, array('public')))
                    $check_permission = TRUE;
        }
                
        if(isset($config_security[$this->class_id]['all_actions']))
        {
            foreach($config_security[$this->class_id]['all_actions'] as $users_role)
                if(in_array($users_role, $this->user_roles) || in_array($users_role, array('public')))
                     $check_permission = TRUE;   
        }
        
        if($check_permission != TRUE)
            exit('Access deny - 403 ');
    }

    

} // End Common
