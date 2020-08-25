<?php 
require_once "/var/www/html/temperature/DBManager.php";


try {
  $db=getDb();
  $stt = $db->prepare('CREATE TABLE '.date('Y_m_d').'(id int primary key auto_increment,room_temp float,room_hum float,cpu float,time int)');

  $stt->execute();
} catch (\Exception $e) {
  print $e;
}
