<?php
session_start();
include "./connect_DB/connect_db.php";

$conn = connectData();

if (!isset($_SESSION['idtk'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['idtk'];
$sql = "SELECT * FROM users WHERE iduser = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_user = trim($_POST['ten_user']);
    $anh_user = $user['Anh_user'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $diachi = $_POST['diachi'];
    $ngaysinh = $_POST['ngaysinh'];


    if (!empty($_FILES['anh_user']['name'])) {
        $file_name = basename($_FILES["anh_user"]["name"]);
        $target_dir = "assets/img/";
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["anh_user"]["tmp_name"], $target_file)) {
            $anh_user = $file_name;
        } else {
            $error = "Tải ảnh thất bại.";
        }
    }

    if ($error === "") {
        $updateSql = "UPDATE users SET Ten_user = ?, Ten_user = ?, Anh_user = ? WHERE iduser = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssi", $username, $ten_user, $anh_user, $id);
        if ($updateStmt->execute()) {
            $success = "Cập nhật thành công!";
            $_SESSION['username'] = $username;
            $_SESSION['Ten_user'] = $ten_user;
            $_SESSION['Anh_user'] = $anh_user;
            $_SESSION['sdt'] = $sdt;
            $_SESSION['email'] = $email;
            $_SESSION['diachi'] = $diachi;
            $_SESSION['ngaysinh'] = $ngaysinh;

            $user['username'] = $username;
            $user['Ten_user'] = $ten_user;
            $user['Anh_user'] = $anh_user;
            $user['sdt'] = $sdt;
            $user['email'] = $email;
            $user['diachi'] = $diachi;
            $user['ngaysinh'] = $ngaysinh;

        } else {
            $error = "Cập nhật thất bại!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thay đổi thông tin</title>
    
</head>
<body>
<?php include "./assets/layout/header/index.php"; ?>

<?php include "./assets/layout/info/index.php"; ?>

<?php include "./assets/layout/footer/index.php"; ?>
<script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
