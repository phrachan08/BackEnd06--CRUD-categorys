<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";

    // Prepare a delete statement
    $sql = "DELETE FROM product WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_POST["id"]);

        if(mysqli_stmt_execute($stmt)){
            header("location: product.php");
            exit();
        } else{
            echo "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ลบสินค้า</title>
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
                    <h2 class="mt-5 mb-3">ลบสินค้า</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>คุณแน่ใจหรือไม่ว่าต้องการลบสินค้านี้?</p>
                            <p>
                                <input type="submit" value="ใช่" class="btn btn-danger">
                                <a href="product.php" class="btn btn-secondary">ไม่</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>