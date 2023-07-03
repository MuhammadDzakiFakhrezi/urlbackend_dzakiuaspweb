<?php

include 'koneksi.php';
include 'header.php';

$conn = getConnection();


$nomor = isset($_GET['nomor']) ? $_GET['nomor'] : '';

try {

    $query = "SELECT * FROM anggota WHERE nomor = :nomor";
    

    $statement = $conn->prepare($query);
    

    $statement->bindParam(':nomor', $nomor);
    

    $statement->execute();
    

    $anggota = $statement->fetch(PDO::FETCH_ASSOC);
    

    if ($anggota) {
        $response = [
            'status' => 'success',
            'data' => $anggota
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Data anggota tidak ditemukan'
        ];
    }
} catch(PDOException $e) {

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memilih data anggota: ' . $e->getMessage()
    ];
}


echo json_encode($response);


$conn = null;
?>