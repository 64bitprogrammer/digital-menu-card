function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    const headerHeight = document.querySelector('.header').offsetHeight;
    const navHeight = document.querySelector('.category-nav').offsetHeight;
    const offset = headerHeight + navHeight + 10;
    
    const elementPosition = section.offsetTop - offset;
    
    window.scrollTo({
        top: elementPosition,
        behavior: 'smooth'
    });
    
    // Update active button
    document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    // Collapse menu on mobile after selection
    if (window.innerWidth <= 768) {
        const navButtons = document.getElementById('navButtons');
        const navToggle = document.querySelector('.nav-toggle');
        navButtons.classList.add('collapsed');
        navToggle.textContent = '📋 Browse Menu Categories';
    }
}

function toggleNav() {
    const navButtons = document.getElementById('navButtons');
    const navToggle = document.querySelector('.nav-toggle');
    
    navButtons.classList.toggle('collapsed');
    
    if (navButtons.classList.contains('collapsed')) {
        navToggle.textContent = '📋 Browse Menu Categories';
    } else {
        navToggle.textContent = '✖ Close Menu';
    }
}

// Initialize collapsed state on mobile
window.addEventListener('load', () => {
    if (window.innerWidth <= 768) {
        const navButtons = document.getElementById('navButtons');
        navButtons.classList.add('collapsed');
    }
});

// Handle window resize
window.addEventListener('resize', () => {
    const navButtons = document.getElementById('navButtons');
    const navToggle = document.querySelector('.nav-toggle');
    
    if (window.innerWidth > 768) {
        navButtons.classList.remove('collapsed');
    } else {
        navButtons.classList.add('collapsed');
        navToggle.textContent = '📋 Browse Menu Categories';
    }
});

// Highlight active section on scroll
window.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('.menu-section');
    const navButtons = document.querySelectorAll('.nav-btn');
    const headerHeight = document.querySelector('.header').offsetHeight;
    const navHeight = document.querySelector('.category-nav').offsetHeight;
    const offset = headerHeight + navHeight + 50;
    
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop - offset;
        const sectionHeight = section.offsetHeight;
        
        if (window.pageYOffset >= sectionTop && window.pageYOffset < sectionTop + sectionHeight) {
            current = section.getAttribute('id');
        }
    });
    
    navButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.onclick.toString().includes(current)) {
            btn.classList.add('active');
        }
    });
});