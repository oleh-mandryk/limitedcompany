<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Головна сторінка
 */
class Controller_Index_Menu extends Controller_Index {
    
    public function before() {
        parent::before();
        
        if (!$this->auth->logged_in('admin')) {
            $this->redirect('login');
        }
    }

    public function action_index() {
        $Menu = new Model_Menu();
        $Useful = new Model_Useful();
        $all_menu = $Menu->getMenuAll();
        $table = Useful::set_menu_json($all_menu);
        $json_table = json_encode($table);
        $content = View::factory('index/menu/menu_view')
            ->bind('json_table', $json_table)
            ->bind('errors', $errors)
            ->bind('data', $data);
        
        // Вивід в шаблон
        $this->template->title = 'Меню';
        $this->template->page_title = 'Меню';
        $this->template->block_content = $content;
    }
    
    public function action_add() {
        if (isset($_POST['submit'])) {
            $Menu = new Model_Menu();
            $data = Arr::extract($_POST, array('url', 'name', 'sort', 'type_menu', 'status'));
            $data = Security::xss_clean($data);
            $validate = Validation::factory($data)
                ->rules('url', array(array('not_empty')))
                ->rules('name', array(array('not_empty')))
                ->rules('sort', array(array('not_empty')))
                ->labels(array(
                    'url' => 'URL',
                    'name' => 'Назва',
                    'sort' => 'Сортування',
                    ));
            if ($validate->check()) {
                $Menu->insertMenu($data);
                $this->redirect('menu');
            } else {
                $errors = $validate->errors('validation');  
            }
        }
        
        $content = View::factory('index/menu/menu_add_view')
            ->bind('errors', $errors)
            ->bind('data', $data);
    
        // Вивід в шаблон
        $this->template->page_title = 'Меню :: Додавання';
        $this->template->title = 'Меню :: Додавання';
        $this->template->block_content = $content;
    }
    
    public function action_edit() {
        $id = (int) $this->request->param('id');
        $Menu = new Model_Menu();
        $menu = ORM::factory('menu', $id);
        if(!$menu->loaded()){
            $this->redirect('menu');
        }
        $data = $menu->as_array();
        // Редагування
        if (isset($_POST['submit'])) {
            $data = Arr::extract($_POST, array('url', 'name', 'sort', 'status'));
            $data = Security::xss_clean($data);
            $validate = Validation::factory($data)
                ->rules('url', array(array('not_empty')))
                ->rules('name', array(array('not_empty')))
                ->rules('sort', array(array('not_empty')))
                ->labels(array(
                    'url' => 'URL',
                    'name' => 'Назва',
                    'sort' => 'Сортування',
                    ));
            if ($validate->check()) {
                $Menu->updateMenu($data, $id);
                $this->redirect('menu');
            } else {
                $errors = $validate->errors('validation');  
            }
        }

        $content = View::factory('index/menu/menu_edit_view')
                ->bind('id', $id)
                ->bind('errors', $errors)
                ->bind('data', $data);

        // Вивід в шаблон
        $this->template->page_title = 'Меню :: Редагування';
        $this->template->title = 'Меню :: Редагування';
        $this->template->block_content = $content;
    }
    
    public function action_delete() {
        $id = (int) $this->request->param('id');
        $all_menu = ORM::factory('menu', $id);
        
        if(!$all_menu->loaded()){
            $this->redirect('menu');
        }
        $all_menu->delete();
        
        $this->redirect('menu');
    }
}