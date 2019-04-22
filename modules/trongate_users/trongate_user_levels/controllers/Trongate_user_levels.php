<?php
class Trongate_user_levels {

    function __construct() {
        $this->parent_module = 'trongate_users';
        $this->child_module = 'trongate_user_levels';
    }

    function __destruct() {
        $this->parent_module = '';
        $this->child_module = '';        
    }

}