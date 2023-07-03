<?php

include 'koneksi.php';
include 'header.php';

$conn = getConnection();


$id = isset($_GET['id']) ? $_GET['id'] : '';

try {

    $query = "SELECT pm.id, pm.tanggal_peminjaman, pm.tanggal_pengembalian, pm.status_peminjaman, a.nama AS nama_anggota, b.judul AS judul_buku
              FROM peminjaman_master pm
              JOIN anggota a ON pm.nomor_anggota = a.nomor
              JOIN peminjaman_detail pd ON pm.id = pd.id_peminjaman_master
              JOIN buku b ON pd.kode_buku = b.kode
              WHERE pm.id = :id";
    

    $statement = $conn->prepare($query);
    

    $statement->bindParam(':id', $id);
    

    $statement->execute();

    $kategori = $statement->fetch(PDO::FETCH_ASSOC);
    

    if ($kategori) {
        $response = [
            'status' => 'success',
            'data' => $kategori
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Data peminjaman tidak ditemukan'
        ];
    }
} catch(PDOException $e) {

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memilih data kategori: ' . $e->getMessage()
    ];
}


echo json_encode($response);

// Menutup koneksi
$conn = null;
?>