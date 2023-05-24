<?php

class Posisi extends DB
{
    //Fungsi untuk mendapatkan data posisi
    function getPosisi()
    {
        $query = "SELECT * FROM posisi";
        return $this->execute($query);
    }

    //Fungsi untuk Mendapatkan id dari posisi
    function getPosisiById($id)
    {
        $query = "SELECT * FROM posisi WHERE posisi_id=$id";
        return $this->execute($query);
    }

    //Fungsi untuk mencari klub berdasarkan klub_nama
    function searchPosisi($keyword)
    {
        $query = "SELECT * FROM posisi WHERE posisi_nama LIKE '%$keyword%'";
        return $this->execute($query);
    }

    //Fungsi Untuk Add posisi
    function addPosisi($data)
    {
        $nama = $data['nama'];
        $query = "INSERT INTO posisi VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    // Fungsi untuk ubah posisi
    function updatePosisi($id, $data)
    {
        $nama = $data['nama'];
        $query = "UPDATE posisi SET posisi_nama='$nama' where posisi_id=$id";
        return $this->executeAffected($query);
    }

    // fungsi untuk menghapus posisi
    function deletePosisi($id)
    {
        $query = "DELETE from posisi where posisi_id=$id";
        return $this->executeAffected($query);
    }
}
