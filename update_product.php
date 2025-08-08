<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$productname = $price = $category = "";
$productname_err = $price_err = $category_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
    $input_name = trim($_POST["productname"]);
    if(empty($input_name)){
        $productname_err = "กรุณาใส่ชื่อสินค้า";
    } else{
        $productname = $input_name;
    }

    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "กรุณาใส่ราคา";
    } elseif(!ctype_digit($input_price)){
        $price_err = "กรุณาใส่ราคาเป็นตัวเลขเท่านั้น";
    } else{
        $price = $input_price;
    }

    // Validate category
    $input_category = trim($_POST["category"]);
    if(empty($input_category)){
        $category_err = "กรุณาใส่หมวดหมู่";
    } else{
        $category = $input_category;
    }

    // Check input errors before updating the database
    if(empty($productname_err) && empty($price_err) && empty($category_err)){
        // Prepare an update statement
        $sql = "UPDATE product SET productname=?, price=?, category=? WHERE id=?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sisi", $param_name, $param_price, $param_category, $param_id);

            // Set parameters
            $param_name = $productname;
            $param_price = $price;
            $param_category = $category;
            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                header("location: product.php");
                exit();
            } else{
                echo "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);

        $sql = "SELECT * FROM product WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $productname = $row["productname"];
                    $price = $row["price"];
                    $category = $row["category"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    // header("location: error.php");
                    echo "ไม่พบข้อมูล ID ดังกล่าว";
                    exit();
                }
            } else{
                echo "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง";
            }
        }
        mysqli_stmt_close($stmt);
        // mysqli_close($link); // Let the form use the connection
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        // header("location: error.php");
        echo "URL ไม่ถูกต้อง";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลสินค้า</title>
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
                    <h2 class="mt-5">แก้ไขข้อมูลสินค้า</h2>
                    <p>กรุณาแก้ไขข้อมูลในฟอร์มและกดบันทึก</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>ชื่อสินค้า</label>
                            <input type="text" name="productname" class="form-control <?php echo (!empty($productname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $productname; ?>">
                            <span class="invalid-feedback"><?php echo $productname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>ราคา</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>หมวดหมู่</label>
                            <input type="text" name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $category; ?>">
                            <span class="invalid-feedback"><?php echo $category_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="บันทึก">
                        <a href="product.php" class="btn btn-secondary ml-2">ยกเลิก</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>