<?php

class Vuetable extends CI_Controller {

   function __construct()
   {
      parent::__construct();    
      $this->load->model('Vue_model');
      $this->load->helper('form');
   }

   function index()
   {
      $data['title'] = 'Vue Table Demo';
      $this->load->view('vuetable', $data);
   }

   function product_data()
   {
      $data['total'] = $this->Vue_model->product_data(1); // argumen angka 1 untuk mengaktifkan count pada data
      $data['per_page'] = $this->input->get('per_page');
      $data['current_page'] = $this->input->get('page');
      $data['last_page'] = ceil($data['total']/$data['per_page']);
      $data['from'] = ($data['current_page'] * $data['per_page']) - ($data['per_page'] - 1);
      $data['to'] = $data['per_page'] * $data['current_page'];
      $data['data'] = $this->Vue_model->product_data();
      
      $this->output->set_content_type('application/json');
      $this->output->set_output(json_encode($data));
   }


}
