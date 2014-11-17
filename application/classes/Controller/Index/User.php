<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Головна сторінка
 */
class Controller_Index_User extends Controller_Index {
    
    public function before() {
        parent::before();
        
        if (!$this->auth->logged_in('admin')) {
            $this->redirect('login');
        }
    }

    public function action_index() {
        $User = new Model_User();
        $Useful = new Model_Useful();
        $all_users = $User->getUsers();
        $table = Useful::set_users_json($all_users);
        $json_table = json_encode($table);
         
        $content = View::factory('index/user/user_view')
            ->bind('json_table', $json_table)
            ->bind('errors', $errors)
            ->bind('data', $data);
        
        // Вивід в шаблон
        $this->template->title = 'Користувачі';
        $this->template->page_title = 'Користувачі';
        $this->template->block_content = $content;
    }
    
    public function action_delete() {
        $id = (int) $this->request->param('id');
        $all_users = ORM::factory('user', $id);
        
        if(!$all_users->loaded()){
            $this->redirect('user');
        }
        $all_users->delete();
        
        $this->redirect('user');
    }
}