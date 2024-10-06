<?php
include 'connect.php';  // Include your database connection file

if (isset($_POST['gradeLevel'])) {
    $gradeLevel = $_POST['gradeLevel'];
    
    // Fetch sections based on the selected grade level
    $query = "SELECT s.section_id, s.sectionName
              FROM section s
              WHERE s.gradeLevel = '$gradeLevel'";  // Filter by the selected gradeLevel

    $result = mysqli_query($connect, $query);

    // Array to store echoed section names
    $echoedSections = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $section_id = $row['section_id'];
            $sectionName = $row['sectionName'];
            
            // Check if sectionName has already been echoed
            if (!in_array($sectionName, $echoedSections)) {
                // If not echoed, echo the option and store the sectionName in the array
                echo "<option value='{$sectionName}'>{$section_id} - {$sectionName}</option>";
                $echoedSections[] = $sectionName;  // Add the sectionName to the array
            }
        }
    } else {
        echo "<option>No sections available</option>";
    }
} else {
    echo "<option>Error: No grade level selected</option>";
}
?>
