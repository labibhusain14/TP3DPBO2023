<?php

class Klub extends DB
{
    //Fungsi untuk mendapatkan data klub
    function getKlub()
    {
        $query = "SELECT * FROM klub";
        return $this->execute($query);
    }

    //Fungsi untuk Mendapatkan id dari klub
    function getKlubById($id)
    {
        $query = "SELECT * FROM klub WHERE klub_id=$id";
        return $this->execute($query);
    }

    //Fungsi untuk mencari klub berdasarkan klub_nama
    function searchKlub($keyword)
    {
        $query = "SELECT * FROM klub WHERE klub_nama LIKE '%" . $keyword . "%'";
        return $this->execute($query);
    }

    //Fungsi untuk menambahkan klub
    function addKlub($data)
    {
        $nama = $data['nama'];
        $query = "INSERT INTO klub VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    // Fungsi untuk ubah klub
    function updateKlub($id, $data)
    {
        $nama = $data['nama'];
        $query = "UPDATE klub SET klub_nama='$nama' where klub_id=$id";
        return $this->executeAffected($query);
    }

    // fungsi untuk menghapus klub
    function deleteKlub($id)
    {
        $query = "DELETE from klub where klub_id=$id";
        return $this->executeAffected($query);
    }
}
