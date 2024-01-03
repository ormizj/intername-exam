const loginModalHtml = `
<div class="modal-background"></div>
<div class="modal-container">
  <section class="modal-text-container">
    <p id="modal-text"></p>
  </section>
  <form>
    <label class="username-label" for="username-input">Username</label> <input id="username-input" name="username-input"/>
    <label class="password-label" for="password-input">Password</label> <input id="password-input" name="password-input"/>
  </form>
  <div class="modal-button-container">
    <button type="submit" id="modal-button-accept" class="modal-button">Login</button>
    <button id="modal-button-cancel" class="modal-button">Cancel</button>
  </div>
</div>
`;

const openLoginModal = (message, loginCb, cancelCb) => {
  modalTeleportElement.innerHTML = loginModalHtml;

  const loginCbHelper = (event) => {
    event.preventDefault();
    const username = document.getElementById('username-input').value;
    const password = document.getElementById('password-input').value;

    loginCb(username, password);
  }

  document.getElementById('modal-text').textContent = message;
  document.getElementById('modal-button-accept').addEventListener('click', loginCbHelper);
  document.getElementById('modal-button-accept').addEventListener('click', closeLoginModal);
  document.getElementById('modal-button-cancel').addEventListener('click', cancelCb);
  document.getElementById('modal-button-cancel').addEventListener('click', closeLoginModal);
}

const closeLoginModal = () => {
  modalTeleportElement.innerHTML = '';
}