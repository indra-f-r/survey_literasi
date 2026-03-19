# Survey Literasi (SLiMS Plugin)

Plugin ini merupakan modul tambahan untuk SLiMS (Senayan Library Management System) yang digunakan untuk mengumpulkan data kebutuhan literasi pemustaka melalui survey terstruktur. Data yang dikumpulkan dapat digunakan sebagai dasar pengambilan keputusan dalam pengembangan koleksi, layanan, dan program perpustakaan.

## Deskripsi Singkat

Survey Literasi memungkinkan perpustakaan mengetahui:

* Kebiasaan membaca pemustaka
* Jenis dan kebutuhan buku yang diinginkan
* Pola kunjungan ke perpustakaan
* Minat terhadap literasi digital
* Harapan terhadap layanan dan program perpustakaan

Seluruh data diolah secara otomatis dan ditampilkan dalam bentuk laporan serta visualisasi grafik untuk memudahkan analisis.

## Fitur Utama

* Form survey berbasis web (OPAC) yang mudah digunakan
* Autocomplete pencarian anggota (member)
* Validasi pengisian (wajib isi semua pertanyaan)
* Pembatasan pengisian survey (1 kali per hari per anggota)
* Anti spam sederhana menggunakan verifikasi matematika
* Penyimpanan data otomatis ke database
* Dashboard laporan interaktif menggunakan Chart.js
* Analisa otomatis berdasarkan jawaban terbanyak
* Tampilan data saran pemustaka
* Rekap data berdasarkan kelas atau grup
* Filter laporan berdasarkan rentang tanggal
* Fitur cetak laporan

## Struktur Pertanyaan

Survey terdiri dari beberapa kategori utama:

* Kebiasaan Membaca
* Kebutuhan Buku
* Kunjungan
* Literasi Digital
* Program Literasi
* Pengembangan Perpustakaan

Setiap kategori memiliki beberapa pertanyaan pilihan ganda yang dirancang untuk menggali kebutuhan pemustaka secara komprehensif.

## Cara Kerja

1. Pengguna (pemustaka) mengakses halaman survey melalui OPAC
2. Pengguna mencari dan memilih data dirinya melalui fitur autocomplete
3. Mengisi seluruh pertanyaan yang tersedia
4. Sistem melakukan validasi data
5. Data disimpan ke database
6. Admin dapat melihat hasil dalam bentuk laporan dan grafik

## Instalasi

1. Salin folder plugin ke direktori:
   `plugins/`

2. Pastikan nama folder sesuai, misalnya:
   `survey_kebutuhan`

3. Plugin akan otomatis:

   * Membuat tabel database jika belum ada
   * Menyesuaikan struktur tabel (auto upgrade)

4. Akses menu:
   `Reporting → Survey Literasi`

5. Untuk akses form survey:
   tambahkan parameter:
   `?p=surveyliterasi`

## Struktur Database

Plugin ini menggunakan tabel:
`library_need_survey`

Beberapa field utama:

* member_id
* member_name
* member_class
* survey_date
* q1 – q12 (jawaban survey)
* kebutuhan_text (saran pemustaka)
* created_at

## Output Laporan

Laporan yang dihasilkan meliputi:

* Total responden
* Grafik distribusi jawaban
* Analisa otomatis (jawaban dominan)
* Daftar saran pemustaka
* Distribusi responden per kelas

Grafik akan ditampilkan secara otomatis jika jumlah responden mencukupi.

## Kegunaan

Plugin ini dapat digunakan untuk:

* Analisis kebutuhan koleksi buku
* Perencanaan pengadaan (berbasis data)
* Evaluasi layanan perpustakaan
* Penyusunan program literasi
* Pengambilan keputusan berbasis pengguna

## Kelebihan

* Ringan dan mudah diintegrasikan
* Tidak memerlukan konfigurasi kompleks
* Data langsung terhubung dengan member SLiMS
* Tampilan sederhana namun informatif
* Siap digunakan untuk kebutuhan laporan

## Catatan

* Field `pin` pada member digunakan sebagai informasi kelas/grup
* Disarankan menggunakan data member yang sudah lengkap
* Pastikan akses OPAC terbuka untuk pengguna

## Author

Indra Febriana Rulliawan
[https://github.com/indra-f-r](https://github.com/indra-f-r)

## Lisensi

Plugin ini bersifat bebas digunakan dan dikembangkan sesuai kebutuhan perpustakaan.
