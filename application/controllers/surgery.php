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
		$this->checkLevel ( array (
				'admin' 
		) );
		$this->load->view ( 'surgery/process' );
	}
	public function process_statistics()
	{
		$this->checkLevel ( array (
				'admin' 
		) );
		$this->load->database ();
		
		$query_district = $this->db->select ( 'district_id' )->distinct ()->get ( 'proposal' );
		$count = $query_district->num_rows ();
		$DATA ['isData'] = false;
		if ($count > 0)
		{
			$DATA ['isData'] = true;
			
			$three_day_ago = date ( 'Y-m-d', strtotime ( '-3 day' ) );
			
			$received_status = array (
					'received',
					'sent',
					'refused' 
			);
			$i = 0;
			foreach ( $query_district->result () as $row )
			{
				$district_id = $row->district_id;
				$query = $this->db->select ( 'district_legislator' )->get_where ( 'district_data', array (
						'district_id' => $district_id 
				) );
				if ($query->num_rows () > 0)
				{
					$temp ['district_legislator'] = $query->row ()->district_legislator;
					$temp ['totalApply'] = $this->db->where ( 'district_id', $district_id )->from ( 'proposal' )->count_all_results ();
					$withoutRepeat = $this->db->select ( 'id_last_five, user_id' )->select_max ( 'proposal_id', 'proposal_id' )->select_max ( 'last_update', 'last_update' )->group_by ( array (
							'id_last_five',
							' user_id' 
					) )->where ( 'district_id', $district_id )->get ( 'proposal' );
					$received = $this->db->where ( array (
							'district_id' => $district_id 
					) )->where_in ( 'current_status', $received_status )->select ( 'id_last_five, user_id' )->distinct ()->get ( 'proposal' );
					$temp ['received'] = $received->num_rows ();
					
					$temp ['withoutRepeat'] = 0;
					$temp ['no_received_within_3days'] = 0;
					// 三天前寄信，但是同樣組合沒有記錄的
					foreach ( $withoutRepeat->result () as $proposal )
					{
						$temp ['withoutRepeat'] += 1;
						list ( $proposal_date, $proposal_time ) = explode ( ' ', $proposal->last_update, 2 );
						if ($three_day_ago > $proposal_date)
						{
							$condition = array (
									'district_id' => $district_id,
									'user_id' => $proposal->user_id,
									'id_last_five' => $proposal->id_last_five 
							);
							$find_all_record = $this->db->where ( $condition )->where_in ( 'current_status', $received_status )->get ( 'proposal' );
							if ($find_all_record->num_rows () == 0)
							{
								$temp ['no_received_within_3days'] += 1;
							}
						}
					}
					
					$data ["district_.$i"] = array (
							'district_id' => $temp ['district_legislator'],
							'totalApply' => $temp ['totalApply'],
							'withoutRepeat' => $temp ['withoutRepeat'],
							'received' => $temp ['received'],
							'no_received_within_3days' => $temp ['no_received_within_3days'] 
					);
					$i += 1;
				}
			}
			;
			$DATA ['data'] = $data;
		}
		
		$this->load->view ( 'surgery/process_statistics', $DATA );
	}

	public function process_update()
	{
		$this->checkLevel ( array (
				'admin',
				'app_qrcode' 
		) );
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
						'problem' => ($i + 1) . '的資料有問題！！' 
				);
				$this->load->view ( 'surgery/process_error', $data );
				return;
			}
		}
		$nickname = $this->session->userdata ( 'nickname' );
		$data_list = array (
				'nickname' => $nickname 
		);
		$query = $this->db->select ( 'staff_id' )->get_where ( 'staff_info', $data_list );
		$staff_id = $query->row ()->staff_id;
		// 開始更新資料庫
		for($i = 0; $i < 10; $i ++)
		{
			$sn = $this->input->post ( 'SNO_' . $i );
			$id_card_five = $this->input->post ( 'IDL5_' . $i );
			if ($sn == '' && $id_card_five == '')
			{
				continue;
			}
			// 代誌記到變化資料表（change）
			$data_list = array (
					$id_name => $sn,
					'status_changed_to' => $status,
					'staff_id' => $staff_id 
			);
			$query = $this->db->insert ( $change_table, $data_list );
			// 更新總表
			$data_list = array (
					'current_status' => $status 
			);
			$this->db->where ( $id_name, $sn )->update ( $table, $data_list );
		}
		redirect ( 'surgery/process' );
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
						'surgery/process_statistics',
						'統計資料' 
				),
				array (
						'email/kia3_pue1',
						'寄email' 
				),
				array (
						'hospital/change_password',
						'改密碼' 
				),
				array (
						'hospital/add_user',
						'加帳號' 
				),
				array (
						'doctor/logout',
						'登出' 
				) 
		);
		$surgery_data = $this->load->view ( 'surgery/base', $data, true );
		$data ['content'] = &$surgery_data;
		echo $this->load->view ( 'doctor/base', $data, true );
	}
	private function checkLevel($allow)
	{
		if (! in_array ( $this->session->userdata ( 'level' ), $allow ))
		{
			redirect ( 'doctor/login' );
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
