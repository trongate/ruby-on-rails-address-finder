<?php
class Api extends Trongate {

    function __construct() {
        parent::__construct();
    }

    function test3() {


        $params = '



{
   "first_name!=":"David",
    "OR email NOT LIKE":"david@bla.com"
}

        ';


        $data = [];
        parse_str($params, $data);

var_dump($data); die();

        $params = json_decode($params);


        $query = http_build_query($params, null, '&', PHP_QUERY_RFC3986);
        echo $query;

    }

    function test2() {

        $module_name = 'donors';
        $sql = 'select * from '.$module_name;

        $params = '



{
   "first_name":"David",
    "OR email NOT LIKE":"david@bla.com"
}

        ';

echo $params.'<hr>';

        $params = json_decode($params);
        $params = get_object_vars($params);


        $query_info = $this->_add_params_to_query($module_name, $sql, $params);
        echo $query_info['sql'];
    }

    function test() {

        $module_name = 'donors';
        $sql = 'select * from '.$module_name;

        $params = '



{
   "first_name":"David",
    "OR email NOT LIKE":"david@bla.com"
}

        ';

echo $params.'<hr>';

        $params = json_decode($params);
        $params = get_object_vars($params);

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
                $where_start_word = $this->_extract_where_start_word($where_left_side, $where_condition_count);
                $connective = $this->_extract_connective($where_left_side);

                $new_where_condition = $where_start_word.' '.$where_key.' '.$connective.' :'.$where_key;
                $sql = $sql.' '.$new_where_condition;
                $data[$where_key] = $where_value;

            }

        }



        //add order by
        if (isset($params['orderBy'])) {
            $data['order_by'] = $params['orderBy'];
            $sql = $sql.' order by :order_by';
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
                echo "non numeric limit and/or offset"; die();
            }

            $data['limit'] = $limit;
            $data['offset'] = $offset;
            $sql = $sql.= ' limit :offset, :limit';

        }

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
                $where_start_word = $this->_extract_where_start_word($where_left_side, $where_condition_count);
                $connective = $this->_extract_connective($where_left_side);

                $new_where_condition = $where_start_word.' '.$where_key.' '.$connective.' :'.$where_key;
                $sql = $sql.' '.$new_where_condition;
                $data[$where_key] = $where_value;

            }

        }

        //add order by
        if (isset($params['orderBy'])) {
            $data['order_by'] = $params['orderBy'];
            $sql = $sql.' order by :order_by';
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
                echo "non numeric limit and/or offset"; die();
            }

            $data['limit'] = $limit;
            $data['offset'] = $offset;
            $sql = $sql.= ' limit :offset, :limit';

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

        $ditch = '*!underscore!*';
        $replace = '_';
        $key = str_replace($ditch, $replace, $key);

        $ditch = '*!gt!*';
        $replace = '>';
        $key = str_replace($ditch, $replace, $key);

        $ditch = '*!lt!*';
        $replace = '<';
        $key = str_replace($ditch, $replace, $key);

        $ditch = '*!equalto!*';
        $replace = '=';
        $key = str_replace($ditch, $replace, $key);

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

    function _get_params_from_post() {
        $post = file_get_contents('php://input');
        $post = trim($post);
        $params = json_decode($post, true);
        return $params;
    }

    function get() {
        $this->_validate_token();
        $module_name = $this->url->segment(3);
        $sql = 'select * from '.$module_name;

        $params = $this->_get_params_from_url(4);
        $num_params = count($params);

        if ($num_params < 1) { 
            $rows = $this->model->get('id', $module_name);
            $data = json_encode($rows);
            echo $data;         
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
            $rows = $this->model->query_bind($sql, $data, 'object');
            $result = json_encode($rows);
            echo $result;
        }
        
    }

    function getOLD() {
        $this->_validate_token();

        //if user has made it past this point then token must be good

        $module_name = $this->url->segment(3);
        $sql = 'select * from '.$module_name;

        //let's check to see if any params were posted
        $post = file_get_contents('php://input');
        $post = trim($post);

        if ($post != '') {

            $decoded = json_decode($post, true);

            if ($decoded == false) {
                echo 'invalid JSON'; die();
            }

            if (isset($decoded['params'])) {
                echo 'yes'; die();
                $query_info = $this->_add_params_to_query($sql, $decoded['params']);
            } else {
                echo 'no params set'; die();
            }
            
            
        }



 echo "you should not be here"; die();





        $rows = $this->model->get('id', $data['module_name']);
        $data = json_encode($rows);
        echo $data;
    }



    // function _add_params_to_query($module_name, $sql, $params) {

    //     //php object properties
    //     $params = get_object_vars($params);
    //     $got_where = false;
    //     foreach ($params as $key => $value) {
    //         $param_type = $this->_get_param_type($module_name, $key);

    //         if ($param_type == 'where') {
    //             $data['module_name'] = $module_name;
    //             $data['sql'] = $sql;
    //             $data['key'] = $key;
    //             $data['value'] = $value;
    //             $data['got_where'] = $got_where;
    //             $sql = $this->_add_where_condition($data);
    //             $got_where = true;
    //         }
    //     }

    //     $sql = str_replace('  ', ' ', $sql);

    //                     echo $sql; die();

    //     $data['module_name'] = $module_name;
    //     $rows = $this->model->query($sql, $data, 'array');



    //     echo $sql; die();

    //     echo "adding params to $sql";

    // }

    // function _add_where_condition($data) {
    //     //NOTE:  'LIKE' conditions should have % joined onto value.  For example, 'value%'
    //     extract($data);

    //     /*
    //         * =         { "name":"John"}
    //         * OR        { "OR age >" : 21}
    //         * !=        { "name !=": "John"}
    //         * >         { "age >" : 21}
    //         * <         { "age <" : 21}
    //         * LIKE      { "name LIKE" : "e"}
    //         * NOT LIKE  { "name NOT LIKE" : "e"}
    //     */

    //     $key = trim($key);
    //     $bits = explode(' ', $key);
    //     if (count($bits)>1) {
    //         $first_bit = $bits[0];
    //         if ($first_bit == 'OR') {
    //             $new_sql = $sql.' OR '.$bits[1].' ;connective; :'.$bits[1].' ';
    //         }
    //     }

    //     if (!isset($new_sql)) {

    //         if ($got_where == true) {
    //             $new_sql = $sql.' AND '.$key.' ;connective; :'.$key.' ';
    //         } else {
    //             $new_sql = $sql.' WHERE '.$key.' ;connective; :'.$key.' ';
    //         }

    //     }

    //     //let's figure out what the connective is
    //     if (count($bits)>1) {
    //         //slightly awkward (deserves its own function)
    //         $replace = $this->_figure_out_connective($key, $bits);
    //         $new_sql = str_replace(';connective;', $replace, $new_sql);
    //     }

    //     $new_sql = str_replace(';connective;', '=', $new_sql);
    //     return $new_sql;
    // }

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