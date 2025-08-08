<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$productname = $price = $category = "";
$productname_err = $price_err = $category_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate product name
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

    // Check input errors before inserting in database
    if(empty($productname_err) && empty($price_err) && empty($category_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO product (productname, price, category) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sis", $param_name, $param_price, $param_category);

            // Set parameters
            $param_name = $productname;
            $param_price = $price;
            $param_category = $category;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: product.php");
                exit();
            } else{
                echo "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มสินค้าใหม่</title>
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
                    <h2 class="mt-5">เพิ่มสินค้าใหม่</h2>
                    <p>กรุณากรอกแบบฟอร์มนี้เพื่อเพิ่มสินค้าลงในฐานข้อมูล</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="บันทึก">
                        <a href="product.php" class="btn btn-secondary ml-2">ยกเลิก</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>