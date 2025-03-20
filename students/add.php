<?php
include "../config/database.php";
include "../views/header.php";

$nganhQuery = "SELECT * FROM NganhHoc";
$nganhResult = $conn->query($nganhQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST["MaSV"];
    $HoTen = $_POST["HoTen"];
    $GioiTinh = $_POST["GioiTinh"];
    $NgaySinh = $_POST["NgaySinh"];
    $MaNganh = $_POST["MaNganh"];
    $Hinh = "images/" . $_FILES["Hinh"]["name"];
    move_uploaded_file($_FILES["Hinh"]["tmp_name"], "../" . $Hinh);

    $query = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
              VALUES ('$MaSV', '$HoTen', '$GioiTinh', '$NgaySinh', '$Hinh', '$MaNganh')";
    
    if ($conn->query($query)) {
        header("Location: index.php");
    } else {
        echo "<p class='text-danger'>Lỗi khi thêm sinh viên!</p>";
    }
}
?>

<h2>Thêm Sinh Viên</h2>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="MaSV" placeholder="Mã Sinh Viên" required class="form-control mb-2">
    <input type="text" name="HoTen" placeholder="Họ Tên" required class="form-control mb-2">
    <select name="GioiTinh" class="form-control mb-2">
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
    </select>
    <input type="date" name="NgaySinh" required class="form-control mb-2">
    
    <select name="MaNganh" class="form-control mb-2">
        <?php while ($nganh = $nganhResult->fetch_assoc()) { ?>
            <option value="<?php echo $nganh['MaNganh']; ?>"><?php echo $nganh['TenNganh']; ?></option>
        <?php } ?>
    </select>

    <input type="file" name="Hinh" id="Hinh" class="form-control mb-2" onchange="previewImage(event)">
    
    <img id="preview" src="" alt="Xem trước ảnh" class="mt-2" style="max-width: 150px; display: none;">

    <a href="index.php" class="btn btn-secondary mt-3">Hủy</a>
    <button type="submit" class="btn btn-success mt-3">Thêm</button>
</form>

<script>
function previewImage(event) {
    var preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = 'block';
}
</script>

<?php include "../views/footer.php"; ?>
