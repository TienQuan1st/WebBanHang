<?php
session_start();
include "./connect_DB/connect_db.php";

if (!isset($_SESSION['idtk'])) {
    die("Bạn cần đăng nhập để xem giỏ hàng.");
}

$iduser = $_SESSION['idtk'];
$conn = connectData();
$mes = "";
$items = [];

// Lấy giỏ hàng hiện tại để hiển thị
$sql = "SELECT giohang.*, sanpham.Ten, sanpham.Anh, sanpham.Gia
        FROM giohang
        JOIN sanpham ON giohang.idsanpham = sanpham.id
        WHERE iduser = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $sdt = $_POST['sdt'] ?? '';
    $diachi = $_POST['diachi'] ?? '';

    if (!empty($items)) {
        $tongtien = 0;
        foreach ($items as $item) {
            $tongtien += $item['Gia'] * $item['soluong'];
        }

        $sqlInsertDonHang = "INSERT INTO donhang (idKhach, trangthai, tongtien) VALUES (?, 0, ?)";
        $stmtDonHang = $conn->prepare($sqlInsertDonHang);
        $stmtDonHang->bind_param("ii", $iduser, $tongtien);
        $stmtDonHang->execute();
        $idDonHang = $conn->insert_id;

        foreach ($items as $item) {
            $idsp = $item['idsanpham'];
            $soluong = $item['soluong'];
            $gia = $item['Gia'];

            $sqlInsert = "INSERT INTO chitietdonhang (iddonhang, idsanpham, soluong, gia) VALUES (?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            $stmtInsert->bind_param("iiid", $idDonHang, $idsp, $soluong, $gia);
            $stmtInsert->execute();
        }

        $conn->query("DELETE FROM giohang WHERE iduser = $iduser");

        echo "<script>alert('Đặt hàng thành công!'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Giỏ hàng trống!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="./assets/fonts/css/all.min.css">
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .container {
        max-width: 900px;
    }

    h2 {
        font-weight: bold;
    }

    .card {
        background-color: #f8f9fa;
        padding: 15px;
    }
</style>

<body>
    <?php include "./assets/layout/header/index.php"; ?>

    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Thông tin đơn hàng</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" name="sdt" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="diachi" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Đặt hàng</button>
                </form>
            </div>

            <div class="col-md-6">
                <h2>Thông tin sản phẩm</h2>
                <table class="table table-bordered text-center border border-dark-subtle">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0;
                        if (!empty($items)):
                            foreach ($items as $item):
                                $subtotal = $item['Gia'] * $item['soluong'];
                                $total += $subtotal;
                        ?>
                                <tr>
                                    <td><img src="./assets/img/<?= htmlspecialchars($item['Anh']) ?>" width="60" class="img-fluid"></td>
                                    <td><?= htmlspecialchars($item['Ten']) ?></td>
                                    <td><?= number_format($item['Gia'], 0, ',', '.') ?> VNĐ</td>
                                    <td><?= $item['soluong'] ?></td>
                                </tr>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
                <h5>Tổng tiền: <span class="text-black"><?= number_format($total, 0, ',', '.') ?> VNĐ</span></h5>
            </div>
        </div>
    </div>

    <?php include "./assets/layout/footer/index.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>