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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="ShowAndHidePassword.js"></script>
    <title>CINHS Faculty Evaluation System</title>
    <style>
        /* body{
            background-image: url("login-background.png");
            background-size: cover;
        } */
        #nav-admin-dashboard{
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
            <form method="post">
                <button type="button" name="btnDeleteAllEvaluationRecords" class="btnDeleteAllEvaluationRecords rounded-0 border border-0 btn btn-danger"
                style="
                <?php 

                $query = "SELECT * FROM evaluation_records";
                $executeQuery = mysqli_query($connect, $query);
                $result = mysqli_num_rows($executeQuery);   
                
                echo $result != 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;' 
                
                
                ?>">DELETE ALL EVALUATION RECORDS</button>
                <?php

                $query = "SELECT * FROM evaluation_status";
                $executeQuery = mysqli_query($connect, $query);
                $result = mysqli_fetch_assoc($executeQuery); 
                $status = $result["status"];

                ?>
                <button type="submit" name="btnStartOrStopEvaluation" class="btnStartOrStopEvaluation rounded-0 border border-0 btn btn-success" data-status=<?php echo $status; ?>><?php echo $status == 0 ? 'START EVALUATION' : 'STOP EVALUATION'; ?></button><?php echo $status == 0 ? 'Evaluation is not ongoing' : 'Evaluation is ongoing'; ?>

                <script>
                    // Event delegation: Attach event listener to the document but limit the scope to .btnDeleteAdmin elements
                    document.addEventListener('DOMContentLoaded', () => {
                        document.addEventListener('click', function(e) {
                            if (e.target && e.target.classList.contains('btnDeleteAllEvaluationRecords')) {
                                e.preventDefault();  // Prevent default link behavior
                
                                let deleteAllEvaluationRecords= confirm("Are you sure you want to delete all Evaluation Records?");
                
                                if (deleteAllEvaluationRecords == true) {
                                    // Perform the deletion via AJAX
                                    $.ajax({
                                        url: 'delete-process.php',  // Create this PHP file to handle deletion
                                        type: 'POST',
                                        data: { btnDeleteAllEvaluationRecords: true },  // Send the key to match in PHP
                                        success: function(response) {
                                            if (response == 'success') {
                                                alert("All Evaluation Records deleted successfully.");
                                                window.location.href = 'admin-dashboard.php';  // Reload page to reflect changes
                                            } else {
                                                alert("Failed to delete all Evaluation Records");
                                            }
                                        }
                                    });
                                } else {
                                    alert("Deletion cancelled.");
                                }
                            } else if (e.target && e.target.classList.contains('btnStartOrStopEvaluation')) {
                                e.preventDefault();  // Prevent default link behavior
                
                                let evaluationStatus = e.target.getAttribute("data-status");
                                let btnStartOrStopEvaluation = document.querySelector('.btnStartOrStopEvaluation');

                                if(evaluationStatus == 0){
                                    let startEvaluation = confirm("Are you sure you want to start the Evaluation?");
                
                                    if (startEvaluation == true) {
                                        // Perform the deletion via AJAX
                                        $.ajax({
                                            url: 'handleEvaluationStatus.php',  // Create this PHP file to handle deletion
                                            type: 'POST',
                                            data: { action: 'start' },  // Send the key to match in PHP
                                            success: function(response) {
                                                if (response == 'success') {
                                                    alert("Evaluation is set to start");
                                                    window.location.href = 'admin-dashboard.php';  // Reload page to reflect changes
                                                } else {
                                                    alert("Failed to start Evaluation.");
                                                }
                                            }
                                        });
                                    }     
                                }
                                else{
                                    let stopEvaluation = confirm("Are you sure you want to stop the Evaluation?");

                                    if (stopEvaluation == true) {
                                        // Perform the deletion via AJAX
                                        $.ajax({
                                            url: 'handleEvaluationStatus.php',  // Create this PHP file to handle deletion
                                            type: 'POST',
                                            data: { action: 'stop' },  // Send the key to match in PHP
                                            success: function(response) {
                                                if (response == 'success') {
                                                    alert("Evaluation is set to stop");
                                                    window.location.href = 'admin-dashboard.php';  // Reload page to reflect changes
                                                } else {
                                                    alert("Failed to stop Evaluation.");
                                                }
                                            }
                                        });
                                    }      
                                }
                            }      
                        });
                    });
                </script>  
            </form>
            <div class="listofsections-con col-10 p-5">
                <form action="admin-dashboard.php" method="POST">
                    <h1 id="listofsections-header">Evaluation Records</h1>
                    <div class="row">
                        <div class="col-8">
                            <div class="searchBox input-group mb-3 w-50">
                                <input type="text" id="txtSearchSection" name="txtSearchSection" class="form-control" placeholder="Search/Filter" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="btnSearchSection" name="btnSearchSection"><i class="bi bi-search"></i></button>
                                <button class="btn btn-outline-secondary" type="submit" id="btnCancelSearch" name="btnCancelSearch"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="text-start">
                        <?php 
                        
                        $query = $connect->prepare("SELECT* FROM evaluation_records");
                        $query->execute();
                        $result = $query->get_result();
                        $row = $result->num_rows;
                        
                        ?>
                        <span>Evaluation Records count: <?php echo $row ?></span>
                    </div>
                    <table class="tblSections table table-striped table-group-divider border border-2 text-center">
                        <tr>
                            <th>Evaluation ID</th>
                            <th>Student ID</th>
                            <th>Faculty ID</th>
                            <th>Faculty Name</th>
                            <th>Date</th>
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
                                $query = "SELECT er.evaluation_id, er.student_id, er.faculty_id, er.date, f.firstName, f.lastName 
                                        FROM evaluation_records er
                                        INNER JOIN faculty f ON er.faculty_id = f.faculty_id
                                        WHERE er.evaluation_id LIKE '%$search%' OR er.student_id LIKE '%$search%' OR er.faculty_id LIKE '%$search%' OR f.firstName LIKE '%$search%' OR f.lastName LIKE '%$search%' OR CONCAT(f.firstName, ' ', f.lastName, ' ') LIKE '%$search%' OR er.date LIKE '%$search%'";
                                $executeQuery = mysqli_query($connect, $query);
                                $result = mysqli_num_rows($executeQuery);
            
                                if($result > 0){
                                    while($row = mysqli_fetch_assoc($executeQuery)){                     
                            ?>
                                        <tr>
                                            <td><?php echo $row['evaluation_id']; ?></td>
                                            <td><?php echo $row['student_id']; ?></td>
                                            <td><?php echo $row['faculty_id']; ?></td>
                                            <td><?php echo $row['firstName'] . " " . $row['lastName']; ?></td>
                                            <td><?php echo $row['date']; ?></td>
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
                            $query = "SELECT er.evaluation_id, er.student_id, er.faculty_id, er.date, f.firstName, f.lastName 
                                    FROM evaluation_records er
                                    INNER JOIN faculty f ON er.faculty_id = f.faculty_id;";
                            $fetch_data = mysqli_query($connect, $query);
                        
                            if (mysqli_num_rows($fetch_data) > 0) {
                                foreach ($fetch_data as $row) {
                        ?>
                                    <tr>
                                        <td><?php echo $row['evaluation_id']; ?></td>
                                        <td><?php echo $row['student_id']; ?></td>
                                        <td><?php echo $row['faculty_id']; ?></td>
                                        <td><?php echo $row['firstName'] . " " . $row['lastName']; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                    </tr>
                        <?php                                                                         
                                }
                            }
                        }
                        ?>
                    </table>
                </form>         
            </div>
            <div class="listofsections-con col-10 p-5">
                <form action="admin-dashboard.php" method="POST">
                    <h1 id="listofsections-header">View Faculty Evaluation Overall Results</h1>
                    <div class="row">
                        <div class="col-8">
                            <div class="searchBox input-group mb-3 w-50">
                                <input type="text" id="txtSearchSection" name="txtSearchSection" class="form-control" placeholder="Search/Filter" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="btnSearchSection" name="btnSearchSection"><i class="bi bi-search"></i></button>
                                <button class="btn btn-outline-secondary" type="submit" id="btnCancelSearch" name="btnCancelSearch"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                    </div>
                    <table class="tblSections table table-striped table-group-divider border border-2 text-center">
                        <tr>
                            <th>Faculty ID</th>
                            <th>Faculty Name</th>
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
                                $query = "SELECT er.evaluation_id, er.student_id, er.faculty_id, er.date, f.firstName, f.lastName 
                                        FROM evaluation_records er
                                        INNER JOIN faculty f ON er.faculty_id = f.faculty_id
                                        WHERE er.evaluation_id LIKE '%$search%' OR er.student_id LIKE '%$search%' OR er.faculty_id LIKE '%$search%' OR f.firstName LIKE '%$search%' OR f.lastName LIKE '%$search%' OR CONCAT(f.firstName, ' ', f.lastName, ' ') LIKE '%$search%' OR er.date LIKE '%$search%'";
                                $executeQuery = mysqli_query($connect, $query);
                                $result = mysqli_num_rows($executeQuery);
            
                                if($result > 0){
                                    while($row = mysqli_fetch_assoc($executeQuery)){                     
                            ?>
                                        <tr>
                                            <td><?php echo $row['evaluation_id']; ?></td>
                                            <td><?php echo $row['student_id']; ?></td>
                                            <td><?php echo $row['faculty_id']; ?></td>
                                            <td><?php echo $row['firstName'] . " " . $row['lastName']; ?></td>
                                            <td><?php echo $row['date']; ?></td>
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
                            $query = "SELECT faculty_id, firstName, lastName, gender FROM Faculty";
                            $fetch_data = mysqli_query($connect, $query);
                        
                            if (mysqli_num_rows($fetch_data) > 0) {
                                foreach ($fetch_data as $row) {
                        ?>
                                    <tr>
                                        <td><?php echo $row['faculty_id']; ?></td>
                                        <td><?php echo $row['firstName'] . " " . $row['lastName']; ?></td>
                                        <td><a class="btnViewFacultyEvaluationResult btn btn-success text-light rounded-0"
                                        style="
                                        <?php
                                        
                                        $faculty_id = $row['faculty_id'];
                                        $query = "SELECT * FROM overall_results WHERE faculty_id = $faculty_id";
                                        $executeQuery = mysqli_query($connect, $query);
                                        $result = mysqli_num_rows($executeQuery);
                                        
                                        echo $result == 0 ? 'pointer-events: none; background-color: gray; border-color: gray;' : ''   
                                        ?>"  href="facultyEvaluationResult.php?faculty_id=<?php echo $row['faculty_id']; ?>">VIEW</a></td>
                                    </tr>
                        <?php                                                                         
                                }
                            }
                        }
                        ?>

                    </table>
                </form>         
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
