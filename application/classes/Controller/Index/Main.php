<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Головна сторінка
 */
class Controller_Index_Main extends Controller_Index {
    
    public function before() {
        parent::before();
        
        if (!$this->auth->logged_in()) {
            $this->redirect('login');
        }
    }

    public function action_index() {
        // Вивід в шаблон
        $this->template->title = 'Головна';
        $this->template->page_title = 'Головна';
        $this->template->block_content = '<p>Ласкаво просимо на сайт!</p>';
    }
}