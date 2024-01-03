const infoModalHtml = `
<div class="modal-background"></div>
<div class="modal-container">
  <section class="modal-text-container">
    <p id="modal-resolution">Success!</p>
    <p id="modal-text"></p>
  </section>
  <button id="modal-button" class="modal-button">Close</button>
</div>
`;

const openInfoModal = (message, isSuccess) => {
  modalTeleportElement.innerHTML = infoModalHtml;

  if (!isSuccess) {
    const resolutionEl = document.getElementById('modal-resolution');
    resolutionEl.setAttribute('class', 'failure');
    resolutionEl.textContent = 'Failure!';
  }

  document.getElementById('modal-text').textContent = message;
  document.getElementById('modal-button').addEventListener('click', closeInfoModal);
}

const closeInfoModal = () => {
  modalTeleportElement.innerHTML = '';
}