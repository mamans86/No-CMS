<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Layout extends CMS_Controller{
    
    protected $theme = 'neutral';
    
    public function __construct(){
        parent::__construct();
        $this->theme = $this->cms_get_config('site_theme');
    }

    public function index(){
        // widgets
        $query = $this->db->select('widget_id, widget_name, static_content')->from(cms_table_name('main_widget'))->get();
        $widget_list = $query->result_array();
        $normal_widget_list = array();
        $section_widget_list = array();
        foreach($widget_list as $widget){
            if($widget['widget_id']<6){
                $section_widget_list[$widget['widget_name']] = $widget;
            }else{
                $normal_widget_list[] = $widget;
            }
        }
        // languages
        $language_list = $this->cms_language_list();
        // config
        $query = $this->db->select('config_name, value')->from(cms_table_name('main_config'))->get();
        $config_list = $query->result_array();        
        // send to the view
        $data['normal_widget_list'] = $normal_widget_list;
        $data['section_widget_list'] = $section_widget_list;
        $data['language_list'] = $language_list;
        $data['config_list'] = $config_list;
        $this->view('layout_index', $data, 'main_layout');
    }
}