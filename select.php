<?php
$request = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : '';
if($request !== 'xmlhttprequest') exit;

define('PDO_DSN','pgsql:host=hogehoge.sfc.keio.ac.jp port=9999 dbname=hogehoge');
define('DB_username','hogehoge');
define('DB_password','hogehoge');/*取り扱い注意*/
define('queryText','SELECT * FROM healthcare ORDER BY ymd');

try{
	$db = new PDO(PDO_DSN, DB_username, DB_password);
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stmt = $db->prepare(queryText);
	$stmt->execute();

	while($record = $stmt->fetch(PDO::FETCH_ASSOC)){
		$answer[] = array(
			/* PHPはEUC-JPを使えないと気づくまで２時間格闘しました */
			'id' => mb_convert_encoding($record["id"],"UTF-8","EUC-JP"),
			'ymd' => mb_convert_encoding($record["ymd"],"UTF-8","EUC-JP"),
			'maxval' => mb_convert_encoding($record["maxval"],"UTF-8","EUC-JP"),
			'minval' => mb_convert_encoding($record["minval"],"UTF-8","EUC-JP"),
			'rate' => mb_convert_encoding($record["rate"],"UTF-8","EUC-JP"),
			'comment' => mb_convert_encoding($record["comment"],"UTF-8","EUC-JP")
        );
	}

	header('Content-Type: application/json');
	echo json_encode($answer);
    
	exit;

} catch (PDOException $e){
	// error
	echo $e->getMessage();
	exit;
}