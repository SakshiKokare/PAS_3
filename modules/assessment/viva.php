<?php 
$viva_val = $saved_marks ? $saved_marks['viva'] : 5; 
?>
<!-- 4. Viva -->
<div class="rubric-card">
    <div class="rubric-header">
        <span class="rubric-icon" style="background:#f59e0b;">🗣️</span>
        <div><strong>4. UNDERSTANDING (VIVA)</strong><br><small>(5 Marks)</small></div>
    </div>
    <label class="radio-option">
        <input type="radio" name="viva" value="5" onchange="calculate()" <?php echo ($viva_val == 5) ? 'checked' : ''; ?>> Checked on Same Day <span class="mark-badge">5</span>
    </label>
    <label class="radio-option">
        <input type="radio" name="viva" value="4" onchange="calculate()" <?php echo ($viva_val == 4) ? 'checked' : ''; ?>> Checked Within 7 Days <span class="mark-badge">4</span>
    </label>
    <label class="radio-option">
        <input type="radio" name="viva" value="3" onchange="calculate()" <?php echo ($viva_val == 3) ? 'checked' : ''; ?>> Checked After 7 Days <span class="mark-badge">3</span>
    </label>
</div>