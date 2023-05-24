<?php

class Pemain extends DB
{
    function getPemainJoin()
    {
        // Mendapatkan data pemain dengan melakukan join antara tabel pemain, klub, dan posisi. Data diurutkan berdasarkan pemain_id.
        $query = "SELECT * FROM pemain JOIN klub ON pemain.klub_id=klub.klub_id JOIN posisi ON pemain.posisi_id=posisi.posisi_id ORDER BY pemain.pemain_id";
        return $this->execute($query);
    }

    function getPemain()
    {
        // Mendapatkan semua data pemain dari tabel pemain.
        $query = "SELECT * FROM pemain";
        return $this->execute($query);
    }

    function getPemainById($id)
    {
        // Mendapatkan data pemain berdasarkan pemain_id dengan melakukan join antara tabel pemain, klub, dan posisi.
        $query = "SELECT * FROM pemain JOIN klub ON pemain.klub_id=klub.klub_id JOIN posisi ON pemain.posisi_id=posisi.posisi_id WHERE pemain_id=$id";
        return $this->execute($query);
    }

    function searchPemain($keyword)
    {
        // Mencari data pemain berdasarkan kata kunci yang cocok dengan nama pemain, nama klub, atau nama posisi. Data diurutkan berdasarkan pemain_id.
        $query = "SELECT * FROM pemain JOIN klub ON pemain.klub_id=klub.klub_id JOIN posisi ON pemain.posisi_id=posisi.posisi_id WHERE pemain_nama LIKE '%$keyword%' OR klub_nama LIKE '%$keyword%' OR posisi_nama LIKE '%$keyword%' ORDER BY pemain.pemain_id;";
        return $this->execute($query);
    }

    function sortingPemain()
    {
        // Mendapatkan data pemain dengan melakukan join antara tabel pemain, klub, dan posisi. Data diurutkan berdasarkan pemain_nama secara ascending (A-Z).
        $query = "SELECT * FROM pemain JOIN klub ON pemain.klub_id=klub.klub_id JOIN posisi ON pemain.posisi_id=posisi.posisi_id ORDER BY pemain.pemain_nama ASC";
        return $this->execute($query);
    }

    function addData($data, $file)
    {
        $nama = $data['nama'];
        $foto = $file['foto']['name'];
        $temp_foto = $file['foto']['tmp_name'];
        move_uploaded_file($temp_foto, 'assets/images/' . $foto);
        $no_punggung = $data['no_punggung'];
        $tinggi = $data['tinggi'];
        $usia = $data['usia'];
        $klub = $data['klub'];
        $posisi = $data['posisi'];

        // Menambahkan data pemain baru ke dalam tabel pemain dengan menggunakan nilai-nilai yang diberikan sebagai parameter.
        $query = "INSERT INTO pemain VALUES('', '$foto', '$nama', '$no_punggung',  '$tinggi', '$usia',  '$klub', '$posisi');";
        return $this->executeAffected($query);
    }

    function updateData($id, $data, $file)
    {
        $nama = $data['nama'];
        $foto = $file['foto']['name'];
        $temp_foto = $file['foto']['tmp_name'];
        move_uploaded_file($temp_foto, 'assets/images/' . $foto);
        $no_punggung = $data['no_punggung'];
        $tinggi = $data['tinggi'];
        $usia = $data['usia'];
        $klub = $data['klub'];
        $posisi = $data['posisi'];

        // Memperbarui data pemain berdasarkan pemain_id dengan menggunakan nilai-nilai yang diberikan sebagai parameter.
        $query = "UPDATE pemain SET pemain_foto='$foto', pemain_nama='$nama', pemain_no_punggung='$no_punggung', pemain_tinggi='$tinggi', pemain_usia='$usia', klub_id='$klub', posisi_id='$posisi' where pemain_id=$id ";
        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        // Menghapus data pemain dari tabel pemain berdasarkan pemain_id yang diberikan sebagai parameter.
        $query = "DELETE from pemain where pemain_id=$id";
        return $this->executeAffected($query);
    }
}
