<?php
class Api extends Trongate {

    function __construct() {
        parent::__construct();
        $this->parent_module = 'comments';
        $this->child_module = 'api';
    }

    function submit() {

        $post = file_get_contents('php://input');
        $decoded = json_decode($post, true);

        $token = $decoded['token'];
        $comment = $decoded['comment'];
  
        $this->module('trongate_tokens');
        $token_obj = $this->trongate_tokens->_fetch_token_obj($token);

        if ($token_obj == false) {
            die(); //invalid token
        } else {

            $information = json_decode($token_obj->information);

            if (isset($information->tables)) {
                $tables = get_object_vars($information->tables);

                if (isset($tables['comments'])) {
                    $table_permissions = $tables['comments'];

                    if (($table_permissions == '*') || ($table_permissions == 'w')) {
                        //we have permission to insert this comment - let's do it!
                        $this->_insert_comment($comment);
                    }
                }

            }

        }

    }

    function _insert_comment($comment) {
        $data['comment'] = $comment;
        $data['date_created'] = time();
        $this->model->insert($data, 'comments');
        echo 'Finished.';
    }

    function get() {
        $post = file_get_contents('php://input');
        $decoded = json_decode($post, true);

        $token = $decoded['token'];
        
        $this->module('trongate_tokens');
        $token_obj = $this->trongate_tokens->_fetch_token_obj($token);

        if ($token_obj == false) {
            die(); //invalid token
        } else {

            $information = json_decode($token_obj->information);

            if (isset($information->tables)) {
                $tables = get_object_vars($information->tables);

                if (isset($tables['comments'])) {
                    $table_permissions = $tables['comments'];

                    $comments = $this->model->get('date_created', 'comments');

                    foreach ($comments as $comment) {
                        $row_data['comment'] = $comment->comment;
                        $row_data['date_created'] = date('l jS \of F Y \a\t h:i:s A', $comment->date_created);
                        $data[] = $row_data;
                    }

                    echo json_encode($data);
                }

            }

        }        
    }

    function __destruct() {
        $this->parent_module = '';
        $this->child_module = '';
    }

}