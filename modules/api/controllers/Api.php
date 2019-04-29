<?php
class DUFF!!!!!   Api extends Trongate  DUFF ____ DO NOT USE!!!! {

    function get($module_name) {
        $rows = $this->model->get('id', 'donors');
        echo json_encode($rows);
    }

    function donors() {
        $module_name = 'donors';
        $this->get($module_name);
    }

    function explorer() {
        $this->module('security');
        $this->module('trongate_tokens');

        $token_data['user_id'] = $this->security->_get_user_id();
        $data['token'] = $this->trongate_tokens->_generate_token($token_data);
        $data['endpoints'] = $this->_fetch_endpoints();
        $target_module = $this->url->segment(3);
        $data['endpoint_settings_location'] = '/modules/'.$target_module.'/assets/api.json';

        $this->view('explorer', $data);
    }

    function submit_bypass_auth() {

        $post = file_get_contents('php://input');
        $decoded = json_decode($post, true);
        $token = $decoded['token'];

        $this->module('trongate_tokens');
        $this->trongate_tokens->_attempt_generate_bypass_token($token);
    }

    function _fetch_endpoints() {
        $module_name = $this->url->segment(3);
        $file_path = APPPATH.'modules/'.$module_name.'/assets/api.json';
        $settings = file_get_contents($file_path);
        $endpoints = json_decode($settings, true);   
        return $endpoints;    
    }

    function _attempt_fetch_custom_endpoints() {
        $module_name = $this->url->segment(3);
        $file_path = APPPATH.'modules/'.$module_name.'/assets/api.json';
        $settings = file_get_contents($file_path);
        $settings = json_decode($settings, true);

        unset($settings['Create']);
        unset($settings['Find']);
        unset($settings['Upsert']);
        unset($settings['Update']);
        unset($settings['Find One']);
        unset($settings['Find One By Post']);
        unset($settings['Destroy']);
        unset($settings['Destroy One']);
        unset($settings['Exists']);
        unset($settings['Exists By Post']);
        return $settings;
    }

}