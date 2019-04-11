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
        //$items = $this->model->get_where_custom('item_title', 'Fisdfsdrst one usdfdpdated', '=');
        //$item = $this->model->get_where(3);
        // echo $item->item_title; die();
        //$item = $this->model->get_one_where('item_title', 'First one updated');
        //$items = $this->model->count_where('item_title', 'Fender Stratocaster', '!=');
        //$count = $this->model->count('store_items');
        //echo $count; die();
        // $max_id = $this->model->get_max('store_items');
        // echo $max_id; die();
        // $data['item_title'] = 'Some new title (I think this is the third one)';
        // $this->model->insert($data);
        //echo 'inserted'; die();
        // $data['item_title'] = 'Item updated dc';
        // $update_id = 3;
        // $this->model->update($update_id, $data);
        // //echo 'yes'; die();
        // $this->model->delete(8);
        // echo "you bet"; die();
        // //tesing query
        // $sql = "select * from store_items";
        // $items = $this->model->query($sql);
        // var_dump($items); die();


        $sql = "select * from store_items where id = :id and item_title NOT LIKE :item_title";
        $data['id'] = 4;
        $data['item_title'] = '%updated%';
        $items = $this->model->query_bind($sql, $data, 'object');
        var_dump($items); die();

//query_bind($sql, $data, $return_type=false)






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