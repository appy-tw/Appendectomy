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