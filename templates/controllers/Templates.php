<?php
class Templates extends Trongate {

    function public($data) {
        load('public', $data);
    }

    function error_404($data) {
        load('error_404', $data);
    }

}