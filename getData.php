<?php
require_once "DBManager.php";

try {
    $db=getDb();
    //$stt = $db->prepare('SELECT * FROM '.date('Y_m_d'));
    if($_GET['date']){
      $date=$_GET['date'];
    }else{
      $date=date('Y_m_d');
    }
    $stt = $db->prepare('SELECT * FROM '.$date);
    $stt->execute();
    while ($row=$stt->fetch(PDO::FETCH_ASSOC)) {
        $res[]=$row;
    }
    // foreach ($res as &$value) {
    //   foreach ($value as $key => &$value2) {
    //     if($key=='time'){
    //       $value2=($value2-strtotime(date('Y/m/d')))/3600;
    //     }
    //   }  
    // }
    
    
    print json_encode($res);
} catch (\Exception $e) {
    print $e;
}finally{
  $_GET=[];
}
