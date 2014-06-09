<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include ('surgery.php');
class Hospital extends Surgery
{
	public function change_password()
	{
		$this->checkLevel(array('admin'));
		$this->load->helper ( 'url' );
		$this->load->view ( 'hospital/change_password', array (
				'trg' => 'hospital/check_change_password' 
		) );
	}
	public function check_change_password()
	{
		$this->checkLevel(array('admin'));
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
	public function add_user()
	{
		$this->load->helper ( 'url' );
		$this->checkLevel(array('admin'));
		$this->load->view ( 'hospital/add_user', array (
				'trg' => 'hospital/check_add_user' 
		) );
	}
	public function check_add_user()
	{
		$this->checkLevel(array('admin'));
		$this->load->database ();
		$nickname = $this->input->post ( 'nickname' );
		$pasword = $this->input->post ( 'password' );
		$twice = $this->input->post ( 'twice' );
		$level = $this->input->post ( 'level' );
		if ($pasword != $twice)
		{
			$data = array (
					'problem' => '兩個密碼不一樣' 
			);
			$this->load->view ( 'surgery/process_error', $data );
			return;
		}
		$data_list = array (
				$nickname,
				$pasword,
				$level 
		);
		$sql = "INSERT INTO staff_info (nickname, password, level) VALUES (?, PASSWORD(?),?)";
		$query = $this->db->query ( $sql, $data_list );
		
		$this->load->view ( 'surgery/main' );
	}
	private function checkLevel($allow)
	{
		$this->load->library ( 'session' );
		$this->load->helper ( 'url' );
		if (! in_array($this->session->userdata ( 'level' ),$allow))
		{
			redirect ( 'doctor/login' );
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */