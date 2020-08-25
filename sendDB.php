<?php
date_default_timezone_set('Asia/Tokyo');
require_once "/var/www/html/temperature/DBManager.php";
//create table t(id int primary key auto_increment,room_temp float,room_hum float,cpu float,time time);

$res=getTemp();


try {
    $db=getDb();
    $stt = $db->prepare('INSERT INTO '.date('Y_m_d').'(room_temp,room_hum, cpu, time) VALUES(:room_temp,:room_hum, :cpu, :time)');

    $stt->bindValue(':room_temp', $res[0]);
    $stt->bindValue(':room_hum', $res[1]);
    $stt->bindValue(':cpu', $res[2]);
    $stt->bindValue(':time', time());
    $stt->execute();
} catch (PDOException $e) {
    print $e;
}



function getTemp(){
	$str=shell_exec("sudo python /home/pi/work/BME280/BME2802/bme280_custom.py");
	$res=explode("\n", $str);
	foreach ($res as &$value) {
	    $value=trim($value);
	}
	unset($res[2]);
	$res = array_values($res);

	$str=shell_exec("sudo vcgencmd measure_temp");

	preg_match('/(\d+\.\d)/', $str, $output);
	$res[]=$output[0];
	return $res;
}