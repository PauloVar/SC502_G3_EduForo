document.getElementById('btnMas').addEventListener('click', function(){
  const ocultos = document.querySelectorAll('.pub[data-visible="0"]');
  let revelados = 0;
  ocultos.forEach(card => {
    if (revelados < 4) {
      card.style.display = '';
      card.setAttribute('data-visible','1');
      revelados++;
    }
  });
  if (document.querySelectorAll('.pub[data-visible="0"]').length === 0) {
    this.disabled = true;
    this.textContent = 'No hay más publicaciones';
  }
});
