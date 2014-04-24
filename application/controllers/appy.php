<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Appy extends CI_Controller
{
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// $this->load->database();
		// $this->db->get('user_basic');
		// $query = $this->db->limit(2)->get('user_basic');
		// $query = $this->db->limit(2)->get('user_basic');
		
		// foreach ($query->result() as $row)
		// {
		// $data=array('a'=>$row->email);
		// }
		// $this->load->view('welcome_message',$data);
		// $this->load->view ( 'welcome_message' );
		$this->input_proposal_form ();
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