<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Базовий клас головної сторінки користувача
 */
class Controller_Index extends Controller_Base {
    
    public $template = 'index/base_view'; // Базовий шаблон
    
    public function before() {
        parent::before();
        $Menu = new Model_Menu();
        $menu_main = $Menu->getMenu(1, $this->auth);
        $menu_top = $Menu->getMenu(2, $this->auth);
        $menu_main_last = Arr::get(end($menu_main), 'id');
        $select = Useful::get_select();
        
        // Вывод в шаблон
        $this->template->styles[] = 'media/css/main.css';
        $this->template->styles[] = 'media/css/jquery-ui.css';
        //$this->template->styles[] = 'media/css/jquery-ui-1.8.13.custom.css';
        //$this->template->styles[] = 'media/css/ui.dropdownchecklist.themeroller.css';
        
        
        $this->template->scripts[] = 'https://www.google.com/jsapi';
        $this->template->scripts[] = 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js';
        $this->template->scripts[] = 'media/js/jquery-1.10.2.js';
        $this->template->scripts[] = 'media/js/jquery-ui.js';
        $this->template->scripts[] = 'media/js/dropdownchecklist.js';
        
        $this->template->scripts[] = 'media/js/datepicker.js';
        $this->template->scripts[] = 'media/js/checkbox_check.js';
        $this->template->scripts[] = 'media/js/anchor.js';
        
        $this->template->auth = $this->auth;
        $this->template->menu_main = $menu_main;
        $this->template->menu_top = $menu_top;
        $this->template->select = mb_strtolower($select);
        $this->template->menu_main_last = $menu_main_last;
    }
}