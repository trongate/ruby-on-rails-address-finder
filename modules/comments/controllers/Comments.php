<?php
class Comments extends Trongate {

    function index() {
        echo 'ok';
    }

    function _display_comments() {
        $data['comments'] = $this->model->get('date_created', 'comments');
        $this->view('comments', $data);
    }

}