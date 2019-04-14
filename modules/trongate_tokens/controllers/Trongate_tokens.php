<?php
class Trongate_tokens extends Trongate {

    /*
     * This class can assist you with things like securing API endpoints
     * and cookie based authentication.  The class is associated with a
     * database table called trongate_tokens. Therefore, a database connection 
     * is required for this class to work.
     *
     * The default expiry time for tokens is set to one day.  However, you can 
     * easily change that to suit your needs.
     */

    private $default_token_lifespan = 86400; //one day

    function _is_token_valid($token) {
        $data['token'] = $token;
        $num_rows = $this->model->count_where('token', $token);

        if ($num_rows>0) {
            return true;
        } else {
            return false;
        }
    }

    function _delete_old_tokens() {
        $nowtime = time();
        $sql = "delete from trongate_tokens where expiry_date<$nowtime";
        $this->model->query($sql);
    }

    function _get_user_id($token) {

        $this->_delete_old_tokens(); //housekeeping!

        $sql = "select user_id from trongate_tokens where token = ?";
        $data['token'] = $token;
        $user = $this->model->query_bind($sql, $data, 'object');

        if ($user == false) {
            return false;
        } else {
            $user_id = $user->user_id;
            return $user_id;
        }
    }

    function _generate_token($data=NULL) {

        /*
         * $data array can contain user_id and/or expiry_date.
         * Expiry_date should be a unix timestamp for some future date. 
         * Both $data fields are entirely optional.
         */

        //start by deleting old tokens for this user
        if (isset($data['user_id'])) {
            $this->_delete_my_tokens($user_id);
        } else {
            $this->_delete_old_tokens();
        }

        //now, generate a 64 digit random string
        $token_length = 64;

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';
        for ($i = 0; $i < $token_length; $i++) {
            $random_string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        //build data array variables (required for table insert)
        if (!isset($data['expiry_date'])) {
            $data['expiry_date'] = time() + $this->default_token_lifespan;
        }
        
        $data['token'] = $random_string;
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $this->model->insert($data, 'trongate_tokens');

        return $data['token'];
    }

    function _delete_my_tokens($user_id=NULL) {

        //If user ID has not been passed in then tokens will be deleted by IP address

        if (isset($user_id)) {
            $column = 'user_id';
            $data[] = $user_id;
        } else {
            $column = 'ip_address';
            $data[] = $_SERVER['REMOTE_ADDR'];
        }

        $sql = 'delete from tokens where '.$column.' = ?';
        $this->model->query_bind($sql, $data);

        $this->_delete_old_tokens(); //housekeeping!
    }

}