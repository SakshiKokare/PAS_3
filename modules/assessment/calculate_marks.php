<?php
session_start();

// 1. Connect to Database
include '../../config/database.php'; 

// 2. Get the current student ID from the URL (Default to 1)
$current_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 1;

// 3. Fetch the student's details
$query = "SELECT * FROM students WHERE student_id = $current_id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

if(!$student) {
    header("Location: calculate_marks.php?student_id=1");
    exit();
}

// 4. Fetch SAVED MARKS (Order by DESC ensures we get the latest save)
$roll_no = mysqli_real_escape_string($conn, $student['roll_no']);
$assess_query = "SELECT * FROM assessments WHERE student_roll_no = '$roll_no' AND experiment_no = '05' ORDER BY assessment_id DESC LIMIT 1";
$assess_result = mysqli_query($conn, $assess_query);
$saved_marks = mysqli_fetch_assoc($assess_result); 

// 5. Calculate Previous and Next IDs for the buttons
$prev_query = "SELECT student_id FROM students WHERE student_id < $current_id ORDER BY student_id DESC LIMIT 1";
$prev_result = mysqli_query($conn, $prev_query);
$prev_row = mysqli_fetch_assoc($prev_result);
$prev_id = $prev_row ? $prev_row['student_id'] : $current_id; 

$next_query = "SELECT student_id FROM students WHERE student_id > $current_id ORDER BY student_id ASC LIMIT 1";
$next_result = mysqli_query($conn, $next_query);
$next_row = mysqli_fetch_assoc($next_result);
$next_id = $next_row ? $next_row['student_id'] : $current_id; 

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<main class="main-wrapper">
    <?php include '../../includes/navbar.php'; ?>

    <div class="content flex-row">
        
        <!-- Main Assessment Area -->
        <div class="main-assessment-area">
            
            <div class="meta-bar">
                <div class="meta-item"><span class="meta-icon">🔬</span><div><small>Experiment No.</small><br><strong>05</strong></div></div>
                <div class="meta-item"><span class="meta-icon">📄</span><div><small>Experiment Title</small><br><strong>Arrays in C</strong></div></div>
                <div class="meta-item"><span class="meta-icon">📅</span><div><small>Practical Date</small><br><strong>21 Jul 2025</strong></div></div>
                <div class="meta-item"><span class="meta-icon">👥</span><div><small>Class / Division</small><br><strong>FY ECE / Div C</strong></div></div>
                <div class="meta-item"><span class="meta-icon">🎓</span><div><small>Batch</small><br><strong>2025-26 Sem II</strong></div></div>
            </div>

            <!-- DYNAMIC Student Profile Bar -->
            <div class="student-bar">
                <div class="student-info-left">
                    <div class="student-avatar"><?php echo substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1); ?></div>
                    <div>
                        <small>Student Name</small>
                        <div class="student-name"><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></div>
                    </div>
                </div>
                <div><small>Roll No.</small><br><strong><?php echo htmlspecialchars($student['roll_no']); ?></strong></div>
                <div><small>PRN No.</small><br><strong><?php echo htmlspecialchars($student['prn_no']); ?></strong></div>
                <div><small>Class & Batch</small><br><span class="badge-present"><?php echo htmlspecialchars($student['class_division']); ?></span></div>
            </div>

            <!-- Form pointing to update.php -->
            <form action="update.php" method="POST" id="assessmentForm">
                
                <!-- Hidden inputs so update.php knows who to save -->
                <input type="hidden" name="student_roll_no" value="<?php echo htmlspecialchars($student['roll_no']); ?>">
                <input type="hidden" name="experiment_no" value="05">
                <input type="hidden" name="next_student_id" value="<?php echo $next_id; ?>">
                
                <!-- Modules -->
                <div class="rubric-grid">
                    <?php 
                        include 'regularity.php';
                        include 'practical_conduction.php';
                        include 'program_output.php';
                        include 'viva.php';

                        
                    ?>
                </div>

                <!-- Automatic Totals -->
                <div class="total-section">
                    <div class="total-info">
                        <h3>AUTOMATIC TOTAL MARKS</h3>
                        <small>(Calculated Automatically)</small>
                    </div>
                    <div class="circle-progress">
                        <div class="circle-inner"><h2><span id="live-total">25</span></h2><small>/25</small></div>
                    </div>
                    <div class="stats-info">
                        <div><small>Total Obtained Marks</small><br><h3><span id="live-total-2">25</span> / 25</h3></div>
                        <div class="mt-2"><small>Total Percentage</small><br><h3 style="color:var(--primary);"><span id="live-percentage">100.00</span> %</h3></div>
                    </div>
                    <div class="formula-box">
                        <h4>Calculation Formula</h4>
                        <div class="calc-row"><span>Regularity (5)</span><span id="f-reg">5</span></div>
                        <div class="calc-row"><span>+ Conduction (10)</span><span id="f-cond">10</span></div>
                        <div class="calc-row"><span>+ Output (5)</span><span id="f-out">5</span></div>
                        <div class="calc-row"><span>+ Viva (5)</span><span id="f-viva">5</span></div>
                        <hr style="border-color: #374151; margin: 5px 0;">
                        <div class="calc-row"><strong>Total</strong><strong id="f-total">25</strong></div>
                    </div>
                </div>

                <!-- Bottom Controls (Loads saved remarks) -->
                <div class="bottom-controls">
                    <div class="remarks-box">
                        <label>FACULTY REMARKS <small>(Optional)</small></label>
                        <textarea name="remarks" placeholder="Enter remarks about the student performance..."><?php echo $saved_marks ? htmlspecialchars($saved_marks['remarks']) : ''; ?></textarea>
                    </div>
                    <?php include 'override_marks.php'; ?>
                </div>

                <!-- DYNAMIC Action Buttons -->
                <div class="action-buttons">
                    <a href="calculate_marks.php?student_id=<?php echo $prev_id; ?>" class="btn btn-outline-danger" style="text-decoration:none;">⬅ Previous</a>
                    <button type="submit" name="save_assessment" class="btn btn-primary">💾 Save Assessment</button>
                    <a href="calculate_marks.php?student_id=<?php echo $next_id; ?>" class="btn btn-secondary" style="text-decoration:none;">Next Student ➔</a>
                </div>
            </form>
        </div>

        <!-- Right Side Panel -->
        <aside class="right-panel">
            <div class="panel-card">
                <h3>ASSESSMENT RULES </h3>
                <ul class="rules-list">
                    <li><span class="dot" style="background:#3b82f6;"></span> <strong>1. Regularity</strong> (5 Marks)</li>
                    <li><span class="dot" style="background:#8b5cf6;"></span> <strong>2. Practical Conduction</strong> (10 Marks)</li>
                    <li><span class="dot" style="background:#10b981;"></span> <strong>3. Program Output</strong> (5 Marks)</li>
                    <li><span class="dot" style="background:#f59e0b;"></span> <strong>4. Understanding (Viva)</strong> (5 Marks)</li>
                </ul>
            </div>
            <div class="panel-card" style="margin-top: 15px;">
                <h3>MARKS DISTRIBUTION</h3>
                <ul class="rules-list">
                    <li><span class="dot" style="background:#3b82f6;"></span> Regularity (5) <span style="float:right">20%</span></li>
                    <li><span class="dot" style="background:#8b5cf6;"></span> Conduction (10) <span style="float:right">40%</span></li>
                    <li><span class="dot" style="background:#10b981;"></span> Output (5) <span style="float:right">20%</span></li>
                    <li><span class="dot" style="background:#f59e0b;"></span> Viva (5) <span style="float:right">20%</span></li>
                </ul>
            </div>
            <div class="success-box">
                <strong>✓ ASSESSMENT VALIDATION</strong><br><small>All selected options are valid.</small>
            </div>
        </aside>
    </div>
</main>

<?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <script>alert("Assessment saved successfully!");</script>
<?php endif; ?>

<?php if(isset($_GET['status']) && $_GET['status'] == 'notfound'): ?>
    <script>alert("Student not found! Please check the spelling, PRN, or roll number.");</script>
<?php endif; ?>

<?php include '../../includes/footer.php'; ?>
