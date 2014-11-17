<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Головна сторінка
 */
class Controller_Index_Indebtedness extends Controller_Index {
    
    public function before() {
        parent::before();
        
        if (!$this->auth->logged_in()) {
            $this->redirect('login');
        }
        
        $Menu = new Model_Menu();
        if($Menu->checkStatus() == 0) {
            throw new HTTP_Exception_404('Сторінка не знайдена');
            return;
        }
    }

    public function action_index() {
        $Storecity = new Model_Storecity();
        $Indebtedness = new Model_Indebtedness();
        $store_citys = $Storecity->getStoreCity();
        if (isset($_POST['store_city_id'])) {
            $store_city_id = $_POST['store_city_id'];    
        } else {
            $store_city_id = '00000000-0000-0000-0000-000000000000';    
        }
        $indebtedness = $Indebtedness->getIndebtedness($store_city_id);
        $table = Useful::set_table_indebtedness_json($indebtedness);
        $json_table = json_encode($table);
         
        $content = View::factory('index/indebtedness/indebtedness_view')
            ->bind('store_citys', $store_citys)
            ->bind('json_table', $json_table)
            ->bind('data', $data);
        
        // Вивід в шаблон
        $this->template->title = 'Indebtedness';
        $this->template->page_title = 'Indebtedness';
        $this->template->block_content = $content;
    }
}