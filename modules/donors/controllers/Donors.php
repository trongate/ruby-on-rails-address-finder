<?php
class Donors extends Trongate {

    private $module = 'donors';

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
                    $update_id = $this->model->insert($data, 'donors');
                    $flash_msg = 'The record was successfully created';
                }
    
                set_flashdata($flash_msg);
                redirect('donors/edit/'.$update_id);

            } else {
                //form submission error
                $this->create();
            }

        }

    }

    function submit_delete() {
        $this->module('security');
        $this->security->_make_sure_allowed();

        $submit = $this->input('submit', true);

        if ($submit == 'Submit') {
            $update_id = $this->url->segment(3);

            if (!is_numeric($update_id)) {
                die();
            } else {
                $data['update_id'] = $update_id;

                //delete all of the comments associated with this record
                $sql = 'delete from comments where target_table = :module and update_id = :update_id';
                $data['module'] = $this->module;
                $this->model->query_bind($sql, $data);

                //delete the record
                $this->model->delete($update_id, $this->module);

                //set the flashdata
                $flash_msg = 'The record was successfully created';
                set_flashdata($flash_msg);

                //redirect to the manage page
                redirect('donors/manage');
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

        $data['headline'] = $this->_get_page_headline($update_id, 'donor');

        if ($update_id>0) {
            $data['cancel_url'] = BASE_URL.'donors/edit/'.$update_id;
            $data['btn_text'] = 'UPDATE DONOR DETAILS';
        } else {
            $data['cancel_url'] = BASE_URL.'donors/manage';
            $data['btn_text'] = 'CREATE DONOR RECORD';
        }

        $data['form_location'] = BASE_URL.'donors/submit/'.$update_id;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'create';
        $this->template('admin', $data);
    }

    function _get_page_headline($update_id) {
        //figure out what the page headline should be (on the donors/create page)
        if (!is_numeric($update_id)) {
            $headline = 'Create New Donor Record';
        } else {
            $headline = 'Update Donor Details';
        }

        return $headline;
    }

    function edit() {
        $this->module('security');
        $this->module('trongate_tokens');
        $this->security->_make_sure_allowed();

        $update_id = $this->url->segment(3);
    
        if ((!is_numeric($update_id)) && ($update_id != '')) {
            redirect('donors/manage');
        }

        $data = $this->_fetch_data_from_db($update_id);
        $token_data['user_id'] = $this->security->_get_user_id();
        $data['token'] = $this->trongate_tokens->_generate_token($token_data);

        if ($data == false) {
            redirect('donors/manage');
        } else {
            $data['form_location'] = BASE_URL.'donors/submit/'.$update_id;
            $data['update_id'] = $update_id;
            $data['headline'] = 'Donor Information';
            $data['view_file'] = 'edit';
            $this->template('admin', $data);
        }
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

}