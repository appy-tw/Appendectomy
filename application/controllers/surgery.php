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
	
	public function process_statistics()
	{
		$this->load->database ();
		
		$query = $this->db->group_by('district_id')->get('proposal');
		$count = $query->num_rows ();
		$DATA['isData'] = false;		
		if($count>0)
		{
			$DATA['isData'] = true;
			$district_id = $query->row ()->district_id;
			
			for($i=0;$i<$count;$i++)
			{
				$query = $this->db->select('district_legislator')->get_where('district_data', array('district_id' => $district_id[$i]));
				
				if ($query->num_rows () > 0) {
	 				$temp ['district_legislator'] = $query->row ()->district_legislator;
	 				$temp ['totalApply'] = $this->db->where('district_id',$district_id[$i])->from('proposal')->count_all_results();
	 				$withoutRepeat = $this->db->where('district_id', $district_id[$i])->group_by('id_last_five')->get('proposal');
	 				$temp ['withoutRepeat'] = $withoutRepeat->num_rows ();
	 				$received = $this->db->where(array('district_id' => $district_id[$i], 'current_status' => 'received'))->
	 				group_by('id_last_five')->get('proposal');
	 				$temp ['received'] = $received->num_rows ();
					
					$data["district_.$i"] = array(
							'district_id' => $temp ['district_legislator'],
							'totalApply'=> $temp ['totalApply'],
							'withoutRepeat'=> $temp ['withoutRepeat'],
							'received'=> $temp ['received']
					);				
				}
			};
			$DATA['data'] = $data;
		}
		
		$this->load->view ( 'surgery/process_statistics', $DATA );
		
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
		$nickname = $this->session->userdata ( 'nickname' );
		$data_list = array ( 'nickname'=>$nickname);
		$query = $this->db->select ( 'staff_id' )->get_where ( 'staff_info', $data_list );
		$staff_id=$query->row()->staff_id;
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
					'status_changed_to' => $status ,
					'staff_id'=>$staff_id
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