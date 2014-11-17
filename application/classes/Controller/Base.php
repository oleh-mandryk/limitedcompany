<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Базовий контроллер
 */
class Controller_Base extends Controller_Template {
    
    protected $user;
    protected $auth;
    
    public function before() {
        parent::before();
        
        I18n::lang('ua');
        
        $this->auth = Auth::instance();
        $this->user = $this->auth->get_user();
        
        // Вивід в шаблон
        $this->template->site_name = 'Limited Company';
        $this->template->page_title = null;
        $this->template->title = null;
        $this->template->description = null;
        $this->template->keywords = null;

        // Підключаємо стилі і скрипти
        $this->template->styles = array();
        $this->template->scripts = array();

        // Підключаємо блоки
        $this->template->block_content = null;
    }
}