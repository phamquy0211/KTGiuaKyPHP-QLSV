<?php
include "../config/database.php";
include "../views/header.php";

$query = "SELECT * FROM HocPhan";
$result = $conn->query($query);

if (!isset($_SESSION["MaSV"])) {
    echo "<p class='text-danger'>Vui lòng <a href='../auth/login.php'>đăng nhập</a> để đăng ký học phần.</p>";
    include "../views/footer.php";
    exit();
}

$MaSV = $_SESSION["MaSV"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["MaHP"])) {
    $MaHP = $_POST["MaHP"];
    $NgayDK = date("Y-m-d");

    $checkQuery = "SELECT MaDK FROM DangKy WHERE MaSV = '$MaSV'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows == 0) {
        $conn->query("INSERT INTO DangKy (NgayDK, MaSV) VALUES ('$NgayDK', '$MaSV')");
        $MaDK = $conn->insert_id;
    } else {
        $row = $checkResult->fetch_assoc();
        $MaDK = $row["MaDK"];
    }

    $checkHP = "SELECT * FROM ChiTietDangKy WHERE MaDK = '$MaDK' AND MaHP = '$MaHP'";
    $resultCheckHP = $conn->query($checkHP);

    if ($resultCheckHP->num_rows == 0) {
        $conn->query("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')");
        echo "<p class='text-success'>Đăng ký học phần thành công!</p>";
    } else {
        echo "<p class='text-warning'>Bạn đã đăng ký học phần này rồi.</p>";
    }
}
?>

<h2>Danh sách học phần</h2>
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
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["MaHP"]; ?></td>
                <td><?php echo $row["TenHP"]; ?></td>
                <td><?php echo $row["SoTinChi"]; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="MaHP" value="<?php echo $row["MaHP"]; ?>">
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<a href="../dangky/index.php" class="btn btn-primary">Xem Học phần đã đăng ký</a>

<?php include "../views/footer.php"; ?>
