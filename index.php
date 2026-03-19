<?php
defined('INDEX_AUTH') OR die('Direct access not allowed!');
require SB.'admin/default/session.inc.php';
date_default_timezone_set('Asia/Jakarta');
global $dbs,$sysconf;

$start=$_GET['start']??date('Y-m-01');
$end=$_GET['end']??date('Y-m-d');
$where=" AND survey_date BETWEEN '$start' AND '$end'";

$total=$dbs->query("SELECT COUNT(*) t FROM library_need_survey WHERE 1=1 $where")->fetch_assoc()['t'];
$showChart=$total>=50;

/* MAPPING SESUAI FORM TERBARU */
$q_label=[
'q1'=>[1=>'Setiap hari',2=>'2-3x/minggu',3=>'1x/minggu',4=>'Jarang'],
'q2'=>[1=>'0 buku',2=>'1-2 buku',3=>'3-5 buku',4=>'>5 buku'],
'q3'=>[1=>'Pelajaran',2=>'Novel',3=>'Motivasi',4=>'Teknologi',5=>'Non-Fiksi',6=>'Biografi'],
'q4'=>[1=>'Fiksi',2=>'Non-Fiksi',3=>'Pelajaran',4=>'Referensi',5=>'Pengembangan diri',6=>'Kearifan Lokal',7=>'Persiapan Tes',8=>'Anak'],
'q5'=>[1=>'Mengerjakan tugas',2=>'Menambah wawasan',3=>'Hiburan',4=>'Karir'],
'q6'=>[1=>'>5x/minggu',2=>'3-4x/minggu',3=>'1-2x/minggu',4=>'Jarang',5=>'Tidak pernah'],
'q7'=>[1=>'Buku tidak tersedia',2=>'Koleksi kurang lengkap',3=>'Waktu terbatas',4=>'Suasana kurang nyaman'],
'q8'=>[1=>'Ya',2=>'Tidak'],
'q9'=>[1=>'Buku',2=>'HP',3=>'Laptop'],
'q10'=>[1=>'Rekomendasi buku',2=>'Notifikasi pengingat',3=>'Pencarian online',4=>'Akses ebook'],
'q11'=>[1=>'Lomba membaca',2=>'Bedah buku',3=>'Reading challenge',4=>'Menulis/review',5=>'Diskusi buku',6=>'Workshop'],
'q12'=>[1=>'Koleksi buku',2=>'Fasilitas',3=>'Sistem layanan',4=>'Pelayanan']
];

$kategori=[
'Kebiasaan Membaca'=>['q1','q2','q3'],
'Kebutuhan Buku'=>['q4','q5'],
'Kunjungan'=>['q6','q7'],
'Literasi Digital'=>['q8','q9','q10'],
'Program'=>['q11'],
'Pengembangan'=>['q12']
];

$charts=[];$analisa=[];

foreach($kategori as $kat=>$qs){
foreach($qs as $q){
$res=$dbs->query("SELECT $q val,COUNT(*) total FROM library_need_survey WHERE 1=1 $where AND $q!='' GROUP BY $q");
$labels=[];$values=[];
while($r=$res->fetch_assoc()){
$label=$q_label[$q][$r['val']]??$r['val'];
$labels[]=$label;$values[]=(int)$r['total'];
}
if($labels){
$charts[$kat][$q]=['labels'=>$labels,'values'=>$values];
$max_i=array_keys($values,max($values))[0];
$analisa[$q]=$labels[$max_i];
}
}
}

$saran=$dbs->query("SELECT member_name,member_class,kebutuhan_text FROM library_need_survey WHERE 1=1 $where AND kebutuhan_text!='' ORDER BY survey_date DESC LIMIT 50");
$kelas=$dbs->query("SELECT member_class,COUNT(*) total FROM library_need_survey WHERE 1=1 $where GROUP BY member_class ORDER BY total DESC LIMIT 10");
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.wrap{max-width:1100px;margin:auto;padding:15px}
.stat{background:#1565d8;color:#fff;padding:15px;border-radius:8px;text-align:center;margin-bottom:15px}
.cat{background:#f9fbff;padding:12px;border-radius:10px;margin-bottom:15px}
.cat h3{margin:0 0 8px;font-size:16px;text-align:center}
.row{display:flex;flex-wrap:wrap;gap:10px;justify-content:center}
.item{width:170px;text-align:center}
.item canvas{max-height:150px}
table{width:100%;border-collapse:collapse;margin-top:10px}
th,td{border:1px solid #ddd;padding:6px;text-align:center}
.filter{margin-bottom:10px}
button{padding:5px 10px;background:#1565d8;color:#fff;border:none;border-radius:4px}
@media print{.filter,button{display:none}}
</style>

<div class="menuBox"><div class="menuBoxInner reportingIcon"><div class="wrap">

<div class="filter">
<form method="get" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
<input type="hidden" name="mod" value="<?= $_GET['mod']??'' ?>">
<input type="hidden" name="id" value="<?= $_GET['id']??'' ?>">
<input type="date" name="start" value="<?= $start ?>"> s/d
<input type="date" name="end" value="<?= $end ?>">
<button type="submit">Filter</button>
<button type="button" onclick="window.print()">Print</button>
</form>
</div>

<h2 style="text-align:center">Survey Kebutuhan Pemustaka</h2>
<div style="text-align:center"><?= $start ?> s.d <?= $end ?></div>

<div class="stat">Total Responden<br><?= $total ?></div>

<?php if($showChart){foreach($charts as $kat=>$qset){ ?>
<div class="cat"><h3><?= $kat ?></h3><div class="row">
<?php foreach($qset as $id=>$c){ ?>
<div class="item"><div style="font-size:12px"><?= strtoupper($id) ?></div><canvas id="c_<?= $id ?>"></canvas></div>
<?php } ?>
</div></div>
<?php }} ?>

<h3>Analisa</h3>
<ul>
<li>Frekuensi membaca: <?= $analisa['q1']??'-' ?></li>
<li>Jumlah buku/bulan: <?= $analisa['q2']??'-' ?></li>
<li>Jenis bacaan favorit: <?= $analisa['q3']??'-' ?></li>
<li>Kebutuhan buku terbanyak: <?= $analisa['q4']??'-' ?></li>
<li>Tujuan membaca: <?= $analisa['q5']??'-' ?></li>
<li>Frekuensi kunjungan: <?= $analisa['q6']??'-' ?></li>
<li>Kendala utama: <?= $analisa['q7']??'-' ?></li>
<li>Minat ebook: <?= $analisa['q8']??'-' ?></li>
<li>Media membaca: <?= $analisa['q9']??'-' ?></li>
<li>Fitur diharapkan: <?= $analisa['q10']??'-' ?></li>
<li>Program favorit: <?= $analisa['q11']??'-' ?></li>
<li>Prioritas pengembangan: <?= $analisa['q12']??'-' ?></li>
</ul>

<h3>Saran</h3>
<table>
<tr><th>Nama</th><th>Kelas</th><th>Saran</th></tr>
<?php while($r=$saran->fetch_assoc()){ ?>
<tr><td><?= $r['member_name'] ?></td><td><?= $r['member_class'] ?></td><td><?= $r['kebutuhan_text'] ?></td></tr>
<?php } ?>
</table>

<h3>Per Kelas</h3>
<table>
<tr><th>Kelas</th><th>Jumlah</th></tr>
<?php while($r=$kelas->fetch_assoc()){ ?>
<tr><td><?= $r['member_class'] ?></td><td><?= $r['total'] ?></td></tr>
<?php } ?>
</table>

</div></div></div>

<?php if($showChart){ ?>
<script>
<?php foreach($charts as $kat=>$qset){foreach($qset as $id=>$c){ ?>
new Chart(document.getElementById('c_<?= $id ?>'),{type:'pie',data:{labels:<?= json_encode($c['labels']) ?>,datasets:[{data:<?= json_encode($c['values']) ?>,backgroundColor:['#1565d8','#2e7d32','#ef6c00','#6a1b9a','#c62828','#00838f','#ad1457','#ff8f00']}]},options:{plugins:{legend:{display:false}}}});
<?php }} ?>
</script>
<?php } ?>