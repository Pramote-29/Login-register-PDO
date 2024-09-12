<?php
session_start();
require("config.php");

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'โปรดล็อกอินก่อนเข้าใช้งาน';
    header('location: login.php');
    exit();
}

// ตรวจสอบว่า role เป็น admin หรือไม่
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้';
    header('location: user_dashboard.php'); // เปลี่ยนไปหน้า user
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="sign-in.css">
    <title>admin dashboard</title>
</head>
<body>
   <div class="container">
   <?php 
        include('navbar.php');
    ?>
   <div class="px-4 py-5 my-5 text-center">
            <?php 
                if (isset($_SESSION['user_id'])){
                    $user_id = $_SESSION['user_id'];
                }

                try{
                    $stmt = $pdo->prepare('SELECT * FROM user WHERE id = ?');
                    $stmt->execute([$user_id]);
                    $userData = $stmt->fetch();

                }catch(PDOException $e){
                    echo $e->getMessage();
                }
            ?>
            <h1 class="display-5 fw-bold text-body-emphasis">Welcome Admin, <?php echo $userData['username']?></h1>
            <div class="container mt-4">
        <h1 class="mb-4">Admin Dashboard</h1>
        <div class="row">
            <!-- Manage Books -->
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <i class="bi bi-book"></i>
                        <h5 class="card-title">Manage Books</h5>
                        <p class="card-text">Add, edit, and delete books.</p>
                        <a href="manage_books.php" class="btn btn-primary">Go to Manage Books</a>
                    </div>
                </div>
            </div>
            <!-- Other management links -->
            <!-- Add other cards as needed -->
        </div>
    </div>
        </div>
   </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</html>