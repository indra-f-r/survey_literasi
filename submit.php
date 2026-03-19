<?php
define('INDEX_AUTH',1);
require '../../sysconfig.inc.php';
date_default_timezone_set('Asia/Jakarta');
global $dbs;

if($_SERVER['REQUEST_METHOD']!='POST')die("Invalid request");

$member_id=$dbs->escape_string($_POST['member_id']??'');
$member_name=$dbs->escape_string($_POST['member_name']??'');
$member_class=$dbs->escape_string($_POST['member_class']??'');
if(!$member_id)die("Member tidak valid");

$check=$dbs->query("SELECT id FROM library_need_survey WHERE member_id='$member_id' AND survey_date=CURDATE()");
if($check->num_rows>0)die("Anda sudah mengisi survey hari ini");

$answers=[];
for($i=1;$i<=12;$i++){
if(!isset($_POST["q$i"]))die("Semua pertanyaan wajib diisi");
$val=(int)$_POST["q$i"];
if($val<1||$val>10)die("Nilai tidak valid");
$answers[$i]=$val;
}

$kebutuhan_text='';
if(isset($_POST['kebutuhan_text']))$kebutuhan_text=substr($dbs->escape_string($_POST['kebutuhan_text']),0,255);

$sql="INSERT INTO library_need_survey
(member_id,member_name,member_class,survey_date,
q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,q11,q12,
kebutuhan_text,created_at)
VALUES
('$member_id','$member_name','$member_class',CURDATE(),
'{$answers[1]}','{$answers[2]}','{$answers[3]}','{$answers[4]}','{$answers[5]}','{$answers[6]}',
'{$answers[7]}','{$answers[8]}','{$answers[9]}','{$answers[10]}','{$answers[11]}','{$answers[12]}',
'$kebutuhan_text',NOW())";
$dbs->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Survey Berhasil</title>
<style>
body{margin:0;font-family:Arial;background:#1565d8;display:flex;justify-content:center;align-items:center;height:100vh}
.box{background:#fff;padding:25px;border-radius:12px;width:90%;max-width:400px;text-align:center;box-shadow:0 5px 20px rgba(0,0,0,.2)}
h2{margin:0 0 10px}
.count{font-size:40px;font-weight:bold;color:#1565d8;margin:10px 0}
.bar{height:6px;background:#eee;border-radius:5px;overflow:hidden}
.bar div{height:100%;width:100%;background:#1565d8;animation:load 3s linear forwards}
button{margin-top:15px;padding:10px 20px;border:none;border-radius:6px;background:#1565d8;color:#fff}
@keyframes load{from{width:100%}to{width:0}}
</style>
</head>
<body>

<div class="box">
<h2>Survey Berhasil</h2>
<p>Terima kasih</p>
<div class="count" id="count">3</div>
<p>Kembali ke beranda...</p>
<div class="bar"><div></div></div>
<button onclick="goNow()">Kembali Sekarang</button>
</div>

<script>
let t=3,el=document.getElementById('count');
let timer=setInterval(()=>{t--;el.innerText=t;if(t<=0){clearInterval(timer);goNow();}},1000);
function goNow(){window.location.href='../../';}
</script>

</body>
</html>