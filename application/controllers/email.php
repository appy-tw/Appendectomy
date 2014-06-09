<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include ('surgery.php');
class Email extends CI_Controller
{
	public function siu1_tioh8()
	{
		
		//$this->checkLevel(array('admin'));
		
		$nickname = $this->input->get ( 'tiunn3', true );
		
		$password = $this->input->get ( 'bit8', true );
		$jit8 = $this->input->get ( 'jit8', true );
		
		$this->load->database ();
		
		$sql = "SELECT * FROM staff_info WHERE nickname = ? AND password = PASSWORD(?) AND level=?";
		$query = $this->db->query ( $sql, array (
				$nickname,
				$password,
				'email' 
		) );
		
		if ($query->num_rows () != 1)
		{
			$this->load->helper ( 'url' );
			redirect ( 'doctor/login' );
		}
		
		$recorder_sql = 'SELECT proposal_id FROM proposal_change_record WHERE status_changed_to=? AND DATE(changed_time)=DATE(?)';
		
		$recorder_query = $this->db->query ( $recorder_sql, array (
				'received',
				$jit8 
		) );
		// $proposal_id_list = array ();
		$user_data = array ();
		foreach ( $recorder_query->result () as $recorder_query_row )
		{
			$proposal_id = $recorder_query_row->proposal_id;
			$user_id_query = $this->db->select ( 'user_id' )->where ( 'proposal_id', $proposal_id )->get ( 'proposal' );
			$user_id = $user_id_query->row ()->user_id;
			$user_data [$user_id] = 1;
		}
		$email_data = array ();
		foreach ( $user_data as $user_id => $value )
		{
			$email_query = $this->db->select ( 'email' )->where ( 'user_id', $user_id )->get ( 'user_basic' );
			$email = $email_query->row ()->email;
			$email_data [$email] = 1;
		}
		foreach ( $email_data as $email => $value )
		{
			echo $email.";\n";
		}
		//echo json_encode ( $email_data );
		// $this->load->view ( 'email/show' );
	}
	private function checkLevel($allow)
	{
		$this->load->helper ( 'url' );
		$this->load->library ( 'session' );
		if (! in_array($this->session->userdata ( 'level' ),$allow))
		{
			redirect ( 'doctor/login' );
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */