<?php
class Api extends Trongate {

    function __construct() {
        parent::__construct();
    }

    function test() {

/*
                * =         { "name":"John"}
                * OR        { "OR age >" : 21}
                * !=        { "name !=": "John"}
                * >         { "age >" : 21}
                * <         { "age <" : 21}
                * LIKE      { "name LIKE" : "e"}
                * NOT LIKE  { "name NOT LIKE" : "e"}
*/

        $key = 'name NOT LIKE';
        $key = 'OR name > ';
        $key = 'name LIKE';

        $key = '';
        $key = 'OR age';
        $key = 'name !=';
        $key = 'age <';
        $key = 'name LIKE';
        $key = 'name NOT LIKE';



        $key = trim($key);
        $bits = explode(' ', $key);

        $connective = $this->_figure_out_connective($key, $bits);

        echo 'for <span style="color: blue;">'.$key.'</span> the connective is<br>';
        echo $connective; die();

        $key_len = strlen($key);

        if ($key_len >= 10) {
            $start = $key_len - 8;
            $last_eight = substr($key, $start, $key_len);
            echo $last_eight;
        }


    }

    function submit_bypass_auth() {
        $post = file_get_contents('php://input');
        $decoded = json_decode($post, true);
        $this->module('trongate_tokens');
        $this->trongate_tokens->_attempt_generate_bypass_token();
    }

    function _not_allowed_msg() {
        echo "Invalid token."; die();
    }

    function _validate_token() {

        if (!isset($_SERVER['HTTP_TRONGATETOKEN'])) {
            $this->_not_allowed_msg();
        } else {
            $token = $_SERVER['HTTP_TRONGATETOKEN'];
            $this->module('trongate_tokens');
            $valid = $this->trongate_tokens->_is_token_valid($token); //returns true if num rows>0

            if ($valid == false) {
                $this->_not_allowed_msg();
            }
        }

    }

    function get() {
        $this->_validate_token();

        //if user has made it past this point then token must be good

        $module_name = $this->url->segment(3);
        $sql = 'select * from '.$module_name;

        //let's check to see if any params were posted
        $post = file_get_contents('php://input');
        $decoded = json_decode($post, true);

        if (isset($decoded['params'])) {

            $is_json = $this->is_json($decoded['params']);

            if ($is_json == false) {
                echo "not valid json"; die();
            }

            $params = json_decode($decoded['params']);
            $sql = $this->_add_params_to_query($module_name, $sql, $params);
        }


        echo "you should not be here"; die();


        echo gettype($decoded);

        foreach($decoded as $key => $value) {
            echo "key is $key<br>";
        }
        die();


        $rows = $this->model->get('id', $data['module_name']);
        $data = json_encode($rows);
        echo $data;
    }

    function is_json($string){
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    function _add_params_to_query($module_name, $sql, $params) {

        //php object properties
        $params = get_object_vars($params);
        $got_where = false;
        foreach ($params as $key => $value) {
            $param_type = $this->_get_param_type($module_name, $key);

            if ($param_type == 'where') {
                $data['module_name'] = $module_name;
                $data['sql'] = $sql;
                $data['key'] = $key;
                $data['value'] = $value;
                $data['got_where'] = $got_where;
                $sql = $this->_add_where_condition($data);
                $got_where = true;
            }
        }

        $sql = str_replace('  ', ' ', $sql);

                        echo $sql; die();

        $data['module_name'] = $module_name;
        $rows = $this->model->query($sql, $data, 'array');



        echo $sql; die();

        echo "adding params to $sql";

    }

    function _add_where_condition($data) {
        //NOTE:  'LIKE' conditions should have % joined onto value.  For example, 'value%'
        extract($data);

        /*
            * =         { "name":"John"}
            * OR        { "OR age >" : 21}
            * !=        { "name !=": "John"}
            * >         { "age >" : 21}
            * <         { "age <" : 21}
            * LIKE      { "name LIKE" : "e"}
            * NOT LIKE  { "name NOT LIKE" : "e"}
        */

        $key = trim($key);
        $bits = explode(' ', $key);
        if (count($bits)>1) {
            $first_bit = $bits[0];
            if ($first_bit == 'OR') {
                $new_sql = $sql.' OR '.$bits[1].' ;connective; :'.$bits[1].' ';
            }
        }

        if (!isset($new_sql)) {

            if ($got_where == true) {
                $new_sql = $sql.' AND '.$key.' ;connective; :'.$key.' ';
            } else {
                $new_sql = $sql.' WHERE '.$key.' ;connective; :'.$key.' ';
            }

        }

        //let's figure out what the connective is
        if (count($bits)>1) {
            //slightly awkward (deserves its own function)
            $replace = $this->_figure_out_connective($key, $bits);
            $new_sql = str_replace(';connective;', $replace, $new_sql);
        }

        $new_sql = str_replace(';connective;', '=', $new_sql);
        return $new_sql;
    }

    function _figure_out_connective($key, $bits) {

        $num_bits = count($bits);

        if ($num_bits > 2) {

            /*
                must be one of the following formats:

                    * OR        { "OR age >" : 21}
                    * NOT LIKE  { "name NOT LIKE" : "e"}
            */ 

            $key_len = strlen($key);

            if ($key_len >= 10) {
                $start = $key_len - 9;
                $last_nine = substr($key, $start, $key_len);
                
                if ($last_nine == ' NOT LIKE') {
                    $connective = 'NOT LIKE';
                    echo $connective; die();
                    return $connective;
                }
            }

            //check for 'LIKE'
            $start = $key_len - 5;
            $last_five = substr($key, $start, $key_len);
            
            if ($last_five == ' LIKE') {
                $connective = 'LIKE';
                return $connective;
            }            


            //connective must be last two characters of key (left trimmed)
            $start = $key_len - 2;
            $last_two = substr($key, $start, $key_len);
            $connective = ltrim($last_two);

            return $connective;



        } else {

            /*

                must be one of the following formats:
                * !=        { "name !=": "John"}
                * >         { "age >" : 21}
                * <         { "age <" : 21}
                * LIKE      { "name LIKE" : "e"}
            */

            if ($bits[0] == 'OR') {
                $connective = '=';
            } else {
                $connective = $bits[1];
            }

            return $connective;
        }

    }

    function _get_param_type($module_name, $key) {

        switch ($key) {
            case 'limit':
                $type = 'limit';
                break;
            case 'offset':
                $type = 'offset';
                break;
            case 'orderBy':
                $type = $this->_check_order_by($module_name, $key);
                break;
            case 'order_by':
                $type = $this->_check_order_by($module_name, $key);
                break;
            default:
                $type = 'where';
                break;
        }


        return $type;
    }

    function _check_order_by($module_name, $key) {

        //user has submitted 'order_by' or 'orderBy'
        //is this an order by request or a where condition?

        $sql = 'describe '.$module_name;
        $data['module_name'] = $module_name;

        $rows = $this->model->query($sql, 'array');
        foreach ($rows as $row) {
            $columns[] = $row['Field'];
        }
        
        if (in_array($key, $columns)) {
            //the key is a column name!
            $type = 'where';
        } else {
            $type = 'order by';
        }

        return $type;
    }



    function explorer() {
        $this->module('security');
        // $this->module('trongate_tokens');

        // $token_data['user_id'] = $this->security->_get_user_id();
        // $data['token'] = $this->trongate_tokens->_generate_token($token_data);
        $target_module = $this->url->segment(3);
        $data['endpoints'] = $this->_fetch_endpoints($target_module);
        $data['endpoint_settings_location'] = '/modules/'.$target_module.'/assets/api.json';

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