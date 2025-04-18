<?php
include "./connect_DB/connect_db.php";

$conn = connectData();

$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = '';
$whereClause = '';
$params = [];
$types = '';
$queryString = '';

if (!empty($_GET['query'])) {
    $search = trim($_GET['query']);
    $whereClause = "WHERE username LIKE ? OR email LIKE ?";
    $params = ["%$search%", "%$search%"];
    $types = "ss";
    $queryString = '&query=' . urlencode($search);
} elseif (!empty($_GET['queryid'])) {
    $search = trim($_GET['queryid']);
    $whereClause = "WHERE id LIKE ?";
    $params = ["%$search%"];
    $types = "s";
    $queryString = '&queryid=' . urlencode($search);
}

$countSql = "SELECT COUNT(*) AS total FROM users $whereClause";
$stmt = $conn->prepare($countSql);
if (!empty($whereClause)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$resultCount = $stmt->get_result();
$totalRow = $resultCount->fetch_assoc();
$totalUsers = $totalRow['total'];
$totalPages = ceil($totalUsers / $limit);

$sql = "SELECT * FROM users $whereClause LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($sql);
if (!empty($whereClause)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="./assets/fonts/css/all.min.css">
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mb-5 mt-4">
        <h2 class="text-center mb-4">Quản lý người dùng</h2>

        <!-- Search -->
        <div class="row g-2 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 ">
                <div class="d-flex flex-wrap">
                    <div class="col-12 col-md-6 mb-2">
                        <form action="" method="GET" class="d-flex me-3" style="max-width: 400px;">
                            <input type="text" name="query" class="form-control me-2" placeholder="Tìm kiếm..." style="width: 250px;">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                    <div class="col-12 col-md-6">
                    <form action="" method="GET" class="d-flex" style="max-width: 400px;">
                        <input type="text" name="queryid" class="form-control me-2" placeholder="Tìm kiếm theo ID..." style="width: 150px;">
                        <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i> Tìm theo ID</button>
                    </form>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- User Table -->
        <div class="table-responsive">
            <table class="table table-hover border align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Ảnh</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['iduser'] ?></td>
                                <td><?= htmlspecialchars($row['Ten_user']) ?></td>
                                <td><img src="./assets/img/<?= $row['Anh_user'] ?>" class="img-fluid rounded" style="max-width: 60px;"></td>
                                <td><?= $row['sdt'] ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><a href="./ad/suasanpham.php?id=<?= $row['iduser'] ?>" class="btn btn-warning btn-sm">Sửa</a></td>
                                <td><a href="./ad/xoasanpham.php?id=<?= $row['iduser'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa không?');">Xóa</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Không tìm thấy người dùng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php
            include "./assets/layout/navigation/navigation.php"
        ?>
    </div>

    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
