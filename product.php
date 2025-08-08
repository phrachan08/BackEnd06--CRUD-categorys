<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>รายการสินค้า</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .wrapper{
            width: 800px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">รายการสินค้า ( ไข่หวาน )</h2>
                        <a href="create_product.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> เพิ่มสินค้าใหม่</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM product";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        // 1. หัวตาราง (Headers) เรียงให้ถูกต้อง
                                        echo "<th>#</th>";
                                        echo "<th>ชื่อสินค้า</th>";
                                        echo "<th>ราคา</th>";
                                        echo "<th>หมวดหมู่</th>";
                                        echo "<th>จัดการ</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        // 2. ข้อมูล (Data) เรียงให้ตรงกับหัวตาราง และใช้ชื่อคอลัมน์ที่ถูกต้อง
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['productname'] . "</td>";
                                        echo "<td>" . $row['price'] . "</td>";
                                        echo "<td>" . $row['category'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read_product.php?id='. $row['id'] .'" class="mr-3" title="ดูข้อมูล"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update_product.php?id='. $row['id'] .'" class="mr-3" title="แก้ไขข้อมูล"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete_product.php?id='. $row['id'] .'" title="ลบข้อมูล"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>ไม่พบข้อมูลสินค้า</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>