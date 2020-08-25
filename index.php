<?php
require_once "DBManager.php";
require_once "/var/www/html/temperature/sendDB.php";

try {
    $db=getDb();
    //$stt = $db->prepare('SELECT * FROM '.date('Y_m_d'));
    if($_GET['date']){
      $date=$_GET['date'];
    }else{
      $date=date('Y_m_d');
    }
    $stt = $db->prepare('SHOW TABLES');
    $stt->execute();
    while ($row=$stt->fetch(PDO::FETCH_ASSOC)) {
      foreach ($row as $value) {
        
        $res[]=$value;
      }
    }
  }catch(Exception $e){
    print $e;
  }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>chart</title>

</head>
<body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> 
   
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> 
<canvas id="myChart"></canvas>
<script src="js/index.js"></script>

<select class="date" name="date" onchange="change()">
  <?php foreach ($res as $value): ?>
<option value="<?= $value;?>"><?= $value;?></option>    
  <?php endforeach; ?>
</select>
<select class="range-from" name="ftom" >
  <?php for ($i=0; $i <24 ; $i++) {
print "<option value='{$i}'>{$i}</option>";
  } ?>
</select>
<select class="range-to" name="to" >
  <?php for ($i=0; $i <24 ; $i++) {
print "<option value='{$i}'>{$i}</option>";
  } ?>
</select>
<button type="button" name="button" onclick="setRange()">送信</button>
</body>
</html>
