<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class SurgeryApp extends CI_Controller
{	
	public function processing_app()
	{
		$this->load->database ();
		$input ['SNO'] = $this->input->get ( 'SNO' );

		echo "1";
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
					$STAFF = $QUERY_STRING->row ()->staff_id;
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
							$MAIN_TABLE.'_id' => intval ( substr ( $SNO, 5 ) ),
							'status_changed_to' => $STATUS,
							'staff_id' => $STAFF 
					);
					$this->db->insert($RECORD_TABLE, $data);
					echo "2";
															
					IF ($QUERY_STRING->num_rows () > 0)
					{
						$RECORD_ID = $this->db->mysql_insert_id ();
						$sql = "SELECT current_status,id_last_five FROM ? WHERE ?=? AND validation_code=?";
						$QUERY_STRING = $this->db->query ( $sql, array (
								$MAIN_TABLE,
								$MAIN_TABLE."_id",
								intval ( substr ( $SNO, 5 ) ),
								$VC 
						) );
						IF ($QUERY_STRING->num_rows () == 1)
						{
							$DATA = $QUERY_STRING->row_array ();
							
							IF ($DATA ['id_last_five'] == "")
							{
								IF ($IDL5 == "")
								{
									$RETURNED_STRING = "IDL5";
									$sql = "";
								} else
								{
									$data = array(
											'current_status' => $STATUS,
											'id_last_five' => $IDL5
									);
									
									$this->db->where($MAIN_TABLE."_id", intval ( substr ( $SNO, 5 ) ));
									$this->db->where('validation_code', $VC);
									$this->db->update($MAIN_TABLE, $data);
								}
							} else{
								$data = array(
										'current_status' => $STATUS,
								);
									
								$this->db->where($MAIN_TABLE."_id", intval ( substr ( $SNO, 5 ) ));
								$this->db->where('validation_code', $VC);
								$this->db->update($MAIN_TABLE, $data);
							}
							echo '3';
							IF ($QUERY_STRING != "")
							{
								$RETURNED_STRING = $DATA ['current_status'];
								IF ($QUERY_STRING->num_rows () > 0)
								{
									IF ($this->db->affected_rows () == 1)
									{
										$sql = "UPDATE ? SET succeed='1' WHERE ?=?";
										$this->db->query ( $sql, array (
												$RECORD_TABLE,
												$RECORD_TABLE."_id",
												$RECORD_ID 
										) );
										$data = array(
												'current_status' => $STATUS,
										);
											
										$this->db->where($RECORD_TABLE."_id", $RECORD_ID );
										$this->db->update($RECORD_TABLE, $data);
										
										
										$sql = "SELECT current_status,last_update FROM ? WHERE ?=? AND validation_code=?";
										$QUERY_STRING = $this->db->query ( $sql, array (
												$MAIN_TABLE,
												$MAIN_TABLE."_id",
												intval ( substr ( $SNO, 5 ) ),
												$VC 
										) );
										echo "4";
										IF ($QUERY_STRING->num_rows () == 1)
										{
											$DATA = $QUERY_STRING->row_array ();
											$RETURNED_STRING .= ";" . $DATA ['current_status'] . ";" . $DATA ['last_update'];
										}
									} else
									{
										$RETURNED_STRING .= ";NOCHANGE";
									}echo "5";
								} else
								{
									$RETURNED_STRING = "更新失敗";
								}
							}echo "6";
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
		echo $RETURNED_STRING;
	}
	
}