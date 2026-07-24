<?php
session_start();

// 1. Connect to the database
include '../../config/database.php'; 

// 2. Check if the user actually typed something
if (isset($_GET['query'])) {
    
    // Secure the input
    $search_term = mysqli_real_escape_string($conn, $_GET['query']);

    // 3. Search the database! 
    // We check if the search term matches their Roll No, PRN, or part of their First/Last Name
    $sql = "SELECT student_id FROM students 
            WHERE roll_no = '$search_term' 
            OR prn_no = '$search_term' 
            OR first_name LIKE '%$search_term%' 
            OR last_name LIKE '%$search_term%' 
            LIMIT 1";
            
    $result = mysqli_query($conn, $sql);
    
    // 4. Did we find a match?
    if ($row = mysqli_fetch_assoc($result)) {
        // Yes! Redirect the professor straight to that student's grading page
        header("Location: calculate_marks.php?student_id=" . $row['student_id']);
        exit();
    } else {
        // No match found. Send them back with an error flag.
        header("Location: calculate_marks.php?status=notfound");
        exit();
    }
    
} else {
    // If they accessed search.php by accident without typing anything
    header("Location: calculate_marks.php");
    exit();
}
?>