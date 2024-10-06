<?php

include 'connect.php';

// FOR INDIVIDUAL DELETION
if (isset($_POST['btnDeleteAdmin'])) {
    $admin_id = $_POST['admin_id']; // Get the admin_id from the POST request

    // Prepare the DELETE statement
    $query = $connect->prepare("DELETE FROM Admin WHERE admin_id = ?");
    $query->bind_param("s", $admin_id); // 's' for string

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 
  
else if (isset($_POST['btnDeleteFaculty'])) {
    $faculty_id = $_POST['faculty_id']; // Get the faculty_id from the POST request

    // Prepare the DELETE statement
    $query = $connect->prepare("DELETE FROM Faculty WHERE faculty_id = ?");
    $query->bind_param("s", $faculty_id); // 's' for string

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['btnDeleteStudent'])) {
    $student_id = $_POST['student_id']; // Get the student_id from the POST request

    // Prepare the DELETE statement
    $query = $connect->prepare("DELETE FROM Student WHERE student_id = ?");
    $query->bind_param("s", $student_id); // 's' for string

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['btnDeleteSection'])) {
    $section_id = $_POST['section_id']; // Get the student_id from the POST request

    // Prepare the DELETE statement
    $query = $connect->prepare("DELETE FROM Section WHERE section_id = ?");
    $query->bind_param("s", $section_id); // 's' for string

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['section_id']) && isset($_POST['faculty_id'])) {
    $section_id = $_POST['section_id']; 
    $faculty_id = $_POST['faculty_id']; 

    // Prepare the DELETE statement
    $query = $connect->prepare("DELETE FROM sections_faculties WHERE section_id = ? AND faculty_id = ?");
    $query->bind_param("ss", $section_id, $faculty_id);

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['btnDeleteCriterion'])) {
    $criterion_id = $_POST['criterion_id']; // Get the criterion_id from the POST request
    $deletionAllowed = true;

    // Check if the criterion exists in the Questionnaire table
    $query1 = $connect->prepare("SELECT 1 FROM Questionnaire WHERE criterion_id = ?");
    $query1->bind_param("s", $criterion_id); // 's' for string
    $query1->execute();
    $query1->store_result(); // Store result to check row count

    if ($query1->num_rows > 0) {
        // Criterion exists in the Questionnaire table, so don't allow deletion
        $deletionAllowed = false;
    }
    $query1->close();

    if ($deletionAllowed) {
        // Criterion is not in the Questionnaire table, proceed with the deletion
        $query2 = $connect->prepare("DELETE FROM Criteria WHERE criterion_id = ?");
        $query2->bind_param("s", $criterion_id); // 's' for string

        // Execute the query and check if it was successful
        if ($query2->execute()) {
            // If the query was successful, return 'success'
            echo 'success';
        } else {
            // If something went wrong, log the error
            echo 'error: ' . $query2->error;  // Output the error for debugging
        }
        $query2->close();
    } else {
        // Criterion exists in Questionnaire table, do not delete
        echo 'error';
    }
} 

else if (isset($_POST['btnDeleteQuestion']) && isset($_POST['question_id'])) {
    $question_id = $_POST['question_id']; // Get the criterion_id from the POST request

    // Criterion is not in the Questionnaire table, proceed with the deletion
    $query = $connect->prepare("DELETE FROM Questionnaire WHERE question_id = ?");
    $query->bind_param("i", $question_id); // 's' for string

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    $query->close();
} 




// FOR REMOVING REFERENCES
else if (isset($_POST['btnRemoveAllFacultyConstraints'])) {
    // Find all foreign keys referencing `faculty_id` from other tables
    $query = "SELECT TABLE_NAME, CONSTRAINT_NAME 
              FROM information_schema.KEY_COLUMN_USAGE 
              WHERE REFERENCED_TABLE_NAME = 'faculty' 
              AND REFERENCED_COLUMN_NAME = 'faculty_id'";

    $result = $connect->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tableName = $row['TABLE_NAME'];
            $constraintName = $row['CONSTRAINT_NAME'];

            // Drop the foreign key constraint using backticks to handle special characters
            $dropQuery = "ALTER TABLE `$tableName` DROP FOREIGN KEY `$constraintName`";
            if (!$connect->query($dropQuery)) {
                echo "error" . $connect->error;  // If an error occurs
                exit();
            }
        }
        echo "success";  // All constraints successfully removed
    } else {
        echo "no_constraints";  // No constraints found
    }

    $connect->close();
}

else if (isset($_POST['btnRemoveAllSectionConstraints'])) {
    // Find all foreign keys referencing `faculty_id` from other tables
    $query = "SELECT TABLE_NAME, CONSTRAINT_NAME 
              FROM information_schema.KEY_COLUMN_USAGE 
              WHERE REFERENCED_TABLE_NAME = 'section' 
              AND REFERENCED_COLUMN_NAME = 'section_id'";

    $result = $connect->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tableName = $row['TABLE_NAME'];
            $constraintName = $row['CONSTRAINT_NAME'];

            // Drop the foreign key constraint using backticks to handle special characters
            $dropQuery = "ALTER TABLE `$tableName` DROP FOREIGN KEY `$constraintName`";
            if (!$connect->query($dropQuery)) {
                echo "error" . $connect->error;  // If an error occurs
                exit();
            }
        }
        echo "success";  // All constraints successfully removed
    } else {
        echo "no_constraints";  // No constraints found
    }

    $connect->close();
} 

else if (isset($_POST['btnRemoveAllCriterionConstraints'])) {
    // Find all foreign keys referencing `faculty_id` from other tables
    $query = "SELECT TABLE_NAME, CONSTRAINT_NAME 
              FROM information_schema.KEY_COLUMN_USAGE 
              WHERE REFERENCED_TABLE_NAME = 'criteria' 
              AND REFERENCED_COLUMN_NAME = 'criterion_id'";

    $result = $connect->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tableName = $row['TABLE_NAME'];
            $constraintName = $row['CONSTRAINT_NAME'];

            // Drop the foreign key constraint using backticks to handle special characters
            $dropQuery = "ALTER TABLE `$tableName` DROP FOREIGN KEY `$constraintName`";
            if (!$connect->query($dropQuery)) {
                echo "error" . $connect->error;  // If an error occurs
                exit();
            }
        }
        echo "success";  // All constraints successfully removed
    } else {
        echo "no_constraints";  // No constraints found
    }

    $connect->close();
} 




// FOR DELETE ALL
else if (isset($_POST['btnDeleteAllEvaluationRecords'])) {
    // Prepare the TRUNCATE statements for each table
    $queries = [
        "TRUNCATE TABLE evaluation_records",
        "TRUNCATE TABLE criteria_percentage", // Replace with your table name
        "TRUNCATE TABLE overall_results" // Replace with your table name
    ];

    $success = true; // Flag to check if all queries succeed
    foreach ($queries as $query) {
        // Prepare the statement
        $stmt = $connect->prepare($query);

        // Execute the query and check if it was successful
        if (!$stmt->execute()) {
            // If something went wrong, log the error and break the loop
            echo 'error: ' . $stmt->error;  // Output the error for debugging
            $success = false;
            break;
        }
        // Close the statement
        $stmt->close();
    }

    // If all queries were successful, return 'success'
    if ($success) {
        echo 'success';
    }
}


else if (isset($_POST['btnDeleteAllAdmins'])) {
    // Prepare the DELETE statement
    $query = $connect->prepare("TRUNCATE TABLE Admin");

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['btnDeleteAllFaculties'])) {
    // Prepare the DELETE statement
    $query = $connect->prepare("TRUNCATE TABLE Faculty");

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['btnDeleteAllStudents'])) {
    // Prepare the DELETE statement
    $query = $connect->prepare("TRUNCATE TABLE Student");

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['btnDeleteAllSections'])) {
    // Prepare the DELETE statement
    $query = $connect->prepare("TRUNCATE TABLE Section");

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['btnDeleteAllSectionsOfFaculties'])) {
    // Prepare the DELETE statement
    $query = $connect->prepare("TRUNCATE TABLE sections_faculties");

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['btnDeleteAllCriteria'])) {
    // Prepare the DELETE statement
    $query = $connect->prepare("TRUNCATE TABLE Criteria");

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging; 
    }
    // Close the statement
    $query->close();
} 

else if (isset($_POST['btnDeleteAllQuestions'])) {
    // Prepare the DELETE statement
    $query = $connect->prepare("TRUNCATE TABLE Questionnaire");

    // Execute the query and check if it was successful
    if ($query->execute()) {
        // If the query was successful, return 'success'
        echo 'success';
    } else {
        // If something went wrong, log the error
        echo 'error: ' . $query->error;  // Output the error for debugging
    }
    // Close the statement
    $query->close();
} 









?>
