<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "./connect_DB/connect_db.php";
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        a {
            text-decoration: none;
            color: #333;
        }

        .nav {
            z-index: 10;
            top: 0;
            left: 0;
            right: 0;
            padding: 20px;
        }

        .user-img:hover .box {
            display: block;
        }

        .avatar-img {
            border: 1px solid rgba(0, 0, 0, 0.4);
        }

        .box {
            margin-top: 3px;
            z-index: 10;
            position: absolute;
            top: 10;
            right: 0;
            background-color: white;
            width: 140px;
            height: 30vh;
            display: none;
            box-shadow: 0 0 1px 2px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .box-name {
            text-align: center;
            font-weight: 500;
            font-size: 20px;
            margin: 4px 0;
        }

        .box-tt {
            margin: 12px 0;
            cursor: pointer;
        }

        .box-tt:hover {
            color: rgba(0, 0, 0, 0.4);
        }

        .aff {
            position: relative;
        }

        .aff-child::after {
            content: "";
            left: 0;
            top: 14px;
            position: absolute;
            background-color: transparent;
            width: 100%;
            height: 30px;

        }

        .logoutbtn {
            display: block;
            color: #333;
            text-decoration: none;

        }

        .logoutbtn:hover {
            color: red;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow position-fixed nav">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="./">TQ-Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="./">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="./giohang.php"><i class="fa-solid fa-cart-shopping text-secondary mx-1"></i>Giỏ hàng <span class="badge bg-danger"></span></a></li>
                </ul>

                <form class="d-flex me-3">
                    <input class="form-control me-2  border border-dark" type="search" name="query" placeholder="Tìm kiếm sản phẩm...">
                    <button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>

                <div class="ms-auto">
                    <?php if (isset($_SESSION['idtk'])): ?>
                        <div class="user-img aff d-flex align-items-center justify-content-center">
                            <img src="./assets/img/<?= $_SESSION['Anh_user'] ?>" alt="Avatar" class="rounded-circle avatar-img" width="40" height="40">
                            <div class="position-relative">

                                <p class="box-name px-2 d-flex align-items-center justify-content-center"><?= htmlspecialchars($_SESSION['Ten_user']) ?><i class="fa-solid fa-sort-down mx-1 mb-1"></i></p>
                                <div class="box">
                                    <a href="./thongtinuser.php" class="box-tt d-block">Thông tin chi tiết</a>
                                    <a href="./logout.php" class="logoutbtn" onclick="return confirm('Bạn có muốn đăng xuất không?');">Đăng xuất</a>
                                </div>

                            </div>
                            <div class="aff-child"></div>
                        </div>


                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Đăng nhập</a>
                        <a href="../../signup.php" class="btn btn-secondary">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
    </nav>


</body>

</html>