<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Klub.php');
include('classes/Posisi.php');
include('classes/Pemain.php');
include('classes/Template.php');

$pemain = new Pemain($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME); // Membuat objek Pemain
$pemain->open(); // Membuka koneksi ke database untuk objek Pemain

$data = null;

if (isset($_GET['hapus'])) { // Mengecek apakah parameter GET 'hapus' tersedia
    $id = $_GET['hapus']; // Mendapatkan nilai 'hapus' dari parameter GET

    if ($id > 0) {
        if ($pemain->deleteData($id) > 0) { // Menghapus data pemain berdasarkan 'id' menggunakan metode deleteData()
            echo "
                <script>
                    alert('Data berhasil dihapus!');
                    document.location.href = 'index.php';
                </script>
            "; // Menampilkan pesan sukses dan mengarahkan ke halaman index
        } else {
            echo "
                <script>
                    alert('Data gagal dihapus!');
                    document.location.href = 'index.php';
                </script>
            "; // Menampilkan pesan gagal dan mengarahkan ke halaman index
        }
    }
}

if (isset($_GET['id'])) { // Mengecek apakah parameter GET 'id' tersedia
    $id = $_GET['id']; // Mendapatkan nilai 'id' dari parameter GET

    if ($id > 0) {
        $pemain->getPemainById($id); // Mendapatkan data pemain berdasarkan 'id'
        $row = $pemain->getResult(); // Mengambil hasil data pemain

        $data .= '<div class="card-header text-center">
            <h3 class="my-0">Detail ' . $row['pemain_nama'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['pemain_foto'] . '" class="img-thumbnail" alt="' . $row['pemain_foto'] . '" width="60">
                    </div>
                </div>
                <div class="col-9">
                    <div class="card px-3">
                        <table border="0" class="text-start">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>' . $row['pemain_nama'] . '</td>
                            </tr>
                            <tr>
                                <td>No Punggung</td>
                                <td>:</td>
                                <td>' . $row['pemain_no_punggung'] . '</td>
                            </tr>
                            <tr>
                                <td>Tinggi</td>
                                <td>:</td>
                                <td>' . $row['pemain_tinggi'] . ' cm</td>
                            </tr>
                            <tr>
                                <td>Usia</td>
                                <td>:</td>
                                <td>' . $row['pemain_usia'] . ' Tahun</td>
                            </tr>                                
                            <tr>
                                <td>Posisi</td>
                                <td>:</td>
                                <td>' . $row['posisi_nama'] . '</td>
                            </tr>
                            <tr>
                                <td>Klub</td>
                                <td>:</td>
                                <td>' . $row['klub_nama'] . '</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="update.php?id=' . $row['pemain_id'] . '"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
            <a href="detail.php?hapus=' . $row['pemain_id'] . '"><button type="button" class="btn btn-danger">Hapus Data</button></a>
        </div>'; // Menampilkan detail pemain dan tombol untuk mengubah dan menghapus data pemain
    }
}

$pemain->close(); // Menutup koneksi ke database untuk objek Pemain

$detail = new Template('templates/skindetail.html'); // Membuat objek Template
$detail->replace('DATA_DETAIL_PEMAIN', $data); // Mengganti 'DATA_DETAIL_PEMAIN' dengan data pemain
$detail->write(); // Menulis output template ke layar
