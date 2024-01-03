const ADMIN_PATH = `${SERVER_IP}/controller/admin`;

const loginAdmin = async (username, password) => {
    const response = await fetch(`${ADMIN_PATH}/login.php?username=${username}&password=${password}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'text/plain',
        },
    });

    return await response.json();
}