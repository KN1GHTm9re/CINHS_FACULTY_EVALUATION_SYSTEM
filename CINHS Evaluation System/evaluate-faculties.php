<?php 

session_start();

include_once 'connect.php';

$student_id = $_SESSION["user_id"];

?>

<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="commenceLogout.js"></script>
        <title>Evaluate Faculties</title>
        <style>
            .evaluate-faculties-con{
                display: flex;
                flex-direction: column;
                text-align: center;
            }
    
            .evaluate-faculties-con ul{
                margin-top: 100px;
            }
    
            .evaluate-faculties-con ul img{
                height: 200px;
                margin-bottom: 12px;
                border: 8px solid black;
                border-radius: 50%;
            }
    
            .evaluate-faculties-con ul a{
                text-decoration: none;
                background-color: green;
                color: white;
                padding: 8px;
            }
    
            #btnEvaluate{
                margin-top: 30px;
            }
        </style>
    </head>
    <body id="evaluate-faculties-body">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Student</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a id="nav-student-dashboard" class="nav-link" href="student-dashboard.php">DASHBOARD</a>
                        </li>
                        <li class="nav-item">
                            <a id="nav-evaluate" class="nav-link" href="evaluate-faculties.php">EVALUATE</a>
                        </li>
                        <li class="nav-item">
                            <a id="nav-profile" class="nav-link" href="student-profile.php">PROFILE</a>
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
            <div class="row">
                <div class="evaluate-faculties-con"> 
                    <div>
                    <?php 
                    
                    $query = "SELECT status FROM evaluation_status";
                    $executeQuery = mysqli_query($connect, $query);
                    $result = mysqli_fetch_assoc($executeQuery);
                    $status = $result["status"];

                    if($status == 0){
                    ?>
                        <h1>Evaluation is not ongoing.</h1>
                    <?php
                    } else {
                    ?>
                        <div class="p-5 text-start">     
                    <?php

                        $query = "SELECT section_id FROM student WHERE student_id = $student_id";
                        $executeQuery = mysqli_query($connect, $query);
                        $result = mysqli_fetch_assoc($executeQuery);
                        $section_id = $result["section_id"];

                        $query = "SELECT sf.section_id, sf.faculty_id, s.section_id
                                FROM sections_faculties sf
                                INNER JOIN student s ON sf.section_id = s.section_id
                                WHERE s.section_id = $section_id";
                        $executeQuery = mysqli_query($connect, $query);
                        $facultyCount = mysqli_num_rows($executeQuery);

                    ?>
                        <p>Faculty count: <?php echo $facultyCount ?></p>
                    <?php 
                        
                        $query = "SELECT * FROM evaluation_records WHERE student_id = $student_id";
                        $executeQuery = mysqli_query($connect, $query);
                        $facultiesEvaluated = mysqli_num_rows($executeQuery);

                    ?>
                        <p>Faculties Evaluated: <?php echo $facultiesEvaluated . "/" . $facultyCount ?></p>
                    <?php

                        $pendingEvaluation = $facultyCount - $facultiesEvaluated;

                    ?>
                        <p>Pending Evaluations: <?php echo $pendingEvaluation . "/" . $facultyCount ?></p>
                        </div>
                    <?php

                        $user_id = $_SESSION['user_id'];
                    
                        // Fetch the section ID of the logged-in student
                        $section_query = "SELECT section_id FROM student WHERE student_id = $user_id";
                        $section_result = mysqli_query($connect, $section_query);
                        $section_row = mysqli_fetch_assoc($section_result);
                        $section_id = $section_row['section_id'];
                        
                        // Fetch all faculties belonging to the same section
                        $faculty_query = "SELECT f.* 
                                        FROM Faculty AS f
                                        INNER JOIN sections_faculties AS sf ON f.faculty_id = sf.faculty_id
                                        WHERE sf.section_id = $section_id";
                        $faculty_result = mysqli_query($connect, $faculty_query);
                        
                        while ($row = mysqli_fetch_assoc($faculty_result)) {
                            $alreadyEvaluated = false;
                            $faculty_id = $row["faculty_id"];
                            $stmt = $connect->prepare("SELECT student_id, faculty_id FROM evaluation_records WHERE student_id = ? AND faculty_id = ?");
                            $stmt->bind_param("ii", $user_id, $faculty_id);
                            $stmt->execute();
                            $getResult = $stmt->get_result();
                            
                            while($result = $getResult->fetch_assoc()){
                                if($user_id == $result["student_id"] && $faculty_id == $result["faculty_id"]){
                                    $alreadyEvaluated = true;
                                    break;
                                }
                            }
        
                            if($alreadyEvaluated == false){
                    ?>
                                <ul style='list-style-type: none; padding: 20px'>
                                    <li style='text-align: center'><img src='faculty-images/<?php echo $row['photo']; ?>'></li>
                                    <li><?php echo $row['firstName'] . " " . $row['lastName']; ?></li>
                                    <li id='btnEvaluate'><a href='evaluation-form.php?faculty_id=<?php echo $row['faculty_id']; ?>'>EVALUATE</a></li>
                                </ul>
                    <?php
                            } else{
                    ?>
                                <ul style='list-style-type: none; padding: 20px'>
                                    <li style='text-align: center'><img src='faculty-images/<?php echo $row['photo']; ?>'></li>
                                    <li><?php echo $row['firstName'] . " " . $row['lastName']; ?></li>
                                    <li id='btnEvaluate'><button href='evaluation-form.php?faculty_id=<?php echo $row['faculty_id']; ?>' disabled>EVALUATE</button></li>
                                </ul>
                    <?php
                            }
                        }
                    }
                     
                    ?>     
                    </div>           
                </div>
            </div>
        </div>
    
        <script></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
    </html>







    




