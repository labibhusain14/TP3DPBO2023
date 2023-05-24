<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Posisi.php');
include('classes/Template.php');

$posisi = new Posisi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek Posisi
$posisi->open(); // Membuka koneksi ke database untuk objek Posisi
$posisi->getPosisi(); // Mendapatkan data posisi dari database

if (isset($_POST['btn-search'])) { // Mengecek apakah tombol pencarian diklik
    $posisi->searchPosisi($_POST['search']); // Mencari posisi berdasarkan kata kunci yang diberikan
} else {
    $posisi->getPosisi(); // Mendapatkan data posisi jika tidak ada pencarian
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($posisi->addPosisi($_POST) > 0) { // Menambahkan data posisi baru menggunakan metode addPosisi()
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'posisi.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman posisi
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'posisi.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman posisi
        }
    }

    $btn = 'Tambah'; // Label tombol 'Tambah'
    $title = 'Tambah'; // Judul halaman 'Tambah'
}

$view = new Template('templates/skintabel.html'); // Membuat objek Template
$mainTitle = 'Posisi'; // Judul utama halaman 'Posisi'
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Posisi</th>
<th scope="row">Aksi</th>
</tr>'; // Header tabel posisi
$data = null;
$no = 1;
$formLabel = 'Posisi'; // Label formulir 'Posisi'

while ($div = $posisi->getResult()) { // Mengambil data posisi satu per satu
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['posisi_nama'] . '</td>
    <td style="font-size: 22px;">
        <a href="posisi.php?id=' . $div['posisi_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="posisi.php?hapus=' . $div['posisi_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>'; // Menambahkan baris data posisi ke variabel $data
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($posisi->updatePosisi($id, $_POST) > 0) { // Mengubah data posisi berdasarkan id menggunakan metode updatePosisi()
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'posisi.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman posisi
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'posisi.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman posisi
            }
        }

        $posisi->getPosisiById($id); // Mendapatkan data posisi berdasarkan id menggunakan metode getPosisiById()
        $row = $posisi->getResult();

        $dataUpdate = $row['posisi_nama']; // Data nama posisi yang akan diubah
        $btn = 'Update'; // Label tombol 'Update'
        $title = 'Ubah'; // Judul halaman 'Ubah'

        $view->replace('DATA_VAL_UPDATE', $dataUpdate); // Mengganti 'DATA_VAL_UPDATE' dengan data nama posisi yang akan diubah
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($posisi->deletePosisi($id) > 0) { // Menghapus data posisi berdasarkan id menggunakan metode deletePosisi()
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'posisi.php';
            </script>"; // Menampilkan pesan sukses dan mengarahkan ke halaman posisi
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'posisi.php';
            </script>"; // Menampilkan pesan gagal dan mengarahkan ke halaman posisi
        }
    }
}

$posisi->close(); // Menutup koneksi ke database untuk objek Posisi

$view->replace('DATA_MAIN_TITLE', $mainTitle); // Mengganti 'DATA_MAIN_TITLE' dengan judul utama halaman
$view->replace('DATA_TABEL_HEADER', $header); // Mengganti 'DATA_TABEL_HEADER' dengan header tabel posisi
$view->replace('DATA_TITLE', $title); // Mengganti 'DATA_TITLE' dengan judul halaman
$view->replace('NAMA', $mainTitle); // Mengganti 'NAMA' dengan judul utama halaman
$view->replace('DATA_BUTTON', $btn); // Mengganti 'DATA_BUTTON' dengan label tombol
$view->replace('DATA_FORM_LABEL', $formLabel); // Mengganti 'DATA_FORM_LABEL' dengan label formulir
$view->replace('DATA_TABEL', $data); // Mengganti 'DATA_TABEL' dengan data posisi
$view->write(); // Menulis output template ke layar
