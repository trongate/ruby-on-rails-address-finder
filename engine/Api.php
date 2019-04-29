<?php
class Api extends Trongate {

    function __construct() {
        parent::__construct();
    }

    function _make_sure_table_exists($table) {
        $all_tables = $this->_get_all_tables();
        if(!in_array($table, $all_tables)) {
            http_response_code(422);
            echo 'invalid table name'; die();
        }
    }

    function _get_all_tables() {
        $tables = [];
        $sql = 'show tables';
        $column_name = 'Tables_in_'.DB_NAME;
        $rows = $this->model->query($sql, 'array');
        foreach ($rows as $row) {
            $tables[] = $row[$column_name];
        }

        return $tables;
    }

    function _get_all_columns($table) {

        $columns = [];
        $sql = 'describe '.$table;
        $rows = $this->model->query($sql, 'array');
        foreach ($rows as $row) {
            $columns[] = $row['Field'];
        }

        return $columns;   
    }

    function _extract_where_key($where_left_side) {

        $where_left_side = trim($where_left_side);
        $bits = explode(' ', $where_left_side);

        $first_three = substr($where_left_side, 0, 3);
        if ($first_three == 'OR ') {
            $where_key = $bits[1];
        } else {
            $where_key = $bits[0];
        }

        return $where_key;
    }

    function _extract_where_start_word($where_left_side, $where_condition_count) {
        //return WHERE, AND or OR
        $where_start_word = 'WHERE';
        $where_left_side = trim($where_left_side);

        $first_three = substr($where_left_side, 0, 3);
        if ($first_three == 'OR ') {
            $where_start_word = 'OR';
        } elseif ($where_condition_count>1) {
            $where_start_word = 'AND';
        }

        return $where_start_word;        
    }

    function _extract_connective($where_left_side) {

        /*
            * =         { "name":"John"}
            * OR        { "OR age >" : 21}
            * !=        { "name !=": "John"}
            * >         { "age >" : 21}
            * <         { "age <" : 21}
            * LIKE      { "name LIKE" : "e"}
            * NOT LIKE  { "name NOT LIKE" : "e"}
        */   

        $where_left_side = trim($where_left_side);
        $str_len = strlen($where_left_side);
        $start = $str_len - 9;
        $last_nine = substr($where_left_side, $start, $str_len);

        if ($last_nine == ' NOT LIKE') {
            $connective = 'NOT LIKE';
        }

        $ditch = ' NOT LIKE';
        $replace = '';
        $where_left_side = str_replace($ditch, $replace, $where_left_side);

        if (!isset($connective)) {
            $start = $str_len - 5;
            $last_five = substr($where_left_side, $start, $str_len);

            if ($last_five == ' LIKE') {
                $connective = 'LIKE';
            }            
        }

        $ditch = ' LIKE';
        $replace = '';
        $where_left_side = str_replace($ditch, $replace, $where_left_side);

        if (!isset($connective)) {

            $first_three = substr($where_left_side, 0, 3);
            if ($first_three == 'OR ') {
                $where_left_side = substr($where_left_side, 3, $str_len);
            }

            $bits = explode(' ', $where_left_side);
            $num_bits = count($bits);

            if ($num_bits>1) {
                $target_index = count($bits)-1;
                $connective = $bits[$target_index];
            } else {
                $connective = '=';
            }

        }

        $connective = ltrim(trim($connective));
        return $connective;
    }

    function submit_bypass_auth() {
        $post = file_get_contents('php://input');
        $decoded = json_decode($post, true);
        $this->module('trongate_tokens');
        $this->trongate_tokens->_attempt_generate_bypass_token();
    }

    function _not_allowed_msg() {
        http_response_code(401);
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

        return $token;
    }

    function _add_params_to_query($module_name, $sql, $params) {

        //variables have been posted - start from here
        $got_where = false;
        foreach ($params as $key => $value) {
            $param_type = $this->_get_param_type($module_name, $key);

            if ($param_type == 'where') {
                $where_conditions[$key] = $value;
            }
        }

        //add where conditions
        if (isset($where_conditions)) {
            $where_condition_count = 0;
            foreach ($where_conditions as $where_left_side => $where_value) {
                $where_condition_count++;
                //where_key    where_value
                //manipulate the SQL query

                $where_key = $this->_extract_where_key($where_left_side);

                //make sure this column exists on the table
                $columns = $this->_get_all_columns($module_name);
                if (!in_array($where_key, $columns)) {
                    http_response_code(422);
                    echo $where_key.' is not a valid variable type or column name.';
                    die();
                }

                $where_start_word = $this->_extract_where_start_word($where_left_side, $where_condition_count);
                $connective = $this->_extract_connective($where_left_side);

                $new_where_condition = $where_start_word.' '.$where_key.' '.$connective.' :'.$where_key;
                $sql = $sql.' '.$new_where_condition;
                $data[$where_key] = $where_value;

            }

        }

        //add order by
        if (isset($params['orderBy'])) {

            //make sure this column is on the table
            $columns = $this->_get_all_columns($module_name);
            $column_name = str_replace(' desc', '', $params['orderBy']);

            if (!in_array($column_name, $columns)) {
                //invalid order by
                http_response_code(422);
                echo "invalid order by"; die();
            }

            $sql = $sql.' order by '.$params['orderBy'];
            unset($params['orderBy']);
        }

        //add limit offset
        if (isset($params['limit'])) {

            $limit = $params['limit'];

            //get the offset
            if (isset($params['offset'])) {
                $offset = $params['offset'];
            } else {
                $offset = 0;
            }

            if ((!is_numeric($limit)) || (!is_numeric($offset))) {
                http_response_code(422);
                echo "non numeric limit and/or offset"; die();
            }

            settype($limit, "integer");
            settype($offset, "integer");

            $data['limit'] = $limit;
            $data['offset'] = $offset;
            $sql = $sql.= ' limit :offset, :limit';

        }

        if (!isset($data)) {
            $data = [];
        }

        $query_info['sql'] = $sql;
        $query_info['data'] = $data;
        return $query_info;
    }

    function _get_params_from_url($params_segment) {
        //params segment is where params might be passed
        $params_str = $this->url->segment($params_segment);
        $first_char = substr($params_str, 0, 1);
        if ($first_char == '?') {
            $params_str = substr($params_str, 1);
        }

        $data = [];
        parse_str($params_str, $data);

        //convert into json
        $params = [];
        foreach ($data as $key => $value) {
            $key = $this->_prep_key($key); 
            $value = $this->_remove_special_characters($value);          
            $params[$key] = $value;
        }

        return $params;
    }

    function _prep_key($key) { //php convert json into URL string

        //get last char
        $key = trim($key);
        $str_len = strlen($key);
        $last_char = substr($key, $str_len-1);
        
        if ($last_char == '!') {
            $key = $key.'=';
        }

        $key = $this->_remove_special_characters($key);

        $ditch = 'OR_';
        $replace = 'OR ';
        $key = str_replace($ditch, $replace, $key);

        $ditch = '_NOT_LIKE';
        $replace = ' NOT LIKE';
        $key = str_replace($ditch, $replace, $key);

        $ditch = '_LIKE';
        $replace = ' LIKE';
        $key = str_replace($ditch, $replace, $key);

        $ditch = '_!=';
        $replace = ' !=';
        $key = str_replace($ditch, $replace, $key);

        $ditch = 'AND_';
        $replace = 'AND ';
        $key = str_replace($ditch, $replace, $key);

        $ditch = '_>';
        $replace = ' >';
        $key = str_replace($ditch, $replace, $key);

        $ditch = '_<';
        $replace = ' <';
        $key = str_replace($ditch, $replace, $key);

        return $key;
    }

    function _remove_special_characters($str) {
        $ditch = '*!underscore!*';
        $replace = '_';
        $str = str_replace($ditch, $replace, $str);

        $ditch = '*!gt!*';
        $replace = '>';
        $str = str_replace($ditch, $replace, $str);

        $ditch = '*!lt!*';
        $replace = '<';
        $str = str_replace($ditch, $replace, $str);

        $ditch = '*!equalto!*';
        $replace = '=';
        $str = str_replace($ditch, $replace, $str);

        return $str;
    }

    function _get_params_from_post() {
        $post = file_get_contents('php://input');
        $post = trim($post);
        $params = json_decode($post, true);
        return $params;
    }

    function _attempt_invoke_before_hook($input, $module_endpoints, $target_endpoint) {

        //check API settings & find out which method (if any) to invoke
        if (isset($target_endpoint['beforeHook'])) {
            //invoke the before hook
            $module_name = $input['module_name'];
            $target_method = $target_endpoint['beforeHook'];
            $input = Modules::run($module_name.'/'.$target_method, $input);
        }

        return $input;
    }

    function _attempt_invoke_after_hook($output, $module_endpoints, $target_endpoint) {
        //check API settings & find out which method (if any) to invoke

        if (isset($target_endpoint['afterHook'])) {
            //invoke the after hook
            $module_name = $output['module_name'];
            $code = $output['code'];
            $target_method = $target_endpoint['afterHook'];

            $output = $this->_clean_output($output);

            //ONLY output['body'] and output['code'] is being used at this point
            $output = Modules::run($module_name.'/'.$target_method, $output);

        } else {
            $output = $this->_clean_output($output);
        }

        return $output;
    }

    function _clean_output($output) {
        //remove unwanted output properties
        foreach ($output as $key => $value) {

            if (($key != 'body') && ($key != 'code') && ($key != 'token')) {
                unset($output[$key]);
            }
        }

        return $output;
    }

    function _find_one($module_name, $update_id, $token) {

        //attempt invoke 'before' hook
        $input['token'] = $token;
        $input['params'] = [];
        $input['module_name'] = $module_name;   
        $input['endpoint'] = 'Find One'; 

        $module_endpoints = $this->_fetch_endpoints($input['module_name']);
        $target_endpoint = $module_endpoints[$input['endpoint']];
        $input = $this->_attempt_invoke_before_hook($input, $module_endpoints, $target_endpoint);
        extract($input);


        $result = $this->model->get_where($update_id, $module_name);

        $output['body'] = json_encode($result);
        $output['code'] = 200;
        $output['module_name'] = $module_name;

        $output = $this->_attempt_invoke_after_hook($output, $module_endpoints, $target_endpoint);
        
        $code = $output['code'];
        http_response_code($code);
        echo $output['body'];
    }

    function get() {
        $input['token'] = $this->_validate_token();
        $output['token'] = $input['token'];
        $module_name = $this->url->segment(3);
        $this->_make_sure_table_exists($module_name);

        $fourth_bit = $this->url->segment(4);

        if (is_numeric($fourth_bit)) {
            $this->_find_one($module_name, $fourth_bit, $input['token']);
        } else {
            $params = $this->_get_params_from_url(4);
        }

        $sql = 'select * from '.$module_name;

        

        //attempt invoke 'before' hook
        $input['params'] = $params;
        $input['module_name'] = $module_name;
        $input['endpoint'] = 'Get';

        $module_endpoints = $this->_fetch_endpoints($input['module_name']);
        $target_endpoint = $module_endpoints[$input['endpoint']];
        $input = $this->_attempt_invoke_before_hook($input, $module_endpoints, $target_endpoint);
        extract($input);

        $num_params = count($params);

        if ($num_params < 1) { 
            $rows = $this->model->get('id', $module_name);
            $output['body'] = json_encode($rows);
            $output['code'] = 200;
            $output['module_name'] = $module_name;

            $output = $this->_attempt_invoke_after_hook($output, $module_endpoints, $target_endpoint);
            
            $code = $output['code'];
            http_response_code($code);
            echo $output['body'];

        } else {
            //params were posted
            $sql = 'select * from '.$module_name;
            $params = json_encode($params);
            $params = ltrim($params);
            $params = json_decode($params);
            $params = get_object_vars($params);
            $query_info = $this->_add_params_to_query($module_name, $sql, $params);

            $sql = $query_info['sql'];
            $data = $query_info['data'];

            if (count($data)<1) {
                $rows = $this->model->query($sql, 'object');
            } else {
                $rows = $this->model->query_bind($sql, $data, 'object');
            }

            $output['body'] = json_encode($rows);
            $output['code'] = 200;
            $output['module_name'] = $module_name;

            $output = $this->_attempt_invoke_after_hook($output, $module_endpoints, $target_endpoint);
            
            $code = $output['code'];
            http_response_code($code);
            echo $output['body'];
        }
        
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
                $type = 'order by';
                break;
            default:
                $type = 'where';
                break;
        }


        return $type;
    }

    function explorer() {
        $this->module('security');
        $target_module = $this->url->segment(3);
        $this->_make_sure_table_exists($target_module);
        // $this->module('trongate_tokens');

        // $token_data['user_id'] = $this->security->_get_user_id();
        // $data['token'] = $this->trongate_tokens->_generate_token($token_data);
        
        $data['endpoints'] = $this->_fetch_endpoints($target_module);
        $data['endpoint_settings_location'] = '/modules/'.$target_module.'/assets/api.json';

        $view_file = $file_path = APPPATH.'engine/views/api_explorer.php';
        extract($data);
        require_once $view_file;
    }

    function _fetch_endpoints($target_module) {

        if ($target_module == '') {
            http_response_code(422);
            echo "No target module set"; die();
        }

        $file_path = APPPATH.'modules/'.$target_module.'/assets/api.json';
        $settings = file_get_contents($file_path);
        $endpoints = json_decode($settings, true);   
        return $endpoints;    
    }

}