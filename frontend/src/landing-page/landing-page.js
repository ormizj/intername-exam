const errorMessageEl = document.getElementById('error-message');
const form = document.getElementsByClassName('contact-form')[0]; // getting element by className to avoid refactoring css, because there are duplicate id's in the template with the id of: "contact"
const nameInput = document.getElementById('name');
const surnameInput = document.getElementById('surname');
const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');
const messageInput = document.getElementById('message');
const referrer = document.referrer;
let ip;

document.getElementById('form-submit').addEventListener('click', async (event) => {
    // check form validity before making any requests
    if (!form.checkValidity()) return;
    event.preventDefault();

    // if ip was never checked
    if (!ip) {
        ip = await getUserPublicIp();

        // if was unable to get ip from the api
        if (!ip) {
            addErrorMessage('Failed to resolve your public IP, try again later');
            return;
        }
    }

    const lead = {};
    lead.ip = ip;
    lead.firstName = nameInput.value;
    lead.lastName = surnameInput.value;
    lead.email = emailInput.value;
    lead.phoneNumber = phoneInput.value;
    lead.note = messageInput.value;
    lead.sub1 = document.referrer; // added referrer here, to track what site the user got redirected from

    // couldn't find other ways to get client location without an external API
    // could've used "Intl.DateTimeFormat().resolvedOptions().timeZone;" but the result will be less accurate
    lead.country = getCountry() ?? 'Unknown';

    // modal handled inside
    if (!await submitLead(lead)) return;

    // if successful, reset form
    form.reset();
});

const submitLead = async (lead) => {
    try {
        const res = await createLead(lead);

        if (!res.success) {
            addErrorMessage(errMsg[res.data]);
            return false;
        }

        clearErrorMessage();
        const msg = `Thank you ${lead.firstName} ${lead.lastName}, we’ll contact you soon`;
        openInfoModal(msg, true);
        return true;

    } catch (error) {
        addErrorMessage(errMsg['INT-000']);
        return false;
    }
}

const addErrorMessage = (message) => {
    errorMessageEl.textContent = message;
}

const clearErrorMessage = () => {
    errorMessageEl.textContent = '';
}

document.getElementById('back-office-button').addEventListener('click', async () => {
    openLoginModal('Login to an Admin account to continue', async (username, password) => {
        const res = await loginAdmin(username, password);

        if (!res.success) {
            openInfoModal(errMsg[res.data], false);
            return false;
        }

        // redirect to the back-office if login successful (there isn't protection against manual redirect)
        window.location.href = 'pages/back-office.html';
    });
});
