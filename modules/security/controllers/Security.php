<?php
class Security extends Trongate {

    function _make_sure_allowed() {
        return true;
    }

    function _get_user_id() {
        $user_id = 88;
        return $user_id;
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