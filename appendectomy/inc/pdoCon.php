<?php
function db_connect($dbname, $user, $password, $dbtype = 'mysql', $host = 'localhost', $port = '5432')
{
	$dsn = "{$dbtype}:dbname={$dbname};host={$host};port={$port}";
	
	try
	{
		$dbh = new PDO ( $dsn, $user, $password );
	} catch ( PDOException $e )
	{
		echo 'Connection failed: ' . $e->getMessage ();
	}
	$dbh->query ( "set names utf8" );
	
	return $dbh;
}
function db_disconnect($dbh)
{
	$dbh = NULL;
}
function printErrorInfo($stmt)
{
	$arr = $stmt->errorInfo ();
	if ($arr [0] !== '00000')
	{
		echo "\nPDOStatement::errorInfo():\n";
		print_r ( $arr );
		exit ( - 1 );
	}
}

?>
