<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include ('surgery.php');
class Email extends CI_Controller
{
	public function kia3_pue1()
	{
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
			redirect ( 'Email/login' );
		}
		// $received_status = array (
		// 'received',
		// 'sent',
		// 'refused'
		// );
		// $condition = array (
		// 'no_notify' => 0
		// );
		$recorder_sql = 'SELECT proposal_id, user_id, district_id FROM proposal WHERE current_status=? AND DATE(last_update)=DATE(?)';
		
		$recorder_query = $this->db->query ( $recorder_sql, array (
				'received',
				$jit8 
		) );
		// $proposal_id_list = array ();
		$email_data = array ();
		foreach ( $recorder_query->result () as $recorder_query_row )
		{
			$user_id = $recorder_query_row->user_id;
			$proposal_id = $recorder_query_row->proposal_id;
			$district_id = $recorder_query_row->district_id;
			// email、立委名
			$email_query = $this->db->select ( 'email' )->where ( 'user_id', $user_id )->get ( 'user_basic' );
			$email = $email_query->row ()->email;
			$lyname_query = $this->db->select ( 'district_legislator' )->where ( 'district_id', $district_id )->get ( 'district_data' );
			$lyname = $lyname_query->row ()->district_legislator;
			$email_data [] = array (
					$email,
					$proposal_id,
					$district_id,
					$lyname 
			);
			// json
			// 尾設no_notify
			// $proposal_id_list [] = $proposal_id;
		}
		echo json_encode ( $email_data );
		// $this->load->view ( 'email/show' );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */