<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Klub.php');
include('classes/Posisi.php');
include('classes/Pemain.php');
include('classes/Template.php');

// buat instance pemain
$listPemain = new Pemain($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listPemain->open();
// tampilkan data pemain
$listPemain->getPemainJoin();

// cari pemain
if (isset($_POST['btn-cari'])) {
    // methode mencari data pemain
    $listPemain->searchPemain($_POST['cari']);
} else if (isset($_POST['btn-sort'])) {
    // methode mengurutkan data pemain
    $listPemain->sortingPemain();
} else {
    // method menampilkan data pemain
    $listPemain->getPemainJoin();
}

$data = null;

// ambil data pemain
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listPemain->getResult()) {
    $data .=     " <div class='col-md-3'>
        <a href='detail.php?id=" . $row['pemain_id'] . "'>
            <div class='card p-2 py-3 text-center'>
                <div class='img mb-2'> 
                    <img src='assets/images/" . $row['pemain_foto'] . "' width='110' height='110' class='rounded-circle' alt='" . $row['pemain_foto'] . "' style='object-fit: cover;'>
                </div>
                <h5 class='mb-0'><strong> " . $row['pemain_nama'] . " </strong></h5> 
                <small>" . $row['posisi_nama'] . "</small>
                <small>" . $row['klub_nama'] . "</small>
                <div class='mt-4 apointment'> <button class='btn btn-info btn-opacity-50 text-uppercase'>Detail</button> </div>
            </div>
        </a>
    </div> ";
}

// tutup koneksi
$listPemain->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_PEMAIN', $data);
$home->write();
