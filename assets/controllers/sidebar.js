document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");

    if (!toggle || !sidebar || !overlay) return;

    // Open sidebar
    toggle.addEventListener("click", function () {
        sidebar.classList.add("open");
        overlay.classList.add("active");
    });

    // close the sidebar (overlay)
    overlay.addEventListener("click", function () {
        sidebar.classList.remove("open");
        overlay.classList.remove("active");
    });
});