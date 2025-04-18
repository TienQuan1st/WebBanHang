<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quản trị viên</title>
    <link rel="stylesheet" href="./assets/fonts/css/all.min.css">
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .text-head {
            font-size: 24px;
            margin: 18px 0;
        }

        .menu-link {
            text-decoration: none;
            color: #fff;
            padding: 8px 12px;
            margin: 6px 0;
        }

        .menu-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            transition: .2s all linear;
            transform: translateX(3px);
        }

        .btn-cus {
            width: 100%;
        }

        @media (max-width: 767.98px) {
            .offcanvas-start {
                width: 200px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary d-md-none">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 bg-primary d-none d-md-flex flex-column min-vh-100 text-white p-3">
                <h4 class="text-head text-center">Admin</h4>
                <hr class="bg-light">
                <a href="?page=qltk" class="menu-link"><i class="fa-solid fa-user me-1"></i>Tài khoản</a>
                <a href="?page=qLsp" class="menu-link"><i class="fa-brands fa-product-hunt me-1"></i>Quản lý sản phẩm</a>
                <a href="?page=qlnd" class="menu-link"><i class="fa-solid fa-user me-1"></i>Người dùng</a>
                <a href="logout.php" class="btn btn-danger mt-4 btn-cus text-white" onclick="return confirm('Bạn có muốn đăng xuất không?');">Đăng xuất</a>
            </div>

            <div class="offcanvas offcanvas-start bg-primary text-white" tabindex="-1" id="offcanvasSidebar">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Menu Admin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body d-flex flex-column">
                    <a href="?page=qLsp" class="menu-link"><i class="fa-brands fa-product-hunt me-1"></i>Quản lý sản phẩm</a>
                    <a href="?page=qltk" class="menu-link"><i class="fa-solid fa-user me-1"></i>Tài khoản</a>
                    <a href="?page=qlnd" class="menu-link"><i class="fa-solid fa-user me-1"></i>Người dùng</a>
                    <a href="logout.php" class="btn btn-danger mt-3 btn-cus text-white" onclick="return confirm('Bạn có muốn đăng xuất không?');">Đăng xuất</a>
                </div>
            </div>

            <div class="col-md-10 p-3" id="content">
                <?php
                    $page = $_GET['page'] ?? 'qltk';
                    include $page . '.php';
                ?>
            </div>
        </div>
    </div>

    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".menu-link").click(function (e) {
                e.preventDefault();
                const page = $(this).attr("href").split('?page=')[1];
                $("#content").load(page + '.php');
                if (window.innerWidth < 768) {
                    const offcanvasEl = document.getElementById('offcanvasSidebar');
                    const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                    bsOffcanvas.hide();
                }
            });
        });
    </script>
</body>

</html>
