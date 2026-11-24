document.addEventListener('DOMContentLoaded', () => {
  const checkIn = document.querySelector('#check_in');
  const checkOut = document.querySelector('#check_out');
  const guests = document.querySelector('#guests');
  const room = document.querySelector('#room_id');
  const total = document.querySelector('#estimated_total');
  const nightsText = document.querySelector('#nights_count');
  function calculate() {
    if (!checkIn || !checkOut || !room || !total) return;
    const start = new Date(checkIn.value + 'T00:00:00');
    const end = new Date(checkOut.value + 'T00:00:00');
    const nights = Math.round((end - start) / 86400000);
    const option = room.options[room.selectedIndex];
    const price = Number(option?.dataset.price || 0);
    if (nights > 0) {
      total.textContent = 'LKR ' + (nights * price).toLocaleString('en-US');
      if (nightsText) nightsText.textContent = nights + (nights === 1 ? ' night' : ' nights');
    } else {
      total.textContent = 'Select valid dates';
      if (nightsText) nightsText.textContent = '0 nights';
    }
  }
  [checkIn, checkOut, room, guests].forEach(el => el && el.addEventListener('change', calculate));
  if (checkIn && checkOut) {
    checkIn.addEventListener('change', () => { checkOut.min = checkIn.value; if(checkOut.value && checkOut.value <= checkIn.value) checkOut.value=''; calculate(); });
    checkOut.min = checkIn.value || new Date().toISOString().split('T')[0];
  }
  calculate();

  document.querySelectorAll('form[data-validate="true"]').forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) { event.preventDefault(); form.reportValidity(); }
    });
  });
});


// Gallery lightbox
document.addEventListener('DOMContentLoaded', () => {
  const dialog = document.getElementById('galleryDialog');
  if (!dialog) return;
  const preview = document.getElementById('galleryPreview');
  const title = document.getElementById('galleryTitle');
  document.querySelectorAll('.gallery-item').forEach(item => {
    item.addEventListener('click', () => {
      preview.src = item.dataset.full;
      preview.alt = item.dataset.title || 'Gallery image';
      title.textContent = item.dataset.title || '';
      dialog.showModal();
    });
  });
  dialog.querySelector('.gallery-close').addEventListener('click', () => dialog.close());
  dialog.addEventListener('click', event => { if (event.target === dialog) dialog.close(); });
});
