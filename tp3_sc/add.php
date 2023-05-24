<?php

include('config/db.php'); // Memasukkan file db.php yang berisi konfigurasi database
include('classes/DB.php'); // Memasukkan file DB.php yang berisi definisi kelas DB
include('classes/Klub.php'); // Memasukkan file Klub.php yang berisi definisi kelas Klub
include('classes/Posisi.php'); // Memasukkan file Posisi.php yang berisi definisi kelas Posisi
include('classes/Pemain.php'); // Memasukkan file Pemain.php yang berisi definisi kelas Pemain
include('classes/Template.php'); // Memasukkan file Template.php yang berisi definisi kelas Template

// -------------------------------KLUB---------------------------
$klub = new Klub($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek dari kelas Klub dengan menggunakan nilai-nilai konfigurasi database
$klub->open(); // Membuka koneksi ke database
$klub->getKlub(); // Mengambil data klub dari tabel klub

$list_klub = '';
while ($row = $klub->getResult()) {
    $list_klub .= "<option value=" . $row['klub_id'] . ">" . $row['klub_nama'] . "</option>";
}
$klub->close(); // Menutup koneksi ke database setelah selesai mengambil data klub

// -------------------------------Posisi---------------------------
$posisi = new Posisi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek dari kelas Posisi dengan menggunakan nilai-nilai konfigurasi database
$posisi->open(); // Membuka koneksi ke database
$posisi->getPosisi(); // Mengambil data posisi dari tabel posisi

$list_posisi = '';
while ($row = $posisi->getResult()) {
    $list_posisi .= "<option value=" . $row['posisi_id'] . ">" . $row['posisi_nama'] . "</option>";
}
$posisi->close(); // Menutup koneksi ke database setelah selesai mengambil data posisi

// -------------------------------Pemain---------------------------
$pemain = new Pemain($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek dari kelas Pemain dengan menggunakan nilai-nilai konfigurasi database
$pemain->open(); // Membuka koneksi ke database
$pemain->getPemain(); // Mengambil data pemain dari tabel pemain

// Menghandle logika tambah data pemain jika tombol "btn-add" diklik
if (isset($_POST['btn-add'])) {
    if ($pemain->addData($_POST, $_FILES) > 0) {
        echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'index.php';
            </script>";
    } else {
        echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'index.php';
            </script>";
    }
}

$pemain->close(); // Menutup koneksi ke database setelah selesai mengambil data pemain

$title = 'Tambah'; // Variabel untuk menyimpan judul halaman
$add = new Template('templates/skin_form_add.html'); // Membuat objek dari kelas Template dengan menggunakan berkas template skin_form_add.html

$add->replace('DATA_KLUB', $list_klub); // Mengganti string "DATA_KLUB" dalam konten template dengan daftar klub yang telah diambil
$add->replace('DATA_TITLE', $title); // Mengganti string "DATA_TITLE" dalam konten template dengan judul halaman
$add->replace('BUTTON', $title); // Mengganti string "BUTTON" dalam konten template dengan judul halaman
$add->replace('DATA_POSISI', $list_posisi); // Mengganti string "DATA_POSISI" dalam konten template dengan daftar posisi yang telah diambil
$add->write(); // Menampilkan konten template setelah mengganti string yang sesuai
