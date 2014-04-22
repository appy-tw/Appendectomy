<BODY ONLOAD=initialPhase()>
<?php
	require_once "inc/sql.php";
	connect_valid();
	
	IF(TRIM($_POST[VILLAGE_NAME]!=""))
	{
		$FIRST_ARRAY=EXPLODE("投票率",$_POST[VILLAGE_NAME]);
		$QUERY_STRING="SELECT region_id,local_rep_elect_dist_name AS DISTNAME FROM local_representative_election_district_list WHERE local_rep_elect_dist_id='".$_POST[ELEDISTID]."'";
		$DISTDATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
		
		$FIRST_STRING=STR_REPLACE($DISTDATA[DISTNAME],"",$FIRST_ARRAY[1]);

	//GET CITY_ID
		$CITY_ID=$DISTDATA[region_id];
		
	//GET DIST_ID
		$DIST_ID=$_POST[DISTID];
		$QUERY_STRING="SELECT DISTRICT_NAME FROM DISTRICT_LIST WHERE DISTRICT_ID='".$DIST_ID."'";
		$DISTDATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
		$DISTRICT_NAME=$DISTDATA[DISTRICT_NAME];

		$SECOND_ARRAY=EXPLODE("\n",TRIM(STR_REPLACE($DISTRICT_NAME,"",$FIRST_STRING)));
		$NO_OF_LINES=SIZEOF($SECOND_ARRAY);
		FOR($SEED=0;$SEED<$NO_OF_LINES-1;$SEED++)
		{
			$THIRD_ARRAY=EXPLODE("\t",TRIM($SECOND_ARRAY[$SEED]));
	//		ECHO $SECOND_ARRAY[$SEED]."-".$THIRD_ARRAY[0]."-";
			
/*			ECHO $QUERY_STRING="SELECT VILLAGE_ID FROM VILLAGE_LIST WHERE DISTRICT_ID='".$DIST_ID."' AND VILLAGE_NAME='".$THIRD_ARRAY[0]."'";
			IF(MYSQL_NUM_ROWS(MYSQL_QUERY($QUERY_STRING))==0)
			{
				$QUERY_STRING="INSERT INTO VILLAGE_ID (VILLAGE_NAME,DISTRICT_ID)VALUES('".$THIRD_ARRAY[0]."','".$DIST_ID."')";
				MYSQL_QUERY($QUERY_STRING);
			}*/
			
			$QUERY_STRING="SELECT village_id FROM VILLAGE_TO_CITY WHERE CITY_ID='".$CITY_ID."' AND DISTRICT_ID='".$DIST_ID."' AND VILLAGE_NAME='".$THIRD_ARRAY[0]."'";
			$VILLAGE_DATA=MYSQL_FETCH_ARRAY(MYSQL_QUERY($QUERY_STRING));
			$VILLAGE_ID=$VILLAGE_DATA[village_id];
			$QUERY_STRING="UPDATE village_list SET CITY_LEVEL_REP_ELECT_N_DIST_ID='".$_POST[ELEDISTID]."' WHERE VILLAGE_ID='".$VILLAGE_ID."'";
			IF(MYSQL_QUERY($QUERY_STRING))
			{
				IF(MYSQL_AFFECTED_ROWS()>0)
				{
					ECHO $THIRD_ARRAY[0]."；";
				}
				ELSE
				{
					ECHO "<FONT COLOR=RED>".$THIRD_ARRAY[0]."；</FONT>";
				}
			}
		}
	}
	
	$QUERY_STRING="SELECT * FROM local_representative_election_district_list WHERE ELECTION_LEVEL='DIRECT_CITY'";
	$NO_OF_DATA=MYSQL_NUM_ROWS($RESULT=MYSQL_QUERY($QUERY_STRING));
	
	ECHO "<CENTER>";
	ECHO "<FORM ACTION=?ACT=INPUT METHOD=POST>";
	ECHO "<TABLE BORDER=1>
		<TR><TD COLSPAN=2>輸入選區村里</TD></TR>
		<TR><TD>選區名稱</TD><TD>";
	IF($NO_OF_DATA>0)
	{
		ECHO "<SELECT ID=ELEDISTID NAME=ELEDISTID ONCHANGE=loadDist()>";
		ECHO "<OPTION>選擇選區</OPTION>";
		FOR($SEED=0;$SEED<$NO_OF_DATA;$SEED++)
		{
			$DATA=MYSQL_FETCH_ARRAY($RESULT);
			ECHO "<OPTION VALUE='".$DATA[local_rep_elect_dist_id]."'";
			IF($_POST[ELEDISTID]==$DATA[local_rep_elect_dist_id])
				ECHO " SELECTED";
			ECHO ">".$DATA[local_rep_elect_dist_name]."</OPTION>";
		}
		ECHO "</SELECT>";
	}
	ECHO "</TD></TR>";
	ECHO "<TR><TD>鄉鎮市區</TD><TD><DIV ID=DISTNAME><INPUT TYPE=HIDDEN NAME=DISTID></DIV></TD></TR>";
	ECHO "<TR><TD>村里名稱</TD><TD><TEXTAREA NAME=VILLAGE_NAME COLS=50 ROWS=5></TEXTAREA></TD></TR>";
	ECHO "<TR><TD COLSPAN=2 ALIGN=RIGHT><INPUT TYPE=SUBMIT VALUE=送出></TD></TR>";
	ECHO "</TABLE>";
	ECHO "</FORM>";

?>

<SCRIPT>
var XMLHttpRequestObject = false;
var XMLHttpRequestObject2 = false;
var XMLHttpRequestObject3 = false;
var XMLHttpRequestObject4 = false;
var XMLHttpRequestObject5 = false;
var XMLHttpRequestObject6 = false;
var XMLHttpRequestObject7 = false;

function iniHttpRequestObject(obj)
{
	if(window.XMLHttpRequest)
	{
		obj = new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
		obj = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return obj;
}

function initialPhase()
{
	XMLHttpRequestObject=iniHttpRequestObject(XMLHttpRequestObject);
	XMLHttpRequestObject2=iniHttpRequestObject(XMLHttpRequestObject2);
	XMLHttpRequestObject3=iniHttpRequestObject(XMLHttpRequestObject3);
	XMLHttpRequestObject4=iniHttpRequestObject(XMLHttpRequestObject4);
	XMLHttpRequestObject5=iniHttpRequestObject(XMLHttpRequestObject5);
	XMLHttpRequestObject6=iniHttpRequestObject(XMLHttpRequestObject6);
	XMLHttpRequestObject7=iniHttpRequestObject(XMLHttpRequestObject7);
	loadDist();
}

function loadDist()
{
	loadData('showDistList.php?ELEDISTID='+document.getElementById('ELEDISTID').value,'DISTNAME');
}

function loadData(dataSource,DivID)
{
	document.getElementById(DivID).innerHTML=">>Loading<<";
	if(XMLHttpRequestObject)
	{
		var obj = document.getElementById(DivID);
		XMLHttpRequestObject.open("GET", dataSource);
		XMLHttpRequestObject.onreadystatechange = function()
		{
			if(XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
			{
				obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
		XMLHttpRequestObject.send(null);
	}
}

function loadDataObj(HttpObj,dataSource,DivID)
{
//	document.getElementById(DivID).innerHTML=">>Loading<<";
	if(HttpObj)
	{
		var obj = document.getElementById(DivID);
		HttpObj.open("GET", dataSource);
		HttpObj.onreadystatechange = function()
		{
			if(HttpObj.readyState == 4 && HttpObj.status == 200)
			{
				obj.innerHTML = HttpObj.responseText;
			}
		}
		HttpObj.send(null);
	}
}

function loadDataObjTo(HttpObj,dataSource,DivID,Direction,StartDataID,NO)
{
	dataSource=dataSource+"&DIR="+Direction+"&NO="+NO+"&STPID="+document.getElementById(StartDataID).value;
//	document.getElementById(DivID).innerHTML=">>Loading<<";
	if(HttpObj)
	{
		var obj = document.getElementById(DivID);
		HttpObj.open("GET", dataSource);
		HttpObj.onreadystatechange = function()
		{
			if(HttpObj.readyState == 4 && HttpObj.status == 200)
			{
				obj.innerHTML = HttpObj.responseText;
			}
		}
		HttpObj.send(null);
	}
}
</SCRIPT>