<?php
class Store_items extends Trongate {

    function hello() {
        echo "hello you<br>";
        echo anchor('store_items/display', 'Click Here');
    }

    function goodbye() {
        echo "goodbye";
    }

    function display() {
        echo "dislaying items";
    }

}