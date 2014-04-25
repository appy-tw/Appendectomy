<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Doctor extends CI_Controller
{	
	public function login()
	{
		$this->load->helper('url');
		$data=array('post_url'=> site_url("doctor/check"));
		$this->load->view ( 'doctor/login',$data );
	}
	public function input_proposal_form()
	{
		$this->load->database ();
		$this->load->helper ( 'input_proposal_form' );
		$RESULT = $this->db->get ( 'district_data' );
		$data ['RESULT'] = $RESULT->result_array ();
		$this->load->view ( 'input_proposal_form', $data );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */