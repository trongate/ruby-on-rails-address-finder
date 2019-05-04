<?php
class Trongate_tokens extends Trongate {

    /*
     * This a utility class that can assist you with things like securing API endpoints
     * The class is associated with a database table called trongate_tokens. 
     * Therefore, a database connection is required for this class to work.
     *
     * The default expiry time for tokens is set to one day.  However, you can 
     * easily change that to suit your needs.
     */

    private $default_token_lifespan = 86400; //one day

    function test() {
        $token = $this->url->segment(3);


        // $result = $this->model->get_one_where('token', $token, 'trongate_tokens');

        // if ($result == false) {
        //     //invalid token
        //     echo 'invalid token';
        // } else {
        //     $user_id = $result->user_id;
        //     echo "hello $user_id";
        // }



        // // $data['token'] = $token;
        // // $sql = 'select * from trongate_tokens where token = :token';
        // // $tokens = $this->model->query_bind($sql, $data, 'object');
        // // $num_rows = count($tokens);

        // // echo $num_rows;
    }

    function _validate_token() {

        if (!isset($_SERVER['HTTP_TRONGATETOKEN'])) {
            $this->_not_allowed_msg();
        } else {
            $token = $_SERVER['HTTP_TRONGATETOKEN'];
            $this->_is_token_valid($token);

            if ($valid == false) {
                $this->_not_allowed_msg();
            }
        }

        return $token;
    }

    function clean() {
        $sql = 'delete from trongate_tokens';
        $this->model->query($sql);

        $sql = 'delete from query_mem';
        $this->model->query($sql);
        echo 'cleaned';
    }

    function _generate_token($data=NULL) {

        /*
         * $data array may contain:
         *                         user_id ~ int(11) : required
         *                         expiry_date ~ int(10) : optional 
         *                         code ~ varchar(4) : optional                                     
         *
         * 'expiry_date' (if submitted) should be a unix timestamp, set to some future date.
         * 
         * How you choose to use this class is entirely up to you.
         */

        $this->_delete_old_tokens($data['user_id']);

        //generate 32 digit random string
        $random_string = $this->_generate_rand_str();

        //build data array variables (required for table insert)
        if (!isset($data['expiry_date'])) {
            $data['expiry_date'] = time() + $this->default_token_lifespan;
        }
        
        $data['token'] = $random_string;
        $this->model->insert($data, 'trongate_tokens');

        return $random_string;
    }

    function _generate_rand_str() {
        $token_length = 32;
        $characters = '-_0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';
        for ($i = 0; $i < $token_length; $i++) {
            $random_string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $random_string;
    }

    function regenerate() {
        $old_token = $this->url->segment(3);
        $expiry_date = $this->url->segment(4);

        if (!is_numeric($expiry_date)) {
            die();
        } elseif ($expiry_date<time()) {
            die();
        }

        $data['token'] = $old_token;
        $sql = 'select * from trongate_tokens where token = :token';
        $tokens = $this->model->query_bind($sql, $data, 'object');
        $num_rows = count($tokens);

        if ($num_rows>0) {
            $this_token = $tokens[0];
            $update_id = $this_token->id;
            $new_token = $this->_generate_rand_str();

            $new_data['user_id'] = $this_token->user_id;
            $new_data['code'] = $this_token->code;
            $new_data['expiry_date'] = $expiry_date;
            $new_data['token'] = $new_token;
            $this->model->update($update_id, $new_data, 'trongate_tokens');
            echo $new_token;
        } else {
            echo 'false';
        }

    }

    function _fetch_token_obj($token) {
        $data['token'] = $token;
        $sql = 'select * from trongate_tokens where token = :token';
        $token_objs = $this->model->query_bind($sql, $data, 'object');

        if ($token_objs == false) {
            return false; //token not found
        } else {
            $token_obj = $token_objs[0];
            return $token_obj;
        }

    }

    function _is_token_valid($token, $endpoint) {

        //returns true or false
        $this->_delete_old_tokens();

        $result = $this->model->get_one_where('token', $token, 'trongate_tokens');

        if ($result == false) {
            //invalid token
            return false;
        } else {
            $user_id = $result->user_id;
            $code = $result->code;

            if ($code == 'aaa') {
                return true;
            }

            echo "you should not be here"; die();

            //check to see if this user is allowed to access this endpoint
        }





        
        $data['token'] = $token;
        $sql = 'select * from trongate_tokens where token = :token';
        $tokens = $this->model->query_bind($sql, $data, 'object');
        $num_rows = count($tokens);

        if ($num_rows>0) {
            return true;
        } else {
            return false;
        }
    }

    function _delete_old_tokens($user_id=NULL) {

        $sql = 'delete from trongate_tokens where expiry_date < :nowtime';
        $data['nowtime'] = time();

        if (isset($user_id)) {
            $sql.= ' or user_id = :user_id';
            $data['user_id'] = $user_id;
        }
        
        $this->model->query_bind($sql, $data);
    }

    function _delete_one_token($token) {
        $sql = 'delete from trongate_tokens where token = ?';
        $data[] = $token;
        $this->model->query_bind($sql, $data);        
    }

}