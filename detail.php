<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "u299560388_651230";
$password = "PP7759Pb";
$dbname = "u299560388_651230";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่า SID หรือไม่
if (isset($_GET['sid'])) {
    $sid = $_GET['sid'];

    // ดึงข้อมูลนักศึกษาจากฐานข้อมูลตาม SID
    $sql_details = "
        SELECT 
            tbl_student.SID,
            tbl_predixes.PrefixTH,
            tbl_student.StudentName,
            tbl_student.StudentLastName,
            tbl_student.StudentNameEN,
            tbl_student.StudentLastNameEN,
            tbl_student.Age,
            tbl_student.Address,
            tbl_department.Department,
            tbl_year.Year,
            GROUP_CONCAT(tbl_hobby.HobbyName SEPARATOR ', ') AS HobbiesTH,
            GROUP_CONCAT(tbl_hobby.HobbyNameEng SEPARATOR ', ') AS HobbiesEng
        FROM tbl_student
        JOIN tbl_predixes ON tbl_student.PrefixID = tbl_predixes.PrefixID
        JOIN tbl_department ON tbl_student.DepID = tbl_department.DepID
        JOIN tbl_year ON tbl_student.yearID = tbl_year.yearID
        LEFT JOIN tbl_StudentHobby ON tbl_student.SID = tbl_StudentHobby.SID
        LEFT JOIN tbl_hobby ON tbl_StudentHobby.HobbyID = tbl_hobby.HobbyID
        WHERE tbl_student.SID = ?
        GROUP BY tbl_student.SID
    ";

    // เตรียม statement และเชื่อมต่อข้อมูล
    if ($stmt = $conn->prepare($sql_details)) {
        $stmt->bind_param("i", $sid);
        $stmt->execute();

        // Bind results
        $stmt->bind_result($sid, $prefixTH, $studentName, $studentLastName, $studentNameEN, $studentLastNameEN, $age, $address, $department, $year, $hobbiesTH, $hobbiesEN);
        
        if ($stmt->fetch()) {
            // แสดงข้อมูลรายละเอียดของนักศึกษา
            ?>
            <!DOCTYPE html>
            <html lang="th">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>รายละเอียดนักศึกษา</title>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        background-color: #fff0f5;
                        color: #333;
                        margin: 0;
                        padding: 0;
                    }

                    h2 {
                        text-align: center;
                        color: #d62828;
                        margin-top: 20px;
                    }

                    .container {
                        width: 80%;
                        margin: 20px auto;
                        background-color: #fff;
                        padding: 20px;
                        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                        border-radius: 10px;
                    }

                    .detail {
                        margin: 10px 0;
                        padding: 10px;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        background-color: whitesmoke;
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
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>รายละเอียดของนักศึกษา</h2>
                    <div class="detail"><strong>เลขประจำตัว: </strong><?php echo $sid; ?></div>
                    <div class="detail"><strong>คำนำหน้า: </strong><?php echo $prefixTH; ?></div>
                    <div class="detail"><strong>ชื่อ (ไทย): </strong><?php echo $studentName . " " . $studentLastName; ?></div>
                    <div class="detail"><strong>ชื่อ (อังกฤษ): </strong><?php echo $studentNameEN . " " . $studentLastNameEN; ?></div>
                    <div class="detail"><strong>อายุ: </strong><?php echo $age; ?></div>
                    <div class="detail"><strong>ที่อยู่: </strong><?php echo $address; ?></div>
                    <div class="detail"><strong>สาขาวิชา: </strong><?php echo $department; ?></div>
                    <div class="detail"><strong>ปีเกิด: </strong><?php echo $year; ?></div>
                    <div class="detail"><strong>งานอดิเรก (ไทย): </strong><?php echo $hobbiesTH; ?></div>
                    <div class="detail"><strong>งานอดิเรก (อังกฤษ): </strong><?php echo $hobbiesEN; ?></div>
                    <p><a href='master.php'>กลับไปยังหน้าแรก</a></p>
                </div>

                <div class="footer">
                    <p>Master PHP</p>
                </div>
            </body>
            </html>
            <?php
            
        } else {
            echo "<p>ไม่พบข้อมูลนักศึกษา</p>";
        }

        $stmt->close();
    }
}

$conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
?>
