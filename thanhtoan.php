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
    <?php
    include "./assets/layout/header/index.php"
    ?>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Thông tin đơn hàng</h2>
                <form action="">
                    <div class="mb-3">
                        <label class="form-label">Ho va ten</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control">

                    </div>
                    <button class="btn btn-warning w-100">Thanh Toán</button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="col-md-6">
                <!-- <h2>Order Summary</h2>
                <div class="card">
                    <div class="card-body">
                        <h5>Stavanger By BN</h5>
                        <p><strong>Dimensions:</strong> 180x200 cm</p>
                        <p><strong>Color:</strong> Black</p>
                        <p><strong>Subtotal:</strong> 36,999.00 kr</p>
                        <p><strong>Total:</strong> 103,999.00 kr</p>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <?php
    include "./assets/layout/footer/index.php"
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('paymentMethod').addEventListener('change', function() {
            var creditCardInfo = document.getElementById('creditCardInfo');
            var paypalInfo = document.getElementById('paypalInfo');
            if (this.value === 'creditCard') {
                creditCardInfo.style.display = 'block';
                paypalInfo.style.display = 'none';
            } else if (this.value === 'paypal') {
                creditCardInfo.style.display = 'none';
                paypalInfo.style.display = 'block';
            } else {
                creditCardInfo.style.display = 'none';
                paypalInfo.style.display = 'none';
            }
        });
    </script>
</body>

</html>