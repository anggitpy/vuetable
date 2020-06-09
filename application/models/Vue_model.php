<?php
class Vue_model extends CI_Model{
   
   public function product_data($count = null)
   {
      $data = [];

		$page = $this->input->get('page')-1;
		$per_page = $this->input->get('per_page');
		$sort_init = $this->input->get('sort');
		$sort = str_replace('|',' ',$sort_init);
		$filter = $this->input->get('filter');		
		
		$offset = $per_page * $page;
		
      $this->db->from('barang')
            ->join('kategori','barang_kategori_id = kategori_id')
				->order_by($sort);			
		
		$this->db->group_start()
				->like('barang_kode', $filter)
				->or_like('barang_nama', $filter)
				->or_like('barang_harga', $filter)
				->or_like('kategori_nama', $filter)
				->group_end();	
		
		if($count)
		{
			return $this->db->count_all_results(); 			
		}
		else
		{
			$this->db->limit($per_page, $offset);
			$query = $this->db->get();
			if ($query->num_rows() > 0)
			{				
				foreach ($query->result() as $row)
				{					
					$data[] = $row;
				}
			}
			$query->free_result();    
			return $data; 
		}
	}

}