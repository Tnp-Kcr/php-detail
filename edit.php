<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$servername = "localhost";
$username = ""; // Change to your username
$password = ""; // Change to your password
$dbname = ""; // Database name


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$SID = isset($_GET['sid']) ? $_GET['sid'] : '';





$stmt = $conn->prepare("SELECT SID, PrefixID, StudentName, StudentLastName, StudentNameEn, StudentLastNameEn, Age, DepID, CityID, Address, Domicille, Telephone, SubjectID, YearID FROM tbl_student WHERE SID = ?");
$stmt->bind_param("i", $SID);
$stmt->execute();
$stmt->bind_result($SID, $PrefixID, $StudentName, $StudentLastName, $StudentNameEn, $StudentLastNameEn, $Age, $DepID, $CityID, $Address, $Domicille, $Telephone, $SubjectID, $YearID);
$stmt->fetch();

if (!$SID) {
    die("ไม่พบนักเรียนที่ต้องการแก้ไข");
}


$student = [
    'SID' => $SID,
    'Prefix' => $PrefixID, 
    'StudentName' => $StudentName,
    'StudentLastName' => $StudentLastName,
    'StudentNameEn' => $StudentNameEn,
    'StudentLastNameEn' => $StudentLastNameEn,
    'Age' => $Age,
    'DepID' => $DepID,
    'CityID' => $CityID,
    'Address' => $Address,
    'Domicille' => $Domicille,
    'Telephone' => $Telephone,
    'SubjectID' => $SubjectID,
    'YearID' => $YearID
];


$stmt->close();

$prefixes = [];
$prefix_result = $conn->query("SELECT PrefixID, PrefixTH FROM tbl_predixes");
while ($row = $prefix_result->fetch_assoc()) {
    $prefixes[$row['PrefixID']] = $row['PrefixTH'];
}



$departments = [];
$dep_result = $conn->query("SELECT DepID, Department FROM tbl_department");
while ($row = $dep_result->fetch_assoc()) {
    $departments[$row['DepID']] = $row['Department'];
}

$cities = [];
$city_result = $conn->query("SELECT CityID, CityName FROM tbl_city");
while ($row = $city_result->fetch_assoc()) {
    $cities[$row['CityID']] = $row['CityName'];
}

$subjects = [];
$subject_result = $conn->query("SELECT SubjectID, Subject FROM tbl_subject");
while ($row = $subject_result->fetch_assoc()) {
    $subjects[$row['SubjectID']] = $row['Subject'];
}

$years = [];
$year_result = $conn->query("SELECT YearID, Year FROM tbl_year");
while ($row = $year_result->fetch_assoc()) {
    $years[$row['YearID']] = $row['Year'];
}

$hobbies = [];
$hobby_result = $conn->query("SELECT HobbyID, HobbyName FROM tbl_hobby");

if (!$hobby_result) {
    die("Error in hobbies query: " . $conn->error); // แสดง error ถ้า query ไม่สำเร็จ
}

while ($row = $hobby_result->fetch_assoc()) {
    $hobbies[$row['HobbyID']] = $row['HobbyName'];
}



$student_hobbies = [];
$hobby_stmt = $conn->prepare("SELECT HobbyID FROM tbl_StudentHobby WHERE SID = ?");
$hobby_stmt->bind_param("i", $SID); 
$hobby_stmt->execute();
$hobby_stmt->bind_result($hobby_id);
while ($hobby_stmt->fetch()) {
    $student_hobbies[] = $hobby_id;
}
$hobby_stmt->close();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Prefix = $_POST['Prefix'];
    $name_th = $_POST['StudentName'];
    $surname_th = $_POST['StudentLastName'];
    $name_en = $_POST['StudentNameEn']; 
    $surname_en = $_POST['StudentLastNameEn']; 
    $age = $_POST['Age'];
    $department = $_POST['DepID'];
    $city = $_POST['CityID'];
    $address = $_POST['Address'];
    $hometown = $_POST['Domicille'];
    $phone = $_POST['PhoneNumber'];
    $subject = $_POST['SubjectID'];
    $year = $_POST['YearID'];
    $hobby_ids = isset($_POST['HobbyID']) ? $_POST['HobbyID'] : [];

    if (empty($hobby_ids)) {
        die("กรุณาเลือกงานอดิเรกอย่างน้อยหนึ่งรายการ");
    }

    
    $conn->begin_transaction();
    try {
        
        $stmt = $conn->prepare("UPDATE tbl_student SET PrefixID = ?, StudentName = ?, StudentLastName = ?, StudentNameEn = ?, StudentLastNameEn = ?, Age = ?, DepID = ?, CityID = ?, Address = ?, Domicille = ?, Telephone = ?, SubjectID = ?, YearID = ? WHERE SID = ?");
        $stmt->bind_param("sssssiissssiii", $Prefix, $name_th, $surname_th, $name_en, $surname_en, $age, $department, $city, $address, $hometown, $phone, $subject, $year, $SID);
        if (!$stmt->execute()) {
            throw new Exception("Error updating student: " . $stmt->error);
        }

        
        $conn->query("DELETE FROM tbl_StudentHobby WHERE SID = $SID");

        
        $stmt_hobby = $conn->prepare("INSERT INTO tbl_StudentHobby (SID, HobbyID) VALUES (?, ?)");
        foreach ($hobby_ids as $hobby_id) {
            $stmt_hobby->bind_param("ii", $SID, $hobby_id);
            if (!$stmt_hobby->execute()) {
                throw new Exception("Error inserting student hobby: " . $stmt_hobby->error);
            }
        }

        
        $conn->commit();
        echo "<script>alert('แก้ไขข้อมูลนักเรียนเรียบร้อยแล้ว'); window.location.href='master.php';</script>";
    } catch (Exception $e) {
        
        $conn->rollback();
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Datail</title>
    <style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f4f8;
    color: #333;
    margin: 0;
    padding: 20px;
    min-height: 100vh; 
    left: 0; 
    z-index: 1000; 
}

.form-container {
    max-width: 600px;
    margin: auto;
    background-color: #fff0f5; 
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

h1 {
    text-align: center;
    color: #d62828; 
    margin-bottom: 20px;
}

label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
    color: #d62828; 
}

input[type="text"],
input[type="number"],
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #d62828; 
    border-radius: 5px;
    box-sizing: border-box;
    margin-bottom: 15px;
}

input[type="text"]:focus,
input[type="number"]:focus,
select:focus {
    border-color: #b02020; 
    outline: none;
}

input[type="submit"] {
    background-color: #d62828; 
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #b02020; 
}

.back-button {
    background-color: #ff69b4; 
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}

.back-button:hover {
    background-color: #d0208a; 
}

input[type="checkbox"] {
    margin-right: 5px;
}
.footer {
    background-color: #d62828; 
    color: #fff;
    text-align: center;
    padding: 10px 0;
    margin-top: 20px; 
    width: 100%; 
    left: 0; 
}
    </style>
</head>
<body>
<div class="form-container">
        <h1>แก้ไขข้อมูลนักเรียน</h1>
        <form method="post">
            <label for="Prefix">คำนำหน้าชื่อ:</label>
            <select id="Prefix" name="Prefix" required>
            <?php foreach ($prefixes as $prefix_id => $prefix_name): ?>
            <option value="<?php echo htmlspecialchars($prefix_id); ?>" <?php echo $prefix_id == $student['Prefix'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($prefix_name); ?></option>
            <?php endforeach; ?>
            </select>


            <label for="StudentName">ชื่อ:</label>
            <input type="text" id="StudentName" name="StudentName" value="<?php echo htmlspecialchars($student['StudentName']); ?>" required>

            <label for="StudentLastName">นามสกุล:</label>
            <input type="text" id="StudentLastName" name="StudentLastName" value="<?php echo htmlspecialchars($student['StudentLastName']); ?>" required>

            <label for="StudentNameEn">ชื่อ (ภาษาอังกฤษ):</label>
            <input type="text" id="StudentNameEn" name="StudentNameEn" value="<?php echo htmlspecialchars($student['StudentNameEn']); ?>" required>

            <label for="StudentLastNameEn">นามสกุล (ภาษาอังกฤษ):</label>
            <input type="text" id="StudentLastNameEn" name="StudentLastNameEn" value="<?php echo htmlspecialchars($student['StudentLastNameEn']); ?>" required>

            <label for="Age">อายุ:</label>
            <input type="number" id="Age" name="Age" value="<?php echo htmlspecialchars($student['Age']); ?>" required>

            <label for="DepID">สาขาวิชา:</label>
            <select id="DepID" name="DepID" required>
                <?php foreach ($departments as $dep_id => $dep_name): ?>
                    <option value="<?php echo htmlspecialchars($dep_id); ?>" <?php echo $dep_id == $student['DepID'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($dep_name); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="CityID">จังหวัด:</label>
            <select id="CityID" name="CityID" required>
                <?php foreach ($cities as $city_id => $city_name): ?>
                    <option value="<?php echo htmlspecialchars($city_id); ?>" <?php echo $city_id == $student['CityID'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($city_name); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="Address">ที่อยู่:</label>
            <input type="text" id="Address" name="Address" value="<?php echo htmlspecialchars($student['Address']); ?>" required>

            <label for="Domicille">ภูมิลำเนา:</label>
            <input type="text" id="Domicille" name="Domicille" value="<?php echo htmlspecialchars($student['Domicille']); ?>" required>

            <label for="PhoneNumber">หมายเลขโทรศัพท์:</label>
            <input type="text" id="PhoneNumber" name="PhoneNumber" value="<?php echo htmlspecialchars($student['Telephone']); ?>" required>

            <label for="SubjectID">วิชา:</label>
            <select id="SubjectID" name="SubjectID" required>
                <?php foreach ($subjects as $subject_id => $subject_name): ?>
                    <option value="<?php echo htmlspecialchars($subject_id); ?>" <?php echo $subject_id == $student['SubjectID'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($subject_name); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="YearID">ปีเกิด:</label>
            <select id="YearID" name="YearID" required>
                <?php foreach ($years as $year_id => $year_name): ?>
                    <option value="<?php echo htmlspecialchars($year_id); ?>" <?php echo $year_id == $student['YearID'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($year_name); ?></option>
                <?php endforeach; ?>
            </select>

            <label>งานอดิเรก:</label>
            <div>
                <?php foreach ($hobbies as $hobby_id => $hobby_name): ?>
                    <label>
                        <input type="checkbox" name="HobbyID[]" value="<?php echo htmlspecialchars($hobby_id); ?>" <?php echo in_array($hobby_id, $student_hobbies) ? 'checked' : ''; ?>>
                        <?php echo htmlspecialchars($hobby_name); ?>
                    </label><br>
                <?php endforeach; ?>
            </div>

            <input type="submit" value="บันทึกข้อมูล">
            <button type="button" class="back-button" onclick="window.location.href='master.php'">กลับหน้าหลัก</button>
        </form>
    </div>
    <div class="footer">
        <p>Master PHP</p>
    </div>
</body>
</html>
