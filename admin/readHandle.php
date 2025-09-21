<?php 
include_once("../connect.php");

// Lấy dữ liệu từ CSDL
$sql = "SELECT * FROM theloai ORDER BY idTL DESC";
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
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <form action="admin/readHandle.php" method="post" enctype="multipart/form-data" name="fomr1">
        <table>
            <tr>
                <td><label for="nameType"> Name Type</label></td>
                <td class="col2AllRow"><input type="text" name="nameType" id="nameType"></td>
            </tr>

            <tr>
                <td><label for="numericalOrder">Numerical Order</label></td>
                <td class="col2AllRow" ><input type="text" name="numericalOrder" id="numericalOrder"></td>
            </tr>

            <tr>
                <td><label for="AnHien">Hide Show</label></td>
                <td class="col2AllRow" ><select name="AnHien" id="AnHien">
                    <option value="0">Hide</option>
                    <option value="1">Show</option>
                </select></td>
            </tr>

            <tr>
                <td><label for="icon">Icon</label></td>
                <td class="col2AllRow" ><input type="file" name="icon" id="icon"></td>
            </tr>
            
            <tr>
                <td id="col1_row5"> </td>
                <td class="col2AllRow" colspan="2">
                    <a href="updatesHandle.php" class="btn updates">Updates</a>
                    <a href="deleteHandle.php" class="btn delete">Delete</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>