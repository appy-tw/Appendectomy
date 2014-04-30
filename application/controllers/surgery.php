<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Surgery extends CI_Controller
{
	public function main()
	{
		$this->load->view ( 'surgery/main' );
	}
	public function process()
	{
		$this->load->view ( 'surgery/process' );
	}
	public function process_update()
	{
		// $this->load->view ( 'surgery/process_update' );
		$district_id = $this->input->post ( 'DISTRICT_ID' );
		$doctype = $this->input->post ( 'DOCTYPE' );
		$status = $this->input->post ( 'STATUS' );
		if ($district_id == false || $doctype == false || $status == false)
		{
			$data = array (
					'problem' => '罷免對象、文件類別、文件狀態有一個沒選到' 
			);
			$this->load->view ( 'surgery/process_error', $data );
			return;
		}
		$this->load->database ();
		$table = $doctype;
		$change_table = $doctype . '_change_record';
		$id_name = $doctype . '_id';
		// 先檢查是否全部合法
		for($i = 0; $i < 10; $i ++)
		{
			$sn = $this->input->post ( 'SNO_' . $i );
			$id_card_five = $this->input->post ( 'IDL5_' . $i );
			if ($sn == '' && $id_card_five == '')
			{
				continue;
			}
			$data_list = array (
					$id_name => $sn,
					'id_last_five' => $id_card_five 
			); 
			$query = $this->db->select ( $id_name )->get_where ( $table, $data_list );
			// 有在資料庫無
			if ($query->num_rows () != 1)
			{
				$data = array (
						'problem' => ($i+1) . '的資料有問題！！' 
				);
				$this->load->view ( 'surgery/process_error', $data );
				return;
			}
		}
		// 開始更新資料庫
		for($i = 0; $i < 10; $i ++)
		{
			$data_list = array (
					$id_name => $sn,
					'id_last_five' => $id_card_five 
			);
			$query = $this->db->select ( $id_name )->get_where ( $table, $data_list );
			// 代誌記到變化資料表（change）
			$data_list = array (
					$id_name => $status,
					'status_changed_to' => $status 
			);
			$query = $this->db->insert ( $change_table, $data_list );
			// 更新總表
			$data_list = array (
					'current_status' => $status 
			);
			$this->db->where ( $id_name, $sn )->update ( $table, $data_list );
		}
		redirect ( 'doctor/process' );
	}
	// 有登入才有網頁
	public function __construct()
	{
		parent::__construct ();
		$this->load->helper ( 'url' );
		if (! $this->isLogin ())
		{
			redirect ( 'doctor/login' );
		}
	}
	private function isLogin()
	{
		$this->load->library ( 'session' );
		return $this->session->userdata ( 'nickname' );
	}
	// 外口框架
	function _output($content)
	{
		// Load the base template with output content available as $content
		$data ['content'] = &$content;
		$data ['menu'] = array (
				array (
						'surgery/process',
						'文書處理' 
				),
				array (
						'hospital/change_password',
						'改密碼' 
				) ,
				array (
						'doctor/logout',
						'登出' 
				) 
		);
		$surgery_data = $this->load->view ( 'surgery/base', $data, true );
		$data ['content'] = &$surgery_data;
		echo $this->load->view ( 'doctor/base', $data, true );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */