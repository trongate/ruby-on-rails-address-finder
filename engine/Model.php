<?php
class Model {

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;
    private $debug = true;
    private $query_caveat = 'The query shown above is how the query would look <i>before</i> binding.';

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error; die();
        }
    }

    private function get_param_type($value) {
        switch(true){
            case is_int($value):
            $type = PDO::PARAM_INT;
            break;
        case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
        case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
        default:
            $type = PDO::PARAM_STR;
        }

        return $type;       
    }

    private function get_table_from_url() {
        $segments = SEGMENTS;

        if (isset($segments[1])) {
            $target_tbl = $segments[1];
        } else {
            $target_tbl = '';
        }

        $target_tbl = $this->correct_tablename($target_tbl);

        return $target_tbl;
    }

    private function correct_tablename($target_tbl) {
        $bits = explode('-', $target_tbl);
        $num_bits = count($bits);
        if ($num_bits>1) {
            $target_tbl = $bits[$num_bits-1];
        }

        return $target_tbl;
    }

    private function add_limit_offset($sql, $limit, $offset) {
        if ((is_numeric($limit)) && (is_numeric($offset))) {
            $limit_results = true;
            $sql.= " LIMIT $offset, $limit";
        }

        return $sql;
    }

    private function prepare_and_execute($sql, $params=NULL) {

        if ((isset($params['limit'])) && (isset($params['offset']))) {
            $sql = $this->add_limit_offset($sql, $params['limit'], $params['offset']);;
        }

        // foreach ($params as $key => $value) {
        //     echo "key of $key is <br>";
        // }
        // die();

        if ($this->debug == true) {

            if ((isset($operator)) && (isset($value))) {
                $operator = strtoupper($operator);
                if (($operator == 'LIKE') || ($operator == 'NOT LIKE')) {
                    $value = '%'.$value.'%';
                    $params['value'] = $value;
                }
            }

            $query_to_execute = $this->show_query($sql, $params, $this->query_caveat);
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    
    public function get($order_by=NULL, $target_tbl=NULL, $limit=NULL, $offset=NULL) {

        $params = [];

        if (!isset($order_by)) {
            $order_by = 'id';
        }

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT * FROM $target_tbl order by $order_by";

        if ((isset($limit)) && (isset($offset))) {
            $sql = $this->add_limit_offset($sql, $limit, $offset);
            $params['limit'] = $limit;
            $params['offset'] = $offset;
        }

        $data['params'] = $params;
        $stmt = $this->prepare_and_execute($sql, $data);
        $query = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $query;
    }

    public function get_where_custom($column, $value, $operator='=', $order_by='id', $target_tbl=NULL, $limit=NULL, $offset=NULL) {

        //$items = $this->model->get_where_custom('id', 1, '!=');

        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT * FROM $target_tbl where $column $operator :value order by $order_by";

        if ((isset($limit)) && (isset($offset))) {
            $params['limit'] = $limit;
            $params['offset'] = $offset;
            $sql = $this->add_limit_offset($sql, $params['limit'], $params['offset']);
        }

        $params[$column] = $value;
        //$data['params'] = $params;


        $stmt = $this->prepare_and_execute($sql, $params);

        $query = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $query;
    }

    //fetch a single record
    public function get_where($id, $target_tbl=NULL) {
        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT * FROM $target_tbl where id = :id";

        $params['id'] = $id;
        $data['params'] = $params;

        $stmt = $this->prepare_and_execute($sql, $data);

        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($rows != false) {
            $row = $rows[0];
        } else {
            $row = false;
        }

        return $row;
    }

    //fetch a single record (alternative version)
    public function get_one_where($column, $value, $target_tbl=NULL) {
        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT * FROM $target_tbl where $column = :value";

        $params[$column] = $value;
        $data['params'] = $params;

        $stmt = $this->prepare_and_execute($sql, $data);
        $query = $stmt->fetch(PDO::FETCH_OBJ);
        return $query;
    }

    public function count_where($column, $value, $operator=NULL, $order_by=NULL, $target_tbl=NULL, $limit=NULL, $offset=NULL) {
        $query = $this->get_where_custom($column, $value, $operator, $order_by, $target_tbl, $limit, $offset);
        $num_rows = count($query);
        return $num_rows;
    }

    public function count($target_tbl=NULL) {
        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT COUNT(id) as total FROM $target_tbl";
        $stmt = $this->prepare_and_execute($sql);

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result->total;
    }

    public function get_max($target_tbl=NULL) {
        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "SELECT MAX(id) AS max_id FROM $target_tbl";
        $stmt = $this->prepare_and_execute($sql);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $max_id = $result['max_id'];
        return $max_id;
    }

    public function show_query($raw_sql, $parameters) {

        $keys = array();
        $values = array();
        /*
         * Get longest keys first, sot the regex replacement doesn't
         * cut markers (ex : replace ":username" with "'joe'name"
         * if we have a param name :user )
         */
        $isNamedMarkers = false;
        if (count($parameters) && is_string(key($parameters))) {
            uksort($parameters, function($k1, $k2) {
                return strlen($k2) - strlen($k1);
            });
            $isNamedMarkers = true;
        }
        foreach ($parameters as $key => $value) {
            // check if named parameters (':param') or anonymous parameters ('?') are used
            if (is_string($key)) {
                $keys[] = '/:'.ltrim($key, ':').'/';
            } else {
                $keys[] = '/[?]/';
            }
            // bring parameter into human-readable format
            if (is_string($value)) {
                $values[] = "'" . addslashes($value) . "'";
            } elseif(is_int($value)) {
                $values[] = strval($value);
            } elseif (is_float($value)) {
                $values[] = strval($value);
            } elseif (is_array($value)) {
                $values[] = implode(',', $value);
            } elseif (is_null($value)) {
                $values[] = 'NULL';
            }
        }
        if ($isNamedMarkers) {
            return preg_replace($keys, $values, $raw_sql);
        } else {
            return preg_replace($keys, $values, $raw_sql, 1, $count);
        }
    }

    public function show_queryOLD($query, $params, $caveat=NULL) {

        $named_params = true;

        foreach ($params as $key => $value) {

            if (is_string($key)) {
                $keys[] = '/:'.$key.'/';
            } else {
                $keys[] = '/[?]/';
                $named_params = false;
            }

            if (is_string($value))
                $values[$key] = "'" . $value . "'";

            if (is_array($value))
                $values[$key] = "'" . implode("','", $value) . "'";

            if (is_null($value))
                $values[$key] = 'NULL';
        }

        if ($named_params == true) {
            $query = preg_replace($keys, $values, $query);
        } else {

            $query = $query.' ';
            $bits = explode(' ? ', $query);

            $query = '';
            for ($i=0; $i < count($bits); $i++) { 
                $query.= $bits[$i];

                if (isset($values[$i])) {
                    $query.= ' '.$values[$i].' ';
                }

            }

        }

        if (!isset($caveat)) {
            $caveat_info = '';
        } else {

            $caveat_info = '<br><hr><div style="font-size: 0.8em;"><b>PLEASE NOTE:</b> '.$caveat;
            $caveat_info.= ' PDO currently has no means of displaying previous query executed.</div>';
        }

        echo '<div class="tg-rprt"><b>QUERY TO BE EXECUTED:</b><br><br>  -> ';
        echo $query.$caveat_info.'</div>';
        ?>

<style>
.tg-rprt {
color: #383623;
background-color: #efe79e;
font-family: "Lucida Console", Monaco, monospace;
padding: 1em;
border: 1px #383623 solid;
clear: both !important;
margin: 1em 0;
}    
</style>

    <?php
    }

    public function insert($data, $target_tbl=NULL) {
        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = 'INSERT INTO '.$target_tbl.' (';
        $sql.= implode(", ", array_keys($data)).')';
        $sql.= ' VALUES (';

        foreach ($data as $key => $value) {
            $sql.=':'.$key.', ';
            $params[$key] = $value;
        }

        $sql = rtrim($sql, ', ');
        $sql.=')';


        $data['params'] = $params;
        $stmt = $this->prepare_and_execute($sql, $data);
    }

    public function update($update_id, $data, $target_tbl=NULL) {
        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $sql = "UPDATE `$target_tbl` SET ";

        foreach ($data as $key => $value) {
            $sql.= "`$key` = :$key, ";
            $params[$key] = $value;
        }

        $params['id'] = $update_id;

        $sql = rtrim($sql, ', ');
        $sql.= " WHERE `$target_tbl`.`id` = :id";

        $data['params'] = $params;
        $stmt = $this->prepare_and_execute($sql, $data);
    }

    public function delete($id, $target_tbl=NULL) {
        if (!isset($target_tbl)) {
            $target_tbl = $this->get_table_from_url();
        }

        $params['id'] = $id;
        $data['params'] = $params;
        $sql = "DELETE from `$target_tbl` WHERE id = :id ";

        $stmt = $this->prepare_and_execute($sql, $data);
    }

    public function query($sql, $return_type=false) {

        //WARNING: very high risk of SQL injection - use with caution!

        $stmt = $this->prepare_and_execute($sql);

        if ($return_type == 'object') {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } elseif ($return_type == 'array') {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }

    public function query_bind($sql, $params, $return_type=false) {

        $stmt = $this->prepare_and_execute($sql, $params);

        if ($return_type == 'object') {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } elseif ($return_type == 'array') {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }

    public function insert_batch($table, array $records) {

        //WARNING:  Never let your website visitors invoke this method!
        $fields = array_keys($records[0]);
        $placeHolders = substr(str_repeat(',?', count($fields)), 1);
        $values = [];
        foreach ($records as $record) {
            array_push($values, ...array_values($record));
        }

        $sql = 'INSERT INTO ' . $table . ' (';
        $sql .= implode(',', $fields);
        $sql .= ') VALUES (';
        $sql .= implode('),(', array_fill(0, count($records), $placeHolders));
        $sql .= ')';

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($values);

    }

    public function exec($sql) {
        if (ENV == 'dev') {
            //this gets used on auto module table setups
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();
        } else {
            echo 'Feature disabled, since not on \'dev\' mode.';
        }
    }

}