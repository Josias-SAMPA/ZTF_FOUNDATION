function showSection(sectionName) {
    // Cacher toutes les sections
    document.querySelectorAll("main section").forEach(section => {
        section.style.display = "none";
    });

    // Afficher la section demand�e
    const targetSection = document.getElementById("section-" + sectionName);
    if (targetSection) {
        targetSection.style.display = "block";
    }

    // Mettre � jour les liens actifs dans la navigation
    document.querySelectorAll(".nav-link").forEach(link => {
        link.classList.remove("active");
        if (link.getAttribute("onclick")?.includes(sectionName)) {
            link.classList.add("active");
        }
    });

    // Sauvegarder la derni�re section dans sessionStorage
    sessionStorage.setItem("lastActiveSection", sectionName);
}

// Fonction pour basculer la sidebar
function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    const menuToggle = document.getElementById("menuToggle");

    if (sidebar && overlay && menuToggle) {
        sidebar.classList.toggle("active");
        overlay.classList.toggle("active");
        menuToggle.classList.toggle("active");
    }
}

// Fonction pour fermer la sidebar
function closeSidebar() {
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    const menuToggle = document.getElementById("menuToggle");

    if (sidebar && overlay && menuToggle) {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
        menuToggle.classList.remove("active");
    }
}

// Au chargement de la page
document.addEventListener("DOMContentLoaded", function() {
    // Récupérer la dernière section active ou utiliser "dashboard" par défaut
    const lastSection = sessionStorage.getItem("lastActiveSection") || "dashboard";
    showSection(lastSection);

    // Ajouter la classe active au lien correspondant
    const activeLink = document.querySelector(`.nav-link[onclick*="${lastSection}"]`);
    if (activeLink) {
        activeLink.classList.add("active");
    }

    // Fermer la sidebar si on clique sur un lien de navigation
    document.querySelectorAll(".nav-link").forEach(link => {
        link.addEventListener("click", function() {
            closeSidebar();
        });
    });

    // Fermer la sidebar au redimensionnement si on passe en mode desktop
    window.addEventListener("resize", function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
});
