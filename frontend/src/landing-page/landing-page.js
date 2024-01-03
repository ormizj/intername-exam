const errorMessageEl = document.getElementById('error-message');
const form = document.getElementsByClassName('contact-form')[0]; // getting element by className to avoid refactoring css, because there are duplicate id's in the template with the id of: "contact"
const nameInput = document.getElementById('name');
const surnameInput = document.getElementById('surname');
const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');
const messageInput = document.getElementById('message');
const referrer = document.referrer;

document.getElementById('form-submit').addEventListener('click', async (event) => {
    // check form validity before making any requests
    if (!form.checkValidity()) return;
    event.preventDefault();

    const lead = {};

    const ip = await getUserPublicIp();
    if (!ip) {
        addErrorMessage('Failed to resolve your public IP, try again later');
        return;
    }

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
        const response = await fetch('http://localhost:8000/controller/leads/create-lead.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'text/plain',
            },
            body: JSON.stringify(lead),
        });

        if (!response.ok) {
            const result = await response.json();
            addErrorMessage(errMsg[result.data]);
            return false;
        }

        clearErrorMessage();
        const msg = `Thank you ${lead.firstName} ${lead.lastName}, we’ll contact you soon`;
        openModal(msg, true);
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
