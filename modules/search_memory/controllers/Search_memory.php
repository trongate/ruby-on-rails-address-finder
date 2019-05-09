<?php
class Search_memory extends Trongate {

    function _insert_and_go($data) {
        $nowtime = time();
        $one_day = 86400;
        $back_time = $nowtime-$one_day;
        $sql = 'delete from search_memory where date_created<'.$back_time;
        $this->model->query($sql);

        $this->model->insert($data, 'search_memory');

        $code = $data['code'];
        $root_url = $data['root_url'];
        $target_url = $root_url.'/'.$code;
        redirect($target_url);    
    }

}