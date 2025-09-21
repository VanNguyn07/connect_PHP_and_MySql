<?php 
include_once("../connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $idTL = intval($_POST['idTL']);
    $tenTL = trim($_POST['nameType']);
    $thuTu = intval($_POST['numericalOrder']);
    $anHien = $_POST['AnHien'];
    $iconName = '';

    // Xử lý upload icon mới nếu có
    $projectRoot = dirname(__DIR__);
    $uploadDirFs = $projectRoot . '/assets/image/';
    if (!is_dir($uploadDirFs)) {
        mkdir($uploadDirFs, 0755, true);
    }
    if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['icon']['tmp_name'];
        $orig = basename($_FILES['icon']['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        $safe = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($orig, PATHINFO_FILENAME));
        $iconName = time() . "_" . $safe . "." . $ext;
        $target = $uploadDirFs . $iconName;
        move_uploaded_file($tmp, $target);
    } else {
        // Nếu không upload mới, giữ icon cũ
        $iconName = isset($_POST['icon_old']) ? $_POST['icon_old'] : '';
    }

    // Update DB
    $stmt = mysqli_prepare($connect, "UPDATE theloai SET tenTL=?, thuTu=?, anHien=?, icon=? WHERE idTL=?");
    mysqli_stmt_bind_param($stmt, "siisi", $tenTL, $thuTu, $anHien, $iconName, $idTL);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: readHandle.php?msg=" . urlencode("Cập nhật thành công!"));
    exit;
}

// Lấy dữ liệu để hiển thị lên form (giữ nguyên như trên)
$idTL = isset($_GET['idTL']) ? intval($_GET['idTL']) : 0;
$tenTL = $thuTu = $anHien = $icon = '';

if ($idTL > 0) {
    $sql = "SELECT * FROM theloai WHERE idTL = $idTL";
    $result = mysqli_query($connect, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $tenTL = $row['tenTL'];
        $thuTu = $row['thuTu'];
        $anHien = $row['anHien'];
        $icon = $row['icon'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect PHP And My Sql</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data" name="fomr1">
        <input type="hidden" name="idTL" value="<?php echo $idTL; ?>">
        <input type="hidden" name="icon_old" value="<?php echo htmlspecialchars($icon); ?>">

        <table>
            <tr>
                <td><label for="nameType"> Name Type</label></td>
                <td class="col2AllRow"><input type="text" name="nameType" id="nameType"
                    value="<?php  echo htmlspecialchars($tenTL); ?>"></td>
            </tr>

            <tr>
                <td><label for="numericalOrder">Numerical Order</label></td>
                <td class="col2AllRow" ><input type="text" name="numericalOrder" id="numericalOrder"
                    value="<?php echo htmlspecialchars($thuTu); ?>"></td>
            </tr>

            <tr>
                <td><label for="AnHien">Hide Show</label></td>
                <td class="col2AllRow" >
                    <select name="AnHien" id="AnHien">
                    <option value="0" <?php if($anHien === 'Hide') echo 'selected';?>>Hide</option>
                    <option value="1" <?php if($anHien === 'Show') echo 'selected';?>>Show</option>
                </select></td>
            </tr>

            <tr>
                <td><label for="icon">Icon</label></td>
                <td class="col2AllRow" >
                    <?php if($icon): ?>
                        <img src="../assets/image/<?php echo htmlspecialchars($icon); ?>" alt="icon" width="40"><br>
                    <?php endif; ?>
                    <input type="file" name="icon" id="icon">
                </td>
            </tr>
            
            <tr>
                <td id="col1_row5"> </td>
                <td class="col2AllRow" colspan="2">
                    <button type="submit" name="update">Updates</button>
                    <button type="reset">Cancel</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>