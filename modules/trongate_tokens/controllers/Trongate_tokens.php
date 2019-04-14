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

    function _generate_token($data=NULL) {

        /*
         * $data array may contain:
         *                         user_id ~ int : optional
         *                         expiry_date ~ int(10) : optional
         *                         existing_token ~ varchar(64) : optional
         *                         delete_user_tokens ~ boolean : optional
         * 
         * If $data['existing_token'] has been set then *that* token will be deleted.
         * If $data['delete_user_tokens'] has been set then class will attempt to delete all tokens
         * for that user.  In that scenario, if no user_id has been passed then ip_address will be used.
         *
         * Expiry_date should be a unix timestamp, set to some future date. 
         */

        if (isset($data['existing_token'])) {
            //delete one token
            $this->_delete_one_token($data['existing_token']);
        }

        if (isset($delete_user_tokens)) {

            //attempt delete all tokens for this user
            if (isset($data['user_id'])) {
                $this->_delete_my_tokens($user_id);
            } else {
                $this->_delete_old_tokens(); //delete tokens set from this IP address
            }

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

    function _delete_one_token($token) {
        $sql = 'delete from tokens where token = ?';
        $data[] = $token;
        $this->model->query_bind($sql, $data);        
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