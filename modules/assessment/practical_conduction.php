<?php 
$cond_val = $saved_marks ? $saved_marks['conduction'] : 10; 
?>
<!-- 2. Conduction -->
<div class="rubric-card">
    <div class="rubric-header">
        <span class="rubric-icon" style="background:#8b5cf6;">🔬</span>
        <div><strong>2. PRACTICAL CONDUCTION</strong><br><small>(10 Marks)</small></div>
    </div>
    <label class="radio-option"><input type="radio" name="conduction" value="10" onchange="calculate()" <?php echo ($cond_val == 10) ? 'checked' : ''; ?>> Present and Performed <span class="mark-badge">10</span></label>
    <label class="radio-option"><input type="radio" name="conduction" value="7" onchange="calculate()" <?php echo ($cond_val == 7) ? 'checked' : ''; ?>> Present but Not Performed <span class="mark-badge">7</span></label>
    <label class="radio-option"><input type="radio" name="conduction" value="5" onchange="calculate()" <?php echo ($cond_val == 5) ? 'checked' : ''; ?>> Absent but Performed Later <span class="mark-badge">5</span></label>
    <label class="radio-option"><input type="radio" name="conduction" value="0" onchange="calculate()" <?php echo ($cond_val == 0) ? 'checked' : ''; ?>> Absent and Not Performed <span class="mark-badge">0</span></label>
</div>