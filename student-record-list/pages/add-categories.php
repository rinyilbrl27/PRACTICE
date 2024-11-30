<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Categories</title>
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
        <h1>Add Categories</h1>
            <div class="category-form">
                <div class="subject-form">
                    <form class="add-sub" method="POST">
                        <input type="text" placeholder="Subject Code" name="sub-code" required value="<?php echo isset($subCode) ? htmlspecialchars($subCode) : ''; ?>">
                        <input type="text" placeholder="Subject Name" name="sub-name" value="<?php echo isset($subName) ? htmlspecialchars($subName) : ''; ?>">
                        <br>
                        <button type="submit" name="action" value="add">Add</button>
                        <button type="submit" name="action" value="update">Update</button>
                        <button type="submit" name="action" value="delete">Delete</button>
                    </form>
                </div>

                <div class="section-form">
                    <form class="add-sub" method="POST">
                        <input type="text" placeholder="Section" name="sec-name" required value="<?php echo isset($sec) ? htmlspecialchars($sec) : ''; ?>">
                        <br>
                        <button type="submit" name="action" value="sec-add">Add</button>
                        <button type="submit" name="action" value="sec-delete">Delete</button>
                        <br><br>
                        <button type="button" onclick="location.href='../index.php'">Back</button>
                    </form>
                </div>
            </div>

        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include("../dbconnection.php");

                // Solution doon sa undefined index
                $subCode = isset($_POST["sub-code"]) ? $_POST["sub-code"] : '';
                $subName = isset($_POST["sub-name"]) ? $_POST["sub-name"] : '';
                $sec = isset($_POST["sec-name"]) ? $_POST["sec-name"] : '';

                if ($_POST['action'] === 'add') {
                    $check_sql = "SELECT * FROM `subject-code-tbl` WHERE `subject-code` = '$subCode'";
                    $check_result = $conn->query($check_sql);

                    if ($check_result->num_rows > 0) {
                        echo "<div class='subCode-exist'>Subject Code already exists.</div>";
                    } else {
                        $sql = "INSERT INTO `subject-code-tbl` (`subject-code`, `subject-name`) VALUES ('$subCode', '$subName')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<div class='subCode-added'>Subject Successfully Added.</div>";
                            header("Refresh:0"); 
                            exit();
                        } else {
                            echo "Error: " . $conn->error;
                        } 
                    }
                } elseif ($_POST['action'] === 'update') {
                    $update_sql = "UPDATE `subject-code-tbl` SET `subject-name` = '$subName' WHERE `subject-code` = '$subCode'";
                    if ($conn->query($update_sql) === TRUE) {
                        echo "<div class='subCode-updated'>Subject Successfully Updated.</div>";
                        header("Refresh:0"); 
                        exit();
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }     
                } elseif ($_POST['action'] === 'delete') {
                    $delete_sql = "DELETE FROM `subject-code-tbl` WHERE `subject-code` = '$subCode'";
                    if ($conn->query($delete_sql) === TRUE) {
                        echo "<div class='subCode-deleted'>Subject Successfully Deleted.</div>";
                        header("Refresh:0"); 
                        exit();
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                } elseif ($_POST['action'] === 'sec-add') {
                    $check_sql = "SELECT * FROM `section-tbl` WHERE `section` = '$sec'";
                    $check_result = $conn->query($check_sql);

                    if ($check_result->num_rows > 0) {
                        echo "<div class='section-exist'>Section already exists.</div>";
                    } else {
                        $sql = "INSERT INTO `section-tbl` (`section`) VALUES ('$sec')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<div class='section-added'>Section Successfully Added.</div>";
                            header("Refresh:0"); 
                            exit();
                        } else {
                            echo "Error: " . $conn->error;
                        } 
                    }
                } elseif ($_POST['action'] === 'sec-delete') {
                    $delete_sql = "DELETE FROM `section-tbl` WHERE `section` = '$sec'";
                    if ($conn->query($delete_sql) === TRUE) {
                        echo "<div class='sec-deleted'>Section Successfully Deleted.</div>";
                        header("Refresh:0");
                        exit();
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                }
                $conn->close();
            }
        ?>

    </section>
</body>
</html>