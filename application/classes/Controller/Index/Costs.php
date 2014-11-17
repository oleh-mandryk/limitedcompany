<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Головна сторінка
 */
class Controller_Index_Costs extends Controller_Index {
    
    public function before() {
        parent::before();
        
        $this->template->scripts[] = 'media/js/grid.js';
        //$this->template->scripts[] = 'media/js/TreeMenu.js';
        
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
        $Pocket = new Model_Pocket();
        $Useful = new Model_Useful();
        
        $array_date = $Useful->getArrayDate();
        $store_citys = $Storecity->getStoreCityForPocket();
        $pocket = $Pocket->getPocket();
        $date_from = $array_date[0]['date_from'];
        $date_to = $array_date[0]['date_to'];
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;
         
        $content = View::factory('index/costs/costs_view')
            ->bind('store_citys', $store_citys)
            ->bind('pocket', $pocket)
            ->bind('json_table', $json_table)
            ->bind('json_graph', $json_graph)
            ->bind('data', $data);
        
        // Вивід в шаблон
        $this->template->title = 'Costs';
        $this->template->page_title = 'Costs';
        $this->template->block_content = $content;
    }
}