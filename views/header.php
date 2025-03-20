<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh Viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/chieuthu6/KTGiuaKy-QLSV/students/index.php">Quản Lý Sinh Viên</a>
        <div class="navbar-nav">
            <a class="nav-link" href="/chieuthu6/KTGiuaKy-QLSV/students/index.php">Sinh viên</a>
            <a class="nav-link" href="/chieuthu6/KTGiuaKy-QLSV/hocphan/index.php">Học phần</a>
            <a class="nav-link" href="/chieuthu6/KTGiuaKy-QLSV/dangky/index.php">Học phần đã đăng ký</a>
            <?php if (isset($_SESSION["MaSV"])) { ?>
                <a class="nav-link" href="/chieuthu6/KTGiuaKy-QLSV/auth/logout.php">Đăng xuất</a>
            <?php } else { ?>
                <a class="nav-link" href="/chieuthu6/KTGiuaKy-QLSV/auth/login.php">Đăng nhập</a>
            <?php } ?>
        </div>
    </div>
</nav>

<div class="container mt-4">
