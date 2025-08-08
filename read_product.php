<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM product WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET["id"]);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $productname = $row["productname"];
                $price = $row["price"];
                $category = $row["category"];
            } else{
                header("location: error.php");
                exit();
            }
        } else{
            echo "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else{
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ดูรายละเอียดสินค้า</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">ดูรายละเอียดสินค้า</h1>
                    <div class="form-group">
                        <label><b>ชื่อสินค้า</b></label>
                        <p><?php echo $productname; ?></p>
                    </div>
                    <div class="form-group">
                        <label><b>ราคา</b></label>
                        <p><?php echo $price; ?> บาท</p>
                    </div>
                    <div class="form-group">
                        <label><b>หมวดหมู่</b></label>
                        <p><?php echo $category; ?></p>
                    </div>
                    <p><a href="product.php" class="btn btn-primary">กลับ</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>