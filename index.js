const sideMenu = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');

const darkMode = document.querySelector('.dark-mode');
const darkModeIconLight = darkMode.querySelector('span:nth-child(1)');
const darkModeIconDark = darkMode.querySelector('span:nth-child(2)');

// Check if user preference is stored in localStorage
const isDarkMode = localStorage.getItem('darkMode') === 'true';

// Initialize dark mode based on stored preference
if (isDarkMode) {
    document.body.classList.add('dark-mode-variables');
    darkModeIconLight.classList.remove('active');
    darkModeIconDark.classList.add('active');
} else {
    document.body.classList.remove('dark-mode-variables');
    darkModeIconLight.classList.add('active');
    darkModeIconDark.classList.remove('active');
}

darkMode.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode-variables');
    darkModeIconLight.classList.toggle('active');
    darkModeIconDark.classList.toggle('active');
    
    // Update user preference in localStorage
    const newDarkModePreference = document.body.classList.contains('dark-mode-variables');
    localStorage.setItem('darkMode', newDarkModePreference);
})

menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
});

// darkMode.addEventListener('click', () => {
//     document.body.classList.toggle('dark-mode-variables');
//     darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
//     darkMode.querySelector('span:nth-child(2)').classList.toggle('active');
// })

