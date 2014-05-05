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
	 				$withoutRepeat = $this->db->where('district_id', $district_id[$i])->select('id_last_five, user_id')->distinct()->get('proposal');
	 				$temp ['withoutRepeat'] = $withoutRepeat->num_rows ();
	 				$received = $this->db->where(array('district_id' => $district_id[$i], 'current_status' => 'received'))->
	 				select('id_last_five, user_id')->distinct()->get('proposal');
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
	
	public function processing()
	{
		$this->load->database ();
		$input['SNO'] = $this->input->get('SNO');
		
		if($input['SNO']!="")
		{
			$SNO=$this->input->get('SNO');
			$VC=$this->input->get('VC');
			$STATUS=$this->input->get('STATUS');
			$STFPWD=$this->input->get('STFPWD');
			$NICKNAME=$this->input->get('NICKNAME');
			$IDL5=$this->input->get('IDL5');
			$PROCEED=true;
			if(($STATUS=="refused"||$STATUS=="voided")&&$STFPWD=="")
			{
				$RETURNED_STRING="STFPWD";
				$PROCEED=false;
			}
			else
			{
				if($STATUS=="refused"||$STATUS=="voided")
				{
					$sql = "SELECT staff_id FROM STAFF_INFO WHERE NICKNAME=? AND PASSWORD=PASSWORD(?)";
					$QUERY_STRING = $this->db->query ( $sql, array (
							$NICKNAME,
							$STFPWD
					) );
				}
				else
				{
					$sql = "SELECT staff_id FROM STAFF_INFO WHERE NICKNAME=?";
					$QUERY_STRING = $this->db->query ( $sql, array (
							$NICKNAME
					) );
				}
				if($QUERY_STRING->num_rows()==1)
				{
					$STAFF= $QUERY_STRING->row_array()->staff_id;
				}
				ELSE
				{
					$PROCEED=FALSE;
				}
			}
			if($PROCEED)
			{
				if ($STAFF=="")
				{
					$sql = "SELECT staff_id FROM STAFF_INFO WHERE NICKNAME=?";
					$QUERY_STRING = $this->db->query ( $sql, array (
							$NICKNAME
					) );
					if($QUERY_STRING->num_rows()==1)
					{
						$STAFF=$QUERY_STRING->row()->staff_id;
					}
				}
				IF($STAFF!="")
				{
					IF($SNO[4]==1)
					{
						
						$MAIN_TABLE = "PROPOSAL";
						$RECORD_TABLE = "PROPOSAL_CHANGE_RECORD";
						
					}
					ELSE IF($SNO[4]==2)
					{
						
						$MAIN_TABLE = "PETITION";
						$RECORD_TABLE = "PETITION_CHANGE_RECORD";
						
					}
		
					$sql="INSERT INTO ?(?_ID,STATUS_CHANGED_TO,STAFF_ID)VALUES(?,?,?)";
					$QUERY_STRING = $this->db->query ( $sql, array (
							$RECORD_TABLE,
							$MAIN_TABLE,
							intval(substr($SNO,5)),
							$STATUS,
							$STAFF
					) );					
					IF($QUERY_STRING->num_rows() > 0)
					{
						$RECORD_ID = $this->db->mysql_insert_id();
						$sql ="SELECT current_status,id_last_five FROM ? WHERE ?_ID=? AND VALIDATION_CODE=?";
						$QUERY_STRING = $this->db->query($sql, array(
								$MAIN_TABLE,
								intval(substr($SNO,5)),
								$VC
							)
						);
						IF($QUERY_STRING->num_rows()==1)
						{
							$DATA=$QUERY_STRING->row_array();
		
							IF($DATA['id_last_five']=="")
							{
								IF($IDL5=="")
								{
									$RETURNED_STRING="IDL5";
									$sql="";
								}
								ELSE
								{
									$sql = "UPDATE ? SET CURRENT_STATUS=?,ID_LAST_FIVE=? WHERE ?_ID=? AND VALIDATION_CODE=?";
									$QUERY_STRING = $this->db->query($sql, array(
											$MAIN_TABLE,
											$STATUS,
											$IDL5,
											$MAIN_TABLE,
											intval(substr($SNO,5)),
											$VC
										)
									);
								}
							}
							ELSE
							{
								$sql = "UPDATE ? SET CURRENT_STATUS=? WHERE ?_ID=? AND VALIDATION_CODE=?";
								$QUERY_STRING = $this->db->query($sql, array(
										$MAIN_TABLE,
										$STATUS,
										$MAIN_TABLE,
										intval(substr($SNO,5)),
										$VC
									)
								);
								
							}
		
							IF($QUERY_STRING!="")
							{
								$RETURNED_STRING=$DATA['current_status'];
								IF($QUERY_STRING->num_rows() > 0)
								{
									IF($this->db->affected_rows()==1)
									{
										$sql = "UPDATE ? SET SUCCEED='1' WHERE ?_ID=?";
										$this->db->query($sql, array(
												$RECORD_TABLE,
												$RECORD_TABLE,
												$RECORD_ID
										));
										$sql = "SELECT current_status,last_update FROM ? WHERE ?_ID=? AND VALIDATION_CODE=?";
										$QUERY_STRING = $this->db->query($sql, array(
												$MAIN_TABLE,
												$MAIN_TABLE,
												intval(substr($SNO,5)),
												$VC
										));
										
										
										IF($QUERY_STRING->num_rows()==1)
										{
											$DATA=$QUERY_STRING->row_array();
											$RETURNED_STRING.=";".$DATA['current_status'].";".$DATA['last_update'];
										}
									}
									ELSE
									{
										$RETURNED_STRING.=";NOCHANGE";
									}
								}
								ELSE
								{
									$RETURNED_STRING="更新失敗";
								}
							}
						}
						ELSE
						{
							$RETURNED_STRING="更新失敗";
						}
					}
				}
				ELSE
				{
					$RETURNED_STRING.="NA";
				}
			}
		}
		ECHO $RETURNED_STRING;
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