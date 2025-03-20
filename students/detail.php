<?php
include "../config/database.php";
include "../views/header.php";

if (!isset($_GET["MaSV"])) {
    echo "<p class='text-danger'>Không tìm thấy sinh viên!</p>";
    exit;
}

$MaSV = $_GET["MaSV"];
$query = "SELECT sv.*, nh.TenNganh 
          FROM SinhVien sv 
          JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
          WHERE sv.MaSV = '$MaSV'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    echo "<p class='text-danger'>Không tìm thấy sinh viên!</p>";
    exit;
}

$row = $result->fetch_assoc();
?>

<h2>Thông Tin Chi Tiết Sinh Viên</h2>
<div class="card">
    <div class="card-body">
        <img src="/chieuthu6/KTGiuaKy-QLSV/<?php echo $row['Hinh']; ?>" width="150" class="mb-3">
        <h5>Mã Sinh Viên: <?php echo $row["MaSV"]; ?></h5>
        <h5>Họ Tên: <?php echo $row["HoTen"]; ?></h5>
        <h5>Giới Tính: <?php echo $row["GioiTinh"]; ?></h5>
        <h5>Ngày Sinh: <?php echo $row["NgaySinh"]; ?></h5>
        <h5>Ngành Học: <?php echo $row["TenNganh"]; ?></h5>
        <a href="index.php" class="btn btn-secondary">Quay Lại</a>
    </div>
</div>

<?php include "../views/footer.php"; ?>
