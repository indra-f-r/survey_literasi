<?php
if(!defined('INDEX_AUTH'))define('INDEX_AUTH',1);
require_once __DIR__.'/../../sysconfig.inc.php';
global $sysconf;
?>
<!DOCTYPE html>
<html>
<head>
<title>Survey Kebutuhan Literasi</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
*{box-sizing:border-box}
body{font-family:Arial;background:#f4f6f9;margin:0;padding:10px}
.container{max-width:700px;margin:auto;background:#fff;padding:15px;border-radius:10px}
.header{text-align:center;margin-bottom:15px}
.header img{max-height:80px;margin-bottom:5px}
h2{margin:5px 0;font-size:20px}
h3{margin:0;font-size:14px;color:#555}
.section{margin-top:15px;padding:15px;background:#fff;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,.05)}
.section h3{margin:0 0 10px;font-size:15px;border-bottom:2px solid #1565d8;padding-bottom:5px}
.form-group{margin-bottom:12px}
label{font-weight:bold;font-size:14px;margin-bottom:5px;display:block}
input[type=text],textarea{width:100%;padding:10px;border:1px solid #ccc;border-radius:5px;font-size:14px}
.row{display:flex;gap:10px}
.col{flex:1}
.option{border:1px solid #ddd;padding:12px;border-radius:8px;margin-bottom:8px;display:flex;align-items:center;gap:10px;background:#fafafa;cursor:pointer}
.option:hover{background:#e3f2fd;border-color:#1565d8}
.option input{transform:scale(1.2);pointer-events:none}
button{margin-top:15px;width:100%;padding:12px;background:#1565d8;color:#fff;border:none;border-radius:5px;font-size:16px}
#memberResult{border:1px solid #ccc;background:#fff;max-height:200px;overflow:auto}
.member-result{padding:8px;border-bottom:1px solid #eee;cursor:pointer}
.member-result:hover{background:#f1f1f1}
#math_msg{font-size:12px;margin-top:5px;display:none}
@media(max-width:768px){body{padding:6px}.container{padding:12px}.row{flex-wrap:wrap}}
</style>
</head>
<body>

<div class="container">

<div class="header">
<?php if(!empty($sysconf['logo'])){ ?><img src="../../images/<?php echo $sysconf['logo']; ?>"><?php } ?>
<h1>Survey Kebutuhan Literasi</h1>
<h2><?= $sysconf['library_name']??'Perpustakaan' ?></h2>
<h3><?= $sysconf['library_subname']??'' ?></h3>
</div>

<form method="post" action="plugins/survey_kebutuhan/submit.php">

<div class="section">
<div class="form-group">
<label>Nama Anggota</label>
<input type="text" id="searchMember" placeholder="Ketik nama anggota">
<div id="memberResult"></div>
</div>

<div class="form-group">
<div class="row">
<div class="col">
<label>Member ID</label>
<input type="text" name="member_id" id="member_id" readonly required>
</div>
<div class="col">
<label>Kelas / Grup</label>
<input type="text" name="member_class" id="member_class" readonly required>
</div>
</div>
</div>
<input type="hidden" name="member_name" id="member_name">
</div>

<?php
function q($n,$l,$o){
echo "<div class='form-group'><label>$l</label>";
foreach($o as $v=>$t)echo "<label class='option'><input type='radio' name='$n' value='$v' required>$t</label>";
echo "</div>";
}
?>

<div class="section"><h3>Kebiasaan Membaca</h3>
<?php
q('q1','Seberapa sering Anda membaca buku?',[1=>'Setiap hari',2=>'2-3x/minggu',3=>'1x/minggu',4=>'Jarang']);
q('q2','Berapa jumlah buku yang Anda baca dalam satu bulan?',[1=>'0 buku',2=>'1-2 buku',3=>'3-5 buku',4=>'>5 buku']);
q('q3','Jenis bacaan yang paling Anda sukai?',[1=>'Pelajaran',2=>'Novel',3=>'Motivasi',4=>'Teknologi',5=>'Non-Fiksi',6=>'Biografi']);
?>
</div>

<div class="section"><h3>Kebutuhan Buku</h3>
<?php
q('q4','Jenis buku apa yang menurut Anda masih kurang di perpustakaan?',[1=>'Fiksi',2=>'Non-Fiksi',3=>'Pelajaran',4=>'Referensi',5=>'Pengembangan diri',6=>'Kearifan Lokal',7=>'Persiapan Tes',8=>'Anak']);
q('q5','Apa tujuan utama Anda membaca buku?',[1=>'Mengerjakan tugas',2=>'Menambah wawasan',3=>'Hiburan',4=>'Karir']);
?>
</div>

<div class="section"><h3>Kunjungan</h3>
<?php
q('q6','Seberapa sering Anda berkunjung ke perpustakaan?',[1=>'>5 kali/minggu',2=>'3-4 kali/minggu',3=>'1-2 kali/minggu',4=>'Jarang',5=>'Tidak pernah']);
q('q7','Apa kendala utama yang Anda rasakan saat berkunjung ke perpustakaan?',[1=>'Buku yang dicari tidak tersedia',2=>'Koleksi kurang lengkap',3=>'Waktu berkunjung terbatas',4=>'Suasana kurang nyaman']);
?>
</div>

<div class="section"><h3>Literasi Digital</h3>
<?php
q('q8','Apakah Anda berminat membaca buku dalam bentuk ebook?',[1=>'Ya',2=>'Tidak']);
q('q9','Media apa yang paling sering Anda gunakan untuk membaca?',[1=>'Buku',2=>'HP',3=>'Laptop']);
q('q10','Fitur apa yang Anda harapkan tersedia dalam aplikasi perpustakaan?',[1=>'Rekomendasi buku',2=>'Notifikasi pengingat',3=>'Pencarian online',4=>'Akses ebook']);
?>
</div>

<div class="section"><h3>Program</h3>
<?php
q('q11','Jika perpustakaan mengadakan kegiatan literasi, kegiatan apa yang paling Anda minati?',[1=>'Lomba membaca',2=>'Bedah buku',3=>'Reading challenge',4=>'Menulis/review',5=>'Diskusi buku',6=>'Workshop']);
?>
</div>

<div class="section"><h3>Pengembangan</h3>
<?php
q('q12','Menurut Anda, aspek apa yang perlu ditingkatkan di perpustakaan?',[1=>'Koleksi buku',2=>'Fasilitas',3=>'Sistem layanan',4=>'Pelayanan']);
?>
</div>

<div class="section"><h3>Saran</h3>
<textarea name="kebutuhan_text" rows="3" maxlength="255" placeholder="Tulis kebutuhan buku/fasilitas..."></textarea>
</div>

<!-- AUTO GENERATE MATH -->
<div class="section"><h3>Verifikasi</h3>
<div class="form-group">
<label id="math_question"></label>
<input type="text" id="math_input" placeholder="Jawaban" required>
<div id="math_msg"></div>
</div>
</div>

<button type="submit">Kirim Survey</button>

</form>
</div>

<script>
document.getElementById("searchMember").addEventListener("keyup",function(){
let q=this.value,box=document.getElementById("memberResult");
if(q.length<2){box.innerHTML="";return;}
box.innerHTML="Loading...";
fetch("plugins/survey_kebutuhan/search_member.php?q="+q).then(r=>r.text()).then(d=>box.innerHTML=d);
});
document.addEventListener("click",function(e){
let item=e.target.closest(".member-result");
if(item){
member_id.value=item.dataset.id;
member_name.value=item.dataset.name;
member_class.value=item.dataset.class;
searchMember.value=item.dataset.name;
memberResult.innerHTML="";
}
});

/* AUTO GENERATE MATH */
let a,b,ans;
function gen(){
a=Math.floor(Math.random()*9)+1;
b=Math.floor(Math.random()*9)+1;
ans=a+b;
document.getElementById('math_question').innerText="Berapa "+a+" + "+b+" ?";
document.getElementById('math_input').value="";
document.getElementById('math_msg').style.display="none";
}
gen();

document.querySelector("form").addEventListener("submit",function(e){
if(!member_id.value){alert("Pilih anggota terlebih dahulu");e.preventDefault();return;}
let val=document.getElementById('math_input').value;
let msg=document.getElementById('math_msg');
if(val!=ans){
e.preventDefault();
msg.style.display="block";
msg.style.color="red";
msg.innerText="Jawaban salah, coba lagi";
msg.style.transform="scale(1.1)";
setTimeout(()=>{msg.style.transform="scale(1)"},200);
gen();
}
});
</script>

</body>
</html>