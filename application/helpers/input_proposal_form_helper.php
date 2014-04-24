<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('RETURN_Y'))
{
	function RETURN_Y($NAME,$STYLE,$DEFAULT)
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
}

if ( ! function_exists('RETURN_M'))
{
	function RETURN_M($NAME,$STYLE,$DEFAULT)
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
}

if ( ! function_exists('RETURN_D'))
{
	function RETURN_D($NAME,$STYLE,$DEFAULT)
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
}