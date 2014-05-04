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

		$query = $this->db->select ( 'user_id, id_last_five' )->distinct()->get ( 'proposal' );
		foreach ( $query->result () as $row )
		{
			$user_id = $row->user_id;
			$id_last_five = $row->id_last_five;
			$condition = array (
					'user_id' => $user_id,
					'id_last_five' => $id_last_five 
			);
			
			$ok_record_query = $this->db->where_in ( 'current_status', $received_status )->get_where ( 'proposal' ,$condition);
			if ($ok_record_query->num_rows() > 0)
			{
// 				$ok_record_query->row()->proposal_id;
				echo $id_last_five .$ok_record_query->row()->proposal_id. 'ok'.$ok_record_query->num_rows().'<br/>';
			} else
			{
				echo $id_last_five . 'not receive<br/>';
			}
		}
		
// 		$this->load->view ( 'email/show' );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */