<?php
include "../config/database.php";
include "../views/header.php";

if (!isset($_SESSION["MaSV"])) {
    header("Location: ../auth/login.php");
    exit();
}

$query = "SELECT sv.MaSV, sv.HoTen, sv.GioiTinh, sv.NgaySinh, sv.Hinh, nh.TenNganh 
          FROM SinhVien sv 
          JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh";
$result = $conn->query($query);
?>

<h2>Danh sách Sinh Viên</h2>
<a href="add.php" class="btn btn-success mb-3">Thêm Sinh Viên</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã SV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Ngành</th>
            <th>Hình Ảnh</th>
            <th>Thao Tác</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['MaSV']; ?></td>
            <td><?php echo $row['HoTen']; ?></td>
            <td><?php echo $row['GioiTinh']; ?></td>
            <td><?php echo $row['NgaySinh']; ?></td>
            <td><?php echo $row['TenNganh']; ?></td>
            <td><img src="/chieuthu6/KTGiuaKy-QLSV/<?php echo $row['Hinh']; ?>" width="100"></td>
            <td>
                <a href="detail.php?MaSV=<?php echo $row['MaSV']; ?>" class="btn btn-info">Chi tiết</a>
                <a href="edit.php?MaSV=<?php echo $row['MaSV']; ?>" class="btn btn-warning">Sửa</a>
                <a href="delete.php?MaSV=<?php echo $row['MaSV']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php include "../views/footer.php"; ?>