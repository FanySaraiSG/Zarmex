document.addEventListener("DOMContentLoaded", () => {
  const openBtn  = document.getElementById("openMenu");
  const closeBtn = document.getElementById("closeMenu");
  const menu     = document.getElementById("sideMenu");

  if (!openBtn || !closeBtn || !menu) return;

  const openMenu = () => {
    menu.classList.add("open");
    menu.setAttribute("aria-hidden", "false");
  };

  const closeMenu = () => {
    menu.classList.remove("open");
    menu.setAttribute("aria-hidden", "true");
  };

  openBtn.addEventListener("click", openMenu);
  closeBtn.addEventListener("click", closeMenu);

  // cerrar con ESC
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeMenu();
  });
});
