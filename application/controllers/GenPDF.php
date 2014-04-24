<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class GenPDF extends CI_Controller
{
	public function index()
	{
		// $this->load->database();
		// $this->db->get('user_basic');
		// $query = $this->db->limit(2)->get('user_basic');
		// $query = $this->db->limit(2)->get('user_basic');
		
		// foreach ($query->result() as $row)
		// {
		// $data=array('a'=>$row->email);
		// }
		// $this->load->view('welcome_message',$data);
		$this->load->view ( 'welcome_message' );
	}
	public function proposalframe()
	{
		ECHO "<FORM NAME=TRANSFER ACTION='proposal' METHOD=POST TARGET=pdfframe>";
		while ( $element = current ( $_POST ) )
		{
			echo "<INPUT TYPE=HIDDEN NAME=" . key ( $_POST ) . " VALUE='" . $_POST [key ( $_POST )] . "'>";
			next ( $_POST );
		}
		ECHO "</FORM>";
		$this->load->view ( 'proposalframe' );
	}
	public function proposal()
	{
		$this->load->database ();
		$this->load->helper ( 'proposal' );
		IF ($_POST ['Size'] > 0)
		{
			// 依 constituency 取得立委 DISTRICT_ID
			IF (isset ( $_POST ['constituency'] ) && $_POST ['constituency'] != "")
			{
				
				$data_list = array (
						'CONSTITUENCY' => $_POST ['constituency'] 
				);
				$query = $this->db->select ( 'district_id' )->get_where ( 'user_basic', $data_list );
				if ($query->num_rows () > 0)
				{
					$_POST ['DISTRICT_ID'] = $query->row ()->district_id;
				}
			}
			// 揣（ㄘㄨㄝ）使用者資料
			$email_data = array (
					'EMAIL' => $_POST ['EMAIL'] 
			);
			$query = $this->db->select ( 'user_id' )->get_where ( 'user_basic', $email_data );
			if ($query->num_rows () > 0)
			{
				// 有資料
				$row = $query->row ();
				$USER_ID = $row->user_id;
			}
			else
			{
				// 無資料就加新的
				$query = $this->db->insert ( 'user_basic', $email_data );
				// 揣出來
				$query = $this->db->select ( 'user_id' )->get_where ( 'user_basic', $email_data );
				$row = $query->row ();
				$USER_ID = $row->user_id;
			}
			// pdf流水號記到資料庫
			FOR($SEED = 0; $SEED < $_POST ['Size']; $SEED ++)
			{
				
				// 更新產製資料
				$VCODE = returnValidation ();
				$data_list = array (
						'USER_ID' => $USER_ID,
						'DISTRICT_ID' => $_POST ['DISTRICT_ID'],
						'ID_LAST_FIVE' => SUBSTR ( $_POST ["IDNo_" . $SEED], 5 ),
						'VALIDATION_CODE' => $VCODE 
				);
				$this->db->insert ( 'proposal', $data_list );
				
				$query = $this->db->select ( 'proposal_id' )->get_where ( 'proposal', $data_list );
				$row = $query->row ();
				$proposal_id = $row->proposal_id;
				// 建立流水號
				$_POST ["SNo_" . $SEED] = "AP" . SPRINTF ( "%02d", $_POST ['DISTRICT_ID'] ) . "1" . SPRINTF ( "%06d", $proposal_id );
				// 設定 QR Code 檔案路徑
				$_POST ["QRImgPath_" . $SEED] = 'img/' . $_POST ["SNo_" . $SEED] . ".jpg";
				// 複製 QR Code 檔案
				copy ( "http://140.113.207.111:4000/QRCode/" . $_POST ["SNo_" . $SEED] . "&VC=" . $VCODE, $_POST ["QRImgPath_" . $SEED] );
				// print_r($stmt->errorInfo());
			}
		}
		
		require ('FPDF/chinese-unicode.php');
		$pdf = new PDF_Unicode ();
		
		$CHI_FONT = "DFKai-SB";
		$ENG_FONT = "DFKai-SB";
		$pdf->AddUniCNShwFont ( $CHI_FONT );
		
		$pdf->Open ();
		
		IF ($_POST ['DISTRICT_ID'] != "")
		{
			$data_list = array (
					'DISTRICT_ID' => $_POST ['DISTRICT_ID'] 
			);
			$query = $this->db->get_where ( 'district_data', $data_list );
			$DATA = $query->row_array ();
		}
		
		// DUMMY DATA
		IF ($DATA ['receiver'] == "")
		{
			$DATA ['reason'] = "罷免理由";
			$DATA ['notice'] = "注意事項";
			$DATA ['others'] = "其他";
			$DATA ['zipcode'] = "郵遞區號";
			$DATA ['mailing_address'] = "提議書郵寄地址";
			$DATA ['receiver'] = "提議書收件人";
		}
		$NAME = "提議人姓名";
		$IDNo = "A135792468";
		$SEX = "M";
		$BIRTHDAY = "YYYY.MM.DD";
		$OCCUPATION = "職業";
		$REGADD = "提案人戶籍地址";
		
		IF (! isset ( $_GET ['NO'] ))
		{
			$NO = 1;
		}
		else IF ($_GET ['NO'] > 0)
		{
			$NO = $_GET ['NO'];
		}
		
		// DUMMY DATA
		IF ($_POST ['Name_0'] == "")
		{
			$_POST ['Name_0'] = "馬娘娘";
			$_POST ['IDNo_0'] = "A246813579";
			$_POST ['Sex_0'] = "F";
			$_POST ['Birthday_0'] = "YYYY.MM.DD";
			$_POST ['Occupation_0'] = "孬孬";
			$_POST ['RegAdd_0'] = "魯蛇大本營";
			$_POST ['SNo_0'] = "123456789";
		}
		IF (! isset ( $_POST ['Name_1'] ))
		{
			$_POST ['Name_1'] = "金小刀";
			$_POST ['IDNo_1'] = "A135792468";
			$_POST ['Sex_1'] = "M";
			$_POST ['Birthday_1'] = "YYYY.MM.DD";
			$_POST ['Occupation_1'] = "孬孬";
			$_POST ['RegAdd_1'] = "魯蛇大本營";
			$_POST ['SNo_1'] = "987654321";
		}
		
		IF ($_POST ['Size'] == "")
		{
			$SIZE = 2;
		}
		else
		{
			$SIZE = $_POST ['Size'];
		}
		
		for($SEED = 0; $SEED < $SIZE; $SEED ++)
		{
			$NAME = $_POST ["Name_" . $SEED];
			$IDNo = $_POST ["IDNo_" . $SEED];
			$SEX = $_POST ["Sex_" . $SEED];
			$BIRTHDAY = $_POST ["Birthday_y_" . $SEED] . "-" . $_POST ["Birthday_m_" . $SEED] . "-" . $_POST ["Birthday_d_" . $SEED];
			$OCCUPATION = $_POST ["Occupation_" . $SEED];
			$REGADD = $_POST ["RegAdd_" . $SEED];
			$QRImgPath = "";
			IF ($_POST ["QRImgPath_" . $SEED] != "")
				$QRImgPath = $_POST ["QRImgPath_" . $SEED];
			$SNo = $_POST ["SNo_" . $SEED];
			
			generatePDF ( $pdf, $CHI_FONT, $ENG_FONT, $DATA, $NAME, $IDNo, $SEX, $BIRTHDAY, $OCCUPATION, $REGADD, $QRImgPath, $SNo );
		}
		
		$pdf->Output ();
	}
}