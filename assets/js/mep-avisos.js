document.getElementById('filtroMep').addEventListener('submit', function(e){
  e.preventDefault();
  const q = (document.getElementById('qMep').value || '').trim().toLowerCase();
  const tag = document.getElementById('tagMep').value;
  const cards = document.querySelectorAll('.mep-card');

  let visibles = 0;
  cards.forEach(card => {
    const title = card.querySelector('h5')?.textContent.toLowerCase() || '';
    const tags = card.getAttribute('data-tags') || '';
    const show = (q.length === 0 || title.includes(q)) && (tag === '' || tags.includes(tag));
    card.style.display = show ? '' : 'none';
    if (show) visibles++;
  });
  document.getElementById('sinResultados').style.display = (visibles === 0) ? '' : 'none';
});
