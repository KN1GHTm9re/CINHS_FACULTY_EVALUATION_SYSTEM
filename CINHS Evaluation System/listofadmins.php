<?php

session_start();

include "connect.php";

$user_id = $_SESSION["user_id"];

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
        #nav-admin{
            color: gray;
            pointer-events: none;
        }
        #txtSearchAdmin{
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
<body id="listofadmins-body">
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
            <div class="listofadmins-con col-10 p-5">
                <form action="listofadmins.php" method="POST">
                    <h1 id="listofadmins-header">List of Admins</h1>
                    <div class="row">
                        <div class="col-8">
                            <div class="searchBox input-group mb-3 w-50">
                                <input type="text" id="txtSearchAdmin" name="txtSearchAdmin" class="form-control" placeholder="Search/Filter" aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="btnSearchAdmin" name="btnSearchAdmin"><i class="bi bi-search"></i></button>
                                <button class="btn btn-outline-secondary" type="submit" id="btnCancelSearch" name="btnCancelSearch"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#addAdminModal" name="addNewStudent" id="btnAddStudent" class="rounded-0 border border-0 btn btn-success"             
                            style="
                            <?php 

                            $query = "SELECT status FROM evaluation_status";
                            $executeQuery = mysqli_query($connect, $query);
                            $result = mysqli_fetch_assoc($executeQuery);
                            $evaluationStatus = $result["status"];
                            
                            echo $evaluationStatus == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;' 
                            
                            
                            ?>">ADD AN ADMIN</button>
                         </div>
                    </div>
                    <div class="text-start">
                        <?php 
                        
                        $query = $connect->prepare("SELECT* FROM Admin");
                        $query->execute();
                        $result = $query->get_result();
                        $row = $result->num_rows;
                        
                        ?>
                        <span>Admin count: <?php echo $row ?></span>
                    </div>
                    <table class="tblAdmins table table-striped table-group-divider border border-2">
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
                        
                        if(isset($_POST["btnSearchAdmin"])){
                            $search = mysqli_real_escape_string($connect, $_POST["txtSearchAdmin"]);
                            if($search == ""){
                        ?>
                                <h1>NO RESULT FOUND</h1>
                        <?php
                            }
                            else{
                                $query = "SELECT * FROM Admin WHERE admin_id LIKE '%$search%' OR firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR gender LIKE '%$search%' OR contactNumber LIKE '%$search%' OR email LIKE '%$search%' OR password LIKE '%$search%'";
                                $executeQuery = mysqli_query($connect, $query);
                                $result = mysqli_num_rows($executeQuery);
            
                                if($result > 0){
                                    while($row = mysqli_fetch_assoc($executeQuery)){   
                                        if($user_id != $row["admin_id"]){                      
                            ?>
                                        <tr>
                                            <tr>
                                                <td><?php echo $row['admin_id']; ?></td>
                                                <td><?php echo $row['firstName']; ?></td>
                                                <td><?php echo $row['lastName']; ?></td>
                                                <td><?php echo $row['gender']; ?></td>
                                                <td><?php echo $row['contactNumber']; ?></td>
                                                <td>
                                                    <img src='<?php echo "admin-images/".$row['photo']; ?>' height='40px'>
                                                </td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['password']; ?></td>
                                                <!-- <td>
                                                    <a class='btnUpdateAdmin' href="#" data-id="<?php echo $row['admin_id']; ?>" data-firstname="<?php echo $row['firstName']; ?>" data-lastname="<?php echo $row['lastName']; ?>" data-gender="<?php echo $row['gender']; ?>" data-contactnumber="<?php echo $row['contactNumber']; ?>" data-email="<?php echo $row['email']; ?>" data-password="<?php echo $row['password']; ?>" data-photo="<?php echo $row['photo']; ?>" data-bs-toggle="modal" data-bs-target="#updateAdminModal"                             
                                                    style="
                                                    <?php 

                                                    $query = "SELECT status FROM evaluation_status";
                                                    $executeQuery = mysqli_query($connect, $query);
                                                    $result = mysqli_fetch_assoc($executeQuery);
                                                    $status = $result["status"];
                                                    
                                                    echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;' 
                                                    
                                                    
                                                    ?>">UPDATE</a>
                                                    <a class='btnDeleteAdmin' href="#" data-id="<?php echo $row['admin_id']; ?>" 
                                                    style="
                                                    <?php 

                                                    $query = "SELECT status FROM evaluation_status";
                                                    $executeQuery = mysqli_query($connect, $query);
                                                    $result = mysqli_fetch_assoc($executeQuery);
                                                    $status = $result["status"];

                                                    echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;' 
                                                    
                                                    
                                                    ?>">DELETE</a>
                                                </td> -->
                                            </tr>
                                        </tr>
                            <?php
                                        }
                                        else{
                            ?>
                                            <h1>NO RESULT FOUND</h1>
                            <?php
                                        }
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
                            $query = "SELECT * FROM Admin";
                            $fetch_data = mysqli_query($connect, $query);
                        
                            if (mysqli_num_rows($fetch_data) > 0) {
                                foreach ($fetch_data as $row) {
                                    if($user_id != $row["admin_id"]){
                        ?>
                                    <tr>
                                        <td><?php echo $row['admin_id']; ?></td>
                                        <td><?php echo $row['firstName']; ?></td>
                                        <td><?php echo $row['lastName']; ?></td>
                                        <td><?php echo $row['gender']; ?></td>
                                        <td><?php echo $row['contactNumber']; ?></td>
                                        <td>
                                            <img src='<?php echo "admin-images/" . $row['photo']; ?>' height='40px'>
                                        </td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['password']; ?></td>
                                        <td>
                                            <a class='btnUpdateAdmin text-light' href="#" data-id="<?php echo $row['admin_id']; ?>" data-firstname="<?php echo $row['firstName']; ?>" data-lastname="<?php echo $row['lastName']; ?>" data-gender="<?php echo $row['gender']; ?>" data-contactnumber="<?php echo $row['contactNumber']; ?>" data-email="<?php echo $row['email']; ?>" data-password="<?php echo $row['password']; ?>" data-photo="<?php echo $row['photo']; ?>" data-bs-toggle="modal" data-bs-target="#updateAdminModal" 
                                            style="
                                            <?php 

                                            $query = "SELECT status FROM evaluation_status";
                                            $executeQuery = mysqli_query($connect, $query);
                                            $result = mysqli_fetch_assoc($executeQuery);
                                            $status = $result["status"];
                                            
                                            echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;' 
                                            
                                            
                                            ?>">UPDATE</a>
                                            <a class='btnDeleteAdmin text-light' href="#" data-photo="<?php echo $row["photo"] ?>" data-id="<?php echo $row['admin_id']; ?>" 
                                            style="
                                            <?php 

                                            $query = "SELECT status FROM evaluation_status";
                                            $executeQuery = mysqli_query($connect, $query);
                                            $result = mysqli_fetch_assoc($executeQuery);
                                            $status = $result["status"];

                                            echo $status == 0 ? 'color: white;' : 'pointer-events: none; background-color: gray;' 
                                            
                                            
                                            ?>">DELETE</a>
                                        </td>
                                    </tr>
                        <?php
                                                           
                                    }
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
                                    if (e.target && e.target.classList.contains('btnDeleteAdmin')) {
                                        e.preventDefault();  // Prevent default link behavior
                        
                                        let admin_id = e.target.getAttribute('data-id');  // Get the admin ID from the data attribute
                                        // let admin_photo = e.target.getAttribute('data-photo');  // Get the admin ID from the data attribute
                                        let deleteAdmin = confirm("Are you sure you want to delete this Admin?");
                        
                                        if (deleteAdmin == true) {
                                            // Perform the deletion via AJAX
                                            $.ajax({
                                                url: 'delete-process.php',  // Create this PHP file to handle deletion
                                                type: 'POST',
                                                data: { 
                                                    btnDeleteAdmin : true,
                                                    admin_id: admin_id
                                                },
                                                success: function(response) {
                                                    if (response == 'success') {
                                                        alert("Admin deleted successfully.");
                                                        window.location.href = 'listofadmins.php';  // Reload page to reflect changes
                                                    } else {
                                                        alert("Failed to delete Admin.");
                                                    }
                                                }
                                            });
                                        } else {
                                            alert("Deletion of Admin is cancelled.");
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
    
    <!-- Modal for Adding Admin -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Adding an Admin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <form action="listofadmins.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="addadmin-photo-con mb-3">
                                    <img src='admin-images/default-profile.png' height='150px'> <br> <br>
                                    <h6 class="text-start">Profile</h6>
                                    <div class="input-group">     
                                        <input type="file" id="inputGroupFile02" class="form-control" name="adminImage" accept=".jpg, .jpeg, .png">	
                                    </div>                    
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="text-start">ID<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3 w-50">    
                                    <input type="text" class="addadmin-adminid form-control" placeholder="ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtAdminId" autocomplete="off" required> 
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">First Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">    
                                    <input type="text" class="addadmin-firstname form-control" placeholder="First Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFirstName" autocomplete="new-firstname" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">Last Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="addadmin-lastname form-control" placeholder="Last Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtLastName" autocomplete="new-lastname" required>
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
                                            <input type="text" class="addadmin-contactnumber form-control" placeholder="Contact Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtContactNumber" autocomplete="new-contact">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-start">Email (Optional)</h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="addadmin-email form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtEmail" autocomplete="new-email">
                                </div>
                                <h6 class="text-start">Password<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input  id="txtPasswordAddUser" type="password" class="addadmin-password form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtPassword" autocomplete="off" required>
                                    <button id="btnShowPasswordAddUser" type="button" onclick="showPasswordForAddingUser(this)">SHOW</button>	
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" name="btnAddAdmin">Add</button>
                            </div>
                        </div>             
                    </form> 
                </div>
            </div>
        </div>
    </div>
    <?php

    /* For Adding Admin */
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        if (isset($_POST["btnAddAdmin"])) 
        {
            // Variables for adding admin
            $admin_id = $_POST["txtAdminId"];
            $firstName = $_POST["txtFirstName"];
            $lastName = $_POST["txtLastName"];
            $gender = $_POST["rdoGender"];
            $contactNumber = $_POST["txtContactNumber"];    
            $status = "Admin";
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
            $query = "SELECT * FROM Admin";
            $result = mysqli_query($connect, $query);

            while($row = mysqli_fetch_assoc($result))
            {
                if($admin_id == $row['admin_id']) {
                    echo "<script>alert('Admin ID is already existing.');</script>";
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
                if($_FILES['adminImage']['error'] === 4)
                {
                    $defaultAdminImage = 'default-profile.png'; 

                    $stmt = $connect->prepare("INSERT INTO Admin (admin_id, firstName, lastName, gender, contactNumber, status, photo, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param('sssssssss', $admin_id, $firstName, $lastName, $gender, $contactNumber, $status, $defaultAdminImage, $email, $password);
                    $newAdmin = $stmt->execute();
                }
                else
                {
                    $imageName = $_FILES['adminImage']['name'];
                    $imageSize = $_FILES['adminImage']['size'];
                    $imageTmpPath = $_FILES['adminImage']['tmp_name'];

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

                        move_uploaded_file($imageTmpPath, 'admin-images/' . $newImageName);

                        $stmt = $connect->prepare("INSERT INTO Admin (admin_id, firstName, lastName, gender, contactNumber, status, photo, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param('sssssssss', $admin_id, $firstName, $lastName, $gender, $contactNumber, $status, $newImageName, $email, $password);
                        $newAdmin = $stmt->execute();
                    }
                }  

                if($newAdmin) {
                    echo "<script>alert('New admin added successfully.');</script>";
                    echo "<script>window.location.href='listofadmins.php';</script>";
                } else {
                    echo "<script>alert('Failed to add new admin.');</script>";
                    echo "<script>window.location.href='listofadmins.php';</script>";
                }
            }
        }
    }

    ?>

    <!-- Modal for Updating Admin-->
    <div class="modal fade" id="updateAdminModal" tabindex="-1" aria-labelledby="updateAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Updating an Admin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <form action="listofadmins.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="updateadmin-photo-con mb-3">
                                    <img src='<?php echo 'admin-images/' . $row['photo']?>' height='150px'> <br> <br>
                                    <h6 class="text-start">Profile</h6>
                                    <div class="input-group">     
                                        <input type="file" id="inputGroupFile02" class="form-control" name="adminImage" accept=".jpg, .jpeg, .png">	
                                    </div>
                                    <input type='hidden' name='old-image' value='<?php echo $row['photo']; ?>'>                          
                                </div>
                            </div>
                            <div class="col-12">
                                <h6 class="text-start">ID<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3 w-50">   
                                    <input type="hidden" name="currentAdminId" id="currentAdminId"> <!-- Hidden field for current admin ID -->
                                    <input type="text" class="updateadmin-adminid form-control" placeholder="ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtAdminId" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">First Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">    
                                    <input type="text" class="updateadmin-firstname form-control" placeholder="First Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtFirstName" autocomplete="new-firstname" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <h6 class="text-start">Last Name<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input type="text" class="updateadmin-lastname form-control" placeholder="Last Name" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtLastName" autocomplete="new-lastname" required>
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
                                            <input type="hidden" name="currentContactNumber" id="currentContactNumber"> <!-- Hidden field for current Contact Number -->
                                            <input type="text" class="updateadmin-contactnumber form-control" placeholder="Contact Number" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtContactNumber" autocomplete="new-contact">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-start">Email (Optional)</h6>
                                <div class="input-group mb-3">
                                    <input type="hidden" name="currentEmail" id="currentEmail"> <!-- Hidden field for current Email -->
                                    <input type="text" class="updateadmin-email form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtEmail" autocomplete="new-email">
                                </div>
                                <h6 class="text-start">Password<span style="color: red;"> *<span></h6>
                                <div class="input-group mb-3">
                                    <input id="txtPasswordUpdateUser" type="password" class="updateadmin-password form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="button-addon2" name="txtPassword" autocomplete="off" required>
                                    <button id="btnShowPasswordUpdateUser" type="button" onclick="showPasswordForUpdatingUser(this)">SHOW</button>	
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-info" name="btnUpdateAdmin">Update</button>
                            </div>
                        </div>             
                    </form> 
                </div>
            </div>
        </div>
    </div> 
    <?php

    /* For Updating Admin */
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["btnUpdateAdmin"]) && isset($_POST["currentAdminId"])) {
            $currentAdminId = $_POST["currentAdminId"];
            $updatedAdminId = $_POST["txtAdminId"];
            $firstName = $_POST["txtFirstName"];
            $lastName = $_POST["txtLastName"];
            $gender = $_POST["rdoGender"];
            $currentContactNumber = $_POST["currentContactNumber"];
            $updatedContactNumber = $_POST["txtContactNumber"];
            $currentEmail = $_POST["currentEmail"];
            $updatedEmail = $_POST["txtEmail"];
            $password = $_POST["txtPassword"];
            $newImageName = $_FILES['adminImage']['name'];
            $newImageSize = $_FILES['adminImage']['tmp_name'];
            $newImageTmpPath = $_FILES['adminImage']['tmp_name'];
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

            $query = "SELECT * FROM Admin";
            $result = mysqli_query($connect, $query);

            while($row = mysqli_fetch_assoc($result))
            {
                if($updatedAdminId != $currentAdminId)
                {
                    if($updatedAdminId != "" && $updatedAdminId == $row['admin_id'])
                    {
                        echo "<script>alert('Admin ID is already existing.');</script>";
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
                    $query = $connect->prepare("UPDATE Admin SET admin_id = ?, firstName = ?, lastName = ?,  gender = ?, contactNumber = ?, email = ?, password = ? WHERE admin_id = ?");
                    $query->bind_param("ssssssss", $updatedAdminId, $firstName, $lastName, $gender, $updatedContactNumber, $updatedEmail, $password, $currentAdminId);
                } else if ($newImageName == 'default-profile.png') {   
                    if ($old_image != 'default-profile.png') {
                        unlink('admin-images/'.$old_image);
                    }
                    $query = $connect->prepare("UPDATE Admin SET admin_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, photo = ?, email = ?, password = ? WHERE admin_id = ?");
                    $query->bind_param("sssssssss", $updatedAdminId, $firstName, $lastName, $gender, $updatedContactNumber, $newImageName, $updatedEmail, $password, $currentAdminId);
                } else {
                    $validImageExtension = ['jpg', 'jpeg', 'png'];
                    $imageExtension = explode(".", $newImageName);
                    $imageExtension = strtolower(end($imageExtension));
    
                    if (!in_array($imageExtension, $validImageExtension)) {
                        echo "<script>alert('Invalid image extension');</script>";
                    } else {
                        $updatedAdminImage = uniqid() . '.' . $imageExtension;
                        move_uploaded_file($newImageTmpPath, 'admin-images/' . $updatedAdminImage);
    
                        if ($old_image != 'default-profile.png') {
                            unlink('admin-images/'.$old_image);
                        }
    
                        $query = $connect->prepare("UPDATE Admin SET admin_id = ?, firstName = ?, lastName = ?, gender = ?, contactNumber = ?, photo = ?, email = ?, password = ? WHERE admin_id = ?");
                        $query->bind_param("sssssssss", $updatedAdminId, $firstName, $lastName, $gender, $updatedContactNumber, $updatedAdminImage, $updatedEmail, $password, $currentAdminId);
                    }
                }
    
                if ($query->execute()) {
                    echo "<script>alert('Admin info updated successfully.');</script>";
                    echo "<script>window.location.href='listofadmins.php'</script>";
                } else {
                    echo "<script>alert('Failed to update Admin info.');</script>";
                    echo "<script>window.location.href='listofadmins.php'</script>";
                }
            }       
        }   
    }
    
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateButtons = document.querySelectorAll('.btnUpdateAdmin');
            
            updateButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const adminId = button.getAttribute('data-id');
                    const firstName = button.getAttribute('data-firstname');
                    const lastName = button.getAttribute('data-lastname');
                    const gender = button.getAttribute('data-gender');
                    const contactNumber = button.getAttribute('data-contactnumber');
                    const email = button.getAttribute('data-email');
                    const password = button.getAttribute('data-password');
                    const photo = button.getAttribute('data-photo');
                    
                    document.querySelector('#currentAdminId').value = adminId;
                    document.querySelector('#updateAdminModal [name="txtAdminId"]').value = adminId;
                    document.querySelector('#updateAdminModal [name="txtFirstName"]').value = firstName;
                    document.querySelector('#updateAdminModal [name="txtLastName"]').value = lastName;
                    document.querySelector('#updateAdminModal [name="rdoGender"][value="' + gender + '"]').checked = true;
                    document.querySelector('#currentContactNumber').value = contactNumber;
                    document.querySelector('#updateAdminModal [name="txtContactNumber"]').value = contactNumber;
                    document.querySelector('#currentEmail').value = email;
                    document.querySelector('#updateAdminModal [name="txtEmail"]').value = email;
                    document.querySelector('#updateAdminModal [name="txtPassword"]').value = password;
                    document.querySelector('#updateAdminModal img').src = 'admin-images/' + photo;
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
