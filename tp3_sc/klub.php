<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Klub.php');
include('classes/Template.php');

$klub = new Klub($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek Klub
$klub->open(); // Membuka koneksi ke database untuk objek Klub
$klub->getKlub(); // Mendapatkan data klub dari database

if (isset($_POST['btn-search'])) { // Mengecek apakah tombol pencarian diklik
    $klub->searchKlub($_POST['search']); // Mencari klub berdasarkan kata kunci yang diberikan
} else {
    $klub->getKlub(); // Mendapatkan data klub jika tidak ada pencarian
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($klub->addKlub($_POST) > 0) { // Menambahkan data klub baru menggunakan metode addKlub()
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'klub.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman klub
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'klub.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman klub
        }
    }

    $btn = 'Tambah'; // Label tombol 'Tambah'
    $title = 'Tambah'; // Judul halaman 'Tambah'
}

$view = new Template('templates/skintabel.html'); // Membuat objek Template
$mainTitle = 'Klub'; // Judul utama halaman 'Klub'
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Klub</th>
<th scope="row">Aksi</th>
</tr>'; // Header tabel klub
$data = null;
$no = 1;
$formLabel = 'Klub'; // Label formulir 'Klub'

while ($div = $klub->getResult()) { // Mengambil data klub satu per satu
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['klub_nama'] . '</td>
    <td style="font-size: 22px;">
        <a href="klub.php?id=' . $div['klub_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="klub.php?hapus=' . $div['klub_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>'; // Menambahkan baris data klub ke variabel $data
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($klub->updateKlub($id, $_POST) > 0) { // Mengupdate data klub menggunakan metode updateKlub()
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'klub.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman klub
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'klub.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman klub
            }
        }

        $klub->getKlubById($id); // Mendapatkan data klub berdasarkan id menggunakan metode getKlubById()
        $row = $klub->getResult();

        $dataUpdate = $row['klub_nama']; // Data nama klub yang akan diubah
        $btn = 'Update'; // Label tombol 'Update'
        $title = 'Ubah'; // Judul halaman 'Ubah'

        $view->replace('DATA_VAL_UPDATE', $dataUpdate); // Mengganti 'DATA_VAL_UPDATE' dengan data nama klub yang akan diubah
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($klub->deleteKlub($id) > 0) { // Menghapus data klub berdasarkan id menggunakan metode deleteKlub()
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'klub.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman klub
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'klub.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman klub
        }
    }
}

$klub->close(); // Menutup koneksi ke database untuk objek Klub

$view->replace('DATA_MAIN_TITLE', $mainTitle); // Mengganti 'DATA_MAIN_TITLE' dengan judul utama halaman
$view->replace('DATA_TABEL_HEADER', $header); // Mengganti 'DATA_TABEL_HEADER' dengan header tabel klub
$view->replace('DATA_TITLE', $title); // Mengganti 'DATA_TITLE' dengan judul halaman
$view->replace('NAMA', $mainTitle); // Mengganti 'NAMA' dengan judul utama halaman
$view->replace('SEARCH_TABLE', 'klub.php'); // Mengganti 'SEARCH_TABLE' dengan URL halaman klub
$view->replace('DATA_BUTTON', $btn); // Mengganti 'DATA_BUTTON' dengan label tombol
$view->replace('DATA_FORM_LABEL', $formLabel); // Mengganti 'DATA_FORM_LABEL' dengan label formulir
$view->replace('DATA_TABEL', $data); // Mengganti 'DATA_TABEL' dengan data klub
$view->write(); // Menulis output template ke layar
