<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "./connect_DB/connect_db.php";
$conn = connectData();

if (isset($_SESSION['idtk'])) {
    $idtk = $_SESSION['idtk'];
    $sql = "SELECT Ten_user, Anh_user FROM users WHERE idtk = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idtk);
    $stmt->execute();
    $result = $stmt->get_result();
    $userInfo = $result->fetch_assoc();

    if ($userInfo) {
        $_SESSION['Ten_user'] = $userInfo['Ten_user'];
        $_SESSION['Anh_user'] = $userInfo['Anh_user'];
    }
}

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Tổng sản phẩm
$totalQuery = "SELECT COUNT(*) AS total FROM sanpham";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalProducts = $totalRow['total'];
$totalPages = ceil($totalProducts / $limit);

// Danh mục
$categories = [];
$sqlDanhMuc = "SELECT dm.id_DanhMuc, dm.Ten_DanhMuc, COUNT(sp.id) AS total
               FROM danhmucsanpham dm
               LEFT JOIN sanpham sp ON dm.id_DanhMuc = sp.id_DanhMuc
               GROUP BY dm.id_DanhMuc, dm.Ten_DanhMuc";
$danhMucResult = $conn->query($sqlDanhMuc);
while ($row = $danhMucResult->fetch_assoc()) {
    $categories[] = $row;
}

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $search = trim($_GET['query']);
    $sql = "SELECT * FROM sanpham WHERE Ten LIKE ? OR MoTa LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else if (isset($_GET['danhmuc']) && is_numeric($_GET['danhmuc'])) {
    $id_danhmuc = (int)$_GET['danhmuc'];

    $sql = "SELECT * FROM sanpham WHERE id_DanhMuc = $id_danhmuc LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    $countQuery = "SELECT COUNT(*) AS total FROM sanpham WHERE id_DanhMuc = $id_danhmuc";
    $countResult = $conn->query($countQuery);
    $totalRow = $countResult->fetch_assoc();
    $totalProducts = $totalRow['total'];
    $totalPages = ceil($totalProducts / $limit);
} else {
    $sql = "SELECT * FROM sanpham LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thương Mại Điện Tử</title>
    <link rel="stylesheet" href="./assets/fonts/css/all.min.css">
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/index.css" rel="stylesheet">

</head>

<body>
    <div class="main">
        <?php 
        include "./assets/layout/header/index.php"
        ?>

        <div id="myCarousel" class="carousel slide bg-dark mt-4 mb-4" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner text-center">
                <div class="carousel-item active">
                    <img src="./assets/img/giay.jpg" class="d-block mx-auto" style="height: 500px; object-fit: cover;" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="./assets/img/giay2.jpg" class="d-block mx-auto" style="height: 500px; object-fit: cover;" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="./assets/img/giay3.jpg" class="d-block mx-auto" style="height: 500px; object-fit: cover;" alt="Slide 3">
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-2">
                    <p class="text-title">Danh mục</p>
                    <ul class="list-group list-cus">
                        <?php foreach ($categories as $dm): ?>
                            <li class="list-item d-flex justify-content-between">
                                <a href="?danhmuc=<?= $dm['id_DanhMuc'] ?>"><?= htmlspecialchars($dm['Ten_DanhMuc']) ?></a>
                                <span>(<?= $dm['total'] ?>)</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="col-md-10">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <div class="col">
                                    <div class="card h-100 box-sca">
                                        <a href="./detail.php?id=<?= $row['id'] ?>">
                                            <img src="./assets/img/<?= $row['Anh'] ?>" class="card-img-top mt-2" alt="Hình ảnh sản phẩm">
                                        </a>
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($row['Ten']) ?></h5>
                                            <p class="card-text description-clamp"><?= htmlspecialchars($row['MoTa']) ?></p>
                                            <p>Giá: <?= number_format($row['Gia'], 0, ',', '.') ?> <b>VNĐ</b></p>
                                            <div class="d-flex align-items-center gap-2 flex-nowrap">
                                                <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-detail text-nowrap">
                                                    Chi tiết sản phẩm
                                                </a>
                                                <form action="themvaogio.php" method="POST" class="m-0">
                                                    <input type="hidden" name="idsanpham" value="<?= $row['id'] ?>">
                                                    <button class="btn btn-success d-flex justify-content-center align-items-center cart-btn">
                                                        <i class="fa-solid fa-cart-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p>Không tìm thấy kết quả nào.</p>";
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>

            <?php include "./assets/layout/navigation/navigation.php" ?>
        </div>

        <?php include "./assets/layout/footer/index.php" ?>
    </div>

    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>