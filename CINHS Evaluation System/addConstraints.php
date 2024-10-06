<?php

include "connect.php";

if (isset($_POST['btnAddAllFacultyConstraints'])) {
    // List of original constraints (You should have stored this information somewhere)
    $constraints = [
        [
            'table' => 'sections_faculties',
            'column' => 'faculty_id',
            'referenced_table' => 'faculty',
            'referenced_column' => 'faculty_id',
            'constraint_name' => 'fk_sections_faculties_faculty_id'
        ],
        [
            'table' => 'criteria_percentage',
            'column' => 'faculty_id',
            'referenced_table' => 'faculty',
            'referenced_column' => 'faculty_id',
            'constraint_name' => 'fk_criteria_percentage_faculty_id'
        ],
        [
            'table' => 'overall_results',
            'column' => 'faculty_id',
            'referenced_table' => 'faculty',
            'referenced_column' => 'faculty_id',
            'constraint_name' => 'fk_overall_results_faculty_id'
        ],
        // Add more constraints as necessary
    ];

    // Loop through each constraint and add it back
    foreach ($constraints as $constraint) {
        $addQuery = "ALTER TABLE `{$constraint['table']}` 
                     ADD CONSTRAINT `{$constraint['constraint_name']}` 
                     FOREIGN KEY (`{$constraint['column']}`) 
                     REFERENCES `{$constraint['referenced_table']}` (`{$constraint['referenced_column']}`)";

        if (!$connect->query($addQuery)) {
            echo "error: " . $connect->error;  // If an error occurs, print the error
            exit();
        }
    }

    echo "success";  // All constraints successfully added back

    $connect->close();
}



else if (isset($_POST['btnAddAllSectionConstraints'])) {
    // List of original constraints (You should have stored this information somewhere)
    $constraints = [
        [
            'table' => 'sections_faculties',
            'column' => 'section_id',
            'referenced_table' => 'section',
            'referenced_column' => 'section_id',
            'constraint_name' => 'fk_sections_faculties_section_id'
        ],
        [
            'table' => 'student',
            'column' => 'section_id',
            'referenced_table' => 'section',
            'referenced_column' => 'section_id',
            'constraint_name' => 'fk_student_section_id'
        ],
    ];

    // Loop through each constraint and add it back
    foreach ($constraints as $constraint) {
        $addQuery = "ALTER TABLE `{$constraint['table']}` 
                     ADD CONSTRAINT `{$constraint['constraint_name']}` 
                     FOREIGN KEY (`{$constraint['column']}`) 
                     REFERENCES `{$constraint['referenced_table']}` (`{$constraint['referenced_column']}`)";

        if (!$connect->query($addQuery)) {
            echo "error: " . $connect->error;  // If an error occurs, print the error
            exit();
        }
    }

    echo "success";  // All constraints successfully added back

    $connect->close();
}




else if (isset($_POST['btnAddAllCriterionConstraints'])) {
    // List of original constraints (You should have stored this information somewhere)
    $constraints = [
        [
            'table' => 'questionnaire',
            'column' => 'criterion_id',
            'referenced_table' => 'criteria',
            'referenced_column' => 'criterion_id',
            'constraint_name' => 'fk_questionnaire_criterion_id'
        ],
    ];

    // Loop through each constraint and add it back
    foreach ($constraints as $constraint) {
        $addQuery = "ALTER TABLE `{$constraint['table']}` 
                     ADD CONSTRAINT `{$constraint['constraint_name']}` 
                     FOREIGN KEY (`{$constraint['column']}`) 
                     REFERENCES `{$constraint['referenced_table']}` (`{$constraint['referenced_column']}`)";

        if (!$connect->query($addQuery)) {
            echo "error: " . $connect->error;  // If an error occurs, print the error
            exit();
        }
    }

    echo "success";  // All constraints successfully added back

    $connect->close();
}

?>
