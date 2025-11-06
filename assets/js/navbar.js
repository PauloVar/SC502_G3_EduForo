function setupDropdownActions() {
  const logoutLinks = document.querySelectorAll('[data-action="logout"]');

  logoutLinks.forEach((link) => {
    link.addEventListener('click', (event) => {
      event.preventDefault();

      if (typeof Swal === 'undefined') {
        window.location.href = 'login.html';
        return;
      }

      Swal.fire({
        icon: 'success',
        title: 'Sesión cerrada con éxito',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#0d6efd',
      }).then(() => {
        window.location.href = 'login.html';
      });
    });
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', setupDropdownActions);
} else {
  setupDropdownActions();
}