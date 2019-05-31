<?php
class Items extends Trongate {

    function test() {
        $data['name'] = 'David';
        $var = $this->view('some_view', $data, true);
        echo "it is $var";
    }

}