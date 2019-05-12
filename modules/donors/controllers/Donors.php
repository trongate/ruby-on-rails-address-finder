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
        $this->module('trongate_tokens');
        $this->security->_make_sure_allowed();

        $token_data['user_id'] = $this->security->_get_user_id();
        $data['token'] = $this->trongate_tokens->_generate_token($token_data);
        $data['order_by'] = 'id';

        //format the pagination
        $data['total_rows'] = $this->model->count('donors'); 
        $data['record_name_plural'] = 'donors';

        $data['headline'] = 'Manage Donors';
        $data['view_module'] = 'donors';
        $data['view_file'] = 'manage';

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

}