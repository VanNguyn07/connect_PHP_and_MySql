<?php
include_once("../connect.php");

// Lấy dữ liệu từ CSDL
$sql = "SELECT * FROM theloai ORDER BY idTL ASC";
$result = mysqli_query($connect, $sql);
if(!$result) {
    die("Error: Could not able to execute $sql. " . mysqli_error($connect));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect PHP And My Sql</title>
    <link rel="stylesheet" href="../styleReadHandle.css">
</head>
<body>
    <h2>List Type!</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name Type</th>
            <th>Numerical Order</th>
            <th>Hide Show</th>
            <th>Icon</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['idTL']; ?></td>
            <td><?php echo htmlspecialchars($row['tenTL']); ?></td>
            <td><?php echo $row['thuTu']; ?></td>
            <td><?php echo htmlspecialchars($row['anHien']); ?></td>
            <td>
                <?php if (!empty($row['icon'])): ?>
                    <img src="../assets/image/<?php echo htmlspecialchars($row['icon']); ?>" alt="icon" width="40">
                <?php endif; ?>
            </td>
            <td>
                <div class="btn-group">
                    <a href="../admin/updatesHandle.php?idTL=<?php echo $row['idTL']; ?>" class="btn btn-up">Updates</a>
                    <a href="../admin/deleteHandle.php?idTL=<?php echo $row['idTL']; ?>" class="btn btn-de" onclick="return confirm('Are you sure to delete?');">Delete</a>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>