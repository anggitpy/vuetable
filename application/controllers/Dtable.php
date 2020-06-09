<?php

class Dtable extends CI_Controller {

   function __construct()
   {
      parent::__construct();
      $this->load->library('datatables'); //load library ignited-dataTable
      $this->load->model('Jq_model'); //load model crud_model
   }

   function index()
   {
      $data['kategori'] = $this->Jq_model->get_kategori();
      $this->load->view('datatables', $data);
   }
   
   function get_produk_json() 
   { 
      header('Content-Type: application/json');
      echo $this->Jq_model->get_all_produk();
   }
   
   function simpan()
   { 
      $data = array(
        'barang_kode'     => $this->input->post('kode_barang'),
        'barang_nama'     => $this->input->post('nama_barang'),
        'barang_harga'    => $this->input->post('harga'),
        'barang_kategori_id' => $this->input->post('kategori')
      );
      $this->db->insert('barang', $data);
      redirect('dtable');
   }
   
   function update()
   {
      $kode = $this->input->post('kode_barang');
      $data = array(
         'barang_nama'     => $this->input->post('nama_barang'),
         'barang_harga'    => $this->input->post('harga'),
         'barang_kategori_id' => $this->input->post('kategori')
      );
      $this->db->where('barang_kode',$kode);
      $this->db->update('barang', $data);
      redirect('dtable');
   }
   
   function delete() 
   { 
      $kode=$this->input->post('kode_barang');
      $this->db->where('barang_kode',$kode);
      $this->db->delete('barang');
      redirect('dtable');
   }

}
