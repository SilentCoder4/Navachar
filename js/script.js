console.log("Navachar - Modern community platform loaded.");

document.addEventListener("DOMContentLoaded", () => {
    const userMenu = document.getElementById("user-menu");
    if (userMenu) {
      userMenu.style.cursor = "pointer";
      userMenu.addEventListener("click", () => {
        const logoutLink = document.getElementById("logout-link");
      });
    }
  });