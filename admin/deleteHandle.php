<?php
include_once("../connect.php");

$idTL = isset($_GET['idTL']) ? intval($_GET['idTL']) : 0;

if ($idTL > 0) {
    // Xóa bản ghi
    $stmt = mysqli_prepare($connect, "DELETE FROM theloai WHERE idTL = ?");
    mysqli_stmt_bind_param($stmt, "i", $idTL);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Chuyển hướng về lại danh sách với thông báo
    echo "<script>alert('Xóa thành công'); window.location.href='readHandle.php';</script>";
    exit;
} else {
    echo "<script>alert('ID không hợp lệ'); window.location.href='readHandle.php';</script>";
    exit;
}
?>