<?php
class Donors extends MX_Controller {

    function __construct() {
        parent::__construct();
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

    function submit() {
        $this->load->module('custom_pagination');
        $this->load->module('flash_helper');
        $this->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

        $update_id = $this->uri->segment(3);
        $data = $this->_get_data_from_post();
        $submit = $this->input->post('submit', TRUE);
        $module_root = $this->get_this_module_root();

        if ($submit == 'Delete') {
            $this->_delete($update_id);
            $flash_title = 'Record Deleted';
            $flash_msg = 'The donor was successfully deleted.';
            $flash_theme = 'success';
            $this->flash_helper->_set_flashdata($flash_title, $flash_msg, $flash_theme);
            $target_url = $module_root.'manage';
            redirect($target_url);
        }

        //process the form
        $this->load->library('form_validation');
        $this->form_validation->CI = & $this;
        $this->form_validation->set_rules('first_name', 'first name', 'required|min_length[3]|max_length[65]');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        $this->form_validation->set_rules('introduction', 'introduction', 'required');
        $this->form_validation->set_rules('price', 'price', 'numeric|required|min_length[0]');
        $this->form_validation->set_rules('date_of_birth', 'date of birth', 'callback_in_the_past');
        $this->form_validation->set_rules('next_appointment', 'next appointment', 'required');

        if ($submit == 'Submit') {

            //fetch the posted variables
            $data = $this->_get_data_from_post();

            $this->load->module('timedate');
            $data['date_of_birth'] = $this->timedate->make_timestamp_from_datepicker($data['date_of_birth']);
            $data['next_appointment'] = $this->timedate->make_timestamp_from_dateandtimepicker($data['next_appointment']);

            $url_string = $this->input->post('first_name');
            $url_string = url_title($url_string);
            $data['url_string'] = $url_string;

            if (is_numeric($update_id)) {

                //update the record details
                $this->_update($update_id, $data);
                $flash_title = 'Record Updated';
                $flash_msg = 'The donor was successfully updated.';
                $flash_theme = 'success';
                $this->flash_helper->_set_flashdata($flash_title, $flash_msg, $flash_theme);
                redirect($module_root.'view/'.$update_id);

            } else {

                //insert a new record
                $this->_insert($data);

                //get the ID of the new item
                $update_id = $this->get_max();
                $flash_title = 'Record Created';
                $flash_msg = 'The donor was successfully added.';
                $flash_theme = 'success';
                $this->flash_helper->_set_flashdata($flash_title, $flash_msg, $flash_theme);
                redirect($module_root.'view/'.$update_id);

            }

        } else {
            $this->create();
        }
    }

    function manage() {
        $this->load->module('custom_pagination');
        $this->load->module('flash_helper');
        $this->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

        //count all of the records on the donors table
        $use_limit = FALSE;
        $mysql_query = $this->_generate_query($use_limit);
        $query = $this->_custom_query($mysql_query);
        $total_items = $query->num_rows();

        //fetch the records to be displayed on this page
        $use_limit = TRUE;
        $mysql_query = $this->_generate_query($use_limit);
        $data['query'] = $this->_custom_query($mysql_query);
        $data['num_rows'] = $data['query']->num_rows();

        //generate pagination for the donors/manage page
        $pagination_data['template'] = 'admin';
        $pagination_data['target_base_url'] = $this->get_target_pagination_base_url();
        $pagination_data['total_rows'] = $total_items;
        $pagination_data['offset_segment'] = 3;
        $pagination_data['limit'] = $this->get_limit();
        $data['pagination'] = $this->custom_pagination->_generate_pagination($pagination_data);
        $pagination_data['offset'] = $this->get_offset();
        $data['showing_statement'] = $this->custom_pagination->get_showing_statement($pagination_data);

        $data['limit_pref'] = $_SESSION['limit_pref']; //the (max donors) 'per page' preference
        $data['this_module_root'] = $this->get_this_module_root();
        $data['flash'] = $this->flash_helper->_get_flashdata();

        $data['headline'] = 'Manage Donors';
        $data['view_file'] = 'manage';
        $this->load->module('templates');
        $this->templates->admin($data);
    }

    function create() {
        $this->load->module('custom_pagination');
        $this->load->module('flash_helper');
        $this->load->module('site_security');
        $this->site_security->_make_sure_is_admin();

        $update_id = $this->uri->segment(3);
        $submit = $this->input->post('submit', TRUE);

        if ((!is_numeric($update_id)) && ($update_id != '')) {
            die();
        }

        $this_module_root = $this->get_this_module_root();

        //fetch the form data
        if (($submit == '') && ($update_id>0)) {
            $data = $this->_get_data_from_db($update_id);
        } else {
            $data = $this->_get_data_from_post();
        }

        if ($update_id>0) {
            $data['cancel_url'] = $cancel_url = $this_module_root.'view/'.$update_id;
        } else {
            $data['cancel_url'] = $this_module_root.'manage';
        }

        $data['form_location'] = $this_module_root.'submit/'.$update_id;
        $data['update_id'] = $update_id;
        $data['this_module_root'] = $this_module_root;
        $data['flash'] = $this->flash_helper->_get_flashdata();

        $data['headline'] = $this->_get_page_headline($update_id, 'donor');
        $data['view_file'] = 'create';
        $this->load->module('templates');
        $this->templates->admin($data);
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

    function view() {
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

    function get_limit() {
        if (isset($_SESSION['limit_pref'])) {
            $limit = $_SESSION['limit_pref'];
        } else {
            $limit = 20;
            $_SESSION['limit_pref'] = $limit;
        }

        return $limit;
    }

    function get_offset() {
        $offset = $this->uri->segment(3);
        if (!is_numeric($offset)) {
            $offset = 0;
        }

        return $offset;
    }

    function get_this_module_root() {
        $this_module = $this->uri->segment(1);
        $this_module_root = base_url().$this_module.'/';
        return $this_module_root;
    }

}