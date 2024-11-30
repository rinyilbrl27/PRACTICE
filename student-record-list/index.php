<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- <link rel="stylesheet" href="./style.css"> -->
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/buttons.css">
    <link rel="stylesheet" href="./css/inputs.css">
    <link rel="stylesheet" href="./css/tables.css">
    <link rel="stylesheet" href="./css/container.css">
    <link rel="stylesheet" href="./css/media-queries.css">
    <script src="./js/index.js"></script>
</head>
<body>
    <section>
        <h1>Student Record List</h1>  
        <div id="navigation_container">
            <?php 
                include("dbconnection.php");
                    $section = $_POST['section'] ?? '';
                    $subjectCode = $_POST['subject-code'] ?? '';
                    $status = $_POST['status'] ?? '';
                    $gender = $_POST['gender'] ?? '';
                    $search = $_POST['search'] ?? '';
                    $delData = isset($_POST['studentid']) ? $conn->real_escape_string($_POST['studentid']) : null;

                    $conditions = [];
                    if ($section) $conditions[] = "st.section = '$section'";
                    if ($status) $conditions[] = "st.enrollmentStatus = '$status'";
                    if ($gender) $conditions[] = "st.gender = '$gender'";
                    if ($search) $conditions[] = "st.studentid LIKE '%$search%'";
                ?>
            <form action="index.php" method="POST">
                <div class="filter-select-container"> 
                    <select name="section">
                        <option value="">Section</option>
                        <?php 
                            include('dbconnection.php');

                            $sectionList = mysqli_query($conn, "SELECT * FROM `section-tbl`");
                            if (mysqli_num_rows($sectionList) > 0) {
                                while ($sectionRow = mysqli_fetch_assoc($sectionList)) {
                                    $selected = ($sectionRow['section'] === $section) ? 'selected' : '';
                                    echo "<option value=\"{$sectionRow['section']}\" $selected>{$sectionRow['section']}</option>";
                                }
                            } else {
                                echo "<option>No Sections Available</option>";
                            }      
                        ?>
                    </select>

                    <select name="subject-code">
                        <option value="">Subject</option>
                        <?php 
                            $subjectList = mysqli_query($conn, "SELECT * FROM `subject-code-tbl`");
                            if (mysqli_num_rows($subjectList) > 0) {
                                while ($subjectRow = mysqli_fetch_assoc($subjectList)) {
                                    $selected = ($subjectRow['subject-code'] === $subjectCode) ? 'selected' : '';
                                    echo "<option value=\"{$subjectRow['subject-code']}\" $selected>{$subjectRow['subject-code']}</option>";
                                }
                            } else {
                                echo "<option>No Subjects Available</option>";
                            }      
                        ?>
                    </select>

                    <select name="status">
                        <option value="">Status</option>
                        <option value="Regular" <?= $status == 'Regular' ? 'selected' : '' ?>>Regular</option>
                        <option value="Irregular" <?= $status == 'Irregular' ? 'selected' : '' ?>>Irregular</option>
                    </select>

                    <select name="gender">
                        <option value="">Gender</option>
                        <option value="Male" <?= $gender == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $gender == 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>

                    <div class="search-container">
                        <input type="text" name="search" placeholder="Student ID" value="<?= htmlspecialchars($search) ?>">

                        <button type="submit" name="action" value="view">
                        <img src="./images/search.svg">
                        </button>
                    </div>
                </div>
            </form>

            <div class="dropdown-container">
                <button class="dropdown-toggle"><img src="./images/cog.svg" width="100px"></button>
                    <ul class="dropdown-menu">
                        <li onclick="location.href='./pages/add-student.php'">Update Student</li>
                        <li onclick="location.href='./pages/add-categories.php'">Add Categories</li>
                    </ul>
            </div>
        </div>

        <div class="student-list-table-container">
            <table>
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>Student ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>M.I.</th>
                        <th>Gender</th>
                        <th>Enrollment Status</th>
                        <th>Subject Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        include("dbconnection.php");

                        if ($subjectCode) {
                            $conditions[] = "sc.`subject-code` = '$subjectCode'";
                            $joinClause = "JOIN `student-subjects` AS sc ON st.studentid = sc.studentid";
                            $selectClause = "st.studentid, st.section, st.lastName, st.firstName, st.mi, st.gender, st.enrollmentStatus, sc.`subject-code`";
                        } else {
                            $joinClause = ""; 
                            $selectClause = "DISTINCT st.studentid, st.section, st.lastName, st.firstName, st.mi, st.gender, st.enrollmentStatus";
                        }

                        $whereClause = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

                        $student_list = "SELECT $selectClause
                                        FROM `students-tbl` AS st
                                        $joinClause
                                        $whereClause";
                        
                        $result = $conn->query($student_list);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['section']}</td>
                                        <td>{$row['studentid']}</td>
                                        <td>{$row['lastName']}</td>
                                        <td>{$row['firstName']}</td>
                                        <td class='td-center'>{$row['mi']}</td>
                                        <td class='td-center'>{$row['gender']}</td>
                                        <td class='td-center'>{$row['enrollmentStatus']}</td>";
                                if ($subjectCode) {
                                    echo "<td class='td-center'>{$row['subject-code']}</td>";
                                } else {
                                    echo "<td class='td-center'> </td>";
                                }

                                echo "<td class='table-button'>
                                        <form action='index.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete?\");'>
                                                <input type='hidden' name='studentid' value='" . $row['studentid'] . "'>
                                                <button type='submit' name='delete' value='Delete'>Delete</button>
                                        </form>
                                    </td>";

                                echo "</tr>";

                            }
                        } else {
                            echo "<tr><td>No records found</td></tr>";
                        }

                        // Delete Button
                        if (isset($_POST['delete'])) {
                            $delData = $conn->real_escape_string($_POST['studentid']);
                            $subjectCode = $_POST['subject-code'] ?? ''; 
                        
                            if (empty($subjectCode)) {
                                $deletesubdata = "DELETE FROM `student-subjects` WHERE studentid = '$delData'";
                                $conn->query($deletesubdata);
                        
                                $delDatastud = "DELETE FROM `students-tbl` WHERE studentid = '$delData'";
                                if ($conn->query($delDatastud) === TRUE) {
                                    echo "<script> window.location.href='index.php'; </script>";
                                    exit();
                                }
                            } else {
                                $deletesubdata = "DELETE FROM `student-subjects` WHERE studentid = '$delData' AND `subject-code` = '$subjectCode'";
                                if ($conn->query($deletesubdata) === TRUE) {
                                    echo "<script> window.location.href='index.php'; </script>";
                                    exit();
                                }
                            }
                        }
                        
                        
                        $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    
</body>
</html>
