<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include ('surgery.php');
class Email extends Surgery
{
	public function show()
	{
		$this->load->database ();
		$query = $this->db->order_by('','desc')->where->get( 'proposal');
			
		$this->load->view ( 'email/show');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */