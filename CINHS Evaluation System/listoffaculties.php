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
    <script src="ShowAndHidePassword.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Add jQuery for AJAX support -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>CINHS Faculty Evaluation System</title>
    <style>
        #nav-faculty{
            color: gray;
            pointer-events: none;
        }
        #txtSearchFaculty{
            padding: 0px 20px;
            width: 300px;
            height: 40px;
            font-size: 22px;
        }
        #btnClear{
            padding: 12px;
            height: 44px;
        }
    </style>
</head>
<body id="listoffaculties-body">
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
            <div class="listoffaculties-con col-10 p-5">
                <form action="listoffaculties.php" method="POST">
                    <h1 id="listoffaculties-header">List of Faculties</h1>
                    <div class="row">
                        <div class="col-8">
                            <div class="searchBox input-group mb-3 w-50">
                                <input type="text" id="txtSearchFaculty" name="txtSearchFaculty" class="form-control" placeholder="Search/Filter" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="btnSearchFaculty" name="btnSearchFaculty"><i class="bi bi-search"></i></button>
                                <button class="btn btn-outline-secondary" type="submit" id="btnCancelSearch" name="btnCancelSearch"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <button type="button" 
                            class="<?php 
                            // Find all foreign keys referencing `faculty_id` from other tables
                            $query = "SELECT TABLE_NAME, CONSTRAINT_NAME 
                                    FROM information_schema.KEY_COLUMN_USAGE 
                                    WHERE REFERENCED_TABLE_NAME = 'faculty' 
                                    AND REFERENCED_COLUMN_NAME = 'faculty_id'";
                            
                            $result = mysqli_query($connect, $query);

                            // Check if foreign key constraints are found
                            if ($result->num_rows > 0) {
                                // If constraints exist, allow button to remove them
                                echo 'btnRemoveAllFacultyConstraints rounded-0 border border-0 btn btn-danger';
                            } else {
                                // If no constraints exist, button is to add constraints
                                echo 'btnAddAllFacultyConstraints rounded-0 border border-0 btn btn-primary';
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
                            <button type="button" name="btnDeleteAllFaculties" class="btnDeleteAllFaculties rounded-0 border border-0 btn btn-danger" 
                            style="
                            <?php 

                            $query = "SELECT status FROM evaluation_status";
                            $executeQuery = mysqli_query($connect, $query);
                            $result = mysqli_fetch_assoc($executeQuery);
                            $evaluationStatus = $result["status"];

                            $query = "SELECT * FROM faculty";
                            $executeQuery = mysqli_query($connect, $query);
                            $facultyCount = mysqli_num_rows($executeQuery);

                            echo $evaluationStatus == 1 || $facultyCount <= 0 ? 'pointer-events: none; background-color: gray;' : 'color: white'; 
                            
                            
                            ?>">DELETE ALL</button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addFacultyModal" name="addNewStudent" id="btnAddStudent" class="rounded-0 border border-0 btn btn-success" 
                            style="
                            <?php                             
                            
                            $query = "SELECT status FROM evaluation_status";
                            $executeQuery = mysqli_query($connect, $query);
                            $result = mysqli_fetch_assoc($executeQuery);
                            $status = $result["status"];
                            
                            echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">ADD A FACULTY</button>
                         </div>
                    </div>
                    <div class="text-start">
                        <?php 
                        
                        $query = $connect->prepare("SELECT * FROM Faculty");
                        $query->execute();
                        $result = $query->get_result();
                        $row = $result->num_rows;
                        
                        ?>
                        <span>Faculty count: <?php echo $row ?></span>
                    </div>
                    <table class="tblFaculties table table-striped table-group-divider border border-2">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Contact Number</th>
                            <th>Photo</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Operations</th>
                        </tr>
                        <?php
                        include_once 'connect.php';
                        include_once 'delete-process.php';
                        
                        if(isset($_POST["btnSearchFaculty"])){
                            $search = mysqli_real_escape_string($connect, $_POST["txtSearchFaculty"]);
                            if($search == ""){
                        ?>
                                <h1>NO RESULT FOUND</h1>
                        <?php
                            }
                            else{
                                $query = "SELECT * FROM Faculty WHERE faculty_id LIKE '%$search%' OR firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR gender LIKE '%$search%' OR contactNumber LIKE '%$search%' OR email LIKE '%$search%' OR password LIKE '%$search%'";
                                $executeQuery = mysqli_query($connect, $query);
                                $result = mysqli_num_rows($executeQuery);
            
                                if($result > 0){
                                    while($row = mysqli_fetch_assoc($executeQuery)){                         
                        ?>
                                        <tr>
                                            <tr>
                                                <td><?php echo $row['faculty_id']; ?></td>
                                                <td><?php echo $row['firstName']; ?></td>
                                                <td><?php echo $row['lastName']; ?></td>
                                                <td><?php echo $row['gender']; ?></td>
                                                <td><?php echo $row['contactNumber']; ?></td>
                                                <td>
                                                    <img src='<?php echo "faculty-images/".$row['photo']; ?>' height='40px'>
                                                </td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['password']; ?></td>
                                                <td>
                                                    <a class='btnUpdateFaculty text-light' href="#" data-id="<?php echo $row['faculty_id']; ?>" data-firstname="<?php echo $row['firstName']; ?>" data-lastname="<?php echo $row['lastName']; ?>" data-gender="<?php echo $row['gender']; ?>" data-contactnumber="<?php echo $row['contactNumber']; ?>" data-email="<?php echo $row['email']; ?>" data-password="<?php echo $row['password']; ?>" data-photo="<?php echo $row['photo']; ?>" data-bs-toggle="modal" data-bs-target="#updateFacultyModal" 
                                                    style="
                                                    <?php             
                                                    
                                                    $query = "SELECT status FROM evaluation_status";
                                                    $executeQuery = mysqli_query($connect, $query);
                                                    $result = mysqli_fetch_assoc($executeQuery);
                                                    $status = $result["status"];
                                                    
                                                     echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">UPDATE</a>
                                                    <a class='btnDeleteFaculty text-light' name='btnDeleteFaculty' href="#" data-id="<?php echo $row['faculty_id']; ?>" 
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
                            $query = "SELECT * FROM Faculty";
                            $fetch_data = mysqli_query($connect, $query);

                            if(mysqli_num_rows($fetch_data) > 0)
                            {

                                foreach($fetch_data as $row)
                                {
                        ?>          
                                    <tr>
                                        <td><?php echo $row['faculty_id']; ?></td>
                                        <td><?php echo $row['firstName']; ?></td>
                                        <td><?php echo $row['lastName']; ?></td>
                                        <td><?php echo $row['gender']; ?></td>
                                        <td><?php echo $row['contactNumber']; ?></td>
                                        <td>
                                            <img src='<?php echo "faculty-images/".$row['photo']; ?>' height='40px'>
                                        </td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['password']; ?></td>
                                        <td>
                                            <a class='btnUpdateFaculty text-light' href="#" data-id="<?php echo $row['faculty_id']; ?>" data-firstname="<?php echo $row['firstName']; ?>" data-lastname="<?php echo $row['lastName']; ?>" data-gender="<?php echo $row['gender']; ?>" data-contactnumber="<?php echo $row['contactNumber']; ?>" data-email="<?php echo $row['email']; ?>" data-password="<?php echo $row['password']; ?>" data-photo="<?php echo $row['photo']; ?>" data-bs-toggle="modal" data-bs-target="#updateFacultyModal" 
                                            style="
                                            <?php                             
                                            
                                            $query = "SELECT status FROM evaluation_status";
                                            $executeQuery = mysqli_query($connect, $query);
                                            $result = mysqli_fetch_assoc($executeQuery);
                                            $status = $result["status"];
                                            
                                            echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">UPDATE</a>
                                            <a class='btnDeleteFaculty text-light' name='btnDeleteFaculty' href="#" data-id="<?php echo $row['faculty_id']; ?>" style="
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
                        }                       
                        ?>        
                                             
                        <script>
                            // Event delegation: Attach event listener to the document but limit the scope to .btnDeleteAdmin elements
                            document.addEventListener('DOMContentLoaded', () => {
                                document.addEventListener('click', function(e) {
                                    if (e.target && e.target.classList.contains('btnDeleteFaculty')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let faculty_id = e.target.getAttribute('data-id');  // Get the admin ID from the data attribute
                                        let deleteFaculty = confirm("Are you sure you want to delete this Faculty?");
                        
                                        if (deleteFaculty == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnDeleteFaculty: true,
                                                        faculty_id : faculty_id
                                                },
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("Faculty deleted successfully.");
                                                        window.location.href = 'listoffaculties.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to delete Faculty.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Deletion of Faculty is cancelled.");
                                        }
                                    } else if (e.target && e.target.classList.contains('btnAddAllFacultyConstraints')) {
                                        e.preventDefault();

                                        let addAllFacultyConstraints = confirm("Are you sure you want to add all constraints referencing faculty_id?");

                                        if (addAllFacultyConstraints === true) {
                                            $.ajax({
                                                url: 'addConstraints.php',  // PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnAddAllFacultyConstraints: true },  // Send the key to match in PHP
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("All constraints successfully added.");
                                                        window.location.href = 'listoffaculties.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to add all Constraints.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Adding constraints cancelled.");
                                        }
                                    } else if (e.target && e.target.classList.contains('btnRemoveAllFacultyConstraints')) {
                                        e.preventDefault();

                                        let removeAllFacultyConstraints = confirm("Are you sure you want to remove all constraints referencing faculty_id?");

                                        if (removeAllFacultyConstraints === true) {
                                            $.ajax({
                                                url: 'delete-process.php',  // PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnRemoveAllFacultyConstraints: true },  // Send the key to match in PHP
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("All constraints successfully removed.");
                                                        window.location.href = 'listoffaculties.php';  // Reload page to reflect changes
                                                    } else if (response == 'no_constraints') {
                                                        alert("No constraints found referencing faculty_id.");
                                                    } else {
                                                        alert("Failed to remove all Constraints.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Removal cancelled.");
                                        }
                                    } else if (e.target && e.target.classList.contains('btnDeleteAllFaculties')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let deleteAllFaculties = confirm("Are you sure you want to delete all the Faculties?");
                        
                                        if (deleteAllFaculties == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnDeleteAllFaculties: true },  // Send the key to match in PHP
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("All Faculties are deleted successfully.");
                                                        window.location.href = 'listoffaculties.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to delete all Faculties. Please first remove all constraints referencing faculty_id.");
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

    <!-- Modal for Adding Faculty -->
    <div class="modal fade" id="addFacultyModal" tabindex="-1" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Adding a Faculty</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <form action="listoffaculties.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="addfaculty-photo-con mb-3">
                                    <img src='faculty-images/default-profile.png' height='150px'> <br> <br>
                                    <h6 class="text-start">Profile</h6>
                                    <div class="input-group">     
                                        <input type="file" id="inputGroupFile02" class="form-control" name="facultyImage" accept=".jpg, .jpeg, .png">	
                                    </div>             
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="text-start">ID<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3 w-50">    
                                    <input type="text" class="addfaculty-facultyid form-control" placeholder="ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFacultyId" autocomplete="off" required>
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">First Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">    
                                    <input type="text" class="addfaculty-firstname form-control" placeholder="First Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFirstName" autocomplete="new-firstname" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">Last Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="addfaculty-lastname form-control" placeholder="Last Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtLastName" autocomplete="new-lastname" required>
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="row text-start mb-3">
                                            <h6>Gender<span style="color: red;"> *<span></h6>
                                            <label><input type="radio" name="rdoGender" value="Male" required> Male</label>
                                            <label><input type="radio" name="rdoGender" value="Female" required> Female</label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="text-start">Contact Number (Optional)</h6>
                                        <div class="input-group mb-3">
                                            <input type="text" class="addfaculty-contactnumber form-control" placeholder="Contact Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtContactNumber" autocomplete="new-contact">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-start">Email (Optional)</h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="addfaculty-email form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtEmail" autocomplete="new-email">
                                </div>
                                <h6 class="text-start">Password<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input  id="txtPasswordAddUser" type="password" class="addadmin-password form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtPassword" autocomplete="off" required>
                                    <button id="btnShowPasswordAddUser" type="button" onclick="showPasswordForAddingUser(this)">SHOW</button>	
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" name="btnAddFaculty">Add</button>
                            </div>
                        </div>             
                    </form> 
                </div>
            </div>
        </div>
    </div>
    <?php

    /* For Adding Faculty */
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (isset($_POST["btnAddFaculty"])) 
        {
            // Variables for adding Faculty
            $faculty_id = $_POST["txtFacultyId"];
            $firstName = $_POST["txtFirstName"];
            $lastName = $_POST["txtLastName"];
            $gender = $_POST["rdoGender"];
            $contactNumber = $_POST["txtContactNumber"];    
            $status = "Faculty";
            $email = $_POST["txtEmail"];
            $password = $_POST["txtPassword"];
            $insertionAllowed = true;

            // Contact number and Email validation (before database query)
            if(!preg_match("/^09[0-9]{9}$/", $contactNumber) && $contactNumber != "") {
                echo "<script>alert('Invalid Contact Number. It should start with 09 and be 11 digits long.');</script>";
                $insertionAllowed = false;
            }
            else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != "") {
                echo "<script>alert('Invalid Email');</script>";
                $insertionAllowed = false;
            }

            // Checking if contact number and email is already existing
            $query = "SELECT * FROM Faculty";
            $result = mysqli_query($connect, $query);

            while($row = mysqli_fetch_assoc($result))
            {
                if($faculty_id == $row['faculty_id']) {
                    echo "<script>alert('Faculty ID is already existing.');</script>";
                    $insertionAllowed = false;
                    break;
                } else if($contactNumber != "" && $contactNumber == $row['contactNumber']) {
                    echo "<script>alert('Contact Number is already existing.');</script>";
                    $insertionAllowed = false;
                    break;
                } else if($email != "" && $email == $row['email']) {
                    echo "<script>alert('Email is already existing.');</script>";
                    $insertionAllowed = false;
                    break;
                }
            }

            // Password validation
            if (!preg_match('/[A-Z]/', $password)) {
                echo "<script>alert('Password must contain at least one uppercase letter.');</script>";
                $insertionAllowed = false;
            } elseif (!preg_match('/[a-z]/', $password)) {
                echo "<script>alert('Password must contain at least one lowercase letter.');</script>";
                $insertionAllowed = false;
            } elseif (!preg_match('/[0-9]/', $password)) {
                echo "<script>alert('Password must contain at least one number.');</script>";
                $insertionAllowed = false;
            }

            
            // Continue with insertion if still valid
            if($insertionAllowed) {
                if($_FILES['facultyImage']['error'] === 4)
                {
                    $defaultFacultyImage = 'default-profile.png'; 

                    $stmt = $connect->prepare("INSERT INTO Faculty (faculty_id, firstName, lastName, gender, contactNumber, status, photo, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('sssssssss', $faculty_id, $firstName, $lastName, $gender, $contactNumber, $status, $defaultFacultyImage, $email, $password);
                    $newFaculty = $stmt->execute();
                }
                else
                {
                    $imageName = $_FILES['facultyImage']['name'];
                    $imageSize = $_FILES['facultyImage']['size'];
                    $imageTmpPath = $_FILES['facultyImage']['tmp_name'];

                    $validImageExtension = ['jpg', 'jpeg', 'png'];
                    $imageExtension = explode(".", $imageName);
                    $imageExtension = strtolower(end($imageExtension));

                    if(!in_array($imageExtension, $validImageExtension))
                    {
                        echo "<script>alert('Invalid image extension.');</script>";
                    }
                    else if($imageSize > 1000000)
                    {
                        echo "<script>alert('Image size too large.');</script>";
                    }
                    else
                    {
                        $newImageName = uniqid();
                        $newImageName .= '.' . $imageExtension;

                        move_uploaded_file($imageTmpPath, 'faculty-images/' . $newImageName);

                        $stmt = $connect->prepare("INSERT INTO Faculty (faculty_id, firstName, lastName, gender, contactNumber, status, photo, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param('sssssssss', $faculty_id, $firstName, $lastName, $gender, $contactNumber, $status, $newImageName, $email, $password);
                        $newFaculty = $stmt->execute();
                    }
                }  

                if($newFaculty) {
                    echo "<script>alert('New faculty added successfully.');</script>";
                    echo "<script>window.location.href='listoffaculties.php';</script>";
                } else {
                    echo "<script>alert('Failed to add new faculty.');</script>";
                    echo "<script>window.location.href='listoffaculties.php';</script>";
                }
            }
        }
    }

    ?>

    <!-- Modal for Updating Faculty -->
    <div class="modal fade" id="updateFacultyModal" tabindex="-1" aria-labelledby="updateFacultyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Updating a Faculty</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <form action="listoffaculties.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="updatefaculty-photo-con mb-3">
                                    <img src='<?php echo 'faculty-images/' . $row['photo']?>' height='150px'> <br> <br>
                                    <h6 class="text-start">Profile</h6>
                                    <div class="input-group">     
                                        <input type="file" id="inputGroupFile02" class="form-control" name="facultyImage" accept=".jpg, .jpeg, .png">	
                                    </div>
                                    <input type='hidden' name='old-image' value='<?php echo $row['photo']; ?>'>                          
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="text-start">ID<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3 w-50">   
                                    <input type="hidden" name="currentFacultyId" id="currentFacultyId"> <!-- Hidden field for current faculty ID -->
                                    <input type="text" class="updatefaculty-facultyid form-control" placeholder="ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFacultyId" autocomplete="off" required>
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">First Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">    
                                    <input type="text" class="updatefaculty-firstname form-control" placeholder="First Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFirstName" autocomplete="new-firstname" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">Last Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="updatefaculty-lastname form-control" placeholder="Last Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtLastName" autocomplete="new-lastname" required>
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="row text-start mb-3">
                                            <h6>Gender<span style="color: red;"> *<span></h6>
                                            <label><input type="radio" name="rdoGender" value="Male" required> Male</label>
                                            <label><input type="radio" name="rdoGender" value="Female" required> Female</label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <h6 class="text-start">Contact Number (Optional)</h6>
                                        <div class="input-group mb-3">
                                            <input type="hidden" name="currentContactNumber" id="currentContactNumber"> <!-- Hidden field for current contact number -->
                                            <input type="text" class="updatefaculty-contactnumber form-control" placeholder="Contact Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtContactNumber" autocomplete="new-contact">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-start">Email (Optional)</h6>
                                <div class="input-group mb-3">
                                    <input type="hidden" name="currentEmail" id="currentEmail"> <!-- Hidden field for current contact number -->
                                    <input type="text" class="updatefaculty-email form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtEmail" autocomplete="new-email">
                                </div>
                                <h6 class="text-start">Password<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input id="txtPasswordUpdateUser" type="password" class="updatefaculty-password form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtPassword" autocomplete="off" required>
                                    <button id="btnShowPasswordUpdateUser" type="button" onclick="showPasswordForUpdatingUser(this)">SHOW</button>	
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-info" name="btnUpdateFaculty">Update</button>
                            </div>
                        </div>             
                    </form> 
                </div>
            </div>
        </div>
    </div> 
    <?php

    /* For Updating Faculty */
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["btnUpdateFaculty"]) && isset($_POST["currentFacultyId"])) {
            $currentFacultyId = $_POST["currentFacultyId"];
            $updatedFacultyId = $_POST["txtFacultyId"];
            $firstName = $_POST["txtFirstName"];
            $lastName = $_POST["txtLastName"];
            $gender = $_POST["rdoGender"];
            $currentContactNumber = $_POST["currentContactNumber"];
            $updatedContactNumber = $_POST["txtContactNumber"];
            $currentEmail = $_POST["currentEmail"];
            $updatedEmail = $_POST["txtEmail"];
            $password = $_POST["txtPassword"];
            $newImageName = $_FILES['facultyImage']['name'];
            $newImageSize = $_FILES['facultyImage']['tmp_name'];
            $newImageTmpPath = $_FILES['facultyImage']['tmp_name'];
            $old_image = $_POST['old-image'];
            $insertionAllowed = true;

            if($updatedContactNumber != "" && !preg_match("/^09[0-9]{9}$/", $updatedContactNumber)) {
                echo "<script>alert('Invalid Contact Number. It should start with 09 and be 11 digits long.');</script>";
                $insertionAllowed = false;
            } 
            else if($updatedEmail != "" && !filter_var($updatedEmail, FILTER_VALIDATE_EMAIL))
            {
                echo "<script>alert('Invalid Email');</script>";
                $insertionAllowed = false;
            }  

            // Password validation
            if (!preg_match('/[A-Z]/', $password)) {
                echo "<script>alert('Password must contain at least one uppercase letter.');</script>";
                $insertionAllowed = false;
            } elseif (!preg_match('/[a-z]/', $password)) {
                echo "<script>alert('Password must contain at least one lowercase letter.');</script>";
                $insertionAllowed = false;
            } elseif (!preg_match('/[0-9]/', $password)) {
                echo "<script>alert('Password must contain at least one number.');</script>";
                $insertionAllowed = false;
            } 

            $query = "SELECT * FROM Faculty";
            $result = mysqli_query($connect, $query);

            while($row = mysqli_fetch_assoc($result))
            {
                if($updatedFacultyId != $currentFacultyId)
                {
                    if($updatedFacultyId != "" && $updatedFacultyId == $row['faculty_id'])
                    {
                        echo "<script>alert('Faculty ID is already existing.');</script>";
                        $insertionAllowed = false;
                        break;
                    }
                }
                else if($updatedContactNumber != $currentContactNumber)
                {
                    if($updatedContactNumber != "" && $updatedContactNumber == $row['contactNumber']) 
                    {
                        echo "<script>alert('Contact Number is already existing.');</script>";
                        $insertionAllowed = false;
                        break;
                    } 
                }
                else if($updatedEmail != $currentEmail) 
                {
                    if($updatedEmail != "" && $updatedEmail == $row['email']) 
                    {
                        echo "<script>alert('Email is already existing.');</script>";
                        $insertionAllowed = false;
                        break;
                    } 
                } 
            }

            if($insertionAllowed){
                if ($newImageName == '') {
                    $query = $connect->prepare("UPDATE Faculty SET faculty_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, email = ?, password = ? WHERE faculty_id = ?");
                    $query->bind_param("ssssssss", $updatedFacultyId, $firstName, $lastName, $gender, $updatedContactNumber, $updatedEmail, $password, $currentFacultyId);
                } else if ($newImageName == 'default-profile.png') {   
                    if ($old_image != 'default-profile.png') {
                        unlink('faculty-images/'.$old_image);
                    }
                    $query = $connect->prepare("UPDATE Faculty SET faculty_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, photo = ?, email = ?, password = ? WHERE faculty_id = ?");
                    $query->bind_param("sssssssss", $updatedFacultyId, $firstName, $lastName, $gender, $updatedContactNumber, $newImageName, $updatedEmail, $password, $currentFacultyId);
                } else {
                    $validImageExtension = ['jpg', 'jpeg', 'png'];
                    $imageExtension = explode(".", $newImageName);
                    $imageExtension = strtolower(end($imageExtension));
    
                    if (!in_array($imageExtension, $validImageExtension)) {
                        echo "<script>alert('Invalid image extension');</script>";
                    } else {
                        $updatedFacultyImage = uniqid() . '.' . $imageExtension;
                        move_uploaded_file($newImageTmpPath, 'faculty-images/' . $updatedFacultyImage);
    
                        if ($old_image != 'default-profile.png') {
                            unlink('faculty-images/'.$old_image);
                        }
    
                        $query = $connect->prepare("UPDATE Faculty SET faculty_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, photo = ?, email = ?, password = ? WHERE faculty_id = ?");
                        $query->bind_param("sssssssss", $updatedFacultyId, $firstName, $lastName, $gender, $updatedContactNumber, $updatedFacultyImage, $updatedEmail, $password, $currentFacultyId);
                    }
                }
    
                if ($query->execute()) {
                    echo "<script>alert('Faculty info updated successfully.');</script>";
                    echo "<script>window.location.href='listoffaculties.php'</script>";
                } else {
                    echo "<script>alert('Failed to update Faculty info.');</script>";
                    echo "<script>window.location.href='listoffaculties.php'</script>";
                }
            }       
        }   
    }
    
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateButtons = document.querySelectorAll('.btnUpdateFaculty');
            
            updateButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const facultyId = button.getAttribute('data-id');
                    const firstName = button.getAttribute('data-firstname');
                    const lastName = button.getAttribute('data-lastname');
                    const gender = button.getAttribute('data-gender');
                    const contactNumber = button.getAttribute('data-contactnumber');
                    const email = button.getAttribute('data-email');
                    const password = button.getAttribute('data-password');
                    const photo = button.getAttribute('data-photo');
                    
                    document.querySelector('#currentFacultyId').value = facultyId;
                    document.querySelector('#updateFacultyModal [name="txtFacultyId"]').value = facultyId;
                    document.querySelector('#updateFacultyModal [name="txtFirstName"]').value = firstName;
                    document.querySelector('#updateFacultyModal [name="txtLastName"]').value = lastName;
                    document.querySelector('#updateFacultyModal [name="rdoGender"][value="' + gender + '"]').checked = true;
                    document.querySelector('#currentContactNumber').value = contactNumber;
                    document.querySelector('#updateFacultyModal [name="txtContactNumber"]').value = contactNumber;
                    document.querySelector('#currentEmail').value = email;
                    document.querySelector('#updateFacultyModal [name="txtEmail"]').value = email;
                    document.querySelector('#updateFacultyModal [name="txtPassword"]').value = password;
                    document.querySelector('#updateFacultyModal img').src = 'faculty-images/' + photo;
                });
            });
        });
    </script>
                        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
