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

//  		require_once "inc/sql.php";
//  		connect_valid();
		$this->load->database ();
		ECHO "<CENTER><FORM NAME=DATAINPUT ACTION=proposalframe.php METHOD=POST>
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

		if ($query->num_rows () > 0)
		{
			ECHO "<SELECT NAME=DISTRICT_ID STYLE='WIDTH:300;HEIGHT:30;FONT-SIZE:16'>";
			FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
			{				
				$DATA=$query->result($RESULT);
				ECHO "<OPTION VALUE='".$DATA[district_id]."'>".$DATA[district_name]."．".$DATA[district_legislator]."．".$DATA[party_name].")</OPTION>";
			}
			ECHO "</SELECT>";
		}
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
							$this->RETURN_Y("Birthday_y_0","WIDTH:80;FONT-SIZE:16",1984);
							$this->RETURN_M("Birthday_m_0","WIDTH:60;FONT-SIZE:16",1);
							$this->RETURN_D("Birthday_d_0","WIDTH:60;FONT-SIZE:16",1);
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
	
		$this->load->view ( 'input_proposal_form' );
	}
	
	public function proposalframe()
	{
		ECHO "<FORM NAME=TRANSFER ACTION='../index.php/appy/proposal' METHOD=POST TARGET=pdfframe>";
		while($element = current($_POST)) {
			echo "<INPUT TYPE=HIDDEN NAME=".key($_POST)." VALUE='".$_POST[key($_POST)]."'>";
			next($_POST);
		}
		ECHO "</FORM>";
		$this->load->view ( 'proposalframe' );
	}
	
	protected function RETURN_Y($NAME,$STYLE,$DEFAULT)
	{
		ECHO "<SELECT NAME='".$NAME."' STYLE='".$STYLE."'>";
		$START=date('Y');
		FOR($SEED=22;$SEED<120;$SEED++)
		{
			ECHO "<OPTION VALUE='".($START-$SEED)."' ";
			IF($SEED==$DEFAULT)
			ECHO "SELECTED";
			ECHO ">".($START-$SEED)." 年</OPTION>";
		}
		ECHO "</SELECT>";
	}	
	
	protected function RETURN_M($NAME,$STYLE,$DEFAULT)
	{
		ECHO "<SELECT NAME='".$NAME."' STYLE='".$STYLE."'>";
		FOR($SEED=1;$SEED<13;$SEED++)
		{
			ECHO "<OPTION VALUE='".$SEED."' ";
			IF($SEED==$DEFAULT)
			ECHO "SELECTED";
			ECHO ">".$SEED." 月</OPTION>";
		}
		ECHO "</SELECT>";
	}	
	
	protected FUNCTION RETURN_D($NAME,$STYLE,$DEFAULT)
	{
		ECHO "<SELECT NAME='".$NAME."' STYLE='".$STYLE."'>";
		FOR($SEED=1;$SEED<32;$SEED++)
		{
		ECHO "<OPTION VALUE='".$SEED."' ";
				IF($SEED==$DEFAULT)
				ECHO "SELECTED";
				ECHO ">".$SEED." 日</OPTION>";
		}
		ECHO "</SELECT>";
	}
	
	protected function dashLine($pdf, $STARTX, $STARTY, $ENDX, $ENDY, $DASHWIDTH, $SPACING)
	{
		$pdf->SetLineWidth ( 0.1 );
		$SKIPWIDTH = $DASHWIDTH + $SPACING;
		FOR($SEED = 1; $SEED < $ENDX; $SEED = $SEED + $SKIPWIDTH)
		{
			$pdf->Line ( $STARTX + $SEED, $STARTY, ($STARTX + $DASHWIDTH) + $SEED, $ENDY );
		}
	}
	
	protected function returnValidation()
	{
		// $BASESTRING="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$BASESTRING = "0123456789";
		$FINALSTRING = '';
		FOR($SEED = 0; $SEED < 30; $SEED ++)
		{
			$FINALSTRING .= $BASESTRING [RAND ( 0, 9 )];
		}
		RETURN $FINALSTRING;
	}
	protected function generatePDF($pdf, $CHI_FONT, $ENG_FONT, $DATA, $NAME, $IDNo, $SEX, $BIRTHDAY, $OCCUPATION, $REGADD, $QRImgPath, $SNo)
	{
		$pdf->AddPage ();
		$pdf->SetFont ( $CHI_FONT, '', 14 );
		$pdf->SetFillColor ( 255, 255, 255 );
		$pdf->SetTextColor ( 0, 0, 0 );
		$pdf->Cell ( 0, 1, '', 0, 1 );
		
		$add_offset = 104;
		$form_offset = 213;
		$first_line = 104;
		$second_line = 203;
		
		// 說明資訊列===================================
		IF (isset ( $DATA ['prodescimgpath'] ))
		{
			$pdf->Image ( $DATA ['prodescimgpath'], 0, 0, 210 );
		}
		else
		{
			$pdf->SetXY ( 10, 11 );
			$pdf->SetFillColor ( 200, 200, 200 );
			$pdf->Cell ( 150, 50, $DATA ['reason'], 1, 1, 'C', true );
			$pdf->SetXY ( 10, 63 );
			$pdf->SetFillColor ( 150, 150, 150 );
			$pdf->Cell ( 150, 30, $DATA ['notice'], 1, 1, 'C', true );
			$pdf->SetXY ( 163, 10 );
			$pdf->SetFillColor ( 100, 100, 100 );
			$pdf->Cell ( 40, 83, $DATA ['others'], 1, 1, 'C', true );
		}
		
		// 地址資訊列===================================
		$pdf->SetXY ( 175, 5 + $add_offset );
		$pdf->Cell ( 20, 25, '郵票', 1, 1, 'C', false );
		
		if (isset ( $DATA ['prepaid'] ) && $DATA ['prepaid'] == 1)
		{
			$pdf->Image ( "adv_mail.jpg", 0, $add_offset, 210 );
			$pdf->SetXY ( 141.1, 14.7 + $add_offset );
			$pdf->SetFont ( $CHI_FONT, '', 11 );
			$pdf->Cell ( 41.5, 7.4, $DATA ['postoffice'] . "郵局登記證", 0, 0, 'C', false );
			$pdf->SetXY ( 141.1, 22.1 + $add_offset );
			$pdf->Cell ( 41.5, 7.4, $DATA ['adv_no'], 0, 0, 'C', false );
		}
		
		$pdf->SetFont ( $CHI_FONT, '', 20 );
		$pdf->SetXY ( 60, 55 + $add_offset );
		$pdf->Cell ( 0, 8, $DATA ['zipcode'], 0, 1, 'L', false );
		$pdf->SetXY ( 60, 63 + $add_offset );
		$pdf->Cell ( 0, 8, $DATA ['mailing_address'], 0, 0, 'L', false );
		$pdf->SetXY ( 60, 76 + $add_offset );
		$pdf->Cell ( 0, 8, $DATA ['receiver'] . '　啟', 0, 0, 'L', false );
		
		if ($QRImgPath != "")
		{
			// QR Code 影像
			$pdf->Image ( $QRImgPath, 10, 1 + $add_offset, 33 );
			// 刪除 QR Code 影像
			unlink ( $QRImgPath );
			$pdf->SetXY ( 10, 28 + $add_offset );
			$pdf->SetFont ( $CHI_FONT, '', 14 );
			$pdf->Cell ( 33, 12, $SNo, 0, 1, 'C', false );
		}
		// 提議書表單列===================================
		$pdf->SetXY ( 5, 5 + $form_offset );
		$pdf->SetFont ( $CHI_FONT, '', 24 );
		$pdf->Cell ( 205, 8, '公職人員罷免提議人名冊', 0, 0, 'C', false );
		$pdf->SetFont ( $CHI_FONT, '', 18 );
		
		// $pdf->Cell(0,2,'',0,1);
		
		$pdf->SetXY ( 5, 15 + $form_offset );
		$pdf->SetFont ( $CHI_FONT, '', 12 );
		$pdf->SetFillColor ( 255, 255, 255 );
		$pdf->SetTextColor ( 0, 0, 0 );
		// TODO
		$pdf->Cell ( 200, 8, $DATA ['district_name'] . '立法委員' . $DATA ['district_legislator'] . '罷免案提議人名冊', 1, 1, 'C', false );
		
		$pdf->SetXY ( 5, 23 + $form_offset );
		$pdf->SetFont ( $CHI_FONT, '', 14 );
		$pdf->Cell ( 12, 16, '編號', 1, 0, 'C', true );
		$pdf->Cell ( 40, 8, '姓名', 1, 0, 'C', false );
		$pdf->Cell ( 8, 16, '', 1, 0, 'C', true );
		$pdf->Cell ( 26, 16, '', 1, 0, 'C', true );
		$pdf->Cell ( 20, 16, '職業', 1, 0, 'C', true );
		$pdf->Cell ( 62, 16, '戶籍地址', 1, 0, 'C', true );
		$pdf->Cell ( 20, 16, '', 1, 0, 'C', true );
		$pdf->Cell ( 12, 16, '備註', 1, 0, 'C', true );
		$pdf->Cell ( 20, 8, '', 0, 1 );
		// $pdf->Cell(1);
		$pdf->SetFont ( $CHI_FONT, '', 14 );
		$pdf->SetTextColor ( 0, 0, 0 );
		$pdf->SetXY ( 17, 31 + $form_offset );
		$pdf->Cell ( 40, 8, '身分證字號', 1, 0, 'C', true );
		$pdf->Cell ( 20, 8, '', 0, 1 );
		
		$pdf->SetXY ( 51, 24 + $form_offset );
		$pdf->Cell ( 20, 8, '性', 0, 0, 'C', false );
		$pdf->SetXY ( 51, 30 + $form_offset );
		$pdf->Cell ( 20, 8, '別', 0, 0, 'C', false );
		
		$pdf->SetXY ( 173, 24 + $form_offset );
		$pdf->Cell ( 20, 8, '簽　名', 0, 0, 'C', false );
		$pdf->SetXY ( 173, 30 + $form_offset );
		$pdf->Cell ( 20, 8, '或蓋章', 0, 0, 'C', false );
		
		$pdf->SetXY ( 66, 24 + $form_offset );
		$pdf->Cell ( 24, 8, '出　生', 0, 0, 'C', false );
		$pdf->SetXY ( 66, 30 + $form_offset );
		$pdf->Cell ( 24, 8, '年月日', 0, 0, 'C', false );
		
		$pdf->Cell ( 20, 8, '', 0, 1 );
		
		$pdf->SetXY ( 5, 39 + $form_offset );
		
		$pdf->Cell ( 12, 20, '', 1, 0, 'C', true );
		$pdf->Cell ( 40, 8, $NAME, 1, 0, 'C', false );
		IF ($SEX == "M" || $SEX == "男")
			$SEX_STRING = "男";
		else
			$SEX_STRING = "女";
		$pdf->Cell ( 8, 20, $SEX_STRING, 1, 0, 'C', true );
		$pdf->Cell ( 26, 20, $BIRTHDAY, 1, 0, 'C', true );
		$pdf->Cell ( 20, 20, $OCCUPATION, 1, 0, 'C', true );
		$pdf->Cell ( 62, 20, '', 1, 0, 'C', false );
		$pdf->Cell ( 20, 20, '', 1, 0, 'C', true );
		$pdf->Cell ( 12, 20, '', 1, 0, 'C', true );
		$pdf->Cell ( 20, 8, '', 0, 1 );
		// $pdf->Cell(1);
		$pdf->SetFont ( $CHI_FONT, '', 14 );
		$pdf->SetTextColor ( 0, 0, 0 );
		$pdf->SetXY ( 17, 47 + $form_offset );
		$pdf->Cell ( 4, 12, $IDNo [0], 1, 0, 'C', true );
		$pdf->Cell ( 4, 12, $IDNo [1], 1, 0, 'C', true );
		$pdf->Cell ( 4, 12, $IDNo [2], 1, 0, 'C', true );
		$pdf->Cell ( 4, 12, $IDNo [3], 1, 0, 'C', true );
		$pdf->Cell ( 4, 12, $IDNo [4], 1, 0, 'C', true );
		$pdf->Cell ( 4, 12, $IDNo [5], 1, 0, 'C', true );
		$pdf->Cell ( 4, 12, $IDNo [6], 1, 0, 'C', true );
		$pdf->Cell ( 4, 12, $IDNo [7], 1, 0, 'C', true );
		$pdf->Cell ( 4, 12, $IDNo [8], 1, 0, 'C', true );
		$pdf->Cell ( 4, 12, $IDNo [9], 1, 0, 'C', true );
		$pdf->Cell ( 20, 8, '', 0, 1 );
		
		$this->dashLine ( $pdf, 5, $first_line, 200, $first_line, 2, 2 );
		$this->dashLine ( $pdf, 5, $second_line, 200, $second_line, 2, 2 );
		
		$ADDLEN = MB_STRLEN ( $REGADD );
		$WORDPERLINE = 12;
		$LINE = ($ADDLEN - $ADDLEN % $WORDPERLINE) / $WORDPERLINE;
		IF (($ADDLEN % $WORDPERLINE) > 0)
		{
			$LINE ++;
		}
		IF ($LINE == "" || $LINE == 0)
			$LINE = 1;
		$HEIGHT = 20 / $LINE;
		FOR($LINESEED = 0; $LINESEED < $LINE; $LINESEED ++)
		{
			$pdf->SetXY ( 111, 39 + $form_offset + $LINESEED * $HEIGHT );
			$pdf->Cell ( 62, $HEIGHT, MB_SUBSTR ( $REGADD, $LINESEED * $WORDPERLINE, $WORDPERLINE ), 'C', false );
		}
		
		$pdf->SetXY ( 95, 2 );
		$pdf->SetFont ( $CHI_FONT, '', 10 );
		$pdf->Cell ( 24, 7, "請以膠帶黏貼", 1, 0, 'C', true );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */