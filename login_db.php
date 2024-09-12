<?php 
session_start();
require("config.php");

// ตรวจสอบว่าปุ่ม "login" ถูกคลิกหรือไม่
if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';  // ใช้ค่าเริ่มต้นเป็นว่างในกรณีที่ไม่ได้รับค่าจากฟอร์ม
    $password = $_POST['password'] ?? '';

    // ตรวจสอบว่าฟิลด์อีเมลหรือรหัสผ่านว่างหรือไม่
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'โปรดใส่อีเมลหรือรหัสผ่าน';
        header('location: login.php');
        exit();
    }
    
    // ตรวจสอบรูปแบบอีเมล
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'โปรดใส่อีเมลที่ถูกต้อง';
        header('location: login.php');
        exit();
    }

    // เริ่มกระบวนการตรวจสอบข้อมูลในฐานข้อมูล
    else {
        try {
            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
            $stmt = $pdo->prepare('SELECT * FROM user WHERE email = ?');
            $stmt->execute([$email]);
            $userData = $stmt->fetch();

            // ตรวจสอบว่าพบข้อมูลผู้ใช้และรหัสผ่านถูกต้องหรือไม่
            if ($userData && password_verify($password, $userData['password'])) {
                // เก็บข้อมูลผู้ใช้ใน session
                $_SESSION['user_id'] = $userData['id']; // เก็บเฉพาะ ID ผู้ใช้
                $_SESSION['username'] = $userData['username']; // เก็บชื่อผู้ใช้
                $_SESSION['role'] = $userData['role']; // เก็บ role ของผู้ใช้

                // ตรวจสอบบทบาทของผู้ใช้และเปลี่ยนเส้นทางตามบทบาท
                if ($userData['role'] === 'admin') {
                    header('location: admin_dashboard.php'); // เปลี่ยนไปหน้า Admin Dashboard
                } else {
                    header('location: dashboard.php'); // เปลี่ยนไปหน้า User Dashboard
                }
                exit();
            } else {
                $_SESSION['error'] = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
                header('location: login.php');
                exit(); 
            }
        } catch(PDOException $e) {
            $_SESSION['error'] = 'มีบางอย่างผิดพลาด โปรดลองใหม่อีกครั้ง';
            header('location: login.php');
            exit(); 
        }
    }
}
?>
