<?php
session_start();
include "./connect_DB/connect_db.php";

if (!isset($_SESSION['idtk'])) {
    header("Location: details.php?error=notloggedin");
    exit();
}

$iduser = $_SESSION['idtk'];
$idsanpham = isset($_POST['idsanpham']) ? intval($_POST['idsanpham']) : 0;
$soluong = isset($_POST['soluong']) ? intval($_POST['soluong']) : 1;

$conn = connectData();

$stmt = $conn->prepare("SELECT soluong FROM sanpham WHERE id = ?");
$stmt->bind_param("i", $idsanpham);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: details.php?error=notfound");
    exit();
}

$row = $result->fetch_assoc();
$soluong_tonkho = intval($row['soluong']);

$stmt = $conn->prepare("SELECT soluong FROM giohang WHERE iduser = ? AND idsanpham = ?");
$stmt->bind_param("ii", $iduser, $idsanpham);
$stmt->execute();
$result = $stmt->get_result();

$soluong_hientai = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $soluong_hientai = intval($row['soluong']);
}

$tong_soluong = $soluong_hientai + $soluong;

if ($tong_soluong > $soluong_tonkho) {
    header("Location: detail.php?id=$idsanpham&error=overstock");
    exit();
}

if ($soluong_hientai > 0) {
    $stmt = $conn->prepare("UPDATE giohang SET soluong = soluong + ? WHERE iduser = ? AND idsanpham = ?");
    $stmt->bind_param("iii", $soluong, $iduser, $idsanpham);
} else {
    $stmt = $conn->prepare("INSERT INTO giohang (iduser, idsanpham, soluong) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $iduser, $idsanpham, $soluong);
}
$stmt->execute();

header("Location: giohang.php");
exit();
