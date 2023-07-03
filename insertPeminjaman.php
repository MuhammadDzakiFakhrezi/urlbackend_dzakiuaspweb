<?php

include 'koneksi.php';
include 'header.php';


$tanggal_peminjaman = isset($_POST['tanggal_peminjaman']) ? $_POST['tanggal_peminjaman'] : '';
$nomor_anggota = isset($_POST['nomor_anggota']) ? $_POST['nomor_anggota'] : '';
$tanggal_pengembalian = isset($_POST['tanggal_pengembalian']) ? $_POST['tanggal_pengembalian'] : '';
$durasi_pengembalian = isset($_POST['durasi_pengembalian']) ? $_POST['durasi_pengembalian'] : '';
$kode_buku = isset($_POST['kode_buku']) ? $_POST['kode_buku'] : '';

try {

    $conn = getConnection();
    
    $tanggal_pengembalian = date("Y-m-d", strtotime($tanggal_pengembalian));


    $query = "INSERT INTO peminjaman_master (tanggal_peminjaman, nomor_anggota, tanggal_pengembalian) 
              VALUES (:tanggal_peminjaman, :nomor_anggota, :tanggal_pengembalian)";
    

    $statement = $conn->prepare($query);
    

    $statement->bindParam(':tanggal_peminjaman', $tanggal_peminjaman);
    $statement->bindParam(':nomor_anggota', $nomor_anggota);
    $statement->bindParam(':tanggal_pengembalian', $tanggal_pengembalian);

    $statement->execute();


    $id_peminjaman_master = $conn->lastInsertId();

    $query = "INSERT INTO peminjaman_detail (id_peminjaman_master, kode_buku) 
              VALUES (:id_peminjaman_master, :kode_buku)";
    

    $statement = $conn->prepare($query);
    

    $statement->bindParam(':id_peminjaman_master', $id_peminjaman_master);
    $statement->bindParam(':kode_buku', $kode_buku);
    

    $statement->execute();
    

    $response = [
        'status' => 'success',
        'message' => 'Data peminjaman berhasil ditambahkan'
    ];
} catch(PDOException $e) {

    $response = [
        'status' => 'error' . $kode,
        'message' => 'Terjadi kesalahan saat menambahkan data peminjaman: ' . $e->getMessage()
    ];
}


echo json_encode($response);


$conn = null;
?>