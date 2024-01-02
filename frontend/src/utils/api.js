const getUserPublicIp = async () => {
    try {
        const response = await fetch('https://api.ipify.org');
        const data = await response.text();
        return data;

    } catch (error) {
        console.error('Error fetching IP address:', error);
        return null;
    }
};

