<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class SurgeryApp extends CI_Controller
{	
	public function processing_app()
	{
		$this->load->database ();
		$input ['SNO'] = $this->input->get ( 'SNO' );
		
		if ($input ['SNO'] != "")
		{
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
				}
			}
			if ($PROCEED)
			{
				if ($STAFF == "")
				{
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
					echo '1';
					IF ($this->db->insert($RECORD_TABLE, $data))
					{
						echo '2';
						$RECORD_ID = $this->db->insert_id ();
						echo 't';

						$QUERY_STRING = $this->db->select('current_status,id_last_five')->where($MAIN_TABLE.'_id',intval ( substr ( $SNO, 5 ) ))
										->where('validation_code',$VC)->get($MAIN_TABLE);
						echo 'q';
						IF ($QUERY_STRING->num_rows () == 1)
						{
							$DATA = $QUERY_STRING->row_array ();
							echo '3';
							IF ($DATA ['id_last_five'] == "")
							{
								echo '4';
								IF ($IDL5 == "")
								{
									echo '5';
									$RETURNED_STRING = "IDL5";
									$sql = "";
								} else
								{
									echo '6';
									
									$data = array(
											'current_status' => $STATUS,
											'id_last_five' => $IDL5
									);
									
									$this->db->where($MAIN_TABLE.'_id', intval ( substr ( $SNO, 5 ) ));
									$this->db->where('validation_code', $VC);
									$QUERY_STRING = $this->db->update($MAIN_TABLE, $data);
								}
							} else
							{
								echo '7';
								
								$data = array(
										'current_status' => $STATUS
								);
									
								$this->db->where($MAIN_TABLE.'_id', intval ( substr ( $SNO, 5 ) ));
								$this->db->where('validation_code', $VC);
								$QUERY_STRING = $this->db->update($MAIN_TABLE, $data);
							}
							
							IF ($QUERY_STRING != "")
							{
								echo '8';
								$RETURNED_STRING = $DATA ['current_status'];
								IF ($QUERY_STRING->num_rows () > 0)
								{
									echo '9';
									IF ($this->db->affected_rows () == 1)
									{
										echo '10';
																				
										$data = array(
												'succeed' => '1'
										);
											
										$this->db->where($RECORD_TABLE.'_id', $RECORD_ID);
										$this->db->update($RECORD_TABLE, $data);
										
// 										$sql = "SELECT current_status,last_update FROM ? WHERE ?=? AND validation_code=?";
// 										$QUERY_STRING = $this->db->query ( $sql, array (
// 												$MAIN_TABLE,
// 												$MAIN_TABLE.'_id',
// 												intval ( substr ( $SNO, 5 ) ),
// 												$VC 
// 										) );
										$QUERY_STRING = $this->db->select('current_status,last_update')->where($MAIN_TABLE.'_id',intval ( substr ( $SNO, 5 ) ))
										->where('validation_code',$VC)->get($MAIN_TABLE);
										
										IF ($QUERY_STRING->num_rows () == 1)
										{
											echo '11';
											$DATA = $QUERY_STRING->row();
											$RETURNED_STRING .= ";" . $DATA ['current_status'] . ";" . $DATA ['last_update'];
										}
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