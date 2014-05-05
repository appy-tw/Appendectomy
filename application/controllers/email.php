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
		foreach ( $recorder_query->result () as $recorder_query_row )
		{
			$user_id = $recorder_query_row->user_id;
			$proposal_id = $recorder_query_row->proposal_id;
			$district_id = $recorder_query_row->district_id;
			#找email、立委名
			#做json
			#上尾設no_notify
		}
		
		// $this->load->view ( 'email/show' );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */