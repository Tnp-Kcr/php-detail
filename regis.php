<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();


$servername = "localhost";
$username = ""; 
$password = ""; 
$dbname = ""; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$genders = ['นาย', 'นางสาว'];

function fetchData($conn, $query) {
    $data = [];
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[$row['ID']] = $row['Name'];
        }
    } else {
        die("Error fetching data: " . $conn->error); 
    }
    return $data;
}


$departments = fetchData($conn, "SELECT DepID AS ID, Department AS Name FROM tbl_department");
$cities = fetchData($conn, "SELECT CityID AS ID, CityName AS Name FROM tbl_city");
$subjects = fetchData($conn, "SELECT SubjectID AS ID, Subject AS Name FROM tbl_subject");
$years = fetchData($conn, "SELECT YearID AS ID, Year AS Name FROM tbl_year");
$hobbies = fetchData($conn, "SELECT HobbyID AS ID, HobbyName AS Name FROM tbl_hobby");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $Prefix = $_POST['Prefix'];
    $name_th = $_POST['StudentName'];
    $surname_th = $_POST['StudentLastName'];
    $name_en = $_POST['StudentNameEng'];
    $surname_en = $_POST['StudentLastNameEng'];
    $age = isset($_POST['Age']) && is_numeric($_POST['Age']) ? (int)$_POST['Age'] : 0; 
    $department = (int)$_POST['DepID'];
    $city = (int)$_POST['CityID']; 
    $address = $_POST['Address'];
    $hometown = $_POST['Domicile'];
    $phone = $_POST['PhoneNumber'];
    $subject = (int)$_POST['SubjectID']; 
    $year = (int)$_POST['YearID']; 
    $hobby_ids = isset($_POST['HobbyID']) ? $_POST['HobbyID'] : [];

    if (empty($hobby_ids)) {
        die("กรุณาเลือกงานอดิเรกอย่างน้อยหนึ่งรายการ");
    }

    
    $conn->begin_transaction();

    try {
        
        $result = $conn->query("SELECT COALESCE(MAX(SID), 0) AS max_stu_id FROM tbl_student");
        if (!$result) {
            die("Query failed: " . $conn->error);
        }
        $row = $result->fetch_assoc();
        $new_stu_id = $row['max_stu_id'] + 1; 

        
        $stmt = $conn->prepare("INSERT INTO tbl_student (SID, PrefixID, StudentName, StudentLastName, StudentNameEn, StudentLastNameEn, Age, DepID, CityID, Address, Domicille, Telephone, SubjectID, YearID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        
        
        $prefixes = fetchData($conn, "SELECT PrefixID AS ID, PrefixTH AS Name FROM tbl_predixes");

        
        $Prefix = $_POST['Prefix'];
        $PrefixID = array_search($Prefix, $prefixes);

        if ($PrefixID === false) {
        die("คำนำหน้าไม่ถูกต้อง");
        }
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        
        $stmt->bind_param("isssssiissssii", $new_stu_id, $PrefixID, $name_th, $surname_th, $name_en, $surname_en, $age, $department, $city, $address, $hometown, $phone, $subject, $year);
        if (!$stmt->execute()) {
            throw new Exception("Error inserting student: " . $stmt->error);
        }

        
        $stmt_hobby = $conn->prepare("INSERT INTO tbl_StudentHobby (SID, HobbyID) VALUES (?, ?)");
        if (!$stmt_hobby) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        foreach ($hobby_ids as $hobby_id) {
            
            if (array_key_exists($hobby_id, $hobbies)) {
                $stmt_hobby->bind_param("ii", $new_stu_id, $hobby_id);
                if (!$stmt_hobby->execute()) {
                    throw new Exception("Error inserting student hobby: " . $stmt_hobby->error);
                }
            } else {
                throw new Exception("HobbyID $hobby_id does not exist in tbl_StudentHobby");
            }
        }

        
        $conn->commit();
        
        
        $_SESSION['success_message'] = "บันทึกข้อมูลนักเรียนเรียบร้อยแล้ว";
        
        
        header("Location: master.php");
        exit(); 

    } catch (Exception $e) {
        
        $conn->rollback();
        error_log($e->getMessage()); 
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
        
    }
}
?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
       body, html {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Prompt', sans-serif;
    background-color: #fce4ec; 
    overflow-y: scroll;
}

.container {
    max-width: 700px;
    margin: 50px auto;
    padding: 30px;
    background-color: #ffffff; 
    border-radius: 10px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
    border: 1px solid #f8bbd0; 
}

h1 {
    text-align: center;
    color: #d50032; 
    margin-bottom: 30px;
    font-size: 32px;
    font-weight: bold;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin: 15px 0 5px;
    font-weight: bold;
    color: #333;
}

input[type="text"],
input[type="number"],
input[type="tel"],
input[type="email"],
select,
textarea {
    width: 100%;
    padding: 15px;
    margin-bottom: 15px;
    border: 1px solid #f06292; 
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
    transition: border-color 0.3s, background-color 0.3s;
    outline: none;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="tel"]:focus,
input[type="email"]:focus,
select:focus,
textarea:focus {
    border-color: #d50032; 
    background-color: #ffe0e6; 
}

input[type="submit"] {
    background-color: #f48fb1; 
    color: white;
    border: none;
    border-radius: 5px;
    padding: 15px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.3s;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #d50032; 
    transform: translateY(-3px); 
}

.back-button {
    background-color: #f06292; 
    color: white;
    border: none;
    border-radius: 5px;
    padding: 15px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    transition: background-color 0.3s, transform 0.3s;
    width: 100%;
    margin-top: 10px; 
}

.back-button:hover {
    background-color: #c51162; 
    transform: translateY(-3px); 

.hobbies-label {
    margin: 15px 0;
    font-weight: bold;
    color: #d50032; 
}

.hobbies-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 10px; 
}

.hobbies-column {
    flex: 1 1 48%; 
    display: flex;
    align-items: center;
    border: 1px solid #f06292; 
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    transition: border-color 0.3s, background-color 0.3s;
    background-color: #f8bbd0; 
}

.hobbies-column:hover {
    border-color: #d50032; 
    background-color: #ffebee; 
}

.hobby-checkbox {
    margin-right: 10px;
    accent-color: #d50032; 
}


@media (max-width: 768px) {
    .hobbies-column {
        flex: 1 1 100%;
    }
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



    </style>
</head>
<body>
    <div class="container">
        <h1>บันทึกข้อมูลนักศึกษา</h1>
        <form method="POST">
            <label for="Prefix">คำนำหน้า</label>
            <select name="Prefix" id="Prefix" required>
                <?php foreach ($genders as $gender): ?>
                    <option value="<?= $gender ?>"><?= $gender ?></option>
                <?php endforeach; ?>
            </select>

            <label for="StudentName">ชื่อ (ภาษาไทย)</label>
            <input type="text" name="StudentName" id="StudentName" required>

            <label for="StudentLastName">นามสกุล (ภาษาไทย)</label>
            <input type="text" name="StudentLastName" id="StudentLastName" required>

            <label for="StudentNameEng">ชื่อ (ภาษาอังกฤษ):</label>
            <input type="text" name="StudentNameEng" id="StudentNameEng" required>

            <label for="StudentLastNameEng">นามสกุล (ภาษาอังกฤษ):</label>
            <input type="text" name="StudentLastNameEng" id="StudentLastNameEng" required>

            <label for="Age">อายุ</label>
            <input type="number" name="Age" id="Age" min="1" max="100" required>

            <label for="DepID">สาขาวิชา</label>
            <select name="DepID" id="DepID" required>
                <?php foreach ($departments as $id => $name): ?>
                    <option value="<?= $id ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>

            <label for="CityID">จังหวัด</label>
            <select name="CityID" id="CityID" required>
                <?php foreach ($cities as $id => $name): ?>
                    <option value="<?= $id ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>

            <label for="Address">ที่อยู่</label>
            <textarea name="Address" id="Address" required></textarea>

            <label for="Domicile">ภูมิลำเนา</label>
            <input type="text" name="Domicile" id="Domicile" required>

            <label for="PhoneNumber">หมายเลขโทรศัพท์</label>
            <input type="tel" name="PhoneNumber" id="PhoneNumber" pattern="[0-9]{10}" maxlength="10" required>


            <label for="SubjectID">วิชา</label>
            <select name="SubjectID" id="SubjectID" required>
                <?php foreach ($subjects as $id => $name): ?>
                    <option value="<?= $id ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>

            <label for="YearID">ปีเกิด</label>
            <select name="YearID" id="YearID" required>
                <?php foreach ($years as $id => $name): ?>
                    <option value="<?= $id ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>

            <label class="hobbies-label">งานอดิเรก</label>
            <div class="hobbies-wrapper">
                <?php foreach ($hobbies as $id => $name): ?>
                    <div class="hobbies-column">
                        <input type="checkbox" class="hobby-checkbox" name="HobbyID[]" value="<?= $id ?>" id="hobby_<?= $id ?>">
                        <label for="hobby_<?= $id ?>"><?= $name ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <input type="submit" value="บันทึกข้อมูล">
            <button class="back-button" onclick="window.location.href='master.php'">กลับหน้าหลัก</button>
        </form>
    </div>
    <div class="footer">
        <p>Master PHP</p>
    </div>
</body>
</html>
