<?php
session_start();


$conn = new mysqli("localhost", "root", "", "_qlbh_");
$mess = "";


if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $username = str_replace(" ", "", $username);

    $query = "SELECT * FROM taikhoan WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['password'] === $password) {
            if ($row['trangthai'] == 0) {
                $mess = "<div style='color: red; text-align: center;'>Tài khoản của bạn đã bị khóa.</div>";
            } else {
                $_SESSION['iduser'] = $user_id;
                $_SESSION['idtk'] = $row['idtk'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['Anh'] = $row['Anh'];
                $_SESSION['role_id'] = $row['roleId'];

                if (!isset($_SESSION["cart"])) {
                    $_SESSION["cart"] = [];
                }

                if ($row['roleId'] == 1) {
                    header("Location: admin.php");
                } else if($row['roleId'] == 2){
                    header("Location: index.php");
                }else{
                    header("Location: operater.php");
                }
                exit();
            }
        } else {
            $mess = "<div style='color: red; text-align: center;'>Mật khẩu không đúng.</div>";
        }
    } else {
        $mess = "<div style='color: red; text-align: center;'>Tài khoản không tồn tại.</div>";
    }
}


$conn->close();
?>



<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/fonts/css/all.min.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('./assets/img/bg.jpg') no-repeat center center/cover;
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            color: white;
            text-align: center;
        }

        .glassmorphism input {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        .glassmorphism input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .glassmorphism input:focus {
            background: rgba(255, 255, 255, 0.6);
            outline: none;
        }

        .btn-custom {
            background: rgba(255, 255, 255, 0.3);
            border: none;
            color: white;
        }

        .btn-custom:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 768px) {
            .glassmorphism {
                padding: 20px;
                max-width: 90%;
            }

        }

        @media (max-width: 480px) {
            .glassmorphism {
                padding: 15px;
            }

            .glassmorphism h2 {
                font-size: 22px;
            }

            .btn-custom {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>

    <div class="glassmorphism">
        <h2 class="fw-bold mb-4">Đăng nhập</h2>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Nhập tên" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            </div>
            <div class="d-flex justify-content-end">
                <a href="#" class="text-white">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="btn btn-custom w-100 mt-3">Đăng nhập</button>
        </form>
        <p class="mt-3">Không có tài khoản? <a href="./signup.php" class="text-white fw-bold">Đăng ký</a></p>

        <?= $mess ?>
    </div>

    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>