<?php
include "./connect_DB/connect_db.php";

$conn = connectData();
$mess = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = trim($_POST['username']);
    $password = $_POST['password'];

    $ten = str_replace(" ", "", $ten);
    $roleId = 2;
    $Anh = "user.jpg";

    $sql = "INSERT INTO user (username, password, roleId, Anh, sdt, email) 
            VALUES ('$ten', '$password', '$roleId', '$Anh', '$sdt', '$email')";

    if ($conn->query($sql) === TRUE) {
        header("location: ./login.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <h2 class="fw-bold mb-4">Đăng ký</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Tên">
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="mb-3">
                <input type="passwonamerd" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="mb-3">
                <input type="text" name="sdt" class="form-control" placeholder="Số điện thoại">
            </div>
            <button type="submit" class="btn btn-custom w-100 mt-3">Đăng ký</button>
        </form>
        <p class="mt-3">Đã có tài khoản <a href="./login.php" class="text-white fw-bold">Đăng nhập</a></p>
    </div>


    <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>