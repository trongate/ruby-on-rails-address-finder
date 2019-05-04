<?php
class Templates extends Trongate {

    function error_404($data) {
        load('error_404', $data);
    }

}