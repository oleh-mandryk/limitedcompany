<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Головна сторінка
 */
class Controller_Index_Remain extends Controller_Index {
    
    public function before() {
        parent::before();
        
        $this->template->scripts[] = 'media/js/grid.js';
        
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
        $Useful = new Model_Useful();
        
        $array_date = $Useful->getArrayDate();
        $store_citys = $Storecity->getStoreCityForRemain();
        $company_identifier = $Storecity->getStoreCityIndex();
        $date_from = $array_date[0]['date_from'];
        $date_to = $array_date[0]['date_to'];
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
    
        $content = View::factory('index/remain/remain_view')
            ->bind('store_citys', $store_citys)
            ->bind('company_identifier', $company_identifier)
            ->bind('json_table', $json_table)
            ->bind('json_graph', $json_graph)
            ->bind('data', $data);
        
        // Вивід в шаблон
        $this->template->title = 'Balances';
        $this->template->page_title = 'Balances';
        $this->template->block_content = $content;
    }
}