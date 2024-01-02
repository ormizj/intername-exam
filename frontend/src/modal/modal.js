const modalHtml = `
<div class="modal-background"></div>
<div class="modal-container">
  <section class="modal-text-container">
    <p id="modal-resolution">Success!</p>
    <p id="modal-text"></p>
  </section>
  <button id="modal-button">Close</button>
</div>
`;

const modalTeleportElement = document.getElementById('modal-teleport');

const openModal = (message, isSuccess) => {
    modalTeleportElement.innerHTML = modalHtml;

    if (!isSuccess) {
        const resolutionEl = document.getElementById('modal-resolution');
        resolutionEl.setAttribute('class', 'failure');
        resolutionEl.textContent = 'Failure!';
    }

    document.getElementById('modal-text').textContent = message;
    document.getElementById('modal-button').addEventListener('click', closeModal);
}

const closeModal = () => {
    modalTeleportElement.innerHTML = '';
}