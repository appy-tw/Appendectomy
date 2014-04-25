<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Doctor extends CI_Controller
{
	public function login()
	{
		$this->load->helper ( 'url' );
		$data = array (
				'post_url' => site_url ( "doctor/check" ) 
		);
		$this->load->view ( 'doctor/login', $data );
	}
	public function check()
	{
		$this->load->database ();
		$this->load->helper ( 'url' );
		$nickname = $this->input->post ( 'NICKNAME' );
		$password = $this->input->post ( 'PASSWORD' );
		$sql = "SELECT * FROM staff_info WHERE nickname = ? AND password = PASSWORD(?)";
		$query = $this->db->query ( $sql, array (
				$nickname,
				$password 
		) );
		// $data_list = array (
		// 'nickname' => $nickname,
		// 'password' => $password
		// );
		// $query = $this->db->get_where ( 'staff_info', $data_list );
		echo $query->num_rows ();
		if ($query->num_rows () == 1)
		{
			$this->load->library ( 'session' );
			$this->session->set_userdata ( 'nickname', $nickname );
			redirect ( 'doctor/menu' );
		}
		else
		{
			redirect ( 'doctor/login' );
		}
	}
	private function isLogin()
	{
		$this->load->library ( 'session' );
		return $this->session->userdata ( 'nickname' );
	}
	public function menu()
	{
		if (! $this->isLogin ())
		{
			$this->load->helper ( 'url' );
			redirect ( 'doctor/login' );
		}
		echo 'meu';
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */