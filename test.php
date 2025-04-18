<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./assets/fonts/css/all.min.css">
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #0e1a2b;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            background-color: #101b2d;
            height: 100vh;
            padding: 20px;
        }

        .sidebar h2 {
            color: #fff;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .menu-link {
            display: block;
            padding: 12px;
            color: #c0c7d1;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: background 0.2s ease;
        }

        .menu-link:hover,
        .menu-link.active {
            background-color: #1d2b44;
            color: #fff;
        }

        .content-wrapper {
            padding: 20px;
        }

        .card-custom {
            background-color: #1d2b44;
            border: none;
            border-radius: 12px;
            color: #fff;
            margin-bottom: 20px;
            padding: 20px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
        }

        .stat-text {
            font-size: 14px;
            color: #9da9ba;
        }

        .logout-btn {
            margin-top: 20px;
        }

        .card-icon {
            font-size: 30px;
            float: right;
            color: #4e8cff;
        }

        .navbar input::placeholder {
            color: #ccc;
        }

        .badge {
            font-size: 10px;
            height: 16px;
            width: 16px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <!-- HEADER NAVBAR -->
    <nav class="navbar navbar-expand-lg px-4 py-2 bg-primary">
        <div class="d-flex align-items-center w-100 justify-content-between">
            <!-- Logo + Toggle -->
            <div class="d-flex align-items-center">
                <img src="https://img.icons8.com/fluency/32/stack.png" alt="Logo" class="me-2">
                <span class="text-white fs-5 fw-bold">AppStack</span>
                <i class="fa-solid fa-bars ms-4 text-white" style="cursor:pointer;"></i>
            </div>

            <!-- Search -->
            <div class="d-flex align-items-center flex-grow-1 mx-4">
                <input class="form-control bg-dark border-0 text-white" type="text" placeholder="Search projects..." style="max-width: 300px;" />
                <i class="fa-solid fa-magnifying-glass text-white ms-2"></i>
                <div class="ms-4 text-white dropdown">
                    <span class="dropdown-toggle" data-bs-toggle="dropdown" role="button">Mega menu</span>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Option 1</a></li>
                        <li><a class="dropdown-item" href="#">Option 2</a></li>
                    </ul>
                </div>
            </div>

            <!-- Icons + Profile -->
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <i class="fa-regular fa-bell text-white fs-5"></i>
                    <span class="badge bg-primary rounded-circle position-absolute top-0 start-100 translate-middle p-1" style="font-size: 10px;">4</span>
                </div>
                <i class="fa-solid fa-bell-slash text-white fs-5"></i>
                <i class="fa-solid fa-sun text-white fs-5"></i>
                <img src="https://flagsapi.com/US/flat/24.png" class="rounded-circle" alt="Flag">
                <div class="dropdown">
                    <span class="text-white dropdown-toggle" data-bs-toggle="dropdown" role="button">Chris Wood</span>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h2>AppStack</h2>
                <a href="qLsp.php" class="menu-link active"><i class="fa-brands fa-product-hunt me-2"></i> Sản phẩm</a>
                <a href="qlnd.php" class="menu-link"><i class="fa-solid fa-user me-2"></i> Người dùng</a>
                <a href="logout.php" class="btn btn-danger logout-btn w-100" onclick="return confirm('Bạn có muốn đăng xuất không?');">Đăng xuất</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 content-wrapper">
                <div id="content" class="mt-4">
                    <?php include 'qLsp.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".menu-link").click(function(e) {
                e.preventDefault();
                $(".menu-link").removeClass("active");
                $(this).addClass("active");
                const page = $(this).attr("href");
                $("#content").load(page);
            });
        });
    </script>
</body>

</html>