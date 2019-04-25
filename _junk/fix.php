        //variables have been posted - start from here
        $got_where = false;
        foreach ($params as $key => $value) {
            $param_type = $this->_get_param_type($module_name, $key);

            if ($param_type == 'where') {
                $where_conditions[$key] = $value;
            }
        }

        //add where conditions
        if (isset($where_conditions)) {
            $where_condition_count = 0;
            foreach ($where_conditions as $where_left_side => $where_value) {
                $where_condition_count++;
                //where_key    where_value
                //manipulate the SQL query

                $where_key = $this->_extract_where_key($where_left_side);
                $where_start_word = $this->_extract_where_start_word($where_left_side, $where_condition_count);
                $connective = $this->_extract_connective($where_left_side);

                $new_where_condition = $where_start_word.' '.$where_key.' '.$connective.' :'.$where_key;
                $sql = $sql.' '.$new_where_condition;
                $data[$where_key] = $where_value;

            }

        }



        //add order by
        if (isset($params['orderBy'])) {
            $data['order_by'] = $params['orderBy'];
            $sql = $sql.' order by :order_by';
        }

        //add limit offset
        if (isset($params['limit'])) {

            $limit = $params['limit'];

            //get the offset
            if (isset($params['offset'])) {
                $offset = $params['offset'];
            } else {
                $offset = 0;
            }

            if ((!is_numeric($limit)) || (!is_numeric($offset))) {
                echo "non numeric limit and/or offset"; die();
            }

            $data['limit'] = $limit;
            $data['offset'] = $offset;
            $sql = $sql.= ' limit :offset, :limit';

        }