function calculate() {
    // 1. Get the values of the currently checked radio buttons
    // If nothing is selected yet, default to 0
    let regVal = parseInt(document.querySelector('input[name="regularity"]:checked')?.value || 0);
    let condVal = parseInt(document.querySelector('input[name="conduction"]:checked')?.value || 0);
    let outVal = parseInt(document.querySelector('input[name="output"]:checked')?.value || 0);
    let vivaVal = parseInt(document.querySelector('input[name="viva"]:checked')?.value || 0);
    
    // 2. Calculate the sums
    let total = regVal + condVal + outVal + vivaVal;
    let percentage = (total / 25) * 100;

    // 3. Update the main total displays
    document.getElementById('live-total').innerText = total;
    document.getElementById('live-total-2').innerText = total;
    document.getElementById('live-percentage').innerText = percentage.toFixed(2);

    // 4. Update the "Calculation Formula" breakdown box dynamically
    document.getElementById('f-reg').innerText = regVal;
    document.getElementById('f-cond').innerText = condVal;
    document.getElementById('f-out').innerText = outVal;
    document.getElementById('f-viva').innerText = vivaVal;
    document.getElementById('f-total').innerText = total;
    
    // 5. Adjust the circular progress bar (Visual flourish)
    // Converts the total (0-25) to a degree (0-360) for the CSS conic-gradient
    let degrees = (total / 25) * 360;
    const circle = document.querySelector('.circle-progress');
    
    // Check if body is in light mode to adjust the unfilled part of the circle
    const emptyColor = document.body.classList.contains('light-mode') ? '#e2e8f0' : '#1e293b';
    
    if(circle) {
        circle.style.background = `conic-gradient(var(--primary) ${degrees}deg, ${emptyColor} 0)`;
    }
}

// Run it once on page load to initialize the default 'checked' values
document.addEventListener("DOMContentLoaded", function() {
    calculate();
});

// --- Theme Toggle Logic ---
const themeToggleBtn = document.getElementById('theme-toggle');
const body = document.body;

// Check local storage for theme preference
if (localStorage.getItem('theme') === 'light') {
    body.classList.add('light-mode');
    if (themeToggleBtn) themeToggleBtn.innerText = '🌙'; 
} else {
    if (themeToggleBtn) themeToggleBtn.innerText = '☀️';
}

// Add click event to the button
if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', () => {
        body.classList.toggle('light-mode');
        
        if (body.classList.contains('light-mode')) {
            localStorage.setItem('theme', 'light');
            themeToggleBtn.innerText = '🌙'; 
        } else {
            localStorage.setItem('theme', 'dark');
            themeToggleBtn.innerText = '☀️'; 
        }
        
        // Recalculate to update the circle progress bar colors for the new theme
        calculate();
    });
}
