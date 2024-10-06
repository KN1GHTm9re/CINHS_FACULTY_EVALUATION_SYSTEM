<?php
include 'connect.php';  // Include your database connection file

if (isset($_POST['gradeLevel'])) {
    $gradeLevel = $_POST['gradeLevel'];
    
    // Fetch sections based on the selected grade level
    $query = "SELECT sectionName FROM Section WHERE gradeLevel = '$gradeLevel'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['sectionName']}'>";
            echo $row['sectionName'];
            echo "</option>";
        }
    } else {
        echo "<option>No sections available</option>";
    }
} else {
    echo "<option>Error: No grade level selected</option>";
}
?>