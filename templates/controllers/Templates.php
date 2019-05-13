<?php
class Templates extends Trongate {

    function admin($data) {
        load('admin', $data);
    }

    function error_404($data) {
        load('error_404', $data);
    }

}