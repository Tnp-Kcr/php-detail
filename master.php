<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// การเชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "u299560388_651230";
$password = "PP7759Pb";
$dbname = "u299560388_651230";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sid'])) {
    $sidToDelete = $_POST['sid'];

    // ตรวจสอบค่าที่ได้รับ
    error_log("SID ที่จะลบ: " . $sidToDelete);

    // สร้างคำสั่ง SQL สำหรับการลบ
    $deleteSql = "DELETE FROM tbl_student WHERE SID = ?";
    
    // เตรียมคำสั่ง SQL
    if ($stmt = $conn->prepare($deleteSql)) {
        // Bind parameters
        $stmt->bind_param("i", $sidToDelete);
        // Execute
        if ($stmt->execute()) {
            // ลบสำเร็จให้เปลี่ยนเส้นทางไปยังหน้าเดิม
            header("Location: " . $_SERVER['PHP_SELF']); // เปลี่ยนกลับมายังหน้าเดิม
            exit(); // หยุดการทำงานของสคริปต์
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล: " . $stmt->error . "');</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('ไม่สามารถเตรียมคำสั่ง SQL ได้');</script>";
    }

    // ตรวจสอบว่ามีการลบข้อมูล
    $resultCheck = $conn->query("SELECT * FROM tbl_student WHERE SID = $sidToDelete");
    if ($resultCheck->num_rows === 0) {
        error_log('ข้อมูลถูกลบเรียบร้อยแล้ว');
    } else {
        error_log('ข้อมูลยังคงอยู่ในฐานข้อมูล');
    }
}

// ดึงข้อมูลนักศึกษาจากตารางที่เกี่ยวข้อง
$sql = "
    SELECT 
        tbl_student.SID,
        tbl_predixes.PrefixTH,
        tbl_student.StudentName,
        tbl_student.StudentLastName,
        tbl_student.Age,
        tbl_department.Department,
        tbl_year.Year,
        GROUP_CONCAT(tbl_hobby.HobbyName SEPARATOR ', ') AS Hobbies
    FROM tbl_student
    JOIN tbl_predixes ON tbl_student.PrefixID = tbl_predixes.PrefixID
    JOIN tbl_department ON tbl_student.DepID = tbl_department.DepID
    JOIN tbl_year ON tbl_student.yearID = tbl_year.yearID
    LEFT JOIN tbl_StudentHobby ON tbl_student.SID = tbl_StudentHobby.SID
    LEFT JOIN tbl_hobby ON tbl_StudentHobby.HobbyID = tbl_hobby.HobbyID
    GROUP BY tbl_student.SID
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9; /* สีพื้นหลัง */
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #d62828; /* สีแดงเข้ม */
            font-size: 36px;
            margin: 20px 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff; /* สีพื้นหลังของตาราง */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #d62828; /* สีแดงเข้ม */
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            background-color: #ffffff; /* สีพื้นหลังเซลล์ */
            color: #333;
            transition: background-color 0.3s;
        }

        tr:hover td {
            background-color: #ffe5e5; /* สีพื้นหลังเมื่อ hover */
        }

        .footer {
        margin-top: 50px; 
        padding: 20px 0; 
        background-color: #d62828; 
        color: white; 
        text-align: center; 
        font-size: 16px; 
        position: relative; 
        bottom: 0; 
        width: 100%;
        }


        a {
            color: #d62828;
            text-decoration: none;
            font-weight: bold;
        }

        .register-button {
            display: inline-block;
            width: 200px;
            padding: 10px;
            text-align: center;
            background-color: #d62828; /* สีแดงเข้ม */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
            margin: 20px auto;
        }

        .register-button:hover {
            background-color: #b02020; /* สีแดงเข้มขึ้นเมื่อ hover */
            transform: translateY(-3px);
        }

        .edit-button {
            color: #007bff; /* สีน้ำเงิน */
            text-decoration: none;
            font-weight: bold;
            border: none;
            background: none;
            cursor: pointer;
            transition: color 0.3s;
        }
        .detail-button {
            color: #333; /* สีน้ำเงิน */
            text-decoration: none;
            font-weight: bold;
            border: none;
            background: none;
            cursor: pointer;
            transition: color 0.3s;
        }

        .edit-button:hover {
            color: #0056b3; /* สีน้ำเงินเข้มขึ้นเมื่อ hover */
        }

        .delete-button {
            color: #dc3545; /* สีแดง */
            text-decoration: none;
            font-weight: bold;
            border: none;
            background: none;
            cursor: pointer;
            transition: color 0.3s;
        }

        .delete-button:hover {
            color: #a71c24; /* สีแดงเข้มขึ้นเมื่อ hover */
        }

        @media (max-width: 768px) {
            table {
                width: 90%; /* ปรับความกว้างเมื่อหน้าจอเล็ก */
            }

            .register-button {
                width: 100%; /* กำหนดให้ปุ่มเต็มกว้างเมื่อหน้าจอเล็ก */
            }
        }
    </style>
</head>
<body>
    <h1>Students</h1>

    <table>
        <tr>
            <th>เลขประจำตัว</th>
            <th>คำนำหน้า</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>อายุ</th>
            <th>สาขาวิชา</th>
            <th>ปีเกิด</th>
            <th>รายละเอียดเพิ่มเติม</th>
            <th>แก้ไข</th>
            <th>ลบ</th> <!-- เพิ่มคอลัมน์สำหรับปุ่ม Delete -->
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // แสดงข้อมูลของนักศึกษา
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["SID"]. "</td>
                        <td>" . $row["PrefixTH"]. "</td>
                        <td>" . $row["StudentName"]. "</td>
                        <td>" . $row["StudentLastName"]. "</td>
                        <td>" . $row["Age"]. "</td>
                        <td>" . $row["Department"]. "</td>
                        <td>" . $row["Year"]. "</td>
                        <td><a href='detail.php?sid=" . $row["SID"] . "'class='detail-button'>ดูรายละเอียด</a></td>
                        <td>
                            <a href='edit.php?sid=" . $row["SID"] . "' class='edit-button'>แก้ไข</a>
                        </td>
                        <td>
                            <form action='' method='POST' onsubmit='return confirm(\"คุณแน่ใจว่าต้องการลบข้อมูลนี้?\");'>
                                <input type='hidden' name='sid' value='" . $row["SID"] . "'>
                                <button type='submit' class='delete-button'>ลบ</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>ไม่มีข้อมูล</td></tr>";
        }
        ?>
        <tr>
            <td colspan="10" style="text-align: center;">
                <a class="register-button" href="regis.php">เพิ่มข้อมูล</a>
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>Master PHP</p>
    </div>
</body>
</html>
