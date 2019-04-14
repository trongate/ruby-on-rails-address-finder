<?php
class Donors extends Trongate {
/*
    function test() {
        echo 'hello';
    }

    function _get_data_from_post() {
        $data['first_name'] = $this->input->post('first_name');
        $data['email'] = $this->input->post('email');
        $data['introduction'] = $this->input->post('introduction');
        $data['price'] = $this->input->post('price');
        $data['date_of_birth'] = $this->input->post('date_of_birth');
        $data['next_appointment'] = $this->input->post('next_appointment');
        $data['active'] = $this->input->post('active');
        return $data;
    }

    function _get_data_from_db($update_id) {
        $query = $this->get_where($update_id);
        foreach ($query->result() as $row) {
            $data['first_name'] = $row->first_name;
            $data['email'] = $row->email;
            $data['introduction'] = $row->introduction;
            $data['price'] = $row->price;
            $data['date_of_birth'] = $row->date_of_birth;
            $data['next_appointment'] = $row->next_appointment;
            $data['active'] = $row->active;
        }

        $this->load->module('timedate');
        $data['date_of_birth'] = $this->timedate->get_nice_date($data['date_of_birth'], 'datepicker');
        $data['next_appointment'] = $this->timedate->get_nice_date($data['next_appointment'], 'dateandtimepicker');
        return $data;
    }
*/

    function submit() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        $submit = $this->input('submit', true);

        if ($submit == 'Submit') {

            $this->validation_helper->set_rules('first_name', 'first name', 'required|min_length[4]');
            $this->validation_helper->set_rules('price', 'price', 'required|numeric|greater_than[0]');
            $this->validation_helper->set_rules('introduction', 'introduction', 'required');

            $result = $this->validation_helper->run();

            if ($result == true) {

                $update_id = $this->url->segment(3);
                $data = $this->_fetch_data_from_post();

                if (is_numeric($update_id)) {
                    //update an existing record
                    $this->model->update($update_id, $data, 'donors');
                    $flash_msg = 'The record was successfully updated';
                } else {
                    //insert the new record
                    $this->model->insert($data, 'donors');
                    $flash_msg = 'The record was successfully created';
                    $update_id = $this->model->get_max('donors');
                }
    
                set_flashdata($flash_msg);
                redirect('donors/edit/'.$update_id);

            } else {
                //form submission error
                $this->create();
            }

        }

    }

    function manage() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        //fetch the donors for this page
        $limit = $this->_get_limit();
        $offset = $this->_get_offset();
        $data['donors'] = $this->model->get('first_name', 'donors', $limit, $offset);
        $data['total_rows'] = count($data['donors']);
        $data['total_rows'] = 888;

        //format the pagination
        $data['include_showing_statement'] = true;    
        $data['record_name_plural'] = 'donors';  

        $data['headline'] = 'Manage Donors';
        $data['view_module'] = 'donors';
        $data['view_file'] = 'manage';
        $data['limit_pref'] = $_SESSION['limit_pref']; //the (max donors) 'per page' preference

        $this->template('admin', $data);
    }
/*


        $data['limit_pref'] = $_SESSION['limit_pref']; //the (max donors) 'per page' preference
        $data['this_module_root'] = $this->get_this_module_root();
        $data['flash'] = $this->flash_helper->_get_flashdata();

        $data['headline'] = 'Manage Donors';
        $data['view_file'] = 'manage';
        $this->load->module('templates');
        $this->templates->admin($data);



    }
*/
    function _fetch_data_from_db($update_id) {
        $donors = $this->model->get_where($update_id, 'donors');

        if ($donors == false) {
            $this->template('error_404');
            die();
        } else {
            $data['first_name'] = $donors->first_name;
            $data['email'] = $donors->email;
            $data['introduction'] = $donors->introduction;
            $data['price'] = $donors->price;
            $data['date_of_birth'] = $donors->date_of_birth;
            $data['next_appointment'] = $donors->next_appointment;
            $data['active'] = $donors->active;

            //format the unix timestamps
            $this->module('timedate');
            $data['date_of_birth'] = $this->timedate->get_nice_date($data['date_of_birth'], 'datepicker');
            //$data['next_appointment'] = $this->timedate->get_nice_date($data['next_appointment'], 'dateandtimepicker');
            $data['next_appointment'] = $this->timedate->get_nice_date($data['next_appointment'], 'datepicker');
            return $data;        
        }
    }

    function _fetch_data_from_post() {
        $data['first_name'] = $this->input('first_name', true);
        $data['email'] = $this->input('email', true);
        $data['introduction'] = $this->input('introduction', true);
        $data['price'] = $this->input('price', true);
        $data['date_of_birth'] = $this->input('date_of_birth', true);
        $data['next_appointment'] = $this->input('next_appointment', true);
        $data['active'] = $this->input('active', true);
        return $data;
    }

    function create() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        $update_id = $this->url->segment(3);
        $submit = $this->input('submit', true);

        if ((!is_numeric($update_id)) && ($update_id != '')) {
            redirect('donors/manage');
        }

        //fetch the form data
        if (($submit == '') && ($update_id>0)) {
            $data = $this->_fetch_data_from_db($update_id);
        } else {
            $data = $this->_fetch_data_from_post();
        }

        if ($update_id>0) {
            $data['cancel_url'] = BASE_URL.'donors/edit/'.$update_id;
        } else {
            $data['cancel_url'] = BASE_URL.'donors/manage';
        }

        $data['form_location'] = BASE_URL.'donors/submit/'.$update_id;
        $data['update_id'] = $update_id;
        $data['headline'] = $this->_get_page_headline($update_id, 'donor');
        $data['view_file'] = 'create';
        $this->template('admin', $data);
    }

    function _get_page_headline($update_id) {
        //figure out what the page headline should be (on the donors/create page)
        if (!is_numeric($update_id)) {
            $headline = 'Create Donor';
        } else {
            $headline = 'Update Donor';
        }

        return $headline;
    }

/*
    function _get_page_headline($update_id) {
        //figure out what the page headline should be (on the donors/create page)
        if (!is_numeric($update_id)) {
            $headline = 'Create Donor';
        } else {
            $headline = 'Update Donor';
        }

        return $headline;
    }
*/

    function edit() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        $update_id = $this->url->segment(3);
        
        if ((!is_numeric($update_id)) && ($update_id != '')) {
            redirect('donors/manage');
        }

        $data = $this->_fetch_data_from_db($update_id);
        $data['form_location'] = BASE_URL.'donors/submit/'.$update_id;
        $data['update_id'] = $update_id;
        $data['headline'] = 'Donor Information';
        $data['view_file'] = 'edit';
        $this->template('admin', $data);
    }




    function viewX() {
        $this->load->module('custom_pagination');
        $this->load->module('flash_helper');
        $this->load->module('site_security');
        $this->load->module('tokens');
        $this->site_security->_make_sure_is_admin();

        $token = $this->tokens->_generate_and_fetch();
        $update_id = $this->uri->segment(3);
        $this_module_root = $this->get_this_module_root();

        if ((!is_numeric($update_id)) && ($update_id != '')) {
            redirect('donors/manage');
        }

        $data = $this->_get_data_from_db($update_id);
        $data['form_location'] = $this_module_root.'submit/'.$update_id;
        $data['token'] = $token;
        $data['ng_app'] = 'app_donors';
        $data['update_id'] = $update_id;
        $data['this_module_root'] = $this_module_root;
        $data['flash'] = $this->flash_helper->_get_flashdata();

        $data['headline'] = 'Donor Information';
        $data['view_file'] = 'view';
        $this->load->module('templates');
        $this->templates->admin($data);
    }
/*
    function search_results() {
        $this->load->module('custom_pagination');
        $this->load->module('flash_helper');
        $this->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

        $code = $this->uri->segment(3);

        //count all records returned from the search query
        $use_limit = FALSE;
        $mysql_query = $this->_generate_search_query($code, $use_limit);
        $query = $this->_custom_query($mysql_query);
        $total_items = $query->num_rows();

        //fetch the records to be shown on this (search results) page
        $use_limit = TRUE;
        $mysql_query = $this->_generate_search_query($code, $use_limit);
        $data['query'] = $this->_custom_query($mysql_query);
        $data['num_rows'] = $data['query']->num_rows();

        //generate the pagination
        $pagination_data['template'] = 'admin';
        $pagination_data['target_base_url'] = $this->get_target_pagination_base_url().'/'.$code;
        $pagination_data['total_rows'] = $total_items;
        $pagination_data['offset_segment'] = 4;
        $pagination_data['limit'] = $this->get_limit();
        $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
        $pagination_data['offset'] = $this->get_offset();
        $data['showing_statement'] = $this->custom_pagination->get_showing_statement($pagination_data);

        $data['limit_pref'] = $_SESSION['limit_pref']; //the (max search results) 'per page' preference
        $data['this_module_root'] = $this->get_this_module_root();
        $data['flash'] = $this->flash_helper->_get_flashdata();

        $data['headline'] = 'Search Results';
        $data['view_file'] = 'manage';
        $this->load->module('templates');
        $this->templates->admin($data);
    }

    function no_results() {
        $this->load->module('custom_pagination');
        $this->load->module('flash_helper');
        $this->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

        if (isset($_SERVER['HTTP_REFERER'])) {
            $data['previous_url'] = $_SERVER['HTTP_REFERER'];
        }

        $data['headline'] = 'Search Results';
        $data['view_file'] = 'no_results';
        $this->load->module('templates');
        $this->templates->admin($data);
    }

    function submit_search() {
        $this->load->module('custom_pagination');
        $this->load->module('search_memory');
        $this->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

        $search_string = $this->input->post('search_string', TRUE);
        $mysql_query = "SELECT * from donors WHERE first_name LIKE '%$search_string%' OR email LIKE '%$search_string%' OR introduction LIKE '%$search_string%' OR price LIKE '%$search_string%' OR date_of_birth LIKE '%$search_string%' OR next_appointment LIKE '%$search_string%' OR active LIKE '%$search_string%'";
        $mysql_query = ltrim($mysql_query);
        $query = $this->_custom_query($mysql_query);
        $num_rows = $query->num_rows();

        if ($num_rows > 0) {

            //the search has yielded at least one result
            $data['code'] = $this->site_security->generate_random_string(6);
            $module_root = $this->get_this_module_root();
            $data['root_url'] = $module_root.'search_results';
            $data['sql_query'] = $mysql_query;
            $data['date_created'] = time();

            //store the search string in the db then send user to search results page
            $this->search_memory->_insert_and_go($data);

        } else {
            redirect('donors/no_results');
        }
    }

    function get($order_by) {
        $this->load->model('mdl_donors');
        $query = $this->mdl_donors->get($order_by);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        if ((!is_numeric($limit)) || (!is_numeric($offset))) {
            die('Non-numeric variable!');
        }

        $this->load->model('mdl_donors');
        $query = $this->mdl_donors->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function get_where($id) {
        if (!is_numeric($id)) {
            die('Non-numeric variable!');
        }

        $this->load->model('mdl_donors');
        $query = $this->mdl_donors->get_where($id);
        return $query;
    }

    function get_where_custom($col, $value) {
        $this->load->model('mdl_donors');
        $query = $this->mdl_donors->get_where_custom($col, $value);
        return $query;
    }

    function _insert($data) {
        $this->load->model('mdl_donors');
        $this->mdl_donors->_insert($data);
    }

    function _update($id, $data) {
        if (!is_numeric($id)) {
            die('Non-numeric variable!');
        }

        $this->load->model('mdl_donors');
        $this->mdl_donors->_update($id, $data);
    }

    function _delete($id) {
        if (!is_numeric($id)) {
            die('Non-numeric variable!');
        }

        $this->load->model('mdl_donors');
        $this->mdl_donors->_delete($id);
    }

    function count_where($column, $value) {
        $this->load->model('mdl_donors');
        $count = $this->mdl_donors->count_where($column, $value);
        return $count;
    }

    function get_max() {
        $this->load->model('mdl_donors');
        $max_id = $this->mdl_donors->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $this->load->model('mdl_donors');
        $query = $this->mdl_donors->_custom_query($mysql_query);
        return $query;
    }

    function get_target_pagination_base_url() {
        $first_bit = $this->uri->segment(1);
        $second_bit = $this->uri->segment(2);
        $third_bit = $this->uri->segment(3);
        $target_base_url = base_url().$first_bit."/".$second_bit;
        return $target_base_url;
    }

    function _generate_query($use_limit) {

        //NOTE: use_limit can be TRUE or FALSE
        $mysql_query = "SELECT * from donors order by first_name";
        if ($use_limit == TRUE) {
            $limit = $this->get_limit();
            $offset = $this->get_offset();
            $mysql_query.= " limit ".$offset.", ".$limit;
        }

        return $mysql_query;
    }

    function _generate_search_query($code, $use_limit) {

        //NOTE: use_limit can be TRUE or FALSE
        $this->load->module('search_memory');
        $query = $this->search_memory->get_where_custom('code', $code);
        foreach ($query->result() as $row) {
            $mysql_query = $row->sql_query;
        }

        if ($use_limit == TRUE) {
            $limit = $this->get_limit();
            $offset = $this->uri->segment(4);

            if (!isset($offset)) {
                $offset = 0;
            }

            $mysql_query.= " limit ".$offset.", ".$limit;
        }

        return $mysql_query;
    }
*/

    function _get_limit() {
        if (isset($_SESSION['limit_pref'])) {
            $limit = $_SESSION['limit_pref'];
        } else {
            $limit = 20;
            $_SESSION['limit_pref'] = $limit;
        }

        return $limit;
    }

    function _get_offset() {
        $offset = $this->url->segment(3);
        if (!is_numeric($offset)) {
            $offset = 0;
        }

        return $offset;
    }
/*
    function get_this_module_root() {
        $this_module = $this->uri->segment(1);
        $this_module_root = base_url().$this_module.'/';
        return $this_module_root;
    }
*/



}