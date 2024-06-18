document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault();
    registerUser();
});

function registerUser() {
    const first_name = document.getElementById('first_name').value;
    const last_name = document.getElementById('last_name').value;
    const email = document.getElementById('email').value;
    const pwd = document.getElementById('pwd').value;
    const messageElement = document.getElementById('message');

    // Validate required fields
    if (!first_name || !last_name || !email || !pwd) {
        messageElement.textContent = 'All fields are required!';
        return;
    }

    const data = {
        first_name,
        last_name,
        email,
        pwd,
    };

    console.log('Data being sent:', data);

    // Send data to server
    fetch('http://localhost/RentACar-SoftwareEngineering/backend/api/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.text())  // First convert to text
    .then(text => {
        try {
            // Try to parse it as JSON
            const data = JSON.parse(text);
            if (data.error) {
                throw new Error(data.error);
            }
            messageElement.textContent = 'Registration successful!';
            console.log(data);
        } catch (error) {
            // If parsing fails, it's likely HTML
            console.error("Received HTML response from the server: ", text);
            messageElement.textContent = 'Server error occurred. Please check the console for more details.';
        }
    })
    .catch(error => {
        console.error('Fetch error:', error.message);
        messageElement.textContent = `Error: ${error.message}`;
    });
    
}