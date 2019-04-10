<?php
class Store_items extends Trongate {

    function hello() {
        echo "hello you<br>";

        //$link = anchor('store_items/goodbye', true);

        $link = anchor('store_items/display', true);

        echo "the link is :".$link;


        // echo $link;

        // echo "<hr>";
        // echo anchor('store_items/display', 'Click Here');


        // echo "<hr>";
        // echo anchor('store_items/display', 'Click Here');
    }

    function goodbye() {
        $items = $this->model->get('id');
        echo '<hr>';
        var_dump($items);
    }

    function display() {

        //$items = $this->model->get('id desc');
        $items = $this->model->get_where_custom('item_title', 'First Item', '=');
        // $item = $this->model->get_where(2);
        // $item = $this->model->get_one_where('id', 1);
        // $items = $this->model->count_where('item_title', 'Fender Stratocaster', '!=');
        //$count = $this->model->count('store_items');
        //$max_id = $this->model->get_max('store_items');
        // $data['item_title'] = 'Some new title (I think this is the third one)';
        // $this->model->insert($data);
        //echo 'inserted'; die();
        // $data['item_title'] = 'Item updated';
        // $update_id = 3;
        // $this->model->update($update_id, $data);
        //$this->model->delete(2);



//          $sql = "select * from store_items where id = ?";
//          $data['id'] = 3;
//          $items = $this->model->query_bind($sql, $data, 'array');
// var_dump($items);



//         foreach ($items as $key => $value) {
//             echo "key of $value->id<br>";
//             echo "key of $value->item_title x<br><hr>";
//         }



// echo 'fin';
























      
        // echo $item->item_title;
        // echo $item->item_id;
        // die();


        // foreach ($items as $key => $value) {
        //     echo "key of $value->id<br>";
        //     echo "key of $value->item_title<br><hr>";
        // }





        //$this->model->delete(6);

        // $sql = "select * from store_items where id>1";
        // $items = $this->model->query($sql, 'array');
        // foreach ($items as $item) {
        //     echo 'ID is '.$item['id'].'<br>';
        //     echo 'Title is '.$item['item_title'].'<br><hr>';
        // }

        // $sql = "update store_items set item_title = 'bla' where id>10";
        // $items = $this->model->query($sql);


        // $data['id'] = 3;
        // $sql = "select * from store_items where id = ?";

        // $items = $this->model->query_bind($sql, $data, 'array');

        // foreach ($items as $item) {
        //     echo 'ID is '.$item['id'].'<br>';
        //     echo 'Title is '.$item['item_title'].'<br><hr>';
        // }

die();
//query_bind($sql, $data, $return_type=false)



        die();



        $update_id = 6;
        
        echo "deleted";

die();


        // echo $max_id; die();


        // echo $count; die();






        echo $items; die();

        foreach($items as $item) {
            echo $item->id.' : ';
            echo $item->item_title.'<br>';
        }
        die();

        $data['view_module'] = 'store_items';
        $data['view_file'] = 'display';
        $data['include_css'] = true;
        $data['include_showing_statement'] = true;
        $data['total_rows'] = 888;
        // $this->view('display', $data);

        $this->template('public', $data);
    }

}