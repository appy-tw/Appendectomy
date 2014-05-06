<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include ('surgery.php');
class Email extends Surgery
{
	public function show()
	{
		$received_status = array (
				'received',
				'sent',
				'refused' 
		);
		$this->load->database ();
		$condition = array (
				'no_notify' => 0 
		);
		$recorder_query = $this->db->select ( 'proposal_id, user_id,district_id' )->where_in ( 'current_status', $received_status )->get_where ( 'proposal', $condition );
		$proposal_id_list = array ();
		$email_data=array();
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
			echo $proposal_id.' '.$email.' '.$lyname.' '.$district_id;
			// json
			// 尾設no_notify
			$proposal_id_list[]=$proposal_id;
		}
		
		// $this->load->view ( 'email/show' );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */