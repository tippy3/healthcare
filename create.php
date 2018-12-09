<?php
$request = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : '';
if($request !== 'xmlhttprequest') exit;

define('PDO_DSN','pgsql:host=hogehoge.sfc.keio.ac.jp port=9999 dbname=hogehoge');
define('DB_username','hogehoge');
define('DB_password','hogehoge');/*取り扱い注意*/
define('queryText',"INSERT INTO healthcare VALUES(nextval('healthcare_id_seq'),?,?,?,?,?)");

$ymd = (int) htmlspecialchars($_POST['ymd'],ENT_QUOTES);
$maxval = (int) htmlspecialchars($_POST['maxval'],ENT_QUOTES);
$minval = (int) htmlspecialchars($_POST['minval'],ENT_QUOTES);
$rate = (int) htmlspecialchars($_POST['rate'],ENT_QUOTES);
$comment = htmlspecialchars($_POST['comment'],ENT_QUOTES);
$password = (int) htmlspecialchars($_POST['password'],ENT_QUOTES);

if ($password!="hogehoge"/*取り扱い注意*/){
	exit;
}

$comment = mb_convert_encoding($comment,"EUC-JP","UTF-8");

try{
	$db = new PDO(PDO_DSN, DB_username, DB_password);
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stmt = $db->prepare(queryText);	
	$stmt->execute([$ymd,$maxval,$minval,$rate,$comment]);    
   
	exit;

} catch (PDOException $e){
	// error
	echo $e->getMessage();
	exit;
}