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
				$sql = "SELECT staff_id FROM staff_info WHERE NICKNAME=? AND PASSWORD=PASSWORD(?) AND level=?";
				$QUERY_STRING = $this->db->query ( $sql, array (
						$NICKNAME,
						$STFPWD,
						'app_qrcode' 
				) );
				if ($QUERY_STRING->num_rows () == 1)
				{
					$STAFF = $QUERY_STRING->row_array ()->staff_id;
				} else
				{
					$PROCEED = FALSE;
				}
			}
			if ($PROCEED)
			{
				if ($STAFF == "")
				{
					$sql = "SELECT staff_id FROM staff_info WHERE NICKNAME=?";
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
						
						$MAIN_TABLE = "PROPOSAL";
						$RECORD_TABLE = "PROPOSAL_CHANGE_RECORD";
					} else IF ($SNO [4] == 2)
					{
						
						$MAIN_TABLE = "PETITION";
						$RECORD_TABLE = "PETITION_CHANGE_RECORD";
					}
					
					$sql = "INSERT INTO ?(?_ID,STATUS_CHANGED_TO,STAFF_ID)VALUES(?,?,?)";
					$QUERY_STRING = $this->db->query ( $sql, array (
							$RECORD_TABLE,
							$MAIN_TABLE,
							intval ( substr ( $SNO, 5 ) ),
							$STATUS,
							$STAFF 
					) );
					IF ($QUERY_STRING->num_rows () > 0)
					{
						$RECORD_ID = $this->db->mysql_insert_id ();
						$sql = "SELECT current_status,id_last_five FROM ? WHERE ?_ID=? AND VALIDATION_CODE=?";
						$QUERY_STRING = $this->db->query ( $sql, array (
								$MAIN_TABLE,
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
									$sql = "UPDATE ? SET CURRENT_STATUS=?,ID_LAST_FIVE=? WHERE ?_ID=? AND VALIDATION_CODE=?";
									$QUERY_STRING = $this->db->query ( $sql, array (
											$MAIN_TABLE,
											$STATUS,
											$IDL5,
											$MAIN_TABLE,
											intval ( substr ( $SNO, 5 ) ),
											$VC 
									) );
								}
							} else
							{
								$sql = "UPDATE ? SET CURRENT_STATUS=? WHERE ?_ID=? AND VALIDATION_CODE=?";
								$QUERY_STRING = $this->db->query ( $sql, array (
										$MAIN_TABLE,
										$STATUS,
										$MAIN_TABLE,
										intval ( substr ( $SNO, 5 ) ),
										$VC 
								) );
							}
							
							IF ($QUERY_STRING != "")
							{
								$RETURNED_STRING = $DATA ['current_status'];
								IF ($QUERY_STRING->num_rows () > 0)
								{
									IF ($this->db->affected_rows () == 1)
									{
										$sql = "UPDATE ? SET SUCCEED='1' WHERE ?_ID=?";
										$this->db->query ( $sql, array (
												$RECORD_TABLE,
												$RECORD_TABLE,
												$RECORD_ID 
										) );
										$sql = "SELECT current_status,last_update FROM ? WHERE ?_ID=? AND VALIDATION_CODE=?";
										$QUERY_STRING = $this->db->query ( $sql, array (
												$MAIN_TABLE,
												$MAIN_TABLE,
												intval ( substr ( $SNO, 5 ) ),
												$VC 
										) );
										
										IF ($QUERY_STRING->num_rows () == 1)
										{
											$DATA = $QUERY_STRING->row_array ();
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