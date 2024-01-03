const createLead = async (lead) => {
    const response = await fetch(`${LEADS_PATH}/create-lead.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'text/plain',
        },
        body: JSON.stringify(lead),
    });

    return await response.json();
}

const getAllLeads = async () => {
    const response = await fetch(`${LEADS_PATH}/get-all-leads.php`, {
        method: 'GET',
        headers: {
            'Content-Type': 'text/plain',
        },
    });

    return await response.json();
}

const getLeadById = async (id) => {
    const response = await fetch(`${LEADS_PATH}/get-lead-by-id.php?id=${id}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'text/plain',
        },
    });

    return await response.json();
}

const getLeadsByFilter = async (isCalled = '', isCreatedToday = '', country = '') => {
    let filters = '';
    if (!isStringEmpty(isCalled)) filters += `isCalled=${isCalled}&`;
    if (!isStringEmpty(isCreatedToday)) filters += `isCreatedToday=${isCreatedToday}&`;
    if (!isStringEmpty(country)) filters += `country=${country}&`;
    filters.slice(0, -1);

    const response = await fetch(`${LEADS_PATH}/get-leads-by-filter.php?${filters}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'text/plain',
        },
    });

    return await response.json();
}

const markLeadAsCalled = async (id) => {

    const response = await fetch(`${LEADS_PATH}/mark-lead-as-called.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'text/plain',
        },
        body: JSON.stringify({ id: id }),
    });

    return await response.json();
}