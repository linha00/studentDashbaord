function updateProgress() {
    const moduleMCElement = document.getElementById('module-MC');
    const [completedMCs, totalMCs] = moduleMCElement.textContent.match(/\d+/g).map(Number);

    /* update module MC */
    const unitElements = document.querySelectorAll('.module p');

    // Calculate the total completed units
    let totalCompletedUnits = 0;
    unitElements.forEach(unitElement => {
        const unitsText = unitElement.textContent.trim();
        const unitsMatch = unitsText.match(/(\d+)\s*units/);

        if (unitsMatch) {
            const units = parseInt(unitsMatch[1], 10); // Convert the matched units to a number
            totalCompletedUnits += units;
        }
    });

    moduleMCElement.textContent = `${totalCompletedUnits} / ${totalMCs} MCs Completed`;

    /* update progress bar */
    // Calculate the target percentage
    const targetPercentage = Math.round((totalCompletedUnits / totalMCs) * 100);

    // Reference to the SVG progress bar elements
    const percentageTextElement = document.getElementById('percentage-text');
    const fgCircle = document.querySelector('.circular-progress .fg');
    const overflowCircle = document.querySelector('.circular-progress .overflow-fg');

    // Ensure the radius is being retrieved correctly
    const radius = fgCircle.r.baseVal.value; 
    const circumference = 2 * Math.PI * radius;

    let currentPercentage = 0;
    const animationDuration = 1000; // 1 second animation
    const frameDuration = 1000 / 60; // Assuming 60 frames per second
    const totalFrames = Math.round(animationDuration / frameDuration);
    const increment = targetPercentage / totalFrames;

    // Set the initial stroke-dasharray for the foreground circle
    fgCircle.style.strokeDasharray = `${circumference} ${circumference}`;
    fgCircle.style.strokeDashoffset = circumference;
    overflowCircle.style.strokeDasharray = `${circumference} ${circumference}`;
    overflowCircle.style.strokeDashoffset = circumference;

    function animateProgress() {
        currentPercentage += increment;
        if (currentPercentage >= targetPercentage) {
            currentPercentage = targetPercentage;
            clearInterval(animationInterval);
        }

        // Calculate the dash offset based on the current percentage
        const dashOffset = circumference - (currentPercentage / 100) * circumference;

        // Update the SVG circle's stroke-dashoffset
        fgCircle.style.strokeDashoffset = dashOffset;

        // Check if the percentage goes beyond 100% and adjust overflow
        if (currentPercentage > 100) {
            const overflowPercentage = currentPercentage - 100;
            const overflowOffset = circumference - (overflowPercentage / 100) * circumference;
            overflowCircle.style.strokeDashoffset = overflowOffset;
        } else {
            // Hide the overflow circle if within 100%
            overflowCircle.style.strokeDashoffset = circumference;
        }

        // Update the percentage text
        percentageTextElement.textContent = `${Math.round(currentPercentage)}%`;
    }

    const animationInterval = setInterval(animateProgress, frameDuration);
}

function updatePQE_PHD() {
    // Retrieve the target date from the "Done" paragraph
    const pqeDateText = document.querySelector('#pqe-task p').textContent.trim();
    const phdDateText = document.querySelector('#phd-task p').textContent.trim();
    const dateMatch_pqe = pqeDateText.match(/(Done|Due) (\d{1,2}) (\w+) (\d{4})/);
    const dateMatch_phd = phdDateText.match(/(Done|Due) (\d{1,2}) (\w+) (\d{4})/);
    
    const currentDate = new Date();

    if (dateMatch_pqe) {
        const [fullMatch, statusText, day, month, year] = dateMatch_pqe;
        const targetDate_pqe = new Date(`${month} ${day}, ${year}`);

        // Calculate the difference in milliseconds
        const timeDifference_pqe = targetDate_pqe - currentDate;
        
        // Calculate the difference in days and hours
        const differenceInDays_pqe = Math.floor(timeDifference_pqe / (1000 * 60 * 60 * 24));
        const differenceInHours_pqe = Math.floor((timeDifference_pqe % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

        // Update the corresponding elements
        document.getElementById('pqe-day').textContent = `${Math.abs(differenceInDays_pqe)} Days`;
        document.getElementById('pqe-hour').textContent = `${Math.abs(differenceInHours_pqe)} Hours`;

        // Check if the date is in the past
        if (timeDifference_pqe < 0) {
            document.getElementById('pqe-day').textContent = `0 Days`;
            document.getElementById('pqe-hour').textContent = `0 Hours`;
        }

        //update icon
        const pqeImg = document.querySelector('#pqe-task img');
        if (statusText === 'Done') {
            pqeImg.src = "https://cdn-icons-png.flaticon.com/512/10728/10728453.png";
            pqeImg.alt = "Check Mark Icon"; 
        } else {
            pqeImg.src = "https://cdn-icons-png.flaticon.com/512/7069/7069964.png";
            pqeImg.alt = "Info Icon"; 
        }
    }

    if (dateMatch_phd) {
        const [fullMatch, statusText, day, month, year] = dateMatch_phd;
        const targetDate_phd = new Date(`${month} ${day}, ${year}`);

        // Calculate the difference in milliseconds
        const timeDifference_phd = targetDate_phd - currentDate;
        
        // Calculate the difference in days and hours
        const differenceInDays_phd = Math.floor(timeDifference_phd / (1000 * 60 * 60 * 24));
        const differenceInHours_phd = Math.floor((timeDifference_phd % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

        // Update the corresponding elements
        document.getElementById('phd-day').textContent = `${Math.abs(differenceInDays_phd)} Days`;
        document.getElementById('phd-hour').textContent = `${Math.abs(differenceInHours_phd)} Hours`;

        // Check if the date is in the past
        if (timeDifference_phd < 0) {
            document.getElementById('phd-day').textContent = `0 Days`;
            document.getElementById('phd-hour').textContent = `0 Hours`;
        }

        //update icon
        const phdImg = document.querySelector('#phd-task img');
        if (statusText === 'Done') {
            phdImg.src = "https://cdn-icons-png.flaticon.com/512/10728/10728453.png";
            phdImg.alt = "Check Mark Icon"; 
        } else {
            phdImg.src = "https://cdn-icons-png.flaticon.com/512/7069/7069964.png";
            phdImg.alt = "Info Icon"; 
        }
    }
}

function updateDutyProgress() {
    // Define an array of duty IDs
    const duties = [
        { id: 'duties-teaching', hoursId: 'duty-hours-teaching' },
        { id: 'duties-research', hoursId: 'duty-hours-research' },
        { id: 'duties-other', hoursId: 'duty-hours-other' }
    ];

    // Iterate over each duty to update its progress
    duties.forEach(duty => {
        // Get the total and completed hours
        const hoursElement = document.getElementById(duty.hoursId);
        const [completed, total] = hoursElement.textContent.match(/\d+/g).map(Number);

        // Calculate the percentage
        const percentage = (completed / total) * 100;

        // Select the progress bar element
        const progressBar = document.getElementById(duty.id);

        // Initialize the animation variables
        let currentPercentage = 0;
        const animationDuration = 1000; // 1-second animation
        const frameDuration = 1000 / 60; // Assuming 60 frames per second
        const totalFrames = Math.round(animationDuration / frameDuration);
        const increment = percentage / totalFrames;

        // Set initial width
        progressBar.style.width = '0';

        // Create the animation function
        function animateProgress() {
            currentPercentage += increment;
            if (currentPercentage >= percentage) {
                currentPercentage = percentage;
                clearInterval(animationInterval);
            }

            // Update the width of the progress bar
            progressBar.style.width = currentPercentage + '%';
        }

        // Start the animation
        const animationInterval = setInterval(animateProgress, frameDuration);
    });
}

document.addEventListener("DOMContentLoaded", function() {
    updateProgress();
    updatePQE_PHD();
    updateDutyProgress();
});
