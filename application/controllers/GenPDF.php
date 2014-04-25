<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class GenPDF extends CI_Controller {
// 	public function index() {
// 		// $this->load->database();
// 		// $this->db->get('user_basic');
// 		// $query = $this->db->limit(2)->get('user_basic');
// 		// $query = $this->db->limit(2)->get('user_basic');
		
// 		// foreach ($query->result() as $row)
// 		// {
// 		// $data=array('a'=>$row->email);
// 		// }
// 		// $this->load->view('welcome_message',$data);
// 		$this->load->view ( 'welcome_message' );
// 	}
	// public function proposalframe() {
	// ECHO "<FORM NAME=TRANSFER ACTION='proposal' METHOD=POST TARGET=pdfframe>";
	// while ( $element = current ( $_POST ) ) {
	// echo "<INPUT TYPE=HIDDEN NAME=" . key ( $_POST ) . " VALUE='" . $_POST [key ( $_POST )] . "'>";
	// next ( $_POST );
	// }
	// ECHO "</FORM>";
	// $this->load->view ( 'proposalframe' );
	// }
	public function proposal() {
		$this->load->database ();
		$this->load->helper ( 'proposal' );
		
		$dataValid = true;
		if (($data ['Size'] = $this->input->post ( 'Size', true )) == false)
			$dataValid = false;
		if ($dataValid == true && $data ['Size'] > 0 &&  $data ['Size'] != "") {
			if (($data ['constituency'] = $this->input->post ( 'constituency' , true)) == false)
				$dataValid = false;
			if ($data ['constituency'] == "")
				$dataValid = false;
			if (($data ['EMAIL'] = $this->input->post ( 'EMAIL' , true)) == false)
				$dataValid = false;
			for($SEED = 0; $SEED < $data ['Size']; $SEED ++) {
				if ($dataValid == false)
					break;
				if (($data ["Name_" . $SEED] = $this->input->post ( "Name_" . $SEED , true)) == false) {
					$dataValid = false;
					break;
				}
				if (($data ["IDNo_" . $SEED] = $this->input->post ( "IDNo_" . $SEED , true)) == false) {
					$dataValid = false;
					break;
				}
				if (($data ["Sex_" . $SEED] = $this->input->post ( "Sex_" . $SEED , true)) == false) {
					$dataValid = false;
					break;
				}
				if (($data ["Birthday_y_" . $SEED] = $this->input->post ( "Birthday_y_" . $SEED , true)) == false) {
					$dataValid = false;
					break;
				}
				if (($data ["Birthday_m_" . $SEED] = $this->input->post ( "Birthday_m_" . $SEED , true)) == false) {
					$dataValid = false;
					break;
				}
				if (($data ["Birthday_d_" . $SEED] = $this->input->post ( "Birthday_d_" . $SEED , true)) == false) {
					$dataValid = false;
					break;
				}
				if (($data ["Occupation_" . $SEED] = $this->input->post ( "Occupation_" . $SEED , true)) == false) {
					$dataValid = false;
					break;
				}
				if (($data ["RegAdd_" . $SEED] = $this->input->post ( "RegAdd_" . $SEED , true)) == false) {
					$dataValid = false;
					break;
				}
			}
		} else
			$dataValid = false;
		
		if ($dataValid == true) {
			// 依 constituency 取得立委 DISTRICT_ID
			// if (isset ( $data ['constituency'] ) && $data ['constituency'] != "") {
			
			$data_list = array (
					'CONSTITUENCY' => $data ['constituency'] 
			);
			$query = $this->db->select ( 'district_id' )->get_where ( 'district_data', $data_list );
			if ($query->num_rows () > 0) {
				$data ['DISTRICT_ID'] = $query->row ()->district_id;
			}
			// }
			// 揣（ㄘㄨㄝ）使用者資料
			$email_data = array (
					'EMAIL' => $data ['EMAIL'] 
			);
			$query = $this->db->select ( 'user_id' )->get_where ( 'user_basic', $email_data );
			if ($query->num_rows () > 0) {
				// 有資料
				$row = $query->row ();
				$USER_ID = $row->user_id;
			} else {
				// 無資料就加新的
				$query = $this->db->insert ( 'user_basic', $email_data );
				// 揣出來
				$query = $this->db->select ( 'user_id' )->get_where ( 'user_basic', $email_data );
				$row = $query->row ();
				$USER_ID = $row->user_id;
			}
			// pdf流水號記到資料庫
			for($SEED = 0; $SEED < $data ['Size']; $SEED ++) {
				
				// 更新產製資料
				$VCODE = returnValidation ();
				$data_list = array (
						'USER_ID' => $USER_ID,
						'DISTRICT_ID' => $data ['DISTRICT_ID'],
						'ID_LAST_FIVE' => SUBSTR ( $data ["IDNo_" . $SEED], 5 ),
						'VALIDATION_CODE' => $VCODE 
				);
				$this->db->insert ( 'proposal', $data_list );
				
				$query = $this->db->select ( 'proposal_id' )->get_where ( 'proposal', $data_list );
				$row = $query->row ();
				$proposal_id = $row->proposal_id;
				// 建立流水號
				$data ["SNo_" . $SEED] = "AP" . SPRINTF ( "%02d", $data ['DISTRICT_ID'] ) . "1" . SPRINTF ( "%06d", $proposal_id );
				// 設定 QR Code 檔案路徑
				$data ["QRImgPath_" . $SEED] = 'img/' . $data ["SNo_" . $SEED] . ".jpg";
				// 複製 QR Code 檔案
				copy ( "http://140.113.207.111:4000/QRCode/" . $data ["SNo_" . $SEED] . "&VC=" . $VCODE, $data ["QRImgPath_" . $SEED] );
				// print_r($stmt->errorInfo());
			}
			
			require ('FPDF/chinese-unicode.php');
			$pdf = new PDF_Unicode ();
			
			$CHI_FONT = "DFKai-SB";
			$ENG_FONT = "DFKai-SB";
			$pdf->AddUniCNShwFont ( $CHI_FONT );
			
			$pdf->Open ();
			
			if ($data ['DISTRICT_ID'] != "") {
				$data_list = array (
						'DISTRICT_ID' => $data ['DISTRICT_ID'] 
				);
				$query = $this->db->get_where ( 'district_data', $data_list );
				$DATA = $query->row_array ();
			}
			
			// DUMMY DATA
			if ($DATA ['receiver'] == "") {
				$DATA ['reason'] = "罷免理由";
				$DATA ['notice'] = "注意事項";
				$DATA ['others'] = "其他";
				$DATA ['zipcode'] = "郵遞區號";
				$DATA ['mailing_address'] = "提議書郵寄地址";
				$DATA ['receiver'] = "提議書收件人";
			}			
				// DUMMY DATA
			if ($data ['Name_0'] == "") {
				$data ['Name_0'] = "馬娘娘";
				$data ['IDNo_0'] = "A246813579";
				$data ['Sex_0'] = "F";
				$data ['Birthday_0'] = "YYYY.MM.DD";
				$data ['Occupation_0'] = "孬孬";
				$data ['RegAdd_0'] = "魯蛇大本營";
				$data ['SNo_0'] = "123456789";
			}
// 			if (! isset ( $data ['Name_1'] )) {
// 				$data ['Name_1'] = "金小刀";
// 				$data ['IDNo_1'] = "A135792468";
// 				$data ['Sex_1'] = "M";
// 				$data ['Birthday_1'] = "YYYY.MM.DD";
// 				$data ['Occupation_1'] = "孬孬";
// 				$data ['RegAdd_1'] = "魯蛇大本營";
// 				$data ['SNo_1'] = "987654321";
// 			}

// 			$NAME = "提議人姓名";
// 			$IDNo = "A135792468";
// 			$SEX = "M";
// 			$BIRTHDAY = "YYYY.MM.DD";
// 			$OCCUPATION = "職業";
// 			$REGADD = "提案人戶籍地址";			
			
			for($SEED = 0; $SEED < $data ['Size']; $SEED ++) {
				$NAME = $data ["Name_" . $SEED];
				$IDNo = $data ["IDNo_" . $SEED];
				$SEX = $data ["Sex_" . $SEED];
				$BIRTHDAY = $data ["Birthday_y_" . $SEED] . "-" . $data ["Birthday_m_" . $SEED] . "-" . $data ["Birthday_d_" . $SEED];
				$OCCUPATION = $data ["Occupation_" . $SEED];
				$REGADD = $data ["RegAdd_" . $SEED];
				$QRImgPath = "";
				if ($data ["QRImgPath_" . $SEED] != "")
					$QRImgPath = $data ["QRImgPath_" . $SEED];
				$SNo = $data ["SNo_" . $SEED];
				
				generatePDF ( $pdf, $CHI_FONT, $ENG_FONT, $DATA, $NAME, $IDNo, $SEX, $BIRTHDAY, $OCCUPATION, $REGADD, $QRImgPath, $SNo );
			}
			
			$pdf->Output ();
		}
	}
}