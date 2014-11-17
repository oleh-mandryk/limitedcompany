<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Авторизація
 */
class Controller_Index_Auth extends Controller_Index {
    
    public function action_index() {
        $this->action_login();
    }
    
    //Функція для авторизації
    public function action_login() {
        if ($this->auth->logged_in()) {
            $this->redirect();        
        }
        else {
            if (isset($_POST['submit'])) {
                $data = Arr::extract($_POST, array('username', 'password', 'remember'));
                $users = ORM::factory('user')->where('username', '=', $data['username'])->find()->as_array();
                $status = Auth::instance()->login($data['username'], $data['password'], (bool) $data['remember']);
                if ($status) {
                    $this->redirect();
                }
                else {
                    $errors = array(Kohana::message('message', 'no_user'));     
                }
            }    
        }
         
        $content = View::factory('index/auth/auth_login_view')
            ->bind('errors', $errors)
            ->bind('data', $data);

        // Выводим в шаблон
        $this->template->title = 'Вхід';
        $this->template->page_title = 'Вхід';
        $this->template->block_content = $content;
    }
    
    //Функція для реєстрації
    public function action_register() {
        if (!$this->auth->logged_in('admin')) {
            $this->redirect();        
        }
        else {
            if (isset($_POST['submit'])) {
                $data = Arr::extract($_POST, array('username', 'email', 'password', 'password_confirm'));
                $users = ORM::factory('user');
                try {
                    if (isset($_POST['type_register'])) {
                        $type_register = $_POST['type_register'];
                    } else {
                        $type_register = '1';    
                    }
                    $users->create_user($_POST, array(
                        'username',
                        'email',
                        'password',
                        'status'
                    ));
                    switch ($type_register) {
                        case 1:
                            $role = ORM::factory('role')->where('name', '=', 'login')->find();
                            $users->add('roles', $role);    
                        break;
                        
                        case 2:
                            $role = ORM::factory('role')->where('name', '=', 'admin')->find();
                            $users->add('roles', $role);
                            $role = ORM::factory('role')->where('name', '=', 'login')->find();
                            $users->add('roles', $role); 
                        break;
                    }
                    $this->redirect('user');        
                }
                catch (ORM_Validation_Exception $e) {
                    $errors = $e->errors('validation');
                }
            } else {
                $data1 = Arr::extract($_POST, array('username', 'email', 'password', 'password_confirm'));
                $type_register = '1';
            }   
            
        }
        $content = View::factory('index/auth/auth_register_view')
            ->bind('type_register', $type_register)
            ->bind('errors', $errors)
            ->bind('data', $data);

        // Виводимо в шаблон
        $this->template->title = 'Реєстрація';
        $this->template->page_title = 'Реєстрація';
        $this->template->block_content = $content;
        
    }
    
    public function action_logout() {
        $this->auth->logout();
        $this->redirect();
    }
}