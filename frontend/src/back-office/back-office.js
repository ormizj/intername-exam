const tableBodyEl = document.getElementById('table-body');
const filterForm = document.getElementById('filter-form');
const calledInput = document.getElementById('called-input');
const createdTodayInput = document.getElementById('created-today-input');
const countryInput = document.getElementById('country-input');

const pageInit = async () => {
    await fillTableWithAllLeads();
}

const fillTableWithAllLeads = async () => {
    const res = await getAllLeads();
    const leads = res.data;

    if (!res.success) {
        openInfoModal(errMsg[res.data], false);
        return false;
    }

    fillLeadsTable(leads)
}

const fillLeadsTable = (leads) => {
    tableBodyEl.innerHTML = '';
    let newTableBody = '';

    if (leads.length === 0) return openInfoModal('No leads found!', false);

    for (const lead of leads) {
        const leadRow = getLeadRowHtml(lead);
        newTableBody = leadRow + newTableBody;
    }

    tableBodyEl.innerHTML = newTableBody;
    addCallLeadEvent();
}

const getLeadRowHtml = (lead) => {
    const leadRowHtml = `
    <tr class="${lead.called ? 'called' : 'not-called'}" lead-id="${lead.id}" id=lead-${lead.id}>
        <th scope="row" class="center">${lead.id}</th>
        <td>${lead.first_name}</td>
        <td>${lead.last_name}</td>
        <td>${lead.email}</td>
        <td>${lead.phone_number}</td>
        <td>${lead.country}</td>
        <td>${lead.created_at}</td>
        <td class="center">
            <button class="${lead.called ? 'called-lead' : 'uncalled-lead'}" id=lead-button-${lead.id}>
                ${lead.called ? 'Yes' : 'No'} 
            </button>
        </td>
    </tr>
    `

    return leadRowHtml;
}

const addCallLeadEvent = () => {
    const notCalledLeadsEl = document.getElementsByClassName('not-called');

    for (const notCalledLeadEl of notCalledLeadsEl) {
        const leadId = notCalledLeadEl.getAttribute('lead-id');
        const callButton = document.getElementById(`lead-button-${leadId}`);
        const buttonCb = () => callLead(leadId);
        callButton.addEventListener('click', buttonCb);
    }
}

const callLead = async (leadId) => {
    openConfirmModal('Are you sure you want to mark this lead as called?', async () => {
        const res = await markLeadAsCalled(leadId);

        if (!res.success) return openInfoModal(errMsg[res.data], false);

        openInfoModal('Lead marked as called successfully', true);
        changeLeadCalledStatusToCalled(leadId);
    })
}

const changeLeadCalledStatusToCalled = (leadId) => {
    const leadEl = document.getElementById(`lead-${leadId}`);
    leadEl.setAttribute('class', 'called');

    const leadButtonEl = document.getElementById(`lead-button-${leadId}`);
    leadButtonEl.setAttribute('class', 'called-lead');
    leadButtonEl.innerText = 'Yes';
}

document.getElementById('filter-form-submit').addEventListener('click', async (event) => {
    event.preventDefault();

    const called = calledInput.value;
    const createdToday = createdTodayInput.value;
    const country = countryInput.value;

    const res = await getLeadsByFilter(called, createdToday, country);

    if (!res.success) {
        openInfoModal(errMsg[res.data]);
        return false;
    }

    fillLeadsTable(res.data);
});

document.getElementById('filter-form-reset').addEventListener('click', async (event) => {
    await fillTableWithAllLeads();
});