// js/script.js

// Utility function to select elements
const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);

// Form Validation for Login, Signup, Forgot Password, Contact, and Profile Forms
function validateForm(formId) {
    const form = $(`#${formId}`);
    if (!form) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const inputs = form.querySelectorAll('input, textarea');
        let isValid = true;

        inputs.forEach((input) => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = 'red';
            } else {
                input.style.borderColor = '#ddd';
            }

            // Email validation
            if (input.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
                isValid = false;
                input.style.borderColor = 'red';
            }

            // Password validation (minimum 6 characters)
            if (input.type === 'password' && input.value.length < 6) {
                isValid = false;
                input.style.borderColor = 'red';
            }
        });

        if (isValid) {
            alert('Form submitted successfully!');
            form.reset();
        } else {
            alert('Please fill in all required fields correctly.');
        }
    });
}

// Search Functionality for Courses Page
function initSearch() {
    const searchBar = $('#search-bar');
    const filter = $('#filter');
    if (!searchBar || !filter) return;

    searchBar.addEventListener('input', () => {
        const searchTerm = searchBar.value.toLowerCase();
        const selectedCategory = filter.value;
        const courseCards = $$('.course-card');

        courseCards.forEach((card) => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = selectedCategory === '' || card.dataset.category === selectedCategory;

            if (matchesSearch && matchesCategory) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    filter.addEventListener('change', () => {
        const searchTerm = searchBar.value.toLowerCase();
        const selectedCategory = filter.value;
        const courseCards = $$('.course-card');

        courseCards.forEach((card) => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = selectedCategory === '' || card.dataset.category === selectedCategory;

            if (matchesSearch && matchesCategory) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

// Add to Cart Functionality
function initAddToCart() {
    const addToCartButtons = $$('.btn[href="cart.html"]');
    addToCartButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const courseCard = button.closest('.course-card');
            const courseName = courseCard.querySelector('h3').textContent;
            const coursePrice = courseCard.querySelector('.price').textContent;

            // Simulate adding to cart (you can use localStorage or a backend API)
            const cartItem = { name: courseName, price: coursePrice };
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push(cartItem);
            localStorage.setItem('cart', JSON.stringify(cart));

            alert(`${courseName} has been added to your cart!`);
            window.location.href = 'cart.html';
        });
    });
}

// Cart Page: Display and Remove Items
function initCart() {
    if (window.location.pathname.includes('cart.html')) {
        const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
        const cartContainer = $('.cart');
        if (!cartContainer) return;

        cartItems.forEach((item, index) => {
            const cartItem = document.createElement('div');
            cartItem.className = 'cart-item';
            cartItem.innerHTML = `
                
${item.name}

                ${item.price}
                Remove
            `;
            cartContainer.insertBefore(cartItem, $('.cart-total'));
        });

        const total = cartItems.reduce((sum, item) => sum + parseFloat(item.price.replace('$', '')), 0);
        $('.cart-total h3').textContent = `Total: $${total.toFixed(2)}`;

        const removeButtons = $$('.cart-item .btn');
        removeButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const index = button.dataset.index;
                cartItems.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cartItems));
                window.location.reload();
            });
        });
    }
}

// Checkout Form Validation
function initCheckout() {
    if (window.location.pathname.includes('checkout.html')) {
        const paymentForm = $('#payment-form');
        if (!paymentForm) return;

        paymentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const cardNumber = $('#card-number').value;
            const expiry = $('#expiry').value;
            const cvv = $('#cvv').value;

            if (cardNumber.length < 16 || !/^\d{2}\/\d{2}$/.test(expiry) || cvv.length < 3) {
                alert('Please enter valid payment details.');
                return;
            }

            // Simulate payment processing
            const success = Math.random() > 0.2; // 80% success rate for demo
            if (success) {
                localStorage.removeItem('cart');
                window.location.href = 'payment-success.html';
            } else {
                window.location.href = 'payment-failure.html';
            }
        });
    }
}

// Profile Update
function initProfile() {
    if (window.location.pathname.includes('profile.html')) {
        const profileForm = $('#profile-form');
        if (!profileForm) return;

        profileForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Profile updated successfully!');
        });
    }
}

// Initialize Functions on Page Load
document.addEventListener('DOMContentLoaded', () => {
    // Form validations
    validateForm('login-form');
    validateForm('signup-form');
    validateForm('forgot-password-form');
    validateForm('contact-form');
    validateForm('profile-form');
    validateForm('admin-login-form');

    // Search functionality
    initSearch();

    // Cart functionality
    initAddToCart();
    initCart();

    // Checkout functionality
    initCheckout();

    // Profile functionality
    initProfile();
});