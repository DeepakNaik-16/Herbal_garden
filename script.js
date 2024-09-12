document.getElementById('loginForm').addEventListener('submit', function (event) {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (!email || !password) {
        event.preventDefault();
        document.getElementById('error-msg').textContent = 'Please fill in both fields';
    }
});
