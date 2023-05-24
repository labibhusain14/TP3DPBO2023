<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Klub.php');
include('classes/Posisi.php');
include('classes/Pemain.php');
include('classes/Template.php');

$pemain = new Pemain($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek Pemain
$klub = new Klub($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek Klub
$posisi = new Posisi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek Posisi

$pemain->open(); // Membuka koneksi ke database untuk objek Pemain
$klub->open(); // Membuka koneksi ke database untuk objek Klub
$posisi->open(); // Membuka koneksi ke database untuk objek Posisi

if (isset($_POST['btn-add'])) { // Mengecek apakah tombol "btn-add" diklik
    $id = $_GET['id']; // Mendapatkan nilai 'id' dari parameter GET
    $pemain->getPemainById($id); // Mendapatkan data pemain berdasarkan 'id'
    $row = $pemain->getResult(); // Mengambil hasil data pemain

    if ($pemain->updateData($id, $_POST, $_FILES) > 0) { // Memperbarui data pemain dengan menggunakan metode updateData()
        echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman index
    } else {
        echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'index.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman index
    }
}

if (isset($_GET['id'])) { // Mengecek apakah parameter GET 'id' tersedia
    $id = $_GET['id']; // Mendapatkan nilai 'id' dari parameter GET

    if ($id > 0) {
        $pemain->getPemainById($id); // Mendapatkan data pemain berdasarkan 'id'
        $row = $pemain->getResult(); // Mengambil hasil data pemain

        $klub->getKlub(); // Mendapatkan data klub
        $posisi->getPosisi(); // Mendapatkan data posisi

        $klubs = [];
        while ($club = $klub->getResult()) {
            $klubs[] = $club;
        } // Mengambil semua data klub

        $positions = [];
        while ($pos = $posisi->getResult()) {
            $positions[] = $pos;
        } // Mengambil semua data posisi

        $list_klub = '';
        foreach ($klubs as $club) {
            $selected = ($club['klub_id'] == $row['klub_id']) ? 'selected' : '';
            $list_klub .= "<option value=\"{$club['klub_id']}\" $selected>{$club['klub_nama']}</option>";
        } // Membuat daftar pilihan klub dengan opsi yang dipilih berdasarkan data pemain

        $list_posisi = '';
        foreach ($positions as $pos) {
            $selected = ($pos['posisi_id'] == $row['posisi_id']) ? 'selected' : '';
            $list_posisi .= "<option value=\"{$pos['posisi_id']}\" $selected>{$pos['posisi_nama']}</option>";
        } // Membuat daftar pilihan posisi dengan opsi yang dipilih berdasarkan data pemain

        $title = 'Update'; // Judul halaman
        $btn = 'Simpan'; // Teks tombol

        $klub->close(); // Menutup koneksi ke database untuk objek Klub
        $posisi->close(); // Menutup koneksi ke database untuk objek Posisi

        $add = new Template('templates/skin_form_add.html'); // Membuat objek Template
        $add->replace('DATA_TITLE', $title); // Mengganti 'DATA_TITLE' dengan judul halaman
        $add->replace('BUTTON', $btn); // Mengganti 'BUTTON' dengan teks tombol
        $add->replace('DATA_KLUB', $list_klub); // Mengganti 'DATA_KLUB' dengan daftar klub
        $add->replace('DATA_POSISI', $list_posisi); // Mengganti 'DATA_POSISI' dengan daftar posisi
        $add->replace('DATA_FOTO', $row['pemain_foto']); // Mengganti 'DATA_FOTO' dengan foto pemain
        $add->replace('DATA_NAMA', $row['pemain_nama']); // Mengganti 'DATA_NAMA' dengan nama pemain
        $add->replace('DATA_NOPUNG', $row['pemain_no_punggung']); // Mengganti 'DATA_NOPUNG' dengan nomor punggung pemain
        $add->replace('DATA_TINGGI', $row['pemain_tinggi']); // Mengganti 'DATA_TINGGI' dengan tinggi pemain
        $add->replace('DATA_USIA', $row['pemain_usia']); // Mengganti 'DATA_USIA' dengan usia pemain
        $add->replace('DATA_KLUB', $row['klub_id']); // Mengganti 'DATA_KLUB' dengan klub pemain
        $add->replace('DATA_POSISI', $row['posisi_id']); // Mengganti 'DATA_POSISI' dengan posisi pemain
        $add->write(); // Menulis output template ke layar
        $pemain->close(); // Menutup koneksi ke database untuk objek Pemain
    }
}
