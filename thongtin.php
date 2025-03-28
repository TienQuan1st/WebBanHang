<?php
session_start();
include_once 'connect_DB/connect_db.php';
if (!isset($_SESSION['idtk'])) {
    echo "Bạn chưa đăng nhập.";
    exit;
}
$conn = connectData();


$idtk = $_SESSION['idtk'];
$sql = "SELECT * FROM users WHERE idtk = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idtk);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<?php include "./assets/layout/info/index.php"; ?>

<?php
// Xử lý cập nhật
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_user = $_POST['ten_user'];

    // Xử lý ảnh nếu có
    $anh_user = $user['Anh_user'];
    if (isset($_FILES['anh_user']) && $_FILES['anh_user']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['anh_user']['tmp_name'];
        $filename = basename($_FILES['anh_user']['name']);
        move_uploaded_file($tmp_name, "./assets/img/" . $filename);
        $anh_user = $filename;
    }

    $update_sql = "UPDATE users SET Ten_user = ?, Anh_user = ? WHERE idtk = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $ten_user, $anh_user, $idtk);
    $update_stmt->execute();

    $_SESSION['Ten_user'] = $ten_user;
    $_SESSION['Anh_user'] = $anh_user;

    echo "<script>alert('Cập nhật thành công!'); window.location.href='?page=thongtin';</script>";
}
?>
