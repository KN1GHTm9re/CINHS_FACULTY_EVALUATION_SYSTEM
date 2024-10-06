<?php

session_start();

include "connect.php";

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <script src="commenceLogout.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="ShowAndHidePassword.js"></script>
    <title>CINHS Faculty Evaluation System</title>
    <style>
        #nav-section{
            color: gray;
            pointer-events: none;
        }
        textarea{
            resize: none;
        }
        #txtSearchSection{
            padding: 0px 20px;
            width: 300px;
            height: 40px;
            font-size: 22px;
        }

        .listofsections-con{
            border: 4px solid gold;
            background-color: #202124;
            margin: 50px auto;
            border-radius: 8px;
            text-align: center;	
            color: #FFFFFF;
            padding: 24px 32px;
        }

        #listofsections-header{
            margin-bottom: 48px;
        }

        .btnUpdateSection{
            color: #FFF;
            background-color: blue;
            text-decoration: none;
            padding: 10px;
            cursor: pointer;
            border: none;
            margin-right: 10px;
        }

        .btnUpdateSection:hover{
            background-color: darkblue;
        }

        .btnDeleteSection{
            color: #FFF;
            background-color: red;
            text-decoration: none;
            padding: 10px;
            margin-left: 10px;
        }

        .btnDeleteSection:hover{
            background-color: darkred;
        }

        .listofsections-con p{
            margin: 0;
            margin-top: 48px;
        }


        .listofsections-con a{
            color: skyblue;
            text-decoration: none;
        }

        .listofsections-con a:hover{
            color: lightblue;
        }

        .btnUpdateSectionOfFaculty{
            color: #FFF;
            background-color: blue;
            text-decoration: none;
            padding: 10px;
            cursor: pointer;
            border: none;
            margin-right: 10px;
        }

        .btnUpdateSection:hover{
            background-color: darkblue;
        }

        
        .btnDeleteSectionOfFaculty{
            color: #FFF;
            background-color: red;
            text-decoration: none;
            padding: 10px;
            margin-left: 10px;
        }

        .btnDeleteSectionOfFaculty:hover{
            background-color: darkred;
        }
    </style>
</head>
<body id="listofsections-body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a id="nav-admin-dashboard" class="nav-link" href="admin-dashboard.php">DASHBOARD</a>
                    </li>
                    <li class="nav-item">
                        <a id="nav-admin" class="nav-link" href="listofadmins.php">ADMIN</a>
                    </li>
                    <li class="nav-item">
                        <a id="nav-faculty" class="nav-link" href="listoffaculties.php">FACULTY</a>
                    </li>
                    <li class="nav-item">
                        <a id="nav-student" class="nav-link" href="listofstudents.php">STUDENT</a>
                    </li>
                    <li class="nav-item">
                        <a id="nav-section" class="nav-link" href="listofsections.php">SECTION</a>
                    </li>
                    <li class="nav-item">
                        <a id="nav-questionnaire" class="nav-link" href="questionnaire.php">QUESTIONNAIRE</a>
                    </li>
                    <li class="nav-item">
                        <a id="nav-profile" class="nav-link" href="admin-profile.php">PROFILE</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a id="nav-logout" class="nav-link" href="#" onclick="commenceLogout()">LOGOUT</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row p-5">
            <div class="listofsections-con col-10 p-5">
                <form action="listofsections.php" method="POST">
                    <h1 id="listofsections-header">List of Sections</h1>
                    <div class="row">
                        <div class="col-8">
                            <div class="searchBox input-group mb-3 w-50">
                                <input type="text" id="txtSearchSection" name="txtSearchSection" class="form-control" placeholder="Search/Filter" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="btnSearchSection" name="btnSearchSection"><i class="bi bi-search"></i></button>
                                <button class="btn btn-outline-secondary" type="submit" id="btnCancelSearch" name="btnCancelSearch"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                        <button type="button" 
                            class="<?php 
                            // Find all foreign keys referencing `faculty_id` from other tables
                            $query = "SELECT TABLE_NAME, CONSTRAINT_NAME 
                                    FROM information_schema.KEY_COLUMN_USAGE 
                                    WHERE REFERENCED_TABLE_NAME = 'section' 
                                    AND REFERENCED_COLUMN_NAME = 'section_id'";
                            
                            $result = mysqli_query($connect, $query);

                            // Check if foreign key constraints are found
                            if ($result->num_rows > 0) {
                                // If constraints exist, allow button to remove them
                                echo 'btnRemoveAllSectionConstraints rounded-0 border border-0 btn btn-danger';
                            } else {
                                // If no constraints exist, button is to add constraints
                                echo 'btnAddAllSectionConstraints rounded-0 border border-0 btn btn-primary';
                            }
                            ?>" 

                            style="<?php
                                // Fetch the current evaluation status
                                $query = "SELECT status FROM evaluation_status";
                                $executeQuery = mysqli_query($connect, $query);
                                $resultStatus = mysqli_fetch_assoc($executeQuery);
                                $status = $resultStatus["status"];

                                // If evaluation is ongoing, disable the button
                                if ($status == 0) {
                                    // If status is 0 (evaluation not ongoing), enable the button
                                    echo 'color: white;';
                                } else {
                                    // If status is not 0 (evaluation ongoing), disable the button
                                    echo 'pointer-events: none; background-color: gray;';
                                }
                            ?>">

                            <?php 
                            // Set the button description based on the presence of constraints
                            if ($result->num_rows > 0) {
                                echo 'REMOVE CONSTRAINTS';  // If constraints exist, allow removal
                            } else {
                                echo 'ADD CONSTRAINTS';     // If no constraints exist, allow adding
                            }
                            ?>
                            </button>
                            <button type="button" name="btnDeleteAllSections" class="btnDeleteAllSections rounded-0 border border-0 btn btn-danger" 
                            style="
                            <?php 

                            $query = "SELECT status FROM evaluation_status";
                            $executeQuery = mysqli_query($connect, $query);
                            $result = mysqli_fetch_assoc($executeQuery);
                            $evaluationStatus = $result["status"];

                            $query = "SELECT * FROM section";
                            $executeQuery = mysqli_query($connect, $query);
                            $sectionCount = mysqli_fetch_assoc($executeQuery);

                            $query = "SELECT * FROM sections_faculties";
                            $executeQuery = mysqli_query($connect, $query);
                            $sectionFacultiesCount = mysqli_num_rows($executeQuery);

                            echo $evaluationStatus == 1 || $sectionCount <= 0 || $sectionFacultiesCount > 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;'; 
                                         
                            ?>">DELETE ALL</button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addSectionModal" name="addNewStudent" id="btnAddStudent" class="rounded-0 border border-0 btn btn-success" 
                            style="
                            <?php                             
                            
                            $query = "SELECT status FROM evaluation_status";
                            $executeQuery = mysqli_query($connect, $query);
                            $result = mysqli_fetch_assoc($executeQuery);
                            $status = $result["status"];
                            
                            echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;' ?>">ADD A SECTION</button>
                         </div>
                    </div>
                    <div class="text-start">
                        <?php 
                        
                        $query = $connect->prepare("SELECT* FROM Section");
                        $query->execute();
                        $result = $query->get_result();
                        $row = $result->num_rows;
                        
                        ?>
                        <span>Section count: <?php echo $row ?></span>
                    </div>
                    <table class="tblSections table table-striped table-group-divider border border-2 text-center">
                        <tr>
                            <th>ID</th>
                            <th>Section</th>
                            <th>Grade Level</th>
                            <th>Operations</th>
                        </tr>
                        <?php

                        include_once 'connect.php';
                        
                        if(isset($_POST["btnSearchSection"])){
                            $search = mysqli_real_escape_string($connect, $_POST["txtSearchSection"]);
                            if($search == ""){
                        ?>
                                <h1>NO RESULT FOUND</h1>
                        <?php
                            }
                            else{
                                $query = "SELECT * FROM Section WHERE section_id LIKE '%$search%' OR sectionName LIKE '%$search%' OR gradeLevel LIKE '%$search%'";
                                $executeQuery = mysqli_query($connect, $query);
                                $result = mysqli_num_rows($executeQuery);
            
                                if($result > 0){
                                    while($row = mysqli_fetch_assoc($executeQuery)){                     
                            ?>
                                        <tr>
                                            <tr>
                                                <td><?php echo $row['section_id']; ?></td>
                                                <td><?php echo $row['sectionName']; ?></td>
                                                <td><?php echo $row['gradeLevel']; ?></td>
                                                <td>
                                                <a class='btnUpdateSection text-light' href="#" data-id="<?php echo $row['section_id']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-gradeLevel="<?php echo $row['gradeLevel']; ?>" data-bs-toggle="modal" data-bs-target="#updateSectionModal" 
                                                style="
                                                <?php                             
                                                
                                                $query = "SELECT status FROM evaluation_status";
                                                $executeQuery = mysqli_query($connect, $query);
                                                $result = mysqli_fetch_assoc($executeQuery);
                                                $evaluationStatus = $result["status"];
                                                
                                                echo $evaluationStatus == 1 || $sectionFacultiesCount > 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;';  ?>">UPDATE</a>
                                                <a class='btnDeleteSection text-light' name='btnDeleteSection' href="#" data-id="<?php echo $row['section_id']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-gradeLevel="<?php echo $row['gradeLevel']; ?>" 
                                                style="
                                                <?php                             
                                                
                                                $query = "SELECT status FROM evaluation_status";
                                                $executeQuery = mysqli_query($connect, $query);
                                                $result = mysqli_fetch_assoc($executeQuery);
                                                $evaluationStatus = $result["status"];
                                                
                                                echo $evaluationStatus == 1 || $sectionFacultiesCount > 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;'; ?>">DELETE</a>
                                                </td>
                                            </tr>
                                        </tr>
                            <?php
                                    }
                                }
                                else{
                            ?>
                                    <h1>NO RESULT FOUND</h1>
                            <?php
                                }
                            }                   
                        }
                        else {
                            $query = "SELECT * FROM Section";
                            $fetch_data = mysqli_query($connect, $query);
                        
                            if (mysqli_num_rows($fetch_data) > 0) {
                                foreach ($fetch_data as $row) {
                        ?>
                                    <tr>
                                        <td><?php echo $row['section_id']; ?></td>
                                        <td><?php echo $row['sectionName']; ?></td>
                                        <td><?php echo $row['gradeLevel']; ?></td>
                                        <td>
                                            <a class='btnUpdateSection text-light' href="#" data-id="<?php echo $row['section_id']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-gradeLevel="<?php echo $row['gradeLevel']; ?>" data-bs-toggle="modal" data-bs-target="#updateSectionModal" 
                                            style="
                                            <?php                             
                                            
                                            $query = "SELECT status FROM evaluation_status";
                                            $executeQuery = mysqli_query($connect, $query);
                                            $result = mysqli_fetch_assoc($executeQuery);
                                            $evaluationStatus = $result["status"];
                                            
                                            echo $evaluationStatus == 1 || $sectionFacultiesCount > 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;';  ?>">UPDATE</a>
                                            <a class='btnDeleteSection text-light' name='btnDeleteSection' href="#" data-id="<?php echo $row['section_id']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-gradeLevel="<?php echo $row['gradeLevel']; ?>" 
                                            style="
                                            <?php                             
                                            
                                            $query = "SELECT status FROM evaluation_status";
                                            $executeQuery = mysqli_query($connect, $query);
                                            $result = mysqli_fetch_assoc($executeQuery);
                                            $evaluationStatus = $result["status"];
                                            
                                            echo $evaluationStatus == 1 || $sectionFacultiesCount > 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;'; ?>">DELETE</a>
                                        </td>
                                    </tr>
                        <?php                                                                         
                                }
                            }
                        }
                        ?>
                        
                        <script>
                            // Event delegation: Attach event listener to the document but limit the scope to .btnDeleteAdmin elements
                            document.addEventListener('DOMContentLoaded', () => {
                                document.addEventListener('click', function(e) {
                                    if (e.target && e.target.classList.contains('btnDeleteSection')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let section_id = e.target.getAttribute('data-id');  // Get the admin ID from the data attribute
                                        // let admin_photo = e.target.getAttribute('data-photo');  // Get the admin ID from the data attribute
                                        let deleteSection = confirm("Are you sure you want to delete this Section?");
                        
                                        if (deleteSection == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { 
                                                    btnDeleteSection : true,
                                                    section_id: section_id
                                                },
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("Section deleted successfully.");
                                                        window.location.href = 'listofsections.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to delete Section. Please first remove all constraints referencing section_id and delete all records from Faculties' Sections table.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Deletion of Section is cancelled.");
                                        }
                                    } else if (e.target && e.target.classList.contains('btnAddAllSectionConstraints')) {
                                        e.preventDefault();

                                        let addAllSectionConstraints = confirm("Are you sure you want to add all constraints referencing section_id?");

                                        if (addAllSectionConstraints === true) {
                                            $.ajax({
                                                url: 'addConstraints.php',  // PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnAddAllSectionConstraints: true },  // Send the key to match in PHP
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("All constraints successfully added.");
                                                        window.location.href = 'listofsections.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to add all Constraints. Please delete all the student's record first.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Removal cancelled.");
                                        }
                                    } else if (e.target && e.target.classList.contains('btnRemoveAllSectionConstraints')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let removeAllSectionConstraints = confirm("Are you sure you want to remove all constraints referencing section_id?");
                        
                                        if (removeAllSectionConstraints == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnRemoveAllSectionConstraints: true },  // Send the key to match in PHP
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("All constraints successfully removed.");
                                                        window.location.href = 'listofsections.php';  // Reload page to reflect changes
                                                    } else if (response == 'no_constraints') {
                                                        alert("No constraints found referencing section_id.");
                                                    } else {
                                                        alert("Failed to remove all Constraints.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Removal cancelled.");
                                        }
                                    } else if (e.target && e.target.classList.contains('btnDeleteAllSections')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let deleteAllSections= confirm("Are you sure you want to delete all the Sections?");
                        
                                        if (deleteAllSections == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnDeleteAllSections: true },  // Send the key to match in PHP
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("All Sections are deleted successfully.");
                                                        window.location.href = 'listofsections.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to delete all Sections. Please first remove all constraints referencing section_id and delete all records from Faculties' Sections table.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Deletion cancelled.");
                                        }
                                    }            
                                });
                            });
                        </script>  
                    </table>
                </form>         
            </div>
            <div class="listofsections-con col-10 p-5">
                <form action="listofsections.php" method="POST">
                    <h1 id="listofsections-header">Faculties' Sections</h1>
                    <div class="row">
                        <div class="col-7">
                            <div class="searchBox input-group mb-3 w-50">
                                <input type="text" id="txtSearchSectionOfFaculty" name="txtSearchSectionOfFaculty" class="form-control" placeholder="Search/Filter" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="btnSearchSectionOfFaculty" name="btnSearchSectionOfFaculty"><i class="bi bi-search"></i></button>
                                <button class="btn btn-outline-secondary" type="submit" id="btnCancelSearch" name="btnCancelSearch"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="col-5 text-end">
                            <button type="button" name="btnDeleteAllSectionsOfFaculties" class="btnDeleteAllSectionsOfFaculties rounded-0 border border-0 btn btn-danger" 
                            style="
                            <?php 

                            $query = "SELECT status FROM evaluation_status";
                            $executeQuery = mysqli_query($connect, $query);
                            $result = mysqli_fetch_assoc($executeQuery);
                            $evaluationStatus = $result["status"];
                         
                            $query = "SELECT * FROM sections_faculties";
                            $executeQuery = mysqli_query($connect, $query);
                            $sectionOfFacultiesCount = mysqli_num_rows($executeQuery);

                            echo $evaluationStatus == 1 || $sectionOfFacultiesCount <= 0 ? 'pointer-events: none; background-color: gray;' : 'color: white' 
                            
                            
                            ?>">DELETE ALL</button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addSectionToFacultyModal" name="btnAddSectionToFaculty" id="btnAddSectionToFaculty" class="rounded-0 border border-0 btn btn-success" 
                            style="
                            <?php                             
                            
                            $query = "SELECT status FROM evaluation_status";
                            $executeQuery = mysqli_query($connect, $query);
                            $result = mysqli_fetch_assoc($executeQuery);
                            $status = $result["status"];

                            $query = "SELECT * FROM faculty";
                            $executeQuery = mysqli_query($connect, $query);
                            $facultyCount = mysqli_fetch_assoc($executeQuery);

                            $query = "SELECT * FROM section";
                            $executeQuery = mysqli_query($connect, $query);
                            $sectionCount = mysqli_fetch_assoc($executeQuery);
                            
                            echo $status != 0 || $facultyCount <= 0 || $sectionCount <= 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;';  ?>">ADD A SECTION TO FACULTY</button>
                         </div>
                    </div>
                    <table class="tblSections table table-striped table-group-divider border border-2 text-center">
                        <tr>
                            <th>Grade Level</th>
                            <th>Section ID</th>
                            <th>Section</th>
                            <th>Faculty ID</th>
                            <th>Faculty</th>
                            <th>Operations</th>
                        </tr>
                        <?php

                        include_once 'connect.php';
                        
                        if(isset($_POST["btnSearchSectionOfFaculty"])){
                            $search = mysqli_real_escape_string($connect, $_POST["txtSearchSectionOfFaculty"]);
                            if($search == ""){
                        ?>
                                <h1>NO RESULT FOUND</h1>
                        <?php
                            }
                            else{
                                $query = "SELECT sf.gradeLevel, sf.section_id, sf.faculty_id, s.sectionName, f.firstName, f.lastName 
                                        FROM sections_faculties sf
                                        INNER JOIN section s ON sf.section_id = s.section_id
                                        INNER JOIN faculty f ON sf.faculty_id = f.faculty_id
                                        WHERE sf.gradeLevel LIKE '%$search%' OR sf.section_id LIKE '%$search%' OR s.sectionName LIKE '%$search%' OR sf.faculty_id LIKE '%$search%' OR f.firstName LIKE '%$search%' OR f.lastName LIKE '%$search%'";
                                $executeQuery = mysqli_query($connect, $query);
                                $result = mysqli_num_rows($executeQuery);
            
                                if($result > 0){
                                    while($row = mysqli_fetch_assoc($executeQuery)){                     
                            ?>
                                        <tr>
                                            <td><?php echo $row['gradeLevel']; ?></td>
                                            <td><?php echo $row['section_id']; ?></td>
                                            <td><?php echo $row['sectionName']; ?></td>
                                            <td><?php echo $row['faculty_id']; ?></td>
                                            <td><?php echo $row['firstName'] . " " . $row['lastName']; ?></td>
                                            <td>
                                                <a class='btnUpdateSectionOfFaculty text-light' href="#" data-gradeLevel="<?php echo $row['gradeLevel']; ?>" data-sectionId="<?php echo $row['section_id']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-facultyId="<?php echo $row['faculty_id']; ?>" data-facultyName="<?php echo $row['lastName']; ?>" data-bs-toggle="modal" data-bs-target="#updateSectionOfFacultyModal" 
                                                style="
                                                <?php                             
                                                
                                                $query = "SELECT status FROM evaluation_status";
                                                $executeQuery = mysqli_query($connect, $query);
                                                $result = mysqli_fetch_assoc($executeQuery);
                                                $status = $result["status"];
                                                
                                                echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">UPDATE</a>
                                                <a class='btnDeleteSectionOfFaculty text-light' name='btnDeleteSectionOfFaculty' href="#" data-gradeLevel="<?php echo $row['gradeLevel']; ?>" data-sectionId="<?php echo $row['section_id']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-facultyId="<?php echo $row['faculty_id']; ?>" data-facultyName="<?php echo $row['lastName']; ?>" 
                                                style="
                                                <?php                             
                                                
                                                $query = "SELECT status FROM evaluation_status";
                                                $executeQuery = mysqli_query($connect, $query);
                                                $result = mysqli_fetch_assoc($executeQuery);
                                                $status = $result["status"];
                                                
                                                echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">DELETE</a>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                }
                                else{
                            ?>
                                    <h1>NO RESULT FOUND</h1>
                            <?php
                                }
                            }                   
                        }
                        else {
                            $query = "SELECT sf.gradeLevel, sf.section_id, s.section_id, s.sectionName, sf.faculty_id, f.faculty_id, f.firstName, f.lastName 
                                    FROM sections_faculties sf
                                    INNER JOIN section s ON sf.section_id = s.section_id
                                    INNER JOIN faculty f ON sf.faculty_id = f.faculty_id";
                            $fetch_data = mysqli_query($connect, $query);
                        
                            if (mysqli_num_rows($fetch_data) > 0) {
                                foreach ($fetch_data as $row) {
                        ?>
                                    <tr>
                                        <tr>
                                            <td><?php echo $row['gradeLevel']; ?></td>
                                            <td><?php echo $row['section_id']; ?></td>
                                            <td><?php echo $row['sectionName']; ?></td>
                                            <td><?php echo $row['faculty_id']; ?></td>
                                            <td><?php echo $row['firstName'] . " " . $row['lastName']; ?></td>
                                            <td>
                                                <a class='btnUpdateSectionOfFaculty text-light' href="#" data-gradeLevel="<?php echo $row['gradeLevel']; ?>" data-sectionId="<?php echo $row['section_id']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-facultyId="<?php echo $row['faculty_id']; ?>" data-facultyName="<?php echo $row['lastName']; ?>" data-bs-toggle="modal" data-bs-target="#updateSectionOfFacultyModal" 
                                                style="
                                                <?php                             
                                                
                                                $query = "SELECT status FROM evaluation_status";
                                                $executeQuery = mysqli_query($connect, $query);
                                                $result = mysqli_fetch_assoc($executeQuery);
                                                $status = $result["status"];
                                                
                                                echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">UPDATE</a>
                                                <a class='btnDeleteSectionOfFaculty text-light' name='btnDeleteSectionOfFaculty' href="#" data-gradeLevel="<?php echo $row['gradeLevel']; ?>" data-sectionId="<?php echo $row['section_id']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-facultyId="<?php echo $row['faculty_id']; ?>" data-facultyName="<?php echo $row['lastName']; ?>" 
                                                style="
                                                <?php                             
                                                
                                                $query = "SELECT status FROM evaluation_status";
                                                $executeQuery = mysqli_query($connect, $query);
                                                $result = mysqli_fetch_assoc($executeQuery);
                                                $status = $result["status"];
                                                
                                                echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">DELETE</a>
                                            </td>
                                        </tr>
                                    </tr>
                        <?php                                                                         
                                }
                            }
                        }
                        ?>
                        
                        <script>
                            // Event delegation: Attach event listener to the document but limit the scope to .btnDeleteAdmin elements
                            document.addEventListener('DOMContentLoaded', () => {
                                document.addEventListener('click', function(e) {
                                    if (e.target && e.target.classList.contains('btnDeleteSectionOfFaculty')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let section_id = e.target.getAttribute('data-sectionId');  
                                        let faculty_id = e.target.getAttribute('data-facultyId');  
                                        let deleteSectionOfFaculty = confirm("Are you sure you want to remove the Section of this Faculty?");
                        
                                        if (deleteSectionOfFaculty == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { 
                                                    section_id: section_id,
                                                    faculty_id: faculty_id
                                                },
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("Section of Faculty removed successfully.");
                                                        window.location.href = 'listofsections.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to remove Section of Faculty.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Removal of Section is cancelled.");
                                        }
                                    } else if (e.target && e.target.classList.contains('btnDeleteAllSectionsOfFaculties')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let deleteAllSectionsOfFaculties = confirm("Are you sure you want to delete all Records?");
                        
                                        if (deleteAllSectionsOfFaculties == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnDeleteAllSectionsOfFaculties: true },  // Send the key to match in PHP
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("All records are deleted successfully.");
                                                        window.location.href = 'listofsections.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to delete all Records.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Deletion cancelled.");
                                        }
                                    }            
                                });
                            });
                        </script>  
                    </table>
                </form>         
            </div>
        </div>
    </div>
    
    <!-- Modal for Adding Section -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Section</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-middle">
                            <p class="label-question">Section <span style="color: red;"> *<span></p>
                            <textarea id="txtSection" name="txtSection" class="question" required></textarea>
                        </div>
                        <div class="gradeLevel-con">
                            <label for="gradeLevel" class="gradeLevel-label">Grade Level: </label><span style="color: red">*</span>
                            <select name="gradeLevel" id="gradeLevel" required>
                                <?php

                                $query = "SELECT * FROM gradelevel";
                                $executeQuery = mysqli_query($connect, $query);

                                while($row = mysqli_fetch_assoc($executeQuery)) {
                                ?>
                                    <option value="<?php echo $row['gradeLevel']; ?>"><?php echo $row["gradeLevel"]; ?></option>

                                <?php
                                }

                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="btnAddSection">Add</button>
                            <?php

                            if(isset($_POST["btnAddSection"])) {
                                $txtSection = $_POST["txtSection"];
                                $gradeLevel = $_POST["gradeLevel"];

                                if($txtSection == "") {
                                    echo "<script>alert('Question cannot be empty.');</script>";
                                    echo "<script>window.location.href='listofsections.php';</script>";
                                }
                                else {
                                    $stmt = $connect->prepare("INSERT INTO Section (sectionName, gradeLevel) VALUES (?, ?)");
                                    $stmt->bind_param('si', $txtSection, $gradeLevel);
                                    $newSection = $stmt->execute();
                                }

                                if($newSection) {
                                    echo "<script>alert('New Section added successfully.');</script>";
                                    echo "<script>window.location.href='listofsections.php';</script>";
                                }
                                else {
                                    echo "<script>alert('Failed to add new Section.');</script>";
                                    echo "<script>window.location.href='listofsections.php';</script>";
                                }
                            }

                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal for Updating Section -->
    <div class="modal fade" id="updateSectionModal" tabindex="-1" aria-labelledby="updateSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Section</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-middle">
                            <p class="label-question">Crtierion <span style="color: red;"> *<span></p>
                            <input type="hidden" name="currentSectionId" id="currentSectionId">
                            <input type="hidden" name="currentSection" id="currentSection">
                            <textarea id="txtSection" name="txtSection" class="question" required></textarea>
                            <div class="gradeLevel-con">
                                <input type="hidden" name="currentGradeLevel" id="currentGradeLevel">
                                <label for="gradeLevel" class="gradeLevel-label">Grade Level: </label><span style="color: red">*</span>
                                <select name="gradeLevel" id="gradeLevel" required>
                                    <?php

                                    $query = "SELECT gradeLevel FROM gradelevel";
                                    $executeQuery = mysqli_query($connect, $query);

                                    while($row = mysqli_fetch_assoc($executeQuery)) {
                                    ?>

                                        <option value="<?php echo $row['gradeLevel']; ?>"><?php echo $row["gradeLevel"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                                <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        const btnUpdateSection = document.querySelectorAll('.btnUpdateSection');
                                        
                                        btnUpdateSection.forEach(button => {
                                            button.addEventListener('click', () => {
                                                const sectionId = button.getAttribute('data-id');
                                                const section = button.getAttribute('data-sectionName');
                                                const gradeLevel = button.getAttribute('data-gradeLevel');
                                                
                                                document.querySelector('#currentSectionId').value = sectionId;
                                                document.querySelector('#currentSection').value = section;
                                                document.querySelector('#updateSectionModal [name="txtSection"]').value = section;
                                                document.querySelector('#currentGradeLevel').value = gradeLevel;
                                                document.querySelector('#updateSectionModal [name="gradeLevel"]').value = gradeLevel;
                                            });
                                        });
                                    });   
                                </script>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="btnUpdateSection">Update</button>
                            <?php

                            if($_SERVER["REQUEST_METHOD"] == "POST"){
                                if(isset($_POST["btnUpdateSection"]) && isset($_POST["currentSection"])){
                                    $currentSectionId = $_POST["currentSectionId"];
                                    $currentSection = $_POST["currentSection"];
                                    $currentGradeLevel = $_POST["currentGradeLevel"];
                                    $updatedSection = $_POST["txtSection"];
                                    $updatedGradeLevel = $_POST["gradeLevel"];
                                    $insertionAllowed = true;

                                    $query = "SELECT * FROM Criteria";
                                    $result = mysqli_query($connect, $query);

                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        if($updatedSection != $currentSection)
                                        {
                                            if($updatedSection != "" && $updatedSection == $row['sectionName'])
                                            {
                                                echo "<script>alert('Section is already existing.');</script>";
                                                $insertionAllowed = false;
                                                break;
                                            }
                                        }
                                    }

                                    if($insertionAllowed){
                                        $query = $connect->prepare("UPDATE Section SET sectionName = ?, gradeLevel = ? WHERE sectionName = ?");
                                        $query->bind_param("sss", $updatedSection, $updatedGradeLevel, $currentSection);

                                        if ($query->execute()) {
                                            echo "<script>alert('Section updated successfully.');</script>";
                                            echo "<script>window.location.href='listofsections.php'</script>";
                                        } else {
                                            echo "<script>alert('Failed to update Section.');</script>";
                                            echo "<script>window.location.href='listofsections.php'</script>";
                                        }
                                    }
                                }
                            }

                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Section to Faculty -->
    <div class="modal fade" id="addSectionToFacultyModal" tabindex="-1" aria-labelledby="addSectionToFacultyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Section to Faculty</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">                   
                        <div class="faculty-con">
                            <label for="faculty" class="faculty-label">Faculty: </label><span style="color: red">*</span>
                            <select name="faculty" id="faculty" required>
                                <?php

                                $query = "SELECT * FROM Faculty";
                                $executeQuery = mysqli_query($connect, $query);

                                while($row = mysqli_fetch_assoc($executeQuery)) {
                                ?>
                                    <option value="<?php echo $row["faculty_id"]; ?>"><?php echo $row["faculty_id"] . " - " . $row["firstName"] . " " . $row["lastName"]; ?></option>

                                <?php
                                }

                                ?>
                            </select>
                        </div>
                        <div class="gradeLevel-con">
                            <label for="gradeLevelForFaculty" class="gradeLevel-label">Grade Level: </label><span style="color: red">*</span>
                            <select name="gradeLevelForFaculty" id="gradeLevelForFaculty" required>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>                   
                        <div class="section-con">
                            <label for="sectionForFaculty" class="section-label">Section: </label><span style="color: red">*</span>
                            <select name="sectionForFaculty" id="sectionForFaculty" required>
                                <!-- Section options will be populated by AJAX -->
                                <script>
                                    $(document).ready(function() {
                                        // Function to load sections based on the selected grade level
                                        function loadSectionsForAddingSectionToFaculty(gradeLevel) {
                                            $.ajax({
                                                url: 'fetchSections.php',          // PHP script to fetch sections
                                                type: 'POST',                      // Send data as POST
                                                data: { gradeLevel: gradeLevel },  // Send the selected grade level
                                                success: function(data) {
                                                    $('#sectionForFaculty').html(data);    // Populate the section dropdown
                                                },
                                                error: function(xhr, status, error) {
                                                    console.log('AJAX error: ' + error);  // Log errors
                                                }
                                            });
                                        }

                                        // When the modal opens, load sections based on the current grade level
                                        $('#addSectionToFacultyModal').on('shown.bs.modal', function () {
                                            var gradeLevel = $('#gradeLevelForFaculty').val();  // Get selected grade level
                                            loadSectionsForAddingSectionToFaculty(gradeLevel);  // Load sections when modal is shown
                                        });

                                        // Optionally, you can also handle changes in the grade level
                                        $('#gradeLevelForFaculty').change(function() {
                                            var gradeLevel = $(this).val();
                                            loadSectionsForAddingSectionToFaculty(gradeLevel);  // Load sections when grade level changes
                                        });
                                    });
                                </script>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="btnAddSectionToFaculty">Add</button>
                            <?php

                            if(isset($_POST["btnAddSectionToFaculty"])) {
                                $insertionAllowed = true;
                                $faculty = $_POST["faculty"];
                                $gradeLevel = $_POST["gradeLevelForFaculty"];
                                $section = $_POST["sectionForFaculty"];

                                // Prepare and execute the query to get the updated criterion ID
                                $query = $connect->prepare("SELECT section_id FROM Section WHERE sectionName = ?");
                                $query->bind_param("s", $section);
                                $query->execute();
                                $result = $query->get_result();
                                $row = $result->fetch_assoc();
                                $section_id = $row["section_id"];  

                                // Prepare and execute the query to get the updated criterion ID
                                $query = $connect->prepare("SELECT * FROM sections_faculties");
                                $query->execute();
                                $result = $query->get_result();
                                
                                while($row = mysqli_fetch_assoc($result)) {
                                    if($section_id == $row['section_id'] && $faculty == $row['faculty_id']) {
                                        echo "<script>alert('Faculty is already assigned to this Section.');</script>";
                                        $insertionAllowed = false;
                                        break;
                                    }
                                }

                                if($insertionAllowed){   
                                    $stmt = $connect->prepare("INSERT INTO sections_faculties (gradeLevel, section_id, faculty_id) VALUES (?, ?, ?)");
                                    $stmt->bind_param('sss', $gradeLevel, $section_id, $faculty);
    
                                    if($stmt->execute()) {
                                        echo "<script>alert('Adding section to faculty is successful.');</script>";
                                        echo "<script>window.location.href='listofsections.php';</script>";
                                    }
                                    else {
                                        echo "<script>alert('Failed to add section to faculty.');</script>";
                                        echo "<script>window.location.href='listofsections.php';</script>";
                                    }
                                }                 
                            }

                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Updating Section to Faculty -->
    <div class="modal fade" id="updateSectionOfFacultyModal" tabindex="-1" aria-labelledby="updateSectionOfFacultyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Section of Faculty</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="faculty-con">
                            <input type="hidden" name="currentFacultyId" id="currentFacultyId">
                            <input type="hidden" id="currentFacultyName" name="currentFacultyName">
                            <label for="updateFaculty" class="updateFaculty-label">Faculty: </label><span style="color: red">*</span>
                            <select name="updateFaculty" id="updateFaculty" disabled>
                                <?php

                                $query = "SELECT * FROM Faculty";
                                $executeQuery = mysqli_query($connect, $query);

                                while($row = mysqli_fetch_assoc($executeQuery)) {
                                ?>
                                    <option value="<?php echo $row["faculty_id"]; ?>"><?php echo $row["faculty_id"] . " - " . $row["firstName"] . " " . $row["lastName"]; ?></option>

                                <?php
                                }

                                ?>
                            </select>
                        </div>
                        <div class="gradeLevel-con">
                            <input type="hidden" name="currentGradeLevel" id="currentGradeLevel">
                            <label for="updateGradeLevelOfFaculty" class="updateGradeLevelOfFaculty-label">Grade Level: </label><span style="color: red">*</span>
                            <select name="updateGradeLevelOfFaculty" id="updateGradeLevelOfFaculty" required>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>                   
                        <div class="section-con">
                            <input type="hidden" name="currentSectionIdForUpdate" id="currentSectionIdForUpdate">
                            <label for="updateSectionOfFaculty" class="updateSectionOfFaculty-label">Section: </label><span style="color: red">*</span>
                            <select name="updateSectionOfFaculty" id="updateSectionOfFaculty" required>
                                <!-- Section options will be populated by AJAX -->
                                <script>
                                    $(document).ready(function() {
                                        // Function to load sections based on the selected grade level
                                        function loadSectionsForUpdatingSectionOfFaculty(gradeLevel) {
                                            $.ajax({
                                                url: 'fetchSections.php',          // PHP script to fetch sections
                                                type: 'POST',                      // Send data as POST
                                                data: { gradeLevel: gradeLevel },  // Send the selected grade level
                                                success: function(data) {
                                                    $('#updateSectionOfFaculty').html(data);    // Populate the section dropdown
                                                },
                                                error: function(xhr, status, error) {
                                                    console.log('AJAX error: ' + error);  // Log errors
                                                }
                                            });
                                        }

                                        // Optionally, you can also handle changes in the grade level
                                        $('#updateGradeLevelOfFaculty').change(function() {
                                            var gradeLevel = $(this).val();
                                            loadSectionsForUpdatingSectionOfFaculty(gradeLevel);  // Load sections when grade level changes
                                        });
                                    });
                                </script>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="btnUpdateSectionOfFaculty">Update</button>

                            <?php
                            // Update Question Process 
                            if (isset($_POST["btnUpdateSectionOfFaculty"])) {
                                $insertionAllowed = true;
                                $currentGradeLevel = $_POST['currentGradeLevel'];
                                $currentSectionIdForUpdate = $_POST['currentSectionIdForUpdate'];
                                $currentFacultyId = $_POST['currentFacultyId'];
                                $updatedGradeLevel = $_POST['updateGradeLevelOfFaculty'];
                                $updatedSection = $_POST['updateSectionOfFaculty'];

                                // Prepare and execute the query to get the updated criterion ID
                                $query = $connect->prepare("SELECT section_id FROM Section WHERE sectionName = ?");
                                $query->bind_param("s", $updatedSection);
                                $query->execute();
                                $result = $query->get_result();
                                $row = $result->fetch_assoc();
                                $updatedSectionId = $row['section_id'];
                                $query->close();

                                // Prepare and execute the query to get the updated criterion ID
                                $query = $connect->prepare("SELECT section_id, faculty_id FROM sections_faculties WHERE faculty_id = ?");
                                $query->bind_param("s", $currentFacultyId);
                                $query->execute();
                                $result = $query->get_result();

                                while($row = mysqli_fetch_assoc($result)) {
                                    if($updatedSectionId == $row['section_id'] && $currentFacultyId == $row['faculty_id']) {
                                        echo "<script>alert('Faculty is already assigned to this Section.');</script>";
                                        $insertionAllowed = false;
                                        break;
                                    }
                                }

                                // Proceed to update if no duplicates found
                                if($insertionAllowed) {
                                    $query = $connect->prepare("UPDATE sections_faculties SET gradeLevel = ?, section_id = ? WHERE section_id = ? AND faculty_id = ?");
                                    $query->bind_param("iiii", $updatedGradeLevel, $updatedSectionId, $currentSectionIdForUpdate, $currentFacultyId);
                                
                                    if($query->execute()) {
                                        echo "<script>alert('Section of Faculty successfully changed.');</script>";
                                        echo "<script>window.location.href='listofsections.php';</script>";
                                    } else {
                                        echo "<script>alert('Failed to change Section of Faculty.');</script>";
                                        echo "<script>window.location.href='listofsections.php';</script>";
                                    }                     
                                }                         
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateButtons = document.querySelectorAll('.btnUpdateSectionOfFaculty');
            
            updateButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const gradeLevel = button.getAttribute('data-gradeLevel');
                    const sectionId = button.getAttribute('data-sectionId');
                    const sectionName = button.getAttribute('data-sectionName');
                    const facultyId = button.getAttribute('data-facultyId');
                    const facultyName = button.getAttribute('data-facultyName');
                      
                    // Set all the student details into the form
                    document.querySelector('#currentGradeLevel').value = gradeLevel;
                    const currentSectionIdForUpdate = document.querySelector('#currentSectionIdForUpdate').value = sectionId;
                    document.querySelector('#currentFacultyId').value = facultyId;
                    document.querySelector('#currentFacultyName').value = facultyName;
                    document.querySelector('#updateSectionOfFacultyModal [name="updateGradeLevelOfFaculty"]').value = gradeLevel;                

                    // After setting the grade level, load the sections
                    loadSectionsForUpdateSectionOfFaculty(gradeLevel);  // Manually trigger the AJAX call to fetch sections

                    // Set the section after it is populated
                    setTimeout(() => {   
                        document.querySelector('#updateSectionOfFacultyModal [name="updateFaculty"]').value = facultyId;
                        document.querySelector('#updateSectionOfFacultyModal [name="updateSectionOfFaculty"]').value = sectionName;
                    },  200);  // Delay to ensure section options are loaded
                });
            });
            
            // AJAX function to load sections based on the selected grade level for updating student
            function loadSectionsForUpdateSectionOfFaculty(gradeLevel) {
                $.ajax({
                    url: 'fetchSections.php',          // PHP script to fetch sections
                    type: 'POST',                      // Send data as POST
                    data: { gradeLevel: gradeLevel },  // Send the selected grade level
                    success: function(data) {
                        $('#updateSectionOfFacultyModal #updateSectionOfFaculty').html(data);  // Populate the section dropdown
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX error: ' + error);  // Log errors
                    }
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
