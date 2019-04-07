<?php
class Store_items extends Trongate {

    function hello() {
        echo "hello you<br>";

        $link = anchor('store_items/goodbye', true);

        echo $link;

        echo "<hr>";
        echo anchor('store_items/display', 'Click Here');


        echo "<hr>";
        echo anchor('store_items/display', 'Click Here');
    }

    function goodbye() {
        echo "goodbye";
    }

    function display() {
        $data['view_module'] = 'store_items';
        $data['view_file'] = 'display';
        $data['include_css'] = true;
        $data['include_showing_statement'] = true;
        $data['total_rows'] = 888;
        // $this->view('display', $data);

        $this->template('public', $data);
    }

}