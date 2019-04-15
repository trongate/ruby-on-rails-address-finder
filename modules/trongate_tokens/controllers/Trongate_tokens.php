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

    function _generate_token($data=NULL) {

        /*
         * $data array may contain:
         *                         expiry_date ~ int(10) : optional
         *                         information ~ text : optional
         *                        
         *
         * 'expiry_date' (if submitted) should be a unix timestamp, set to some future date.
         * 
         * 'information' can contain anything you like pertaining to how particular tokens may be used.
         * For example, 'information' could contain a comma separated list of tables for which write access * is permitted.  Another possible example would be to store a JSON string containing user_ids 
         * and other information that could potentially be useful.
         *
         * How you choose to use this class is entirely up to you.
         */

        $this->_delete_old_tokens();

        //generate 64 digit random string
        $token_length = 64;

        $characters = '!@%&,*()[]{}.0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';
        for ($i = 0; $i < $token_length; $i++) {
            $random_string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        //build data array variables (required for table insert)
        if (!isset($data['expiry_date'])) {
            $data['expiry_date'] = time() + $this->default_token_lifespan;
        }
        
        $data['token'] = $random_string;
        $this->model->insert($data, 'trongate_tokens');
        return $data['token'];
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

    function _is_token_valid($token) {
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

    function _delete_old_tokens() {
        $nowtime = time();
        $sql = "delete from trongate_tokens where expiry_date<$nowtime";
        $this->model->query($sql);
    }

    function _delete_one_token($token) {
        $sql = 'delete from trongate_tokens where token = ?';
        $data[] = $token;
        $this->model->query_bind($sql, $data);        
    }

}