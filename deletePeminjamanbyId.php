<?php

include 'koneksi.php';
include 'header.php';

$conn = getConnection();


$id = isset($_POST['id']) ? $_POST['id'] : '';

try {

    $query = "DELETE FROM peminjaman_detail WHERE id_peminjaman_master = :id";


    $statement = $conn->prepare($query);


    $statement->bindParam(':id', $id);



    $query = "DELETE FROM peminjaman_master WHERE id = :id";


    $statement = $conn->prepare($query);

    $statement->bindParam(':id', $id);


    $statement->execute();



    $query = "DELETE FROM peminjaman_detail WHERE id_peminjaman_master = :id";


    $statement = $conn->prepare($query);


    $statement->bindParam(':id', $id);


    $statement->execute();


    $response = [
        'status' => 'success',
        'message' => 'Data peminjaman berhasil dihapus'
    ];
} catch(PDOException $e) {

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat menghapus data peminjaman: ' . $e->getMessage()
    ];
}


echo json_encode($response);


$conn = null;
?>