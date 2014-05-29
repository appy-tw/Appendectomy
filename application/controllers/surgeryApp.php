<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class SurgeryApp extends CI_Controller
{	
	public function processing_app()
	{
		$this->load->database ();
		$input ['SNO'] = $this->input->get ( 'SNO' );
		echo '0';
		if ($input ['SNO'] != "")
		{
			echo '1';
			$SNO = $this->input->get ( 'SNO' );
			$VC = $this->input->get ( 'VC' );
			$STATUS = $this->input->get ( 'STATUS' );
			$STFPWD = $this->input->get ( 'STFPWD' );
			$NICKNAME = $this->input->get ( 'NICKNAME' );
			$IDL5 = $this->input->get ( 'IDL5' );
			$PROCEED = true;
			if (($STATUS == "refused" || $STATUS == "voided") && $STFPWD == "")
			{
				$RETURNED_STRING = "STFPWD";
				$PROCEED = false;
				echo 'QQ';
			} else
			{
				$sql = "SELECT staff_id FROM staff_info WHERE nickname=? AND password=PASSWORD(?) AND level=?";
				$QUERY_STRING = $this->db->query ( $sql, array (
						$NICKNAME,
						$STFPWD,
						'app_qrcode' 
				) );
				if ($QUERY_STRING->num_rows () == 1)
				{
					$STAFF = $QUERY_STRING->row()->staff_id;
				} else
				{
					$PROCEED = FALSE;
					echo 'TT';
				}
			}
			echo '2';
			if ($PROCEED)
			{
				if ($STAFF == "")
				{
					echo '3';
					$sql = "SELECT staff_id FROM staff_info WHERE nickname=?";
					$QUERY_STRING = $this->db->query ( $sql, array (
							$NICKNAME 
					) );
					if ($QUERY_STRING->num_rows () == 1)
					{
						$STAFF = $QUERY_STRING->row ()->staff_id;
					}
				}
				IF ($STAFF != "")
				{
					echo '4';
					IF ($SNO [4] == 1)
					{
						
						$MAIN_TABLE = "proposal";
						$RECORD_TABLE = "proposal_change_record";
					} else IF ($SNO [4] == 2)
					{
						
						$MAIN_TABLE = "petition";
						$RECORD_TABLE = "petition_change_record";
					}
					
					$data = array(
							$MAIN_TABLE."_id" => intval ( substr ( $SNO, 5 ) ),
							'status_changed_to' => $STATUS,
							'staff_id' => $STAFF
					);
					echo '5';
					IF ($this->db->insert($RECORD_TABLE, $data))
					{
						echo '0';
						$RECORD_ID = $this->db->insert_id ();
						
						$QUERY_STRING = $this->db->select('current_status,id_last_five')->where($MAIN_TABLE.'_id',intval ( substr ( $SNO, 5 ) ))
										->where('validation_code',$VC)->get($MAIN_TABLE);
						IF ($QUERY_STRING->num_rows () == 1)
						{
							echo '1';
							$DATA = $QUERY_STRING->row_array ();
							IF ($DATA ['id_last_five'] == "")
							{
								
								IF ($IDL5 == "")
								{
									$RETURNED_STRING = "IDL5";
									$data = "";
									$where = "";
								} else
								{	
									$data = array(
											'current_status' => $STATUS,
											'id_last_five' => $IDL5
									);
									
									$where = array(
											$MAIN_TABLE.'_id' => intval ( substr ( $SNO, 5 ) ),
											'validation_code' => $VC
									);
								}
							} else
							{
								
								$data = array(
										'current_status' => $STATUS
								);
									
								$where = array(
										$MAIN_TABLE.'_id' => intval ( substr ( $SNO, 5 ) ),
										'validation_code' => $VC
								);
							}
							IF ($data != "")
							{
								echo '3';
								$RETURNED_STRING = $DATA ['current_status'];
								$this->db->where($where);
								$QUERY_STRING = $this->db->select('current_status')->get($MAIN_TABLE);
								if($QUERY_STRING->num_rows() == 1)$QUERY_STRING = $QUERY_STRING->row()->current_status;
								else $QUERY_STRING = "";
								echo '4';
								$this->db->where($where);
								echo '5';
								IF ($this->db->update($MAIN_TABLE, $data))
								{	echo '6';
									$affected_rows = false;
									$this->db->where($where);
									$QUERY_UPDATE = $this->db->select('current_status')->get($MAIN_TABLE);
									
									if($QUERY_STRING != "" && $QUERY_UPDATE->num_rows() == 1){
										$QUERY_UPDATE = $QUERY_UPDATE->row()->current_status;
										if($QUERY_STRING != $QUERY_UPDATE)
											$affected_rows = true;
									}
									echo '7';
									
									IF ($affected_rows)
									{
										echo $affected_rows;
										echo '8';
										$data = array(
												'succeed' => '1'
										);											
										$this->db->where($RECORD_TABLE.'_id', $RECORD_ID);
										$this->db->update($RECORD_TABLE, $data);
										echo '9';
										$QUERY_STRING = $this->db->select('current_status,last_update')->where($MAIN_TABLE.'_id',intval ( substr ( $SNO, 5 ) ))
										->where('validation_code',$VC)->get($MAIN_TABLE);
										echo '10';
										IF ($QUERY_STRING->num_rows () == 1)
										{
											$DATA = $QUERY_STRING->row();
											$RETURNED_STRING .= ";" . $DATA->current_status . ";" . $DATA->last_update;
										}echo '11';
									} else
									{
										$RETURNED_STRING .= ";NOCHANGE";
									}
								} else
								{
									$RETURNED_STRING = "更新失敗";
								}
							}
						} else
						{
							$RETURNED_STRING = "更新失敗";
						}
					}
				} else
				{
					$RETURNED_STRING .= "NA";
				}
			}
		}
		ECHO $RETURNED_STRING;
	}
	
}