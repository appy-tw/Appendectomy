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
		
		$user_query = $this->db->select ( 'user_id' )->distinct ()->get ( 'proposal' );
		foreach ( $user_query->result () as $user_row )
		{
			$user_id = $user_row->user_id;
			$user_condition = array (
					'user_id' => $user_id 
			);
			$query = $this->db->select ( 'id_last_five' )->distinct ()->get_where ( 'proposal', $user_condition );
			$receive_array = array ();
			$not_rec_array = array ();
			foreach ( $query->result () as $row )
			{
				$id_last_five = $row->id_last_five;
				$condition = array (
						'user_id' => $user_id,
						'id_last_five' => $id_last_five 
				);
				
				$ok_record_query = $this->db->where_in ( 'current_status', $received_status )->get_where ( 'proposal', $condition );
				if ($ok_record_query->num_rows () > 0)
				{
					$receive_array [] = $id_last_five;
				} else
				{
					$not_rec_array [] = $id_last_five;
				}
			}
			echo $user_id;
			print_r ( $receive_array );
			print_r ( $not_rec_array );
			$email = $this->db->select ( 'email' )->get_where ( 'user_basic', $user_condition )->row()->email;
			echo $email;
		}
		
		// $this->load->view ( 'email/show' );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */