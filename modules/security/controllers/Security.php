<?php
class Security extends Trongate {

    function _make_sure_allowed() {
        return true;
    }

    function _get_user_id() {
        $user_id = 1; //replace this with your own authentication code
        return $user_id;
    }

    function _get_user_level($return_type=NULL) {
        //possible return types are NULL (returns object), 'id' or 'level_title'
        $data['user_id'] = $this->_get_user_id();
        $sql = 'SELECT trongate_user_levels.*
                    FROM
                        trongate_users
                    INNER JOIN trongate_user_levels ON trongate_users.user_level_id = trongate_user_levels.id 
                    WHERE trongate_users.id = :user_id';

        $rows = $this->model->query_bind($sql, $data, 'object');
        $user_level = $rows[0];
        
        if ($return_type == 'id') {
            $user_level = $user_level->id;
        } elseif ($return_type == 'level_title') {
            $user_level = $user_level->level_title;
        }

        return $user_level;
    }

    function _generate_random_string($length) {
        $characters = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}