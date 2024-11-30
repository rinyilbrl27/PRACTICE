<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <!-- <link rel="stylesheet" href="../style.css"> -->
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <link rel="stylesheet" href="../css/inputs.css">
    <link rel="stylesheet" href="../css/tables.css">
    <link rel="stylesheet" href="../css/container.css">
    <link rel="stylesheet" href="../css/media-queries.css">
    <script src="../js/index.js"></script>
</head>
<body>
    
    <section>
        <h1>Add Student</h1>
            <div class="student-form-container"> 
                <form method="POST" action="add-student.php">
                    <div class="student-form-inputs">
                        <input type="text" name="student-id" placeholder="Student ID" required>
                        <input type="text" name="lname" placeholder="Last Name">
                        <input type="text" name="fname" placeholder="First Name">
                        <input type="text" name="mi" placeholder="Middle Initial">
                    </div>

                    <div class="student-form-select">
                        <select name="gender">
                            <option value="">Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <select name="enrol-status">
                            <option value="" >Status</option>
                            <option value="Regular">Regular</option>
                            <option value="Irregular">Irregular</option>
                        </select>
                        <select name="section">
                            <option value="">Section</option>
                            <?php 
                                include("../dbconnection.php");

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                $sectionList = mysqli_query($conn, "SELECT * FROM `section-tbl`");
                                
                                if (mysqli_num_rows($sectionList) > 0) {
                                    while ($section = mysqli_fetch_assoc($sectionList)) {
                                        echo "<option value=\"{$section['section']}\">{$section['section']}</option>";
                                    }
                                } else {
                                    echo "<option>No Sections Available</option>";
                                }      
                            ?>
                        </select>
                    </div>

                    <div class="student-form-subjects" >
                    <?php
                        $subjectList = mysqli_query($conn, "SELECT * FROM `subject-code-tbl`");
                        
                        if (mysqli_num_rows($subjectList) > 0): 
                        ?>

                        <div class="student-subjects-checkbox-selectAll">
                            <input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)">
                            <label for="selectAll">Select All</label>
                        </div>

                        <?php
                            while ($subject = mysqli_fetch_assoc($subjectList)) {
                                echo '<div class="student-subjects-checkbox">';
                                echo '<input type="checkbox" class="subject-checkbox" name="subjects[]" value="' . htmlspecialchars($subject['subject-code']) . '">';
                                echo '<label>' . htmlspecialchars($subject['subject-code']) . '</label>';
                                echo '</div>';
                            }
                            else:
                                echo '<p>No subjects available</p>';
                            endif;
                        $conn->close();
                    ?> 
                    </div>

                    <div class="student-form-button">
                        <button type="submit" name="action" value="add">Add</button>
                        <button type="submit" name="action" value="update">Update</button>               
                        <button type="button" onclick="location.href='../index.php'">Back</button>
                    </div>

                </form>
            </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include("../dbconnection.php");

            $studID = isset($_POST['student-id']) ? $conn->real_escape_string($_POST['student-id']) : null;
            $lastName = isset($_POST['lname']) ? $conn->real_escape_string($_POST['lname']) : null;
            $firstName = isset($_POST['fname']) ? $conn->real_escape_string($_POST['fname']) : null;
            $mid = isset($_POST['mi']) ? $conn->real_escape_string($_POST['mi']) : null;
            $gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : null;
            $status = isset($_POST['enrol-status']) ? $conn->real_escape_string($_POST['enrol-status']) : null;
            $section = isset($_POST['section']) ? $conn->real_escape_string($_POST['section']) : null;

            if ($_POST['action'] === 'add') {
                $check_sql = "SELECT * FROM `students-tbl` WHERE studentid = '$studID'";
                $check_result = $conn->query($check_sql);

                if ($check_result->num_rows > 0) {
                    echo "<div class='student-exist'>Student ID already exists</div>";
                } else {
                    $sql = "INSERT INTO `students-tbl` (studentid, lastName, firstName, mi, gender, section, enrollmentStatus)
                            VALUES ('$studID', '$lastName', '$firstName', '$mid', '$gender', '$section', '$status')";
                    
                    if ($conn->query($sql) === TRUE) {
                        if (!empty($_POST['subjects'])) {
                            foreach ($_POST['subjects'] as $subjectCode) {
                                $insertSubjectSql = "INSERT INTO `student-subjects` (studentid, `subject-code`)
                                                     VALUES ('$studID', '$subjectCode')";
                                if ($conn->query($insertSubjectSql) === FALSE) {
                                    echo "Error inserting subject: " . $conn->error . "<br>";
                                } 
                            }
                        }
                        echo "<script> window.location.href='add-student.php'; </script>";
                        exit();
                    } else {
                        echo "<div class='error'>Error: " . $conn->error . "</div>";
                    }
                }
            } elseif ($_POST['action'] === 'update') {
                $updateFields = [];
                
                // comdition na para iupdate lang yung hindi empty na input box
                if (!empty($lastName)) {
                    $updateFields[] = "lastName = '$lastName'";
                }
                if (!empty($firstName)) {
                    $updateFields[] = "firstName = '$firstName'";
                }
                if (!empty($mid)) {
                    $updateFields[] = "mi = '$mid'";
                }
                if (!empty($gender)) {
                    $updateFields[] = "gender = '$gender'";
                }
                if (!empty($section)) {
                    $updateFields[] = "section = '$section'";
                }
                if (!empty($status)) {
                    $updateFields[] = "enrollmentStatus = '$status'";
                }
            
                // dynamic update query
                if (!empty($updateFields)) {
                    $updateQuery = "UPDATE `students-tbl` SET " . implode(", ", $updateFields) . " WHERE `studentid` = '$studID'";
                    if ($conn->query($updateQuery) === TRUE) {
                        
                        if (!empty($_POST['subjects'])) {
                            // Clear the existing subjects for the student
                            $deleteSubjectsQuery = "DELETE FROM `student-subjects` WHERE studentid = '$studID'";
                            $conn->query($deleteSubjectsQuery);
            
                            // Insert the new subjects
                            foreach ($_POST['subjects'] as $subjectCode) {
                                $insertSubjectSql = "INSERT INTO `student-subjects` (studentid, `subject-code`) VALUES ('$studID', '$subjectCode')";
                                if ($conn->query($insertSubjectSql) === FALSE) {
                                    echo "Error inserting subject: " . $conn->error . "<br>";
                                }
                            }
                        }
                        echo "<script> window.location.href='add-student.php'; </script>";
                        exit();
                    } else {
                        echo "Error updating student: " . $conn->error . "<br>";
                    }
                } else {
                    echo "<div class='error'>No fields to update</div>";
                }
            }
            
            $conn->close();            
        }
        ?>
    </section>
</body>
</html>