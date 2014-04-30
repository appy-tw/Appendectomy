<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include ('surgery.php');
class Hospital extends Surgery
{
	public function change_password()
	{
		$this->load->helper ( 'url' );
		$this->load->view ( 'hospital/change_password', array (
				'trg' => 'hospital/check_change_password' 
		) );
	}
	public function check_change_password()
	{
		$this->load->database ();
		$this->load->helper ( 'url' );
		$origin = $this->input->post ( 'origin' );
		$new = $this->input->post ( 'new' );
		$twice = $this->input->post ( 'twice' );
		if ($new != $twice)
		{
			$data = array (
					'problem' => '兩個新密碼不一樣' 
			);
			$this->load->view ( 'surgery/process_error', $data );
			return;
		}
		$this->load->library ( 'session' );
		$nickname = $this->session->userdata ( 'nickname' );
		$data_list = array (
				$nickname,
				$origin 
		);
		$sql = "SELECT * FROM staff_info WHERE nickname = ? AND password = PASSWORD(?)";
		$query = $this->db->query ( $sql, $data_list );
		
		if ($query->num_rows () != 1)
		{
			$data = array (
					'problem' => '原本密碼打錯！！' 
			);
			$this->load->view ( 'surgery/process_error', $data );
			return;
		}
		$data_list = array (
				$new,
				$nickname 
		);
		$sql = "UPDATE staff_info SET password = PASSWORD(?) WHERE nickname = ?";
		$query = $this->db->query ( $sql, $data_list );
		$this->load->view ( 'surgery/main' );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */