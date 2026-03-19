<?php
/**
 * Plugin Name: Survey Literasi
 * Plugin URI: https://github.com/indra-f-r
 * Description: Survey Kebutuhan Perpustakaan
 * Version: 1.0.0
 * Author: Indra Febriana Rulliawan
 * Author URI: https://github.com/indra-f-r
 */

$plugin = \SLiMS\Plugins::getInstance();
global $dbs;

/* =====================================
CEK / BUAT TABEL
===================================== */

$check = $dbs->query("SHOW TABLES LIKE 'library_need_survey'");

if ($check && $check->num_rows == 0) {

$sql = "CREATE TABLE library_need_survey (

id INT AUTO_INCREMENT PRIMARY KEY,

member_id VARCHAR(20),
member_name VARCHAR(100),
member_class VARCHAR(50),

survey_date DATE,

q1 TINYINT,
q2 TINYINT,
q3 TINYINT,
q4 TINYINT,
q5 TINYINT,
q6 TINYINT,
q7 TINYINT,
q8 TINYINT,
q9 TINYINT,
q10 TINYINT,
q11 TINYINT,
q12 TINYINT,

kebutuhan_text VARCHAR(255),

created_at DATETIME

) ENGINE=InnoDB";

$dbs->query($sql);

}

/* =====================================
CEK KOLOM TAMBAHAN (AUTO UPGRADE)
===================================== */

$columns = [];

$result = $dbs->query("SHOW COLUMNS FROM library_need_survey");

while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

/* Tambahan kolom baru */

if (!in_array('member_class', $columns)) {
    $dbs->query("ALTER TABLE library_need_survey ADD member_class VARCHAR(50)");
}

if (!in_array('survey_date', $columns)) {
    $dbs->query("ALTER TABLE library_need_survey ADD survey_date DATE");
}

if (!in_array('created_at', $columns)) {
    $dbs->query("ALTER TABLE library_need_survey ADD created_at DATETIME");
}

if (!in_array('kebutuhan_text', $columns)) {
    $dbs->query("ALTER TABLE library_need_survey ADD kebutuhan_text VARCHAR(255)");
}

/* =====================================
REGISTER MENU
===================================== */

$plugin->registerMenu(
'reporting',
'Survey Literasi',
__DIR__.'/index.php'
);

/* =====================================
ROUTING OPAC
===================================== */

if (isset($_GET['p']) && $_GET['p'] == 'surveyliterasi') {
    if(!defined('INDEX_AUTH')) define('INDEX_AUTH',1);
    require_once SB.'sysconfig.inc.php';
    require __DIR__.'/survey_literasi.php';
    exit;
}