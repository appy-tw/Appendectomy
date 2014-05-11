<?php

	//條碼圖像路徑	
	$codeimgpath = $_GET['CODEIMG'];
	//取得條碼圖像尺寸
	list($width, $height) = getimagesize($codeimgpath);
	//建立條碼圖
	$codeimg = imagecreatefromjpeg($codeimgpath); 


	/* get mime-type for a specific file */
	//底圖短圖
	IF($_GET['BASE']==1)
	{
		$baseimgpath ="spot_base1.jpg";
		$baseimg = imagecreatefromjpeg($baseimgpath);
		$newwidth=263;
		$newheight=263;
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		//調整條碼圖像尺寸
		imagecopyresized($thumb, $codeimg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		//合併條碼圖及底圖
		imagecopymerge($baseimg, $thumb, 755, 806, 0, 0, $newwidth, $newheight, 100);
	}
	//底圖長圖
	ELSE IF($_GET['BASE']==2)
	{
		$baseimgpath ="spot_base2.jpg";
		$baseimg = imagecreatefromjpeg($baseimgpath);
		$newwidth=645;
		$newheight=645;
		$thumb = imagecreatetruecolor(645, 645);
		//調整條碼圖像尺寸
		imagecopyresized($thumb, $codeimg, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		//合併條碼圖及底圖
		imagecopymerge($baseimg, $thumb, 920, 2017, 0, 0, $newwidth, $newheight, 100);
	}


	IF($_GET['BASE']==1)
	{
	}
	ELSE IF($_GET['BASE']==2)
	{
	}

	Header ('Content-type: image/jpeg');
	ImageJPEG($baseimg);
	ImageDestroy($baseimg);
	ImageDestroy($codeimg);
	ImageDestroy($thumb);


php?>