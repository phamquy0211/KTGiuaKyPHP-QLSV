<?php
include "../config/database.php";

if (!isset($_GET["MaSV"])) {
    echo "<p class='text-danger'>Không tìm thấy sinh viên!</p>";
    exit;
}

$MaSV = $_GET["MaSV"];

$checkQuery = "SELECT * FROM DangKy WHERE MaSV = '$MaSV'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {
    echo "<script>alert('Không thể xóa! Sinh viên đã đăng ký học phần.'); window.location.href='index.php';</script>";
    exit;
}

$query = "DELETE FROM SinhVien WHERE MaSV = '$MaSV'";
if ($conn->query($query)) {
    echo "<script>alert('Xóa thành công!'); window.location.href='index.php';</script>";
} else {
    echo "<p class='text-danger'>Lỗi khi xóa!</p>";
}
?>
