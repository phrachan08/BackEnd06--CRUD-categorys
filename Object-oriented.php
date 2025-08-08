<?php
// ตั้งค่าให้แสดงผลภาษาไทยได้ถูกต้อง
header('Content-Type: text/html; charset=utf-8');

// --- 1. ตั้งค่าการเชื่อมต่อ ---
$servername = "localhost";
$username = "root";
$password = ""; // สำหรับ XAMPP/MAMP ส่วนใหญ่รหัสผ่านจะเป็นค่าว่าง
$dbname = "login_system";

// สร้างการเชื่อมต่อเริ่มต้น (ยังไม่เลือกฐานข้อมูล)
$conn = new mysqli($servername, $username, $password);
$conn->set_charset("utf8mb4");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
  die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}
echo "✅ เชื่อมต่อกับ MySQL สำเร็จ<br>";

// --- 2. สร้างฐานข้อมูลหากยังไม่มี ---
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($sql_create_db) === TRUE) {
  echo "✅ ฐานข้อมูล '$dbname' พร้อมใช้งาน<br>";
} else {
  die("เกิดข้อผิดพลาดในการสร้างฐานข้อมูล: " . $conn->error);
}

// เลือกฐานข้อมูลเพื่อใช้งาน
$conn->select_db($dbname);

// --- 3. สร้างตารางหากยังไม่มี ---
$sql_create_table = "
CREATE TABLE IF NOT EXISTS products (
  id INT(11) PRIMARY KEY AUTO_INCREMENT,
  productname VARCHAR(255) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_create_table) === TRUE) {
  echo "✅ ตาราง 'products' พร้อมใช้งาน<br>";
} else {
  die("เกิดข้อผิดพลาดในการสร้างตาราง: " . $conn->error);
}

// --- 4. เพิ่มข้อมูลตัวอย่าง (หากตารางว่าง) ---
$result = $conn->query("SELECT id FROM products LIMIT 1");
if ($result->num_rows == 0) {
    $sql_insert_data = "
    INSERT INTO products (productname, price) VALUES
    ('ข้าวผัด', 40.00),
    ('ก๋วยเตี๋ยว', 45.00)";

    if ($conn->query($sql_insert_data) === TRUE) {
        echo "✅ เพิ่มข้อมูลตัวอย่างลงในตารางเรียบร้อยแล้ว<br>";
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลตัวอย่าง: " . $conn->error . "<br>";
    }
}

// --- 5. อัปเดตข้อมูลตามที่ต้องการ ---
$sql_update = "UPDATE products SET productname = 'กระเพรา' WHERE id = 1";

echo "<hr>กำลังอัปเดตข้อมูล...<br>";
if ($conn->query($sql_update) === TRUE) {
  echo "🚀 **อัปเดตข้อมูลสำเร็จ! สินค้า ID 1 ถูกเปลี่ยนเป็น 'กระเพรา' เรียบร้อยแล้ว**<br>";
} else {
  echo "❌ เกิดข้อผิดพลาดในการอัปเดต: " . $conn->error . "<br>";
}

// --- 6. ปิดการเชื่อมต่อ ---
$conn->close();
echo "<hr>การเชื่อมต่อถูกปิด";

?>