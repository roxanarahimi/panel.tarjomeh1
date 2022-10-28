const themeBtn = document.querySelector('.theme');

function getCurrentTheme() {
    let theme = window.matchMedia('(prefers-color-scheme: dark)')
        .matches ? 'dark' : 'light';
    localStorage.getItem('theme') ? theme= localStorage.getItem('theme'): null;
    return theme;
}

function loadTheme(theme) {
    const root = document.querySelector(':root');
   if (themeBtn){
       if (theme === 'light') {
           themeBtn.innerHTML = '<span class="sidebar_title d-none">night mood</span><i class="bi bi-moon-fill " title="night mood"></i> ';
       } else {
           themeBtn.innerHTML = '<span class="sidebar_title d-none">day mood</span><i class="bi bi-sun-fill" title="day mood"></i> ';
       }
   }
    root.setAttribute('color-scheme', theme)
}

themeBtn?.addEventListener('click', () => {
    let theme = getCurrentTheme();
    theme === 'dark' ? theme = 'light' : theme = 'dark';
    localStorage.setItem('theme', theme);
    loadTheme(theme);
})
window.addEventListener('DOMContentLoaded', () => {
    loadTheme(getCurrentTheme());
});
