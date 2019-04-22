<?php
class api extends Trongate {

    function __construct() {
        parent::__construct(); //required for model
        $this->parent_module = 'donors';
        $this->child_module = 'api';
    }

    function _before_update($input) {
        //do some stuff before sending input
        if ($user_level != 'admin') {

            if (isset($input['paid'])) {
                unset($input['paid']);
            }
        }
    }

    function _after_read($output) {
        //do some stuff before receiving output
        if ($user_level != 'admin') {
            unset($output['password']);
            return $output;
        }
    }



















    /*
            TO DO:

                pre hooks
                post hooks
                access control rules
                callbacks
                custom endpoints   ???
    */

    function endpoint_rock($return_description=NULL) {
        $description = 'rocks the night and does it with style';
        if (isset($return_description)) {
            return $description;
        }
    }

    function _get_endpoint_rock_rules() {
        $data['request_type'] = 'POST';
        return $data;
    }

    function and_again() {
        echo "ok";
    }

    function api_settings() {

            $settings['Create'] = array('description' => 'This one is cool',
                                        'request_type' => 'POST',
                                        'allowed' => 'token|admin');
            $settings['Find'] = 'okay';
            $settings['Upsert'] = 'okay';
            $settings['Update'] = 'okay';
            $settings['Find One'] = 'okay';
            $settings['Find One By Post'] = 'okay';
            $settings['Destroy'] = 'okay';
            $settings['Destroy One'] = 'okay';
            $settings['Exists'] = 'okay';
            $settings['Exists By Post'] = 'okay';

            echo json_encode($settings);

        // $rules = file_get_contents(APPPATH.'modules/donors/api/assets/api_settings.json');
        // $array = json_decode($rules, true);
        // var_dump($array);
    }

    function access_control() {

        $endpoint_rules = [
            'Create' => 'token|user_level["admin"]',
            'Find' => 'token|user_level["admin"]',
            'Upsert' => 'token|user_level["admin"]',
            'Update' => 'token|user_level["admin"]',
            'Find One' => 'token|user_level["admin"]',
            'Find One By Post' => 'token|user_level["admin"]',
            'Destroy' => 'token|user_level["admin"]',
            'Destroy One' => 'token|user_level["admin"]',
            'Exists' => 'token|user_level["admin"]',
            'Exists By Post' => 'token|user_level["admin"]',
            'endpoint_rock' => ''
        ];

        echo json_encode($endpoint_rules);

    }

    // function username_check() {
    //     //to do
    // }

    function __destruct() {
        $this->parent_module = '';
        $this->child_module = '';        
    }

}