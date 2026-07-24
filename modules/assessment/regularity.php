<?php 
// If saved_marks exists, use the saved value. Otherwise, default to 5.
$reg_val = $saved_marks ? $saved_marks['regularity'] : 5; 
?>
<!-- 1. Regularity -->
<div class="rubric-card">
    <div class="rubric-header">
        <span class="rubric-icon" style="background:#3b82f6;">📅</span>
        <div><strong>1. REGULARITY</strong><br><small>(5 Marks)</small></div>
    </div>
    <label class="radio-option">
        <input type="radio" name="regularity" value="5" onchange="calculate()" <?php echo ($reg_val == 5) ? 'checked' : ''; ?>> Present <span class="mark-badge">5</span>
    </label>
    <label class="radio-option">
        <input type="radio" name="regularity" value="0" onchange="calculate()" <?php echo ($reg_val == 0) ? 'checked' : ''; ?>> Absent <span class="mark-badge">0</span>
    </label>
</div>