<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include ('surgery.php');
class Email extends Surgery
{
	public function show()
	{
		$this->load->database ();
		$data_list = array (
				$id_name => $sn,
				'id_last_five' => $id_card_five 
		);
		$query = $this->db->order_by('','desc')->get( 'proposal');
			
		$this->load->helper ( 'url' );
		$this->load->view ( 'hospital/change_password', array (
				'trg' => 'hospital/check_change_password' 
		) );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */