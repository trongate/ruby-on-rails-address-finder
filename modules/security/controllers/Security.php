<?php
class Security extends Trongate {

    function _make_sure_allowed() {
        return true;
    }

    function _get_user_id() {
        $user_id = 88;
        return $user_id;
    }

}