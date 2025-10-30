function showSection(sectionName) {
    // Cacher toutes les sections
    document.querySelectorAll("main section").forEach(section => {
        section.style.display = "none";
    });

    // Afficher la section demandée
    const targetSection = document.getElementById("section-" + sectionName);
    if (targetSection) {
        targetSection.style.display = "block";
    }

    // Mettre à jour les liens actifs dans la navigation
    document.querySelectorAll(".nav-link").forEach(link => {
        link.classList.remove("active");
        if (link.getAttribute("onclick")?.includes(sectionName)) {
            link.classList.add("active");
        }
    });

    // Sauvegarder la dernière section dans sessionStorage
    sessionStorage.setItem("lastActiveSection", sectionName);
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
});
