<?php 
$out_val = $saved_marks ? $saved_marks['output'] : 5; 
?>
<!-- 3. Output -->
<div class="rubric-card">
    <div class="rubric-header">
        <span class="rubric-icon" style="background:#10b981;">💻</span>
        <div><strong>3. PROGRAM OUTPUT</strong><br><small>(5 Marks)</small></div>
    </div>
    <label class="radio-option">
        <input type="radio" name="output" value="5" onchange="calculate()" <?php echo ($out_val == 5) ? 'checked' : ''; ?>> Present and Output Obtained <span class="mark-badge">5</span>
    </label>
    <label class="radio-option">
        <input type="radio" name="output" value="3" onchange="calculate()" <?php echo ($out_val == 3) ? 'checked' : ''; ?>> Present but Output Not Obtained <span class="mark-badge">3</span>
    </label>
    <label class="radio-option">
        <input type="radio" name="output" value="2" onchange="calculate()" <?php echo ($out_val == 2) ? 'checked' : ''; ?>> Absent but Performed Later <span class="mark-badge">2</span>
    </label>
    <label class="radio-option">
        <input type="radio" name="output" value="0" onchange="calculate()" <?php echo ($out_val == 0) ? 'checked' : ''; ?>> Absent and Not Performed <span class="mark-badge">0</span>
    </label>
</div>