const confirmModalHtml = `
<div class="modal-background"></div>
<div class="modal-container">
  <section class="modal-text-container">
    <p id="modal-resolution">Alert!</p>
    <p id="modal-text"></p>
  </section>
  <div class="modal-button-container">
    <button id="modal-button-accept" class="modal-button">Accept</button>
    <button id="modal-button-cancel" class="modal-button">Cancel</button>
  </div>
</div>
`;

const openConfirmModal = (message, acceptCb, cancelCb) => {
    modalTeleportElement.innerHTML = confirmModalHtml;

    document.getElementById('modal-text').textContent = message;
    document.getElementById('modal-button-accept').addEventListener('click', acceptCb);
    document.getElementById('modal-button-accept').addEventListener('click', closeConfirmModal);
    document.getElementById('modal-button-cancel').addEventListener('click', cancelCb);
    document.getElementById('modal-button-cancel').addEventListener('click', closeConfirmModal);
}

const closeConfirmModal = () => {
    modalTeleportElement.innerHTML = '';
}