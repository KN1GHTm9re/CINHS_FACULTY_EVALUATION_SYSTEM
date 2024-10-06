<?php

session_start();

include "connect.php";

$faculty_id = $_GET["faculty_id"];

$query = $connect->prepare("SELECT * FROM Faculty WHERE faculty_id = ?");
$query->bind_param("i", $faculty_id);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();
$firstName = $row["firstName"];
$lastName = $row["lastName"];
$gender = $row["gender"];

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
	<title>Faculty Evaluation Result</title>
	<style>
		#nav-faculty-dashboard{
            color: gray;
            pointer-events: none;
        }

        .chartBox{
            width: 700px;
        }
        
        .back {
            display: inline-block;
            font-size: 32px;
            transition: 0.3s; /* Add transition for smooth animation */
        }

        .back:hover {
            font-size: 38px;
            cursor: pointer;
        }

        
	</style>
</head>
<body id="faculty-dashboard-body">
    <div class="container-fluid p-4">
        <a href="admin-dashboard.php" class="back bi bi-arrow-left-circle pb-5"></a>
        <h1 class="text-center"><?php echo ($row["gender"] == "Male" ? 'Mr. ' : 'Ms. ') . $row["firstName"] . " " . $row["lastName"] ?> Evaluation Result</h1>
        <div class="row">
            <div>
                <h2 class="pb-3">Legend</h2>
                <ul>
                    <li><div style="display: inline-block; width: 20px; height: 20px; background-color: rgba(40, 167, 69, 0.5);"></div> 100% - 81% = Excellent</li>
                    <li><div style="display: inline-block; width: 20px; height: 20px; background-color: rgba(23, 162, 184, 0.5);"></div> 80% - 61% = Satisfactory</li>
                    <li><div style="display: inline-block; width: 20px; height: 20px; background-color: rgba(255, 255, 0, 0.5);"></div> 60% - 41% = Moderate Performance</li>
                    <li><div style="display: inline-block; width: 20px; height: 20px; background-color: rgba(255, 165, 0, 0.5);"></div> 40% - 21% = Needs Improvement</li>
                    <li><div style="display: inline-block; width: 20px; height: 20px; background-color: rgba(255, 0, 0, 0.5);"></div> 20% - 0% = Critical Failure</li>
                </ul>
            </div>

            <div class="col-6 d-flex justify-content-center align-items-center p-5">
                <?php

                $query = "SELECT faculty_id, criterion_id, criterion_percentage FROM criteria_percentage WHERE faculty_id = $faculty_id";
                $result1 = mysqli_query($connect, $query);

                if($result1->num_rows > 0){
                    $criteria = array();
                    $criteria_percentage = array();

                    while($row = mysqli_fetch_assoc($result1)){
                        $criterion_id = $row["criterion_id"];  
                        $query = "SELECT criterion_name FROM criteria WHERE criterion_id = $criterion_id";
                        $result2 = mysqli_query($connect, $query);
                        $criterion_name_row = mysqli_fetch_assoc($result2);
                        $criterion_name = $criterion_name_row["criterion_name"];
                        $criterion_percentage = $row["criterion_percentage"]; 

                        array_push($criteria, $criterion_name); 
                        array_push($criteria_percentage, $criterion_percentage); 
                        // $criteria[] = $criterion_name;
                        // $criteria_percentage[] = $criterion_percentage;
                    }
                }

                ?>
                <div class="chartBox">
                    <canvas id="criteriaChart" width="100" height="100"></canvas>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    // Setup Block
                    const criteria = <?php echo json_encode($criteria); ?>;
                    const criteria_percentage = <?php echo json_encode($criteria_percentage); ?>;

                    // Initialize color arrays
                    let criteria_color = [];
                    let criteria_border_color = [];
                    let description = [];

                        // Determine colors based on each criterion's percentage value
                    for (let i = 0; i < criteria_percentage.length; i++) {
                        if (criteria_percentage[i] <= 20) {
                            criteria_color.push('rgba(255, 99, 71, 0.5)'); // Red (Tomato)
                            criteria_border_color.push('rgba(200, 0, 0, 1)'); // Darker red for border 
                        } else if (criteria_percentage[i] <= 40) {
                            criteria_color.push('rgba(255, 165, 0, 0.5)'); // Orange
                            criteria_border_color.push('rgba(200, 100, 0, 1)'); // Darker orange for border
                        } else if (criteria_percentage[i] <= 60) {
                            criteria_color.push('rgba(255, 255, 0, 0.5)'); // Yellow
                            criteria_border_color.push('rgba(200, 200, 0, 1)'); // Darker yellow for border
                        } else if (criteria_percentage[i] <= 80) {
                            criteria_color.push('rgba(23, 162, 184, 0.5)'); // Blue (Info)
                            criteria_border_color.push('rgba(0, 150, 150, 1)'); // Darker blue for border
                        } else {
                            criteria_color.push('rgba(40, 167, 69, 0.5)'); // Green (Success)
                            criteria_border_color.push('rgba(0, 150, 0, 1)'); // Darker green for border
                        }
                    }
        
                    const criteria_data = {
                        labels: criteria,
                        datasets: [{
                            label: 'Criteria Percentage',
                            data: criteria_percentage,
                            backgroundColor: criteria_color, // Set the background color
                            borderColor: criteria_border_color, // Set the border color
                            borderWidth: 1
                        }]
                    };

                    // Config Block
                    const criteria_config = {
                        type: 'bar',
                        data: criteria_data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        usePointStyle: true, // Use points instead of box for legend items
                                        pointStyle: 'line',  // Set the point style to 'line' (or 'circle', 'star', etc.)
                                        boxWidth: 0,         // Set box width to 0 to hide the box
                                    }
                                }
                            }
                        }
                    };

                    // Render Block
                    const criteriaChart = new Chart(
                        document.getElementById("criteriaChart"),
                        criteria_config
                    )
                </script>
            </div>
            <div class="col-6 d-flex justify-content-center align-items-center p-5">
                <?php

                $query = "SELECT faculty_id, overall_percentage FROM overall_results WHERE faculty_id = $faculty_id";
                $result = mysqli_query($connect, $query);

                if($result->num_rows > 0){
                    $overall_percentage_row = mysqli_fetch_assoc($result);
                    $overall_percentage = $overall_percentage_row["overall_percentage"];
                }

                ?>
                <div class="chartBox text-center">
                    <canvas id="overallChart" width="100" height="100"></canvas> 
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    // Setup Block
                    const overall_percentage = [<?php echo json_encode($overall_percentage); ?>]; // Wrap in array

                    if (overall_percentage[0] <= 20) {
                        overall_color = 'rgba(255, 99, 71, 0.5)'; // Red (Tomato)
                        overall_border_color = 'rgba(200, 0, 0, 1)'; // Darker red for border
                        description = 'Your performance is bad. You need to change your teaching style.';
                    } else if (overall_percentage[0] <= 40) {
                        overall_color = 'rgba(255, 165, 0, 0.5)'; // Orange
                        overall_border_color = 'rgba(200, 100, 0, 1)'; // Darker orange for border
                        description = 'Your performance is below average, you might reconsider your teaching style.';
                    } else if (overall_percentage[0] <= 60) {
                        overall_color = 'rgba(255, 255, 0, 0.5)'; // Yellow
                        overall_border_color = 'rgba(200, 200, 0, 1)'; // Darker yellow for border
                        description = 'Your performance is average. It can be better.';
                    } else if (overall_percentage[0] <= 80) {
                        overall_color = 'rgba(23, 162, 184, 0.5)'; // Blue (Info)
                        overall_border_color = 'rgba(0, 150, 150, 1)'; // Darker blue for border
                        description = 'Your performance is good. Just a little more, you will reach excellence.';
                    } else {
                        overall_color = 'rgba(40, 167, 69, 0.5)'; // Green (Success)
                        overall_border_color = 'rgba(0, 150, 0, 1)'; // Darker green for border
                        description = 'Your performance is excellent. The students really liked your teaching style. Keep up the good work.';
                    }

                    const overall_data = {
                        labels: ["Overall Result"],
                        datasets: [{
                            label: 'Overall Result',
                            data: overall_percentage,
                            backgroundColor: overall_color, // Set the background color
                            borderColor: overall_border_color,      // Set the border color
                            borderWidth: 1
                        }]
                    };

                    // Config Block
                    const overall_config = {
                        type: 'bar',
                        data: overall_data,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        usePointStyle: true, // Use points instead of box for legend items
                                        pointStyle: 'line',  // Set the point style to 'line' (or 'circle', 'star', etc.)
                                        boxWidth: 0,         // Set box width to 0 to hide the box
                                    }
                                }
                            }
                        }
                    };

                    // Render Block
                    const overallChart = new Chart(
                        document.getElementById("overallChart"),
                        overall_config
                    )

                </script>                
            </div>
            <div class="text-center">
                <h6 id="description" class="py-5" style=""></h6>   
                <script>
                    // Update the h1 element with the description
                    document.getElementById('description').innerHTML = description;
                </script>
            </div>
        </div>
    </div>

    

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

