<?php

include "koneksi.php";

// Menentukan metode request
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch($method) {
    case 'GET':
        $sql = "SELECT * FROM wisata";
        $stmt = $pdo->query($sql);
        $wisata = $stmt->fetchAll();
        echo json_encode($wisata);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->nama_wisata) && isset($data->alamat) && isset($data->deskripsi)) {
            $sql = "INSERT INTO wisata (nama_wisata, alamat, deskripsi) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama_wisata, $data->alamat, $data->deskripsi]);
            echo json_encode(['message' => 'Data wisata berhasil ditambahkan']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id_wisata) && ($data->nama_wisata) && isset($data->alamat) && isset($data->deskripsi)) {
            $sql = "UPDATE wisata SET nama_wisata=?, alamat=?, deskripsi=? WHERE id_wisata=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id_wisata, $data->nama_wisata, $data->alamat, $data->deskripsi]);
            echo json_encode(['message' => 'Wisata berhasil diperbarui']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id_wisata)) {
            $sql = "DELETE FROM wisata WHERE id_wisata=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id_wisata]);
            echo json_encode(['message' => 'Wisata berhasil dihapus']);
        } else {
            echo json_encode(['message' => 'ID Wisata tidak ditemukan']);
        }
        break;

    default:
        echo json_encode(['message' => 'Metode tidak dikenali']);
        break;
}

?>
