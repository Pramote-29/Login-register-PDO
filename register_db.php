<?php 
session_start();
require("config.php");

$minlen = 6;

if(isset($_POST["register"])){
    // รับค่าจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $confirmpassword = $_POST['c_password']; 

    // กำหนดให้ role เป็น user ตั้งแต่เริ่ม
    $role = 'user';

    // ตรวจสอบว่าชื่อผู้ใช้ถูกกรอกหรือไม่
    if(empty($username)){
        $_SESSION['error'] = 'Please enter your username';
        header('location: register.php');
        exit();
    }

    // ตรวจสอบว่ารหัสผ่านมีความยาวพอหรือไม่
    if(strlen($password) < $minlen){
        $_SESSION['error'] = 'Password must be at least 6 characters';
        header('location: register.php');
        exit();
    }

    // ตรวจสอบว่าที่อยู่อีเมลถูกต้องหรือไม่
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] = 'Please enter a valid email';
        header('location: register.php');
        exit();
    }

    // ตรวจสอบว่ารหัสผ่านและยืนยันรหัสผ่านตรงกันหรือไม่
    if($password !== $confirmpassword){
        $_SESSION['error'] = 'Your password does not match';
        header('location: register.php');
        exit();
    }

    // ตรวจสอบว่าชื่อผู้ใช้มีอยู่แล้วหรือไม่
    $checkUsername = $pdo->prepare('SELECT COUNT(*) FROM user WHERE username = ?');
    $checkUsername->execute([$username]);
    $usernameExists = $checkUsername->fetchColumn();

    // ตรวจสอบว่าอีเมลมีอยู่แล้วหรือไม่
    $checkEmail = $pdo->prepare('SELECT COUNT(*) FROM user WHERE email = ?');
    $checkEmail->execute([$email]);
    $emailExists = $checkEmail->fetchColumn();

    if($usernameExists){
        $_SESSION['error'] = 'This username is already taken';
        header('location: register.php');
        exit();
    }

    if($emailExists){
        $_SESSION['error'] = 'This email is already registered';
        header('location: register.php');
        exit();
    }

    // ถ้าไม่มีปัญหา ให้ดำเนินการบันทึกข้อมูลลงฐานข้อมูล
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare('INSERT INTO user(username, email, password, role) VALUES(?, ?, ?)');
        $stmt->execute([$username, $email, $passwordHash, $role]);

        $_SESSION['success'] = 'Registration successful';
        header('location: register.php');
        exit();
    } catch(PDOException $e) {
        $_SESSION['error'] = 'Something went wrong: ' . $e->getMessage();
        header('location: register.php');
        exit();
    }
}
?>