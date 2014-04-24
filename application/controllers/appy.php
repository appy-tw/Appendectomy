<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Appy extends CI_Controller
{
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
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
	public function proposal()
	{
		$this->load->database ();

		IF ($_POST ['Size'] > 0)
		{
			// 依 constituency 取得立委 DISTRICT_ID
			IF (isset ( $_POST ['constituency'] ) && $_POST ['constituency'] != "")
			{

				$data_list = array (
						'CONSTITUENCY' => $_POST ['constituency']
				);
				$query = $this->db->select ( 'district_id' )->get_where ( 'user_basic', $email_data );
				if ($query->num_rows () > 0)
				{
					$_POST ['DISTRICT_ID'] = $query->row()->district_id;
				}
			}
			//揣（ㄘㄨㄝ）使用者資料
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
			//pdf流水號記到資料庫
			FOR($SEED = 0; $SEED < $_POST ['Size']; $SEED ++)
			{
				
				// 更新產製資料
				$VCODE = $this->returnValidation ();
				$data_list = array (
						'USER_ID' => $USER_ID,
						'DISTRICT_ID' => $_POST ['DISTRICT_ID'],
						'ID_LAST_FIVE' => SUBSTR ( $_POST ["IDNo_" . $SEED], 5 ),
						'VALIDATION_CODE' => $VCODE,
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
			$data_list=array('DISTRICT_ID'=>$_POST ['DISTRICT_ID']);
			$query = $this->db->get_where ( 'district_data', $data_list );
			$DATA = $query->row_array();
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
			
			$this->generatePDF ( $pdf, $CHI_FONT, $ENG_FONT, $DATA, $NAME, $IDNo, $SEX, $BIRTHDAY, $OCCUPATION, $REGADD, $QRImgPath, $SNo );
		}
		
		$pdf->Output ();
	}
	
	public function  input_proposal_form()
	{
		$this->load->database ();	
		ECHO "<CENTER><FORM NAME=DATAINPUT ACTION=proposalframe METHOD=POST>
		<TABLE BORDER=0 STYLE='FONT-SIZE:16'>
		<TR><TD STYLE='TEXT-ALIGN:CENTER;BACKGROUND-COLOR:#DDDDDD'>填寫提議表單</TD></TR>
		<TR><TD><INPUT TYPE=HIDDEN ID=Size NAME=Size VALUE=1>
			<TABLE BORDER=0 WIDTH=100%>
			<TR><TD STYLE='WIDTH:80;TEXT-ALIGN:CENTER'>電子信箱</TD><TD><INPUT TYPE=TEXT NAME=EMAIL STYLE='WIDTH:300;FONT-SIZE:16'></TD>
				<TD STYLE='WIDTH:100;TEXT-ALIGN:CENTER;BORDER:2px solid #666666'>
				<SPAN STYLE='CURSOR:POINTER;' ONCLICK=ADDFORM()>增加份數</SPAN>
				</TD>
				<TD ALIGN=CENTER>
					<SPAN STYLE='CURSOR:POINTER;COLOR:BLACK'><IMG SRC='info.png' STYLE='WIDTH:20' ALT='可製作數份罷免相同立委的提議書' TITLE='可製作數份罷免相同立委的提議書'></SPAN>
				</TD>
			</TR>
			<TR><TD STYLE='WIDTH:80;TEXT-ALIGN:CENTER'>罷免對象</TD><TD COLSPAN=3>";
	
			//揣（ㄘㄨㄝ）使用者資料
		
		$query = $this->db->get( 'district_data');
		if ($query->num_rows () > 0)
		{
			// 有資料
			$row = $query->row ();
			$USER_ID = $row->district_id;
		}
		
		$RESULT=$this->db->get('district_data');
		$NO_OF_DATA=$RESULT->num_rows();

		if ($NO_OF_DATA > 0)
		{
			ECHO "<SELECT NAME=DISTRICT_ID STYLE='WIDTH:300;HEIGHT:30;FONT-SIZE:16'>";
			FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
			{				
				$DATA=$query->result($RESULT);
				ECHO "<OPTION VALUE='".$DATA[district_id]."'>".$DATA[district_name]."．".$DATA[district_legislator]."．".$DATA[party_name].")</OPTION>";
			}
			ECHO "</SELECT>";
		}


		
// 		$data['Y'] = $this->RETURN_Y("Birthday_y_0","WIDTH:80;FONT-SIZE:16",1984);
// 		$data['M'] = $this->RETURN_M("Birthday_m_0","WIDTH:60;FONT-SIZE:16",1);
// 		$data['D'] = $this->RETURN_D("Birthday_d_0","WIDTH:60;FONT-SIZE:16",1);
// 		$data['DATA'] = $DATA;
		ECHO "</TD></TR>
		<TR><TD COLSPAN=4>
		<DIV ID=INPUTFORM>
			<DIV>
			<TABLE STYLE='BACKGROUND-COLOR:#DDDDDD'>
			<TR><TD STYLE='WIDTH:80;TEXT-ALIGN:CENTER'>1</TD>
				<TD>姓　　　名</TD><TD><INPUT TYPE=TEXT NAME=Name_0 STYLE='WIDTH:100;FONT-SIZE:16'></TD>
				<TD>身分證字號</TD><TD><INPUT TYPE=TEXT NAME=IDNo_0 STYLE='WIDTH:150;FONT-SIZE:16'></TD><TD><IMG SRC='info.png' STYLE='WIDTH:20;CURSOR:POINTER' ALT='請輸入半形英文數字' TITLE='請輸入半形英文數字'></TD></TR>
			<TR><TD></TD>
				<TD>性　　　別</TD><TD><INPUT TYPE=RADIO NAME=Sex_0 VALUE='M' CHECKED>男&nbsp;<INPUT TYPE=RADIO NAME=Sex_0 VALUE='F'>女</TD>
				<TD>出生年月日</TD><TD>";
							$this->load->helper('input_proposal_form');
							echo RETURN_Y("Birthday_y_0","WIDTH:80;FONT-SIZE:16",1984);
							echo RETURN_M("Birthday_m_0","WIDTH:60;FONT-SIZE:16",1);
							echo RETURN_D("Birthday_d_0","WIDTH:60;FONT-SIZE:16",1);
							ECHO "</TD><TD><IMG SRC='info.png' STYLE='WIDTH:20;CURSOR:POINTER' ALT='必須在 1992 年 1 月 13 日（含）以前才能提議或連署罷免' TITLE='必須在 1992 年 1 月 13 日（含）以前出生才能提議罷免'></TD></TR>
			<TR><TD></TD>
				<TD>職　　　業</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=Occupation_0 STYLE='WIDTH:100;FONT-SIZE:16'>（請勿超過４個字）</TD></TR>
			<TR><TD></TD>
				<TD>地　　　址</TD><TD COLSPAN=3><INPUT TYPE=TEXT NAME=RegAdd_0 STYLE='WIDTH:400;FONT-SIZE:16'></TD></TR>
			<TR><TD></TD><TD></TD><TD COLSPAN=3><IMG SRC='info.png' STYLE='WIDTH:20'><SPAN STYLE='HEIGHT:20;VERTICAL-ALIGN:TOP'>&nbsp;請完全依身分證背後地址欄內容填寫，鄰里勿漏</SPAN></TD></TR>
			</TABLE>
			</DIV>
		</DIV>
		<HR>
		</TD></TR>
		</TABLE></TD></TR>
		<TR><TD ALIGN=CENTER><INPUT TYPE=BUTTON ONCLICK=checkInput() VALUE='製作提議書' STYLE='HEIGHT:30;FONT-SIZE:16'></TD></TR>
		</TABLE>
		</FORM>";

		$this->load->view ( 'input_proposal_form');
	}
	
	public function proposalframe()
	{
		ECHO "<FORM NAME=TRANSFER ACTION='proposal' METHOD=POST TARGET=pdfframe>";
		while($element = current($_POST)) {
			echo "<INPUT TYPE=HIDDEN NAME=".key($_POST)." VALUE='".$_POST[key($_POST)]."'>";
			next($_POST);
		}
		ECHO "</FORM>";
		$this->load->view ( 'proposalframe' );
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */