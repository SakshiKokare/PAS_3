 <?php
session_start();

// 1. Connect to database
include '../../config/database.php'; 

// 2. Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_assessment'])) {
    
    // 3. Capture and sanitize data
    $roll_no = mysqli_real_escape_string($conn, $_POST['student_roll_no']);
    $exp_no = mysqli_real_escape_string($conn, $_POST['experiment_no']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks'] ?? '');
    
    // Get rubric marks
    $regularity = intval($_POST['regularity'] ?? 0);
    $conduction = intval($_POST['conduction'] ?? 0);
    $output = intval($_POST['output'] ?? 0);
    $viva = intval($_POST['viva'] ?? 0);
    
    // Check for manual override
    if (isset($_POST['override_toggle']) && $_POST['override_toggle'] == 'on') {
        $total_marks = intval($_POST['override_marks']);
    } else {
        $total_marks = $regularity + $conduction + $output + $viva;
    }

    // Get the next student ID for auto-advancing
    $next_id = intval($_POST['next_student_id'] ?? 1);

    // 4. SQL Query to save the marks
    $sql = "INSERT INTO assessments (student_roll_no, experiment_no, regularity, conduction, output, viva, total_marks, remarks) 
            VALUES ('$roll_no', '$exp_no', '$regularity', '$conduction', '$output', '$viva', '$total_marks', '$remarks')";

    // 5. Execute and Redirect
    if (mysqli_query($conn, $sql)) {
        header("Location: calculate_marks.php?student_id=" . $next_id . "&status=success");
        exit();
    } else {
        die("Database Error: " . mysqli_error($conn));
    }
} else {
    header("Location: calculate_marks.php");
    exit();
}
?>