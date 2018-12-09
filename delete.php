<?php
$request = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : '';
if($request !== 'xmlhttprequest') exit;

define('PDO_DSN','pgsql:host=hogehoge.sfc.keio.ac.jp port=9999 dbname=hogehoge');
define('DB_username','hogehoge');
define('DB_password','hogehoge');/*取り扱い注意*/
define('queryText',"DELETE FROM healthcare WHERE id=?");

$id = (int) htmlspecialchars($_POST['id'],ENT_QUOTES);
$password = (int) htmlspecialchars($_POST['password'],ENT_QUOTES);

if ($password!="hogehoge"/*取り扱い注意*/){
	exit;
}

try{
	$db = new PDO(PDO_DSN, DB_username, DB_password);
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stmt = $db->prepare(queryText);	
	$stmt->execute([$id]);    
   
	exit;

} catch (PDOException $e){
	// error
	echo $e->getMessage();
	exit;
}