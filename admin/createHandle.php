<?php
include_once("../connect.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.html");
    exit;
}

$TenTL = isset($_POST['nameType']) ? trim($_POST['nameType']) : '';
$ThuTu = isset($_POST['numericalOrder']) ? intval($_POST['numericalOrder']) : 0;
$HideShow = isset($_POST['hideShow']) ? intval($_POST['hideShow']) : 1;
$iconName = '';


$projectRoot = dirname(__DIR__);               // path tới thư mục project (1 cấp trên admin)
$uploadDirFs = $projectRoot . '/assets/image/';

// nếu thư mục chưa tồn tại thì tạo
if (!is_dir($uploadDirFs)) {
    if (!mkdir($uploadDirFs, 0755, true) && !is_dir($uploadDirFs)) {
        // không tạo được thư mục -> báo lỗi và dừng
        die("Không tạo được thư mục upload: $uploadDirFs");
    }
}


// xử lý upload ảnh (nếu có)
if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['icon']['tmp_name'];
    $orig = basename($_FILES['icon']['name']);
    $ext = pathinfo($orig, PATHINFO_EXTENSION);
    $safe = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($orig, PATHINFO_FILENAME));
    $iconName = time() . "_" . $safe . "." . $ext;
    $target = $uploadDirFs . $iconName; // ví dụ: .../assets/image/123_name.jpg

    if (!move_uploaded_file($tmp, $target)) {
        // upload thất bại -> xóa tên file để không lưu vào DB
        $iconName = '';
    }
}

// Insert dùng prepared statement (chú ý tên cột theo DB của bạn)
$stmt = mysqli_prepare($connect, "INSERT INTO theloai (tenTL, thuTu, anHien, icon) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    die("Lỗi prepare: " . mysqli_error($connect));
}
mysqli_stmt_bind_param($stmt, "siis", $TenTL, $ThuTu, $HideShow, $iconName);
$ok = mysqli_stmt_execute($stmt);
$err = mysqli_error($connect);
mysqli_stmt_close($stmt);

if ($ok) {
    header("Location: readHandle.php");
    echo "Thêm thành công";
    exit;
} else {
    if ($iconName && file_exists($uploadDirFs . $iconName)) {
        @unlink($uploadDirFs . $iconName);
    }
    header("Location: readHandle.php");
    echo "Lỗi thêm mới: $err";
    exit;
}
?>
