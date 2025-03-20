<?php
include "../config/database.php";
include "../views/header.php";

$MaSV = $_GET["MaSV"];
$query = "SELECT * FROM SinhVien WHERE MaSV = '$MaSV'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

$nganhQuery = "SELECT * FROM NganhHoc";
$nganhResult = $conn->query($nganhQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST["HoTen"];
    $GioiTinh = $_POST["GioiTinh"];
    $NgaySinh = $_POST["NgaySinh"];
    $MaNganh = $_POST["MaNganh"];

    if (!empty($_FILES["Hinh"]["name"])) {
        $Hinh = "images/" . $_FILES["Hinh"]["name"];
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], "../" . $Hinh);
    } else {
        $Hinh = $row["Hinh"];
    }

    $query = "UPDATE SinhVien SET HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', Hinh='$Hinh', MaNganh='$MaNganh' WHERE MaSV='$MaSV'";
    
    if ($conn->query($query)) {
        header("Location: index.php");
    } else {
        echo "<p class='text-danger'>Lỗi khi cập nhật!</p>";
    }
}
?>

<h2>Sửa Thông Tin</h2>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="HoTen" value="<?php echo $row['HoTen']; ?>" required class="form-control mb-2">
    <select name="GioiTinh" class="form-control mb-2">
        <option value="Nam" <?php if ($row['GioiTinh'] == 'Nam') echo 'selected'; ?>>Nam</option>
        <option value="Nữ" <?php if ($row['GioiTinh'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
    </select>
    <input type="date" name="NgaySinh" value="<?php echo $row['NgaySinh']; ?>" required class="form-control mb-2">

    <select name="MaNganh" class="form-control mb-2">
        <?php while ($nganh = $nganhResult->fetch_assoc()) { ?>
            <option value="<?php echo $nganh['MaNganh']; ?>" <?php if ($row['MaNganh'] == $nganh['MaNganh']) echo 'selected'; ?>>
                <?php echo $nganh['TenNganh']; ?>
            </option>
        <?php } ?>
    </select>

    <input type="file" name="Hinh" id="Hinh" class="form-control mb-2" onchange="previewImage(event)">

    <img id="preview" src="/chieuthu6/KTGiuaKy-QLSV/<?php echo $row['Hinh']; ?>" alt="Xem trước ảnh" class="mt-2" style="max-width: 150px;"><br>

    <a href="index.php" class="btn btn-secondary mt-3">Hủy</a>
    <button type="submit" class="btn btn-warning mt-3">Cập nhật</button>
</form>

<script>
function previewImage(event) {
    var preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = 'block';
}
</script>

<?php include "../views/footer.php"; ?>
