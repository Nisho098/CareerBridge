document.addEventListener('DOMContentLoaded', function () {
    // Dynamically add skills to the "Skills" section
    const skills = ['HTML', 'CSS', 'JavaScript', 'Laravel', 'React', 'Node.js'];
    const skillsContainer = document.getElementById('skills-container');

    skills.forEach(skill => {
        const skillTag = document.createElement('div');
        skillTag.className = 'skill-tag';
        skillTag.textContent = skill;
        skillsContainer.appendChild(skillTag);
    });

    // Handle download button click
    const downloadBtn = document.querySelector('.download-btn');
    downloadBtn.addEventListener('click', function () {
        alert('Downloading the file...');
        // Redirect to the file's URL
        window.location.href = 'path-to-your-file/nisha-CV-updated.pdf';
    });
});
