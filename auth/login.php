<?php
include "../config/database.php";
include "../views/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST["MaSV"];

    $query = "SELECT * FROM SinhVien WHERE MaSV = '$MaSV'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION["MaSV"] = $MaSV;
        header("Location: ../students/index.php");
        exit();
    } else {
        echo "<p class='text-danger'>Mã Sinh Viên không tồn tại!</p>";
    }
}
?>

<h2>Đăng nhập</h2>
<form method="post">
    <input type="text" name="MaSV" class="form-control" placeholder="Nhập Mã Sinh Viên" required><br>
    <button type="submit" class="btn btn-primary">Đăng nhập</button>
</form>

<?php include "../views/footer.php"; ?>
