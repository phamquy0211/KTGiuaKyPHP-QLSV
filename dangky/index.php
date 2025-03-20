<?php
include "../config/database.php";
include "../views/header.php";

if (!isset($_SESSION["MaSV"])) {
    echo "<p class='text-danger'>Vui lòng <a href='../auth/login.php'>đăng nhập</a> để xem học phần đã đăng ký.</p>";
    include "../views/footer.php";
    exit();
}

$MaSV = $_SESSION["MaSV"];

$sinhVienQuery = "SELECT SV.MaSV, SV.HoTen, SV.NgaySinh, NH.TenNganh 
                  FROM SinhVien SV 
                  JOIN NganhHoc NH ON SV.MaNganh = NH.MaNganh 
                  WHERE SV.MaSV = '$MaSV'";
$sinhVienResult = $conn->query($sinhVienQuery);
$sinhVien = $sinhVienResult->fetch_assoc();

$query = "SELECT HP.MaHP, HP.TenHP, HP.SoTinChi, DK.MaDK
          FROM HocPhan HP
          JOIN ChiTietDangKy CT ON HP.MaHP = CT.MaHP
          JOIN DangKy DK ON CT.MaDK = DK.MaDK
          WHERE DK.MaSV = '$MaSV'";

$result = $conn->query($query);

$totalCourses = 0;
$totalCredits = 0;
$dangKy = [];
while ($row = $result->fetch_assoc()) {
    $totalCourses++;
    $totalCredits += $row["SoTinChi"];
    $dangKy[] = $row;
}

if (isset($_POST["delete"])) {
    $MaHP = $_POST["MaHP"];
    $MaDK = $_POST["MaDK"];
    $conn->query("DELETE FROM ChiTietDangKy WHERE MaDK='$MaDK' AND MaHP='$MaHP'");
    header("Location: index.php");
}

if (isset($_POST["delete_all"])) {
    $conn->query("DELETE FROM ChiTietDangKy WHERE MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV='$MaSV')");
    $conn->query("DELETE FROM DangKy WHERE MaSV='$MaSV'");
    header("Location: index.php");
}

$showStudentInfo = isset($_POST["show_info"]);

if (isset($_POST["confirm"])) {
    echo "<p class='text-success'>Đăng ký thành công!</p>";
    $showStudentInfo = false;
}

?>

<h2>Học phần đã đăng ký</h2>

<?php if ($totalCourses > 0) { ?>
    <p><strong>Tổng số học phần:</strong> <?php echo $totalCourses; ?></p>
    <p><strong>Tổng số tín chỉ:</strong> <?php echo $totalCredits; ?></p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã HP</th>
                <th>Tên học phần</th>
                <th>Số tín chỉ</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dangKy as $row) { ?>
                <tr>
                    <td><?php echo $row["MaHP"]; ?></td>
                    <td><?php echo $row["TenHP"]; ?></td>
                    <td><?php echo $row["SoTinChi"]; ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="MaHP" value="<?php echo $row["MaHP"]; ?>">
                            <input type="hidden" name="MaDK" value="<?php echo $row["MaDK"]; ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Xoá</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <form method="post">
        <button type="submit" name="delete_all" class="btn btn-warning">Xoá đăng ký</button>
        <button type="submit" name="show_info" class="btn btn-success">Lưu đăng ký</button>
    </form>

<?php } else { ?>
    <p class='text-warning'>Bạn chưa đăng ký học phần nào.</p>
<?php } ?>

<?php if ($showStudentInfo) { ?>
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Thông tin đăng ký</div>
        <div class="card-body">
            <p><strong>Mã SV:</strong> <?php echo $sinhVien["MaSV"]; ?></p>
            <p><strong>Họ Tên:</strong> <?php echo $sinhVien["HoTen"]; ?></p>
            <p><strong>Ngày Sinh:</strong> <?php echo $sinhVien["NgaySinh"]; ?></p>
            <p><strong>Ngành Học:</strong> <?php echo $sinhVien["TenNganh"]; ?></p>
            <p><strong>Ngày Đăng Ký:</strong> <?php echo date("Y-m-d"); ?></p>

            <form method="post">
            <button type="submit" class="btn btn-secondary">Huỷ</button>
                <button type="submit" name="confirm" class="btn btn-primary">Xác nhận</button>
            </form>
        </div>
    </div>
<?php } ?>

<?php include "../views/footer.php"; ?>
