<?php
class Api extends Trongate {

    function __construct() {
        parent::__construct();
    }

    function explorer() {
        $this->module('security');
        $this->module('trongate_tokens');

        $token_data['user_id'] = $this->security->_get_user_id();
        $data['token'] = $this->trongate_tokens->_generate_token($token_data);
        $target_module = $this->url->segment(3);
        $data['endpoints'] = $this->_fetch_endpoints($target_module);
        $data['endpoint_settings_location'] = '/modules/'.$target_module.'/api/assets/api_settings.json';

        $view_file = $file_path = APPPATH.'engine/views/api_explorer.php';
        extract($data);
        require_once $view_file;
    }

    function _fetch_endpoints($target_module) {

        if ($target_module == '') {
            echo "No target module set"; die();
        }

        $file_path = APPPATH.'modules/'.$target_module.'/assets/api.json';
        $settings = file_get_contents($file_path);
                        // $ditch = '}';
                        // $replace = '<span class=&quot;alt-font&quot;>}</span>';
                        // $settings = str_replace($ditch, $replace, $settings);
                        // $ditch = '{';
                        // $replace = '<span class=&quot;alt-font&quot;>{</span>';
                        // $settings = str_replace($ditch, $replace, $settings);


        $endpoints = json_decode($settings, true);   
        return $endpoints;    
    }


}