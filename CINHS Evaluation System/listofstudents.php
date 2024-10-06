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
    <title>CINHS Faculty Evaluation System</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        #nav-student{
            color: gray;
            pointer-events: none;
        }
        #txtSearchStudent{
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
<body id="listofstudents-body">
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
            <div class="listofstudents-con col-10 p-5">
                <form action="listofstudents.php" method="POST">
                    <h1 id="listofstudents-header">List of Students</h1>
                    <div class="row">
                        <div class="col-8">
                            <div class="searchBox input-group mb-3 w-50">
                                <input type="text" id="txtSearchStudent" name="txtSearchStudent" class="form-control" placeholder="Search/Filter" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="btnSearchStudent" name="btnSearchStudent"><i class="bi bi-search"></i></button>
                                <button class="btn btn-outline-secondary" type="submit" id="btnCancelSearch" name="btnCancelSearch"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <button type="button" name="btnDeleteAllStudents" class="btnDeleteAllStudents rounded-0 border border-0 btn btn-danger" 
                            style="
                            <?php 

                            $query = "SELECT status FROM evaluation_status";
                            $executeQuery = mysqli_query($connect, $query);
                            $result = mysqli_fetch_assoc($executeQuery);
                            $evaluationStatus = $result["status"];

                            $query = "SELECT * FROM student";
                            $executeQuery = mysqli_query($connect, $query);
                            $studentCount = mysqli_num_rows($executeQuery);

                            echo $evaluationStatus == 1 || $studentCount <= 0 ? 'pointer-events: none; background-color: gray;' : 'color: white'; 
                                                    
                            ?>">DELETE ALL</button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addStudentModal" name="addNewStudent" id="btnAddStudent" class="rounded-0 border border-0 btn btn-success" 
                            style="
                            <?php                             
                            
                            $query = "SELECT status FROM evaluation_status";
                            $executeQuery = mysqli_query($connect, $query);
                            $result = mysqli_fetch_assoc($executeQuery);
                            $status = $result["status"];

                            $query = "SELECT * FROM section";
                            $executeQuery = mysqli_query($connect, $query);
                            $sectionCount = mysqli_num_rows($executeQuery);
                            
                            echo $status != 0 || $sectionCount <= 0 ? 'pointer-events: none; background-color: gray;' : 'color: white;'  ?>">ADD A STUDENT</button>
                        </div>
                    </div>
                    <div class="text-start">
                        <?php 
                        
                        $query = $connect->prepare("SELECT* FROM Student");
                        $query->execute();
                        $result = $query->get_result();
                        $row = $result->num_rows;
                        
                        ?>
                        <span>Student count: <?php echo $row ?></span>
                    </div>
                    <table class="tblStudents table table-striped table-group-divider border border-2">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Grade Level</th>
                            <th>Section</th>
                            <th>Photo</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Operations</th>
                        </tr>
                        <?php

                        include_once 'connect.php';
                        include_once 'delete-process.php';
                        
                        if(isset($_POST["btnSearchStudent"])){    
                            $search = mysqli_real_escape_string($connect, $_POST["txtSearchStudent"]);
                            if($search == ""){                                                                                
                        ?>
                                <h1>NO RESULT FOUND</h1>
                        <?php
                            }
                            else{
                                $query = "SELECT * FROM Student WHERE student_id LIKE '%$search%' OR firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR gender LIKE '%$search%' OR address LIKE '%$search%' OR contactNumber LIKE '%$search%' OR gradeLevel LIKE '%$search%' OR sectionName LIKE '%$search%' OR email LIKE '%$search%' OR password LIKE '%$search%'";
                                $executeQuery = mysqli_query($connect, $query);
                                $result = mysqli_num_rows($executeQuery);
            
                                if($result > 0){
                                    while($row = mysqli_fetch_assoc($executeQuery)){                         
                        ?>
                                        <tr>
                                            <tr>
                                                <td><?php echo $row['student_id']; ?></td>
                                                <td><?php echo $row['firstName']; ?></td>
                                                <td><?php echo $row['lastName']; ?></td>
                                                <td><?php echo $row['gender']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['contactNumber']; ?></td>
                                                <td><?php echo $row['gradeLevel']; ?></td>
                                                <td><?php echo $row['sectionName']; ?></td>
                                                <td>
                                                    <img src='<?php echo "student-images/".$row['photo']; ?>' height='40px'>
                                                </td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['password']; ?></td>
                                                <td>
                                                    <a class='btnUpdateStudent text-light' href="#" data-id="<?php echo $row['student_id']; ?>" data-firstname="<?php echo $row['firstName']; ?>" data-lastname="<?php echo $row['lastName']; ?>" data-gender="<?php echo $row['gender']; ?>" data-address="<?php echo $row['address']; ?>" data-contactnumber="<?php echo $row['contactNumber']; ?>"  data-gradeLevel="<?php echo $row['gradeLevel']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-photo="<?php echo $row['photo']; ?>" data-email="<?php echo $row['email']; ?>" data-password="<?php echo $row['password']; ?>" data-bs-toggle="modal" data-bs-target="#updateStudentModal" style="
                                                    <?php                             
                                                    
                                                    $query = "SELECT status FROM evaluation_status";
                                                    $executeQuery = mysqli_query($connect, $query);
                                                    $result = mysqli_fetch_assoc($executeQuery);
                                                    $status = $result["status"];
                                                    
                                                    echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">UPDATE</a>
                                                    <a class='btnDeleteStudent text-light' href="#" data-id="<?php echo $row['student_id']; ?>" 
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
                            $query = "SELECT * FROM Student";
                            $fetch_data = mysqli_query($connect, $query);

                            if(mysqli_num_rows($fetch_data) > 0)
                            {

                                foreach($fetch_data as $row)
                                {
                        ?>          
                                    <tr>
                                        <td><?php echo $row['student_id']; ?></td>
                                        <td><?php echo $row['firstName']; ?></td>
                                        <td><?php echo $row['lastName']; ?></td>
                                        <td><?php echo $row['gender']; ?></td>
                                        <td><?php echo $row['address']; ?></td>
                                        <td><?php echo $row['contactNumber']; ?></td>
                                        <td><?php echo $row['gradeLevel']; ?></td>
                                        <td><?php echo $row['sectionName']; ?></td>
                                        <td>
                                            <img src='<?php echo "student-images/".$row['photo']; ?>' height='40px'>
                                        </td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['password']; ?></td>
                                        <td>
                                            <a class='btnUpdateStudent text-light' href="#" data-id="<?php echo $row['student_id']; ?>" data-firstname="<?php echo $row['firstName']; ?>" data-lastname="<?php echo $row['lastName']; ?>" data-gender="<?php echo $row['gender']; ?>" data-address="<?php echo $row['address']; ?>" data-contactnumber="<?php echo $row['contactNumber']; ?>"  data-gradeLevel="<?php echo $row['gradeLevel']; ?>" data-sectionName="<?php echo $row['sectionName']; ?>" data-photo="<?php echo $row['photo']; ?>" data-email="<?php echo $row['email']; ?>" data-password="<?php echo $row['password']; ?>" data-bs-toggle="modal" data-bs-target="#updateStudentModal" 
                                            style="
                                            <?php                             
                                            
                                            $query = "SELECT status FROM evaluation_status";
                                            $executeQuery = mysqli_query($connect, $query);
                                            $result = mysqli_fetch_assoc($executeQuery);
                                            $status = $result["status"];
                                            
                                            echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;'  ?>">UPDATE</a>
                                            <a class='btnDeleteStudent text-light' href="#" data-id="<?php echo $row['student_id']; ?>" 
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
                        }       

                        ?>      

                        <!-- Add jQuery for AJAX support -->
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        
                        <script>
                            // Event delegation: Attach event listener to the document but limit the scope to .btnDeleteAdmin elements
                            document.addEventListener('DOMContentLoaded', () => {
                                document.addEventListener('click', function(e) {
                                    if (e.target && e.target.classList.contains('btnDeleteStudent')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let student_id = e.target.getAttribute('data-id');  // Get the admin ID from the data attribute
                                        let deleteStudent = confirm("Are you sure you want to delete this Student?");
                        
                                        if (deleteStudent == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnDeleteStudent: true,
                                                        student_id: student_id 
                                                    },
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("Student deleted successfully.");
                                                        window.location.href = 'listofstudents.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to delete Student.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Deletion of Student is cancelled.");
                                        }
                                    } else if (e.target && e.target.classList.contains('btnDeleteAllStudents')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let deleteAllStudents = confirm("Are you sure you want to delete all the Students?");
                        
                                        if (deleteAllStudents == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { btnDeleteAllStudents: true },  // Send the key to match in PHP
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("All Students are deleted successfully.");
                                                        window.location.href = 'listofstudents.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to delete all Students.");
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

    <!-- Modal for Adding Student-->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Adding a Student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <form action="listofstudents.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="addstudent-photo-con mb-3">
                                    <img src='student-images/default-profile.png' height='150px'> <br> <br>
                                    <h6 class="text-start">Profile</h6>
                                    <div class="input-group">     
                                        <input type="file" id="inputGroupFile02" class="form-control" name="studentImage" accept=".jpg, .jpeg, .png">	
                                    </div>                        
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="text-start">ID<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3 w-50">    
                                    <input type="text" class="addstudent-studentid form-control" placeholder="ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtStudentId" autocomplete="off" required>             
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">First Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">    
                                    <input type="text" class="addstudent-firstname form-control" placeholder="First Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFirstName" autocomplete="new-firstname" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">Last Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="addstudent-lastname form-control" placeholder="Last Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtLastName" autocomplete="new-lastname" required>
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
                                            <input type="text" class="addstudent-contactnumber form-control" placeholder="Contact Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtContactNumber" autocomplete="new-contact">
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-6">
                                        <div class="addstudent-gradeLevel-con">
                                            <label for="gradeLevel" class="addstudent-label">Grade Level: </label><span style="color: red"> *</span>
                                            <select name="gradeLevel" id="gradeLevel">
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="addstudent-section-con">
                                            <label for="section" class="addstudent-label">Section: </label><span style="color: red"> *</span>
                                            <select name="section" id="section">
                                                <!-- Section options will be populated by AJAX -->
                                                <script>
                                                    $(document).ready(function() {
                                                        // Function to load sections based on the selected grade level
                                                        function loadSectionsForAddStudent(gradeLevel) {
                                                            $.ajax({
                                                                url: 'fetchSections.php',          // PHP script to fetch sections
                                                                type: 'POST',                      // Send data as POST
                                                                data: { gradeLevel: gradeLevel },  // Send the selected grade level
                                                                success: function(data) {
                                                                    $('#section').html(data);    // Populate the section dropdown
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    console.log('AJAX error: ' + error);  // Log errors
                                                                }
                                                            });
                                                        }

                                                        // When the modal opens, load sections based on the current grade level
                                                        $('#addStudentModal').on('shown.bs.modal', function () {
                                                            var gradeLevel = $('#gradeLevel').val();  // Get selected grade level
                                                            loadSectionsForAddStudent(gradeLevel);  // Load sections when modal is shown
                                                        });

                                                        // Optionally, you can also handle changes in the grade level
                                                        $('#gradeLevel').change(function() {
                                                            var gradeLevel = $(this).val();
                                                            loadSectionsForAddStudent(gradeLevel);  // Load sections when grade level changes
                                                        });
                                                    });
                                                </script>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-start">Address (Optional)</h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="updatestudent-address form-control" placeholder="Address" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtAddress" autocomplete="new-address">
                                </div>
                                <h6 class="text-start mt-4">Email (Optional)</h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="addstudent-email form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtEmail" autocomplete="new-email">
                                </div>
                                <h6 class="text-start">Password<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input  id="txtPasswordAddUser" type="password" class="updatestudent-password form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtPassword" autocomplete="off" required>
                                    <button id="btnShowPasswordAddUser" type="button" onclick="showPasswordForAddingUser(this)">SHOW</button>	
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" name="btnAddStudent">Add</button>
                            </div>
                        </div>             
                    </form> 
                </div>
            </div>
        </div>
    </div>
    <?php

    /* For Adding Student */
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (isset($_POST["btnAddStudent"])) 
        {
            // Variables for adding Student
            $student_id = $_POST["txtStudentId"];
            $firstName = $_POST["txtFirstName"];
            $lastName = $_POST["txtLastName"];
            $gender = $_POST["rdoGender"];
            $address = $_POST["txtAddress"];
            $contactNumber = $_POST["txtContactNumber"];  
            $gradeLevel = $_POST["gradeLevel"];
            $sectionName = $_POST["section"];  

            $query = "SELECT section_id FROM Section WHERE sectionName = '$sectionName'";

            $executeQuery = mysqli_query($connect, $query);
            $result = mysqli_fetch_assoc($executeQuery);
            $section_id = $result["section_id"];

            $status = "Student";
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
            $query = "SELECT * FROM Student";
            $result = mysqli_query($connect, $query);

            while($row = mysqli_fetch_assoc($result))
            {
                if($student_id == $row['student_id']) {
                    echo "<script>alert('Student ID is already existing.');</script>";
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
                if($_FILES['studentImage']['error'] === 4)
                {
                    $defaultStudentImage = 'default-profile.png'; 

                    $stmt = $connect->prepare("INSERT INTO Student (student_id, firstName, lastName, gender, address, contactNumber, gradeLevel, section_id, sectionName, status, photo, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('sssssssssssss', $student_id, $firstName, $lastName, $gender, $address, $contactNumber, $gradeLevel, $section_id, $sectionName, $status, $defaultStudentImage, $email, $password);
                    $newStudent = $stmt->execute();
                }
                else
                {
                    $imageName = $_FILES['studentImage']['name'];
                    $imageSize = $_FILES['studentImage']['size'];
                    $imageTmpPath = $_FILES['studentImage']['tmp_name'];

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

                        move_uploaded_file($imageTmpPath, 'studen-images/' . $newImageName);

                        $stmt = $connect->prepare("INSERT INTO Student (studen_id, firstName, lastName, gender, address, contactNumber, gradeLevel, section_id, sectionName,status, photo, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param('sssssssssssss', $student_id, $firstName, $lastName, $gender, $address, $contactNumber, $gradeLevel, $section_id, $sectionName, $status, $newImageName, $email, $password);
                        $newStudent = $stmt->execute();
                    }
                }  

                if($newStudent) {
                    echo "<script>alert('New student added successfully.');</script>";
                    echo "<script>window.location.href='listofstudents.php';</script>";
                } else {
                    echo "<script>alert('Failed to add new student.');</script>";
                    echo "<script>window.location.href='listofstudents.php';</script>";
                }
            }
        }
    }
   
    ?>

    <!-- Modal for Updating Student -->
    <div class="modal fade" id="updateStudentModal" tabindex="-1" aria-labelledby="updateStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Updating a Student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <form action="listofstudents.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="updatestudent-photo-con mb-3">
                                    <img src='<?php echo 'student-images/' . $row['photo']?>' height='150px'> <br> <br>
                                    <h6 class="text-start">Profile</h6>
                                    <div class="input-group">     
                                        <input type="file" id="inputGroupFile02" class="form-control" name="studentImage" accept=".jpg, .jpeg, .png">	
                                    </div>
                                    <input type='hidden' name='old-image' value='<?php echo $row['photo']; ?>'>                          
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="text-start">ID<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3 w-50">   
                                    <input type="hidden" name="currentStudentId" id="currentStudentId"> <!-- Hidden field for current student ID -->
                                    <input type="text" class="updatestudent-studentid form-control" placeholder="ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtStudentId" autocomplete="off" required>          
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">First Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">    
                                    <input type="text" class="updatestudent-firstname form-control" placeholder="First Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFirstName" autocomplete="new-firstname" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">Last Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="updatestudent-lastname form-control" placeholder="Last Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtLastName" autocomplete="new-lastname" required>
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
                                            <input type="text" class="updatestudent-contactnumber form-control" placeholder="Contact Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtContactNumber" autocomplete="new-contact">
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-6">
                                        <div class="updatestudent-gradeLevel-con">
                                            <label for="updateGradeLevel" class="addstudent-label">Grade Level: </label><span style="color: red"> *</span>
                                            <select name="gradeLevel" id="updateGradeLevel">
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="updatestudent-section-con">
                                            <label for="updateSection" class="addstudent-label">Section: </label><span style="color: red"> *</span>
                                            <select name="section" id="updateSection">
                                                <script>
                                                    $(document).ready(function() {
                                                        // Function to load sections based on the selected grade level for updating a student
                                                        function loadSectionsForUpdateStudent(gradeLevel) {
                                                            $.ajax({
                                                                url: 'fetchSections.php',           // PHP script to fetch sections
                                                                type: 'POST',                       // Send data as POST
                                                                data: { gradeLevel: gradeLevel },   // Send the selected grade level
                                                                success: function(data) {
                                                                    $('#updateSection').html(data); // Populate the section dropdown in update modal
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    console.log('AJAX error: ' + error); // Log errors
                                                                }
                                                            });
                                                        }

                                                        // When the update modal opens, load sections based on the current grade level
                                                        $('#updateStudentModal').on('shown.bs.modal', function () {
                                                            var gradeLevel = $('#updateGradeLevel').val();  // Get selected grade level
                                                            loadSectionsForUpdateStudent(gradeLevel);       // Load sections when modal is shown
                                                        });

                                                        // Handle changes in the grade level for update modal
                                                        $('#updateGradeLevel').change(function() {
                                                            var gradeLevel = $(this).val();
                                                            loadSectionsForUpdateStudent(gradeLevel);       // Load sections when grade level changes
                                                        });
                                                    });
                                                </script>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-start">Address (Optional)</h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="updatestudent-address form-control" placeholder="Address" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtAddress" autocomplete="new-address">
                                </div>
                                <h6 class="text-start mt-4">Email (Optional)</h6>
                                <div class="input-group mb-3">
                                    <input type="hidden" name="currentEmail" id="currentEmail"> <!-- Hidden field for current email -->
                                    <input type="text" class="updatestudent-email form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtEmail" autocomplete="new-email">
                                </div>
                                <h6 class="text-start">Password<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input id="txtPasswordUpdateUser" type="password" class="updatestudent-password form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtPassword" autocomplete="off" required>
                                    <button id="btnShowPasswordUpdateUser" type="button" onclick="showPasswordForUpdatingUser(this)">SHOW</button>	
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-info" name="btnUpdateStudent">Update</button>
                            </div>
                        </div>             
                    </form> 
                </div>
            </div>
        </div>
    </div> 
    <?php

    /* For Updating Student */
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["btnUpdateStudent"]) && isset($_POST["currentStudentId"])) {
            $currentStudentId = $_POST["currentStudentId"];
            $updatedStudentId = $_POST["txtStudentId"];
            $firstName = $_POST["txtFirstName"];
            $lastName = $_POST["txtLastName"];
            $gender = $_POST["rdoGender"];
            $gender = $_POST["rdoGender"];
            $address = $_POST["txtAddress"];
            $currentContactNumber = $_POST["currentContactNumber"];
            $updatedContactNumber = $_POST["txtContactNumber"];
            $gradeLevel = $_POST["gradeLevel"];
            $sectionName = $_POST["section"];  

            $query = "SELECT section_id FROM Section WHERE sectionName = '$sectionName'";

            $executeQuery = mysqli_query($connect, $query);
            $result = mysqli_fetch_assoc($executeQuery);
            $section_id = $result["section_id"];

            $currentEmail = $_POST["currentEmail"];
            $updatedEmail = $_POST["txtEmail"];
            $password = $_POST["txtPassword"];
            $newImageName = $_FILES['studentImage']['name'];
            $newImageSize = $_FILES['studentImage']['tmp_name'];
            $newImageTmpPath = $_FILES['studentImage']['tmp_name'];
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

            $query = "SELECT * FROM Student";
            $result = mysqli_query($connect, $query);

            while($row = mysqli_fetch_assoc($result))
            {
                if($updatedStudentId != $currentStudentId)
                {
                    if($updatedStudentId != "" && $updatedStudentId == $row['student_id'])
                    {
                        echo "<script>alert('Student ID is already existing.');</script>";
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
                    $query = $connect->prepare("UPDATE Student SET student_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, gradeLevel = ?, section_id = ?, sectionName = ?, email = ?, password = ? WHERE student_id = ?");
                    $query->bind_param("sssssssssss", $updatedStudentId, $firstName, $lastName, $gender, $updatedContactNumber, $gradeLevel, $section_id, $sectionName, $updatedEmail, $password, $currentStudentId);
                } else if ($newImageName == 'default-profile.png') {   
                    if ($old_image != 'default-profile.png') {
                        unlink('student-images/'.$old_image);
                    }
                    $query = $connect->prepare("UPDATE Student SET student_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, gradeLevel = ?, section_id = ?, sectionName = ?, photo = ?, email = ?, password = ? WHERE student_id = ?");
                    $query->bind_param("ssssssssssss", $updatedStudentId, $firstName, $lastName, $gender, $updatedContactNumber, $gradeLevel, $section_id, $sectionName, $newImageName, $updatedEmail, $password, $currentStudentId);
                } else {
                    $validImageExtension = ['jpg', 'jpeg', 'png'];
                    $imageExtension = explode(".", $newImageName);
                    $imageExtension = strtolower(end($imageExtension));
    
                    if (!in_array($imageExtension, $validImageExtension)) {
                        echo "<script>alert('Invalid image extension');</script>";
                    } else {
                        $updatedStudentImage = uniqid() . '.' . $imageExtension;
                        move_uploaded_file($newImageTmpPath, 'student-images/' . $updatedStudentImage);
    
                        if ($old_image != 'default-profile.png') {
                            unlink('student-images/'.$old_image);
                        }
    
                        $query = $connect->prepare("UPDATE Student SET student_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, gradeLevel = ?, section_id = ?, sectionName = ?, photo = ?, email = ?, password = ? WHERE student_id = ?");
                        $query->bind_param("ssssssssssss", $updatedStudentId, $firstName, $lastName, $gender, $updatedContactNumber, $gradeLevel, $section_id, $sectionName, $updatedStudentImage, $updatedEmail, $password, $currentStudentId);
                    }
                }
    
                if ($query->execute()) {
                    echo "<script>alert('Student info updated successfully.');</script>";
                    echo "<script>window.location.href='listofstudents.php'</script>";
                } else {
                    echo "<script>alert('Failed to update Student info.');</script>";
                    echo "<script>window.location.href='listofstudents.php'</script>";
                }
            }       
        }   
    }
    
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const updateButtons = document.querySelectorAll('.btnUpdateStudent');
        
        updateButtons.forEach(button => {
            button.addEventListener('click', () => {
                const studentId = button.getAttribute('data-id');
                const firstName = button.getAttribute('data-firstname');
                const lastName = button.getAttribute('data-lastname');
                const gender = button.getAttribute('data-gender');
                const address = button.getAttribute('data-address');
                const contactNumber = button.getAttribute('data-contactnumber');
                const gradeLevel = button.getAttribute('data-gradeLevel');
                const sectionName = button.getAttribute('data-sectionName');
                const email = button.getAttribute('data-email');
                const password = button.getAttribute('data-password');
                const photo = button.getAttribute('data-photo');
                
                // Set all the student details into the form
                document.querySelector('#currentStudentId').value = studentId;
                document.querySelector('#updateStudentModal [name="txtStudentId"]').value = studentId;
                document.querySelector('#updateStudentModal [name="txtFirstName"]').value = firstName;
                document.querySelector('#updateStudentModal [name="txtLastName"]').value = lastName;
                document.querySelector('#updateStudentModal [name="rdoGender"][value="' + gender + '"]').checked = true;
                document.querySelector('#updateStudentModal [name="txtAddress"]').value = address;
                document.querySelector('#currentContactNumber').value = contactNumber;
                document.querySelector('#updateStudentModal [name="txtContactNumber"]').value = contactNumber;
                document.querySelector('#updateStudentModal [name="gradeLevel"]').value = gradeLevel;
                document.querySelector('#currentEmail').value = email;
                document.querySelector('#updateStudentModal [name="txtEmail"]').value = email;
                document.querySelector('#updateStudentModal [name="txtPassword"]').value = password;
                document.querySelector('#updateStudentModal img').src = 'student-images/' + photo;

                // After setting the grade level, load the sections
                loadSectionsForUpdateStudent(gradeLevel);  // Manually trigger the AJAX call to fetch sections

                // Set the section after it is populated
                setTimeout(() => {
                    document.querySelector('#updateStudentModal [name="section"]').value = sectionName;
                }, 100);  // Delay to ensure section options are loaded
            });
        });
        
        // AJAX function to load sections based on the selected grade level for updating student
        function loadSectionsForUpdateStudent(gradeLevel) {
            $.ajax({
                url: 'fetchSections.php',          // PHP script to fetch sections
                type: 'POST',                      // Send data as POST
                data: { gradeLevel: gradeLevel },  // Send the selected grade level
                success: function(data) {
                    $('#updateStudentModal #section').html(data);  // Populate the section dropdown
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
