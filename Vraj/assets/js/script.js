// C:\xampp\htdocs\web_technologies\assets\js\script.js
function validateLogin() {
    const username = document.forms["login"]["username"].value;
    const password = document.forms["login"]["password"].value;
    if (username.length < 3) {
        alert("Username must be at least 3 characters.");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters.");
        return false;
    }
    return true;
}

function validateSignup() {
    const username = document.forms["signup"]["username"].value;
    const fullName = document.forms["signup"]["full_name"].value;
    const email = document.forms["signup"]["email"].value;
    const password = document.forms["signup"]["password"].value;
    if (username.length < 3) {
        alert("Username must be at least 3 characters.");
        return false;
    }
    if (fullName.length < 2) {
        alert("Full name must be at least 2 characters.");
        return false;
    }
    if (!email.includes("@")) {
        alert("Please enter a valid email.");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters.");
        return false;
    }
    return true;
}

function validatePaymentForm() {
    const cardNumber = document.getElementById("card_number").value.replace(/\s/g, '');
    const cardHolder = document.getElementById("card_holder").value;
    const expiry = document.getElementById("expiry").value;
    const cvv = document.getElementById("cvv").value;

    if (!/^\d{16}$/.test(cardNumber)) {
        alert("Card number must be 16 digits.");
        return false;
    }
    if (!/^[A-Za-z\s]+$/.test(cardHolder)) {
        alert("Card holder name must contain only letters and spaces.");
        return false;
    }
    if (!/^(0[1-9]|1[0-2])\/[0-9]{2}$/.test(expiry)) {
        alert("Expiry date must be in MM/YY format.");
        return false;
    }
    const [expMonth, expYear] = expiry.split('/');
    const currentYear = new Date().getFullYear() % 100;
    const currentMonth = new Date().getMonth() + 1;
    if (parseInt(expYear) < currentYear || (parseInt(expYear) == currentYear && parseInt(expMonth) < currentMonth)) {
        alert("Card has expired.");
        return false;
    }
    if (!/^\d{3,4}$/.test(cvv)) {
        alert("CVV must be 3 or 4 digits.");
        return false;
    }
    return true;
}