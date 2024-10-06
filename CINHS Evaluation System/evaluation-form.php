<?php

session_start();
include_once 'connect.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Form | Faculty Evaluation</title>
    <link rel="icon" type="image/png" href="/images/systems-plus-computer-college-logo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="icon" href="images/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="questionnaire-style.css">
    <link rel="stylesheet" href="style.css">
    <script src="commenceLogout.js"></script>
    <style>
        .evaluate-faculties-con{
            display: flex;
            flex-direction: column;
            height: auto;
        }

        #btnEvaluate{
            margin-top: 30px;
        }

        #btnSubmit{
            color: white;
            background-color: green; 
            padding: 12px; 
            border: none; 
        }

        #btnSubmit:hover{
            cursor: pointer;
            background-color: darkgreen;
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
    <div class="evaluate-faculties-con p-5 align-items-center">
        <!-- Evaluation Form -->
        <?php

        include_once "connect.php";

        $faculty_id = $_GET["faculty_id"];
        $query = "SELECT * FROM Faculty WHERE faculty_id = $faculty_id";
        $executeQuery = mysqli_query($connect, $query);
        $result = mysqli_fetch_assoc($executeQuery);

        $facultyName = $result["firstName"] . " " . $result["lastName"];

        if($result["gender"] == "Male") {
            $honorific = "Mr.";
        }
        else {
            $honorific = "Ms.";
        }
            
        ?>

        <h1 class="pb-5">You are currently evaluating your teacher <?php echo $honorific . " " . $facultyName; ?></h1>
        <div class="evaluation-question">
             <div class="evaluation-question-top">
                 <p class="label-question">Evaluation Questionnaire for Academic: </p>
             </div>
             <hr>
             <div class="evaluation-question-content">
                 <h1>Rating</h1>
                 <div class="rating-legend-box">
                     <div class="rating-legend-options">1 - STRONGLY DISAGREE</div>
                     <div class="rating-legend-options">2 - DISAGREE</div>
                     <div class="rating-legend-options">3 - UNCERTAIN</div>
                     <div class="rating-legend-options">4 - AGREE</div>
                     <div class="rating-legend-options">5 - STRONGLY AGREE</div>
                 </div>
                 <div class="question-container">
                    <form method="POST">
                        <table class="question-table">
                            <input type="hidden" name="faculty_id" value="<?php echo $faculty_id; ?>">
                            <?php

                            include_once "connect.php";

                            $criteria = [];
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
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
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
                                            <td><input type="radio" name="rating[<?php echo $criterion_name ?>][<?php echo $questionNumber; ?>]" value="5" required></td>
                                            <td><input type="radio" name="rating[<?php echo $criterion_name ?>][<?php echo $questionNumber; ?>]" value="4" required></td>
                                            <td><input type="radio" name="rating[<?php echo $criterion_name ?>][<?php echo $questionNumber; ?>]" value="3" required></td>
                                            <td><input type="radio" name="rating[<?php echo $criterion_name ?>][<?php echo $questionNumber; ?>]" value="2" required></td>
                                            <td><input type="radio" name="rating[<?php echo $criterion_name ?>][<?php echo $questionNumber; ?>]" value="1" required></td>
                                        </tr>
                            <?php
                                            $questionNumber++;
                                        }                   
                                    }
                                    $stmt->close(); // Close the statement after processing
                                }
                            ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button id="cancel" onclick="cancelAction()">CANCEL</button>
                                <input type="submit" id="btnSubmit" name="btnSubmit" value="SUBMIT">

                                <?php

                                include_once 'connect.php';

                                $errorMessage = '';

                                if (isset($_POST["btnSubmit"])) {
                                    if (isset($_POST["rating"])) {
                                        $ratings = $_POST["rating"];
                                        $faculty_id = $_POST["faculty_id"];
                                        $student_id = $_SESSION["user_id"];
                                        $date = date('Y-m-d H:i:s');
                                        $totalScore = 0;
                                        $totalMaxScore = 0;

                                        foreach ($ratings as $criterion => $questions) {
                                            $criterionScore = 0;
                                            $maxScore = count($questions) * 5; // Each question max score is 5

                                            // Fetch criterion ID
                                            $stmt = $connect->prepare("SELECT criterion_id FROM criteria WHERE criterion_name = ?");
                                            $stmt->bind_param('s', $criterion);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            $row = $result->fetch_assoc();
                                            $criterion_id = $row["criterion_id"];
                                            $stmt->close();

                                            // For criteria_percentage
                                            // Calculate score for this criterion
                                            foreach ($questions as $rating) {
                                                $criterionScore += (int)$rating;
                                            }

                                            // Calculate percentage for this criterion
                                            $criterionPercentage = ($criterionScore / $maxScore) * 100;

                                            // Retrieve current cumulative score and student count for this criterion
                                            $query = "SELECT student_count, cumulative_score FROM criteria_percentage WHERE faculty_id = ? AND criterion_id = ?";
                                            $stmt = $connect->prepare($query);
                                            $stmt->bind_param('ii', $faculty_id, $criterion_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            // if faculty_id and criterion_id already exist, update current row
                                            if ($row = $result->fetch_assoc()) {
                                                // Criterion has previous evaluations
                                                $cumulativeScore = $row['cumulative_score'];
                                                $student_count = $row['student_count'] + 1;

                                                // Update cumulative score for this criterion
                                                $cumulativeScore += $criterionScore;

                                                // Calculate new percentage for this criterion
                                                $newCriterionPercentage = ($cumulativeScore / ($student_count * $maxScore)) * 100;

                                                // Retrieve current cumulative score and student count for this criterion
                                                $query = "SELECT faculty_id, criterion_id FROM criteria_percentage WHERE faculty_id = ? AND criterion_id = ?";
                                                $stmt = $connect->prepare($query);
                                                $stmt->bind_param('ii', $faculty_id, $criterion_id);
                                                $stmt->execute();
                                                $execute = $stmt->get_result();
                                                $result = $execute->fetch_assoc();
                                                $stmt->close();

                                                $stmt = $connect->prepare("UPDATE criteria_percentage SET student_count = ?, cumulative_score = ?, criterion_percentage = ? WHERE faculty_id = ? AND criterion_id = ?
                                                ");
                                                $stmt->bind_param('iidii', $student_count, $cumulativeScore, $newCriterionPercentage, $faculty_id, $criterion_id);
                                                $stmt->execute();
                                                $stmt->close();
                                            } 
                                            // if faculty_id and criterion_id do not exist, insert a new row
                                            else {
                                                // No previous evaluations for this criterion
                                                $cumulativeScore = 0;
                                                $student_count = 1;

                                                // Update cumulative score for this criterion
                                                $cumulativeScore += $criterionScore;

                                                // Calculate new percentage for this criterion
                                                $newCriterionPercentage = ($cumulativeScore / ($student_count * $maxScore)) * 100;

                                                // Retrieve current cumulative score and student count for this criterion
                                                $query = "SELECT faculty_id, criterion_id FROM criteria_percentage WHERE faculty_id = ? AND criterion_id = ?";
                                                $stmt = $connect->prepare($query);
                                                $stmt->bind_param('ii', $faculty_id, $criterion_id);
                                                $stmt->execute();
                                                $execute = $stmt->get_result();
                                                $result = $execute->fetch_assoc();
                                                $stmt->close();

                                                $stmt = $connect->prepare("
                                                INSERT INTO criteria_percentage (faculty_id, criterion_id,student_count, cumulative_score,criterion_percentage) 
                                                VALUES (?, ?, ?, ?, ?)");
                                                $stmt->bind_param('iiiid', $faculty_id, $criterion_id,$student_count,$cumulativeScore, $newCriterionPercentage);
                                                $stmt->execute();
                                                $stmt->close();
                                            }
                 
                                            $totalScore += $criterionScore;
                                            $totalMaxScore += $maxScore;
                                        }

                                        // For overall_results
                                        // Now handle overall results (similar to what you've  already done)
                                        $overallPercentage = ($totalScore / $totalMaxScore) * 100;

                                        // Retrieve current cumulative score and student count from overall_results
                                        $query = "SELECT student_count, cumulative_score FROM overall_results WHERE faculty_id = ?";
                                        $stmt = $connect->prepare($query);
                                        $stmt->bind_param('i', $faculty_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $stmt->close();

                                        // if faculty_id already exists, update current row
                                        if ($row = $result->fetch_assoc()) {
                                            // Faculty has previous evaluations
                                            $cumulativeScoreForOverall = $row['cumulative_score'];
                                            $student_count = $row['student_count'] + 1;

                                            // Update cumulative score for overall
                                            $cumulativeScoreForOverall += $totalScore;

                                            // Recalculate overall percentage
                                            $maxPossibleScore = $student_count * $totalMaxScore;
                                            $newOverallPercentage = ($cumulativeScoreForOverall / $maxPossibleScore) * 100;

                                            // Update the overall results
                                            $stmt = $connect->prepare("UPDATE overall_results SET student_count = ?, cumulative_score = ?, overall_percentage = ? WHERE faculty_id = ?");
                                            $stmt->bind_param('iidi', $student_count, $cumulativeScoreForOverall, $newOverallPercentage, $faculty_id);
                                        } 
                                        // if faculty_id does not exist, insert a new row
                                        else {
                                            // No previous evaluations
                                            $cumulativeScoreForOverall = 0;
                                            $student_count = 1;

                                            // Update cumulative score for overall
                                            $cumulativeScoreForOverall += $totalScore;

                                            // Recalculate overall percentage
                                            $maxPossibleScore = $student_count * $totalMaxScore;
                                            $newOverallPercentage = ($cumulativeScoreForOverall / $maxPossibleScore) *100;
                                        
                                            // Insert the overall results
                                            $stmt = $connect->prepare("INSERT INTO overall_results (faculty_id, student_count, cumulative_score, overall_percentage) VALUES(?, ?, ?, ?)");
                                            $stmt->bind_param('iiid', $faculty_id, $student_count, $cumulativeScoreForOverall,$newOverallPercentage);
                                        }
                                        
                                        if ($stmt->execute()) {
                                            $stmt->close();

                                            // Insert evaluation record for this student
                                            $stmt = $connect->prepare("INSERT INTO evaluation_records (student_id, faculty_id, date) VALUES (?, ?, ?)");
                                            $stmt->bind_param('sss', $student_id, $faculty_id, $date);
                                            if ($stmt->execute()) {
                                                $stmt->close();
                                                echo "<script>alert('Faculty has been successfully evaluated.');</script>";
                                                echo "<script>window.location.href='evaluate-faculties.php'</script>";
                                            }
                                        } else {
                                            echo "<script>alert('Failed to evaluate Faculty.')</script>";
                                            echo "<script>window.location.href='evaluate-faculties.php'</script>";
                                        }
                                    } else {
                                        echo "<script>alert('Please answer all the questions.');</script>";
                                    }
                                }

                                ?>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>

function cancelAction() {
    event.preventDefault();
    window.location.href = 'evaluate-faculties.php';
}

</script>
