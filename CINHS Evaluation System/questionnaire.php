<!-- Establish connection to database -->
<?php

session_start();

include_once "connect.php";

?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Question | Faculty Evaluation</title>
    <link rel="icon" type="image/png" href="/images/systems-plus-computer-college-logo.png">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="icon" href="images/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="questionnaire-style.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Add jQuery for AJAX support -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="commenceLogout.js"></script>
    <style>
        #nav-questionnaire{
            color: gray;
            pointer-events: none;
        }
        textarea{
            resize: none;
        }

        #txtSearchCriterion{
            padding: 0px 20px;
            width: 300px;
            height: 40px;
            font-size: 22px;
        }

        .listofcriteria-con{
            border: 4px solid gold;
            background-color: #202124;
            margin: 50px auto;
            border-radius: 8px;
            text-align: center;	
            color: #FFFFFF;
            padding: 24px 32px;
        }

        #listofcriteria-header{
            margin-bottom: 48px;
        }

        .btnUpdateCriterion{
            color: #FFF;
            background-color: blue;
            text-decoration: none;
            padding: 10px;
            cursor: pointer;
            border: none;
            margin-right: 10px;
        }

        .btnUpdateCriterion:hover{
            background-color: darkblue;
        }

        .btnDeleteCriterion{
            color: #FFF;
            background-color: red;
            text-decoration: none;
            padding: 10px;
            margin-left: 10px;
        }

        .btnDeleteCriterion:hover{
            background-color: darkred;
        }

        
        .btnUpdateCriterion{
            color: #FFF;
            background-color: blue;
            text-decoration: none;
            padding: 10px;
            cursor: pointer;
            border: none;
            margin-right: 10px;
        }

        .btnUpdateCriterion:hover{
            background-color: darkblue;
        }

        .btnDeleteQuestion{
            color: #FFF;
            background-color: red;
            text-decoration: none;
            padding: 10px;
            margin-left: 10px;
        }

        .btnDeleteQuestion:hover{
            background-color: darkred;
        }

        .btnUpdateQuestion{
            color: #FFF;
            background-color: blue;
            text-decoration: none;
            padding: 10px;
            cursor: pointer;
            border: none;
            margin-right: 10px;
        }

        .btnUpdateQuestion:hover{
            background-color: darkblue;
        }


        .listofcriteria-con p{
            margin: 0;
            margin-top: 48px;
        }


        .listofcriteria-con a{
            color: skyblue;
            text-decoration: none;
        }

        .listofcriteria-con a:hover{
            color: lightblue;
        }

    </style>
</head>
<body>
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
	<!-------- main content ---------->
	<div class="main-container container-fluid">
		<main>
			<div class="container-main">
				<div class="page-container text-center"><h1><i class="fas fa-book" id="view-info"> Manage Questions</i></h1>
					<hr>
                    <div class="listofcriteria-con col-10 p-5">
                        <form method="POST">
                            <h1 id="listofcriteria-header">List of Criteria</h1>
                            <div class="row">
                                <div class="col-8">
                                    <div class="searchBox input-group mb-3 w-50">
                                        <input type="text" id="txtSearchCriterion" name="txtSearchCriterion" class="form-control" placeholder="Search/Filter" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="btnSearchCriterion" name="btnSearchCriterion"><i class="bi bi-search"></i></button>
                                        <button class="btn btn-outline-secondary" type="submit" id="btnCancelSearch" name="btnCancelSearch"><i class="bi bi-x"></i></button>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <button type="button" 
                                    class="<?php 
                                    // Find all foreign keys referencing `faculty_id` from other tables
                                    $query = "SELECT TABLE_NAME, CONSTRAINT_NAME 
                                            FROM information_schema.KEY_COLUMN_USAGE 
                                            WHERE REFERENCED_TABLE_NAME = 'criteria' 
                                            AND REFERENCED_COLUMN_NAME = 'criterion_id'";
                                    
                                    $result = mysqli_query($connect, $query);

                                    // Check if foreign key constraints are found
                                    if ($result->num_rows > 0) {
                                        // If constraints exist, allow button to remove them
                                        echo 'btnRemoveAllCriterionConstraints rounded-0 border border-0 btn btn-danger';
                                    } else {
                                        // If no constraints exist, button is to add constraints
                                        echo 'btnAddAllCriterionConstraints rounded-0 border border-0 btn btn-primary';
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
                                    <button type="button" name="btnDeleteAllCriteria" class="btnDeleteAllCriteria rounded-0 border border-0 btn btn-danger" 
                                    style="
                                    <?php 

                                    $query = "SELECT status FROM evaluation_status";
                                    $executeQuery = mysqli_query($connect, $query);
                                    $result = mysqli_fetch_assoc($executeQuery);
                                    $evaluationStatus = $result["status"];

                                    $query = "SELECT * FROM criteria";
                                    $executeQuery = mysqli_query($connect, $query);
                                    $criterionCount = mysqli_num_rows($executeQuery);

                                    $query = "SELECT * FROM questionnaire";
                                    $executeQuery = mysqli_query($connect, $query);
                                    $questionCount = mysqli_num_rows($executeQuery);

                                    echo $evaluationStatus == 1 || $criterionCount <= 0 || $questionCount > 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;'; 
                                                                
                                    ?>">DELETE ALL</button>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addCriterionModal" name="addCriterionModalLabel" id="btnAddCriterion" class="rounded-0 border border-0 btn btn-success" 
                                    style="
                                    <?php                             
                                    
                                    $query = "SELECT status FROM evaluation_status";
                                    $executeQuery = mysqli_query($connect, $query);
                                    $result = mysqli_fetch_assoc($executeQuery);
                                    $evaluationStatus = $result["status"];
                             
                                    echo $evaluationStatus == 1 ? 'pointer-events: none; background-color: gray;' : 'color: white;';  ?>">ADD A CRITERION</button>
                                </div>
                            </div>
                            <table class="tblCriteria table table-striped table-group-divider border border-2 text-center">
                                <tr>
                                    <th>Criterion ID</th>
                                    <th>Criterion Name</th>
                                    <th>Operations</th>
                                </tr>
                                <?php
                                include_once 'connect.php';
                                
                                if(isset($_POST["btnSearchCriterion"])){
                                    $search = mysqli_real_escape_string($connect, $_POST["txtSearchCriterion"]);
                                    if($search == ""){
                                ?>
                                        <h1>NO RESULT FOUND</h1>
                                <?php
                                    }
                                    else{
                                        $query = "SELECT * FROM Criteria WHERE criterion_id LIKE '%$search%' OR criterion_name LIKE '%$search%'";
                                        $executeQuery = mysqli_query($connect, $query);
                                        $result = mysqli_num_rows($executeQuery);
                    
                                        if($result > 0){
                                            while($row = mysqli_fetch_assoc($executeQuery)){                         
                                    ?>
                                                <tr>
                                                    <tr>
                                                        <td><?php echo $row['criterion_id']; ?></td>
                                                        <td><?php echo $row['criterion_name']; ?></td>
                                                        <td>
                                                            <a class='btnUpdateCriterion text-light' href="#" data-id="<?php echo $row['criterion_id']; ?>" data-criterion="<?php echo $row['criterion_name']; ?>" data-bs-toggle="modal" data-bs-target="#updateCriterionModal" 
                                                            style="
                                                            <?php                             
                                                            
                                                            $query = "SELECT status FROM evaluation_status";
                                                            $executeQuery = mysqli_query($connect, $query);
                                                            $result = mysqli_fetch_assoc($executeQuery);
                                                            $status = $result["status"];
                                                            
                                                            echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">UPDATE</a>
                                                            <a class='btnDeleteCriterion text-light' href="#" data-id="<?php echo $row['criterion_id']; ?>" 
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
                                        else{
                                    ?>
                                            <h1>NO RESULT FOUND</h1>
                                    <?php
                                        }
                                    }                   
                                }
                                else {
                                    $query = "SELECT * FROM Criteria";
                                    $fetch_data = mysqli_query($connect, $query);
                                
                                    if (mysqli_num_rows($fetch_data) > 0) {
                                        foreach ($fetch_data as $row) {
                                ?>
                                            <tr>
                                                <tr>
                                                    <td><?php echo $row['criterion_id']; ?></td>
                                                    <td><?php echo $row['criterion_name']; ?></td>
                                                    <td>
                                                        <a class='btnUpdateCriterion text-light' href="#" data-criterionId="<?php echo $row['criterion_id']; ?>" data-criterion="<?php echo $row['criterion_name']; ?>" data-bs-toggle="modal" data-bs-target="#updateCriterionModal" 
                                                        style="
                                                        <?php                             
                                                        
                                                        $query = "SELECT status FROM evaluation_status";
                                                        $executeQuery = mysqli_query($connect, $query);
                                                        $result = mysqli_fetch_assoc($executeQuery);
                                                        $evaluationStatus = $result["status"];
                                                        
                                                        echo $evaluationStatus == 1 || $questionCount > 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;'; ?>">UPDATE</a>
                                                        <a class='btnDeleteCriterion text-light' href="#" data-criterionId="<?php echo $row['criterion_id']; ?>" 
                                                        style="
                                                        <?php                             
                                                        
                                                        $query = "SELECT status FROM evaluation_status";
                                                        $executeQuery = mysqli_query($connect, $query);
                                                        $result = mysqli_fetch_assoc($executeQuery);
                                                        $evaluationStatus = $result["status"];
                                                        
                                                        echo $evaluationStatus == 1 || $questionCount > 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;';  ?>">DELETE</a>
                                                    </td>
                                                </tr>
                                            </tr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                                                    
                                <script>
                                    // Event delegation: Attach event listener to the document but limit the scope to .btnDeleteCriterion elements
                                    document.addEventListener('DOMContentLoaded', () => {
                                        document.addEventListener('click', function(e) {
                                            if (e.target && e.target.classList.contains('btnDeleteCriterion')) {
                                                e.preventDefault();  // Prevent default link behavior
                                
                                                let criterion_id = e.target.getAttribute('data-criterionId'); 
                                                let deleteCriterion = confirm("Are you sure you want to delete this Criterion?");
                                
                                                if (deleteCriterion == true) {
                                                    // Perform the deletion via AJAX
                                                    $.ajax({
                                                        url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                        type: 'POST',
                                                        data: { 
                                                            btnDeleteCriterion : true,
                                                            criterion_id: criterion_id 
                                                        },
                                                        success: function(response) {
                                                            if (response == 'success') {
                                                                alert("Criterion deleted successfully.");
                                                                window.location.href = 'questionnaire.php';  // Reload page to reflect changes
                                                            } else {
                                                                alert("Failed to delete Criterion it still has question/s.");
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    alert("Deletion of Criterion is cancelled.");
                                                }
                                            } else if (e.target && e.target.classList.contains('btnAddAllCriterionConstraints')) {
                                                e.preventDefault();

                                                let addAllCriterionConstraints = confirm("Are you sure you want to add all constraints referencing criterion_id?");

                                                if (addAllCriterionConstraints === true) {
                                                    $.ajax({
                                                        url: 'addConstraints.php',  // PHP file to handle deletion
                                                        type: 'POST',
                                                        data: { btnAddAllCriterionConstraints: true },  // Send the key to match in PHP
                                                        success: function(response) {
                                                            if (response == 'success') {
                                                                alert("All constraints successfully added.");
                                                                window.location.href = 'questionnaire.php';  // Reload page to reflect changes
                                                            } else {
                                                                alert("Failed to add all Constraints.");
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    alert("Adding constraints cancelled.");
                                                }
                                            } else if (e.target && e.target.classList.contains('btnRemoveAllCriterionConstraints')) {
                                                e.preventDefault();  // Prevent default link behavior
                                
                                                let RemoveAllCriterionConstraints = confirm("Are you sure you want to remove all constraints referencing criterion_id?");
                                
                                                if (RemoveAllCriterionConstraints == true) {
                                                    // Perform the deletion via AJAX
                                                    $.ajax({
                                                        url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                        type: 'POST',
                                                        data: { btnRemoveAllCriterionConstraints: true },  // Send the key to match in PHP
                                                        success: function(response) {
                                                            if (response == 'success') {
                                                                alert("All constraints successfully removed.");
                                                                window.location.href = 'questionnaire.php';  // Reload page to reflect changes
                                                            } else if (response == 'no_constraints') {
                                                                alert("No constraints found referencing criterion_id.");
                                                            } else {
                                                                alert("Failed to remove all Constraints.");
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    alert("Removal cancelled.");
                                                }
                                            } else if (e.target && e.target.classList.contains('btnDeleteAllCriteria')) {
                                                e.preventDefault();  // Prevent default link behavior
                                        
                                                let deleteAllQuestions = confirm("Are you sure you want to delete all the Criteria?");
                                        
                                                if (deleteAllQuestions == true) {
                                                    // Perform the deletion via AJAX
                                                    $.ajax({
                                                        url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                        type: 'POST',
                                                        data: { btnDeleteAllCriteria: true },  // Send the key to match in PHP
                                                        success: function(response) {
                                                            if (response == 'success') {
                                                                alert("All Criteria are deleted successfully.");
                                                                window.location.href = 'questionnaire.php';  // Reload page to reflect changes
                                                            } else {
                                                                alert("Failed to delete all Criteria. Remove all Constraints and all Questions first.");
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
                                                      
                        
                    <div class="edit-question">                                        
                        <!-- Evaluation Form -->
                        <div class="evaluation-question">
                            <div class="evaluation-question-top">
                                <p class="label-question">Evaluation Questions</p>
                            </div>
                            <hr>
                            <div class="evaluation-question-content">
                                <div class="question-container">
                                    <table class="question-table">
                                        <div class="float-end">
                                        <button type="button" name="btnDeleteAllQuestions" class="btnDeleteAllQuestions rounded-0 border border-0 btn btn-danger" 
                                        style="
                                        <?php 

                                        $query = "SELECT status FROM evaluation_status";
                                        $executeQuery = mysqli_query($connect, $query);
                                        $result = mysqli_fetch_assoc($executeQuery);
                                        $evaluationStatus = $result["status"];

                                        $query = "SELECT * FROM questionnaire";
                                        $executeQuery = mysqli_query($connect, $query);
                                        $questionCount = mysqli_num_rows($executeQuery);

                                        echo $evaluationStatus == 1 || $questionCount <= 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;';                                      
                                        
                                        ?>">DELETE ALL</button>
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#addQuestionModal" name="addNewQuestion" id="btnAddQuestion" class="rounded-0 border border-0 btn btn-success" 
                                            style="
                                            <?php                             
                                            
                                            $query = "SELECT status FROM evaluation_status";
                                            $executeQuery = mysqli_query($connect, $query);
                                            $result = mysqli_fetch_assoc($executeQuery);
                                            $status = $result["status"];

                                            $query = "SELECT * FROM criteria";
                                            $executeQuery = mysqli_query($connect, $query);
                                            $criterionCount = mysqli_num_rows($executeQuery);
                                            
                                            echo $status != 0 || $criterionCount <= 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;';  ?>">ADD A QUESTION</button>
                                        </div>

                                        <?php

                                        $query1 = "SELECT criterion_name FROM Criteria";
                                        $criteria = mysqli_query($connect, $query1);

                                        while ($row1 = mysqli_fetch_assoc($criteria)) {
                                            $criterion_name = $row1["criterion_name"];

                                            // Prepare the statement to fetch questions for the current criterion
                                            $stmt = $connect->prepare("SELECT * FROM Questionnaire WHERE criterion_name = ?");
                                            $stmt->bind_param('s', $criterion_name);
                                            $stmt->execute();
                                            $questions = $stmt->get_result();

                                            // Check if there are any questions associated with this criterion
                                            if ($questions->num_rows > 0) {
                                        ?>
                                                <thead>
                                                    <tr>
                                                        <th><?php echo $criterion_name; ?></th>
                                                        <th>Operation</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        <?php
                                                $questionNumber = 1;

                                                while ($row3 = mysqli_fetch_assoc($questions)) {
                                        ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?php echo $questionNumber; ?>. <?php echo $row3['question']; ?></td>
                                                        <td class="operations-con">
                                                            <a class='btnUpdateQuestion' href="#" data-questionId="<?php echo $row3['question_id']; ?>" data-question="<?php echo $row3['question']; ?>" data-criterionId="<?php echo $row3['criterion_id']; ?>" data-criterionName="<?php echo $row3['criterion_name']; ?>" data-bs-toggle="modal" data-bs-target="#updateQuestionModal" 
                                                            style="
                                                            <?php                             
                                                            
                                                            $query = "SELECT status FROM evaluation_status";
                                                            $executeQuery = mysqli_query($connect, $query);
                                                            $result = mysqli_fetch_assoc($executeQuery);
                                                            $status = $result["status"];
                                                            
                                                            echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">UPDATE</a>
                                                            <a class='btnDeleteQuestion' href="#" data-questionId="<?php echo $row3['question_id']; ?>" 
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
                                                        $questionNumber++;
                                                    }                   
                                                }
                                                $stmt->close(); // Close the statement after processing
                                            }
                                        ?>
                                        </tbody>

                                        <script>
                                            // Event delegation: Attach event listener to the document but limit the scope to .btnDeleteCriterion elements
                                            document.addEventListener('DOMContentLoaded', () => {
                                                document.addEventListener('click', function(e) {
                                                    if (e.target && e.target.classList.contains('btnDeleteQuestion')) {
                                                        e.preventDefault();  // Prevent default link behavior
                                        
                                                        let question_id = e.target.getAttribute('data-questionId'); 
                                                        let deleteQuestion = confirm("Are you sure you want to delete this Question?");
                                        
                                                        if (deleteQuestion == true) {
                                                            // Perform the deletion via AJAX
                                                            $.ajax({
                                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                                type: 'POST',
                                                                data: { 
                                                                    btnDeleteQuestion : true,
                                                                    question_id: question_id 
                                                                },
                                                                success: function(response) {
                                                                    if (response == 'success') {
                                                                        alert("Question deleted successfully.");
                                                                        window.location.href = 'questionnaire.php';  // Reload page to reflect changes
                                                                    } else {
                                                                        alert("Failed to delete Question.");
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            alert("Deletion of Question is cancelled.");
                                                        }
                                                    } else if (e.target && e.target.classList.contains('btnDeleteAllQuestions')) {
                                                        e.preventDefault();  // Prevent default link behavior
                                        
                                                        let deleteAllQuestions = confirm("Are you sure you want to delete all the Questions?");
                                        
                                                        if (deleteAllQuestions == true) {
                                                            // Perform the deletion via AJAX
                                                            $.ajax({
                                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                                type: 'POST',
                                                                data: { btnDeleteAllQuestions: true },  // Send the key to match in PHP
                                                                success: function(response) {
                                                                    if (response == 'success') {
                                                                        alert("All Questions are deleted successfully.");
                                                                        window.location.href = 'questionnaire.php';  // Reload page to reflect changes
                                                                    } else {
                                                                        alert("Failed to delete all Questions.");
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
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</main>

        <!-- Modal for Adding Criterion -->
        <div class="modal fade" id="addCriterionModal" tabindex="-1" aria-labelledby="addCriterionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Criterion</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-middle">
                                <p class="label-question">Crtierion <span style="color: red;"> *<span></p>
                                <textarea id="txtCriterion" name="txtCriterion" class="question"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="btnAddCriterion">Add</button>
                                <?php

                                if(isset($_POST["btnAddCriterion"])) {
                                    $txtCriterion = $_POST["txtCriterion"];

                                    if($txtCriterion == "") {
                                        echo "<script>alert('Question cannot be empty.');</script>";
                                        echo "<script>window.location.href='questionnaire.php';</script>";
                                    }
                                    else {
                                        $stmt = $connect->prepare("INSERT INTO Criteria (criterion_name) VALUES (?)");
                                        $stmt->bind_param('s', $txtCriterion);
                                        $newCriterion = $stmt->execute();
                                    }

                                    if($newCriterion) {
                                        echo "<script>alert('New criterion added successfully.');</script>";
                                        echo "<script>window.location.href='questionnaire.php';</script>";
                                    }
                                    else {
                                        echo "<script>alert('Failed to add new criterion.');</script>";
                                        echo "<script>window.location.href='questionnaire.php';</script>";
                                    }
                                }

                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Updating Criterion -->
        <div class="modal fade" id="updateCriterionModal" tabindex="-1" aria-labelledby="updateCriterionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Criterion</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-middle">
                                <p class="label-question">Crtierion <span style="color: red;"> *<span></p>
                                <input type="hidden" name="currentCriterion" id="currentCriterion">
                                <textarea id="txtCriterion" name="txtCriterion" class="question" required></textarea>
                                <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        const btnUpdateCriterion = document.querySelectorAll('.btnUpdateCriterion');
                                        
                                        btnUpdateCriterion.forEach(button => {
                                            button.addEventListener('click', () => {
                                                const criterion = button.getAttribute('data-criterion');
                                                
                                                document.querySelector('#currentCriterion').value = criterion;
                                                document.querySelector('#updateCriterionModal [name="txtCriterion"]').value = criterion;
                                            });
                                        });
                                    });   
                                </script>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="btnUpdateCriterion">Update</button>
                                <?php

                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    if (isset($_POST["btnUpdateCriterion"]) && isset($_POST["currentCriterion"])) {
                                        $currentCriterion = $_POST["currentCriterion"];
                                        $updatedCriterion = $_POST["txtCriterion"];
                                        $insertionAllowed = true;

                                        // Prepared statement to check if the criterion exists in the Questionnaire
                                        $query = $connect->prepare("SELECT criterion_name FROM Questionnaire WHERE criterion_name = ?");
                                        $query->bind_param("s", $currentCriterion);
                                        $query->execute();
                                        $executeQuery = $query->get_result();
                                        $result = mysqli_num_rows($executeQuery);

                                        if ($result > 0) {
                                            echo "<script>alert('Cannot Update Criterion. It still has question/s.')</script>";
                                        } else {
                                            // Prepared statement to select all criteria and check if the updated one already exists
                                            $query = "SELECT * FROM Criteria";
                                            $executeQuery = mysqli_query($connect, $query);

                                            while ($row = mysqli_fetch_assoc($executeQuery)) {
                                                if ($updatedCriterion != $currentCriterion) {
                                                    if ($updatedCriterion != "" && $updatedCriterion == $row['criterion_name']) {
                                                        echo "<script>alert('Criterion is already existing.');</script>";
                                                        $insertionAllowed = false;
                                                        break;
                                                    }
                                                }
                                            }
                                            // Update the criterion if allowed
                                            if ($insertionAllowed) {
                                                $query = $connect->prepare("UPDATE Criteria SET criterion_name = ? WHERE criterion_name = ?");
                                                $query->bind_param("ss", $updatedCriterion, $currentCriterion);

                                                if ($query->execute()) {
                                                    echo "<script>alert('Criterion updated successfully.');</script>";
                                                    echo "<script>window.location.href='questionnaire.php'</script>";
                                                } else {
                                                    echo "<script>alert('Failed to update Criterion.');</script>";
                                                    echo "<script>window.location.href='questionnaire.php'</script>";
                                                }
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
        
        <!-- Modal for Adding Question -->
        <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Question</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Add Question Form -->
                        <form method="post">
                            <div class="form-middle">
                                <p class="label-question">Question</p>
                                <textarea id="txtQuestion" name="txtQuestion" class="question" required></textarea>
                            </div>
                            <div class="criterion-con">
                                <label for="criterion" class="criterion-label">Criterion: </label><span style="color: red">*</span>
                                <select name="criterion" id="criterion" required>
                                    <?php

                                    $query = "SELECT criterion_name FROM Criteria";
                                    $executeQuery = mysqli_query($connect, $query);

                                    while($row = mysqli_fetch_assoc($executeQuery)) {
                                    ?>

                                        <option value="<?php echo $row['criterion_name']; ?>"><?php echo $row["criterion_name"]; ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="btnAddQuestion">Add</button>
                                <?php

                                if (isset($_POST["btnAddQuestion"])) {
                                    $txtQuestion = $_POST["txtQuestion"];
                                    $criterion = $_POST["criterion"];

                                    if ($txtQuestion == "") {
                                        echo "<script>alert('Question cannot be empty.');</script>";
                                        echo "<script>window.location.href='questionnaire.php';</script>";
                                    } else {
                                        // Select the criterion_id based on the selected criterion_name
                                        $stmt = $connect->prepare("SELECT * FROM Criteria WHERE criterion_name = ?");
                                        $stmt->bind_param('s', $criterion);
                                        $stmt->execute();
                                        $stmt->bind_result($criterion_id, $criterion_name);
                                        $stmt->fetch();
                                        $stmt->close();

                                        if ($criterion_id) {
                                            // Insert the new question along with the criterion_id
                                            $stmt = $connect->prepare("INSERT INTO Questionnaire (question, criterion_id, criterion_name) VALUES (?, ?, ?)");
                                            $stmt->bind_param('sis', $txtQuestion, $criterion_id, $criterion_name);
                                            $newQuestion = $stmt->execute();
                                            $stmt->close();

                                            if ($newQuestion) {
                                                echo "<script>alert('New question added successfully.');</script>";
                                                echo "<script>window.location.href='questionnaire.php';</script>";
                                            } else {
                                                echo "<script>alert('Failed to add new question.');</script>";
                                                echo "<script>window.location.href='questionnaire.php';</script>";
                                            }
                                        } else {
                                            echo "<script>alert('Criterion not found.');</script>";
                                            echo "<script>window.location.href='questionnaire.php';</script>";
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
    </div>

    <!-- Modal for Updating Question -->
    <div class="modal fade" id="updateQuestionModal" tabindex="-1" aria-labelledby="updateQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Question</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-middle">
                            <p class="label-question">Question</p>
                            <input type="hidden" name="currentQuestionId" id="currentQuestionId">
                            <input type="hidden" name="currentQuestion" id="currentQuestion">
                            <textarea id="txtQuestion" name="txtQuestion" class="question"></textarea>
                            
                            <div class="criterion-con">
                                <input type="hidden" name="currentCriterionId" id="currentCriterionId">
                                <input type="hidden" name="currentCriterion" id="currentCriterion">
                                <label for="criterion" class="criterion-label">Criterion: </label><span style="color: red">*</span>
                                <select name="criterion" id="criterion" required>
                                    <?php
                                    $query = "SELECT criterion_name FROM Criteria";
                                    $executeQuery = mysqli_query($connect, $query);

                                    while($row = mysqli_fetch_assoc($executeQuery)) {
                                    ?>
                                        <option value="<?php echo $row['criterion_name']; ?>"><?php echo $row["criterion_name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const btnUpdateQuestion = document.querySelectorAll('.btnUpdateQuestion');
                                    
                                    btnUpdateQuestion.forEach(button => {
                                        button.addEventListener('click', () => {
                                            const questionId = button.getAttribute('data-questionId');
                                            const question = button.getAttribute('data-question');
                                            const criterionId = button.getAttribute('data-criterionId');
                                            const criterion = button.getAttribute('data-criterionName');
                                                
                                            // Set the hidden fields
                                            document.querySelector('#currentQuestionId').value = questionId;
                                            document.querySelector('#currentQuestion').value = question;
                                            document.querySelector('#currentCriterionId').value = criterionId;
                                            document.querySelector('#currentCriterion').value = criterion;
                                            document.querySelector('#updateQuestionModal [name="txtQuestion"]').value = question;
                                            document.querySelector('#updateQuestionModal [name="criterion"]').value = criterion;
                                          
                                        });
                                    });
                                });
                            </script>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="btnUpdateQuestion">Update</button>

                            <?php
                            // Update Question Process 
                            if (isset($_POST["btnUpdateQuestion"]) && isset($_POST["currentQuestion"])) {
                                $currentQuestionId = $_POST['currentQuestionId'];
                                $currentQuestion = $_POST['currentQuestion'];
                                $updatedQuestion = $_POST['txtQuestion'];
                                $currentCriterionId = $_POST['currentCriterionId'];
                                $updatedCriterion = $_POST['criterion'];

                                // Prepare and execute the query to get the updated criterion ID
                                $query = $connect->prepare("SELECT criterion_id FROM Criteria WHERE criterion_name = ?");
                                $query->bind_param("s", $updatedCriterion);
                                $query->execute();
                                $result = $query->get_result();
                                $row = $result->fetch_assoc();
                                $updatedCriterionId = $row['criterion_id'];

                                $insertionAllowed = true;

                                // Check if the updated question already exists
                                $query = "SELECT * FROM Questionnaire";
                                $result = mysqli_query($connect, $query);

                                while($row = mysqli_fetch_assoc($result)) {
                                    if($updatedQuestion != $currentQuestion) {
                                        if($updatedQuestion != "" && $updatedQuestion == $row['question']) {
                                            echo "<script>alert('Question is already existing.');</script>";
                                            $insertionAllowed = false;
                                            break;
                                        }
                                    }
                                }

                                // Proceed to update if no duplicates found
                                if($insertionAllowed) {
                                    $query = $connect->prepare("UPDATE Questionnaire SET question = ?, criterion_id = ?, criterion_name = ? WHERE question_id = ?");
                                    $query->bind_param("sisi", $updatedQuestion, $updatedCriterionId, $updatedCriterion, $currentQuestionId);
                                
                                    if ($query->execute()) {
                                        echo "<script>alert('Question updated successfully.');</script>";
                                        echo "<script>window.location.href='questionnaire.php'</script>";
                                    } else {
                                        echo "<script>alert('Failed to update question.');</script>";
                                        echo "<script>window.location.href='questionnaire.php'</script>";
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


		<!-------- footer ---------->
	</div>
	
	<!--================= popups ===================-->
	<!-------- popup logout ---------->


<!--
	<script src="script.js"></script>
	<script src="deleteConfirmation.js"></script>
-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<!-- Function to clear text -->
<script>
    function cancelAction() {
        event.preventDefault();
        window.location.href = 'questionnaire.php';
    }
</script>



<?php  

 /*
$query = "SELECT * FROM Questionnaire";
$executeQuery = mysqli_query($connect, $query);
$result = mysqli_num_rows($executeQuery);

if($result > 0){
    echo "<script>alert('Cannot Update Criterion. It still has question/s.')</script>";
  
} else{
    echo "data-bs-target='#updateCriterionModal'";
}

*/

?> 