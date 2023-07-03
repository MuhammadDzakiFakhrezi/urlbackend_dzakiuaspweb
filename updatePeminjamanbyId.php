<?php

include 'koneksi.php';
include 'header.php';

$conn = getConnection();


$id = isset($_POST['id']) ? $_POST['id'] : '';
$status_peminjaman = isset($_POST['status_peminjaman']) ? $_POST['status_peminjaman'] : '';

try {

    $query = "UPDATE peminjaman_master SET status_peminjaman = :status_peminjaman WHERE id = :id";
    

    $statement = $conn->prepare($query);
    

    $statement->bindParam(':id', $id);
    $statement->bindParam(':status_peminjaman', $status_peminjaman);
    

    $statement->execute();
    

    $response = [
        'status' => 'success',
        'message' => 'Data peminjaman berhasil diperbarui'
    ];
} catch(PDOException $e) {

    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memperbarui data peminjaman: ' . $e->getMessage()
    ];
}


header('Content-Type: application/json');
echo json_encode($response);


$conn = null;
?>