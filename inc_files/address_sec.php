    <style>
        /* General Styles */
        /* body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        } */

        /* Brands Section */
        .brands-section {
            background-color: white;
            padding: 40px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .brands-container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .brand-logo {
            height: 80px;
            max-width: 100px;
            object-fit: contain;
        }

        /* Footer Section */
        .footer-section {
            background-color: #000;
            color: white;
            padding: 40px 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 30px;
        }

        .footer-column {
            flex: 1;
            text-align: center;
            min-width: 200px;
        }

        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .footer-column p,
        .footer-column a {
            font-size: 16px;
            color: #aaa;
            text-decoration: none;
        }

        .footer-column a:hover {
            text-decoration: underline;
        }

        /* Sticky WhatsApp and Up Button */
        .sticky-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .sticky-buttons a {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: #25d366;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            color: white;
            font-size: 24px;
            text-decoration: none;
        }

        .sticky-buttons a.up-btn {
            background-color: #333;
        }

        .sticky-buttons a:hover {
            opacity: 0.8;
        }
    </style>

<!-- Brands Section -->
<section class="brands-section">
    <div class="brands-container">
        <img src="https://via.placeholder.com/100x80" alt="Taparia" class="brand-logo">
        <img src="https://via.placeholder.com/100x80" alt="Freemans" class="brand-logo">
        <img src="https://via.placeholder.com/100x80" alt="Bipico" class="brand-logo">
        <img src="https://via.placeholder.com/100x80" alt="IT" class="brand-logo">
        <img src="https://via.placeholder.com/100x80" alt="Jhalani" class="brand-logo">
        <img src="https://via.placeholder.com/100x80" alt="Ozar" class="brand-logo">
    </div>
</section>

<!-- Footer Section -->
<footer class="footer-section">
    <div class="footer-column">
        <h3>Open Hours</h3>
        <p>Mon-Fri: 9 AM – 6 PM</p>
        <p>Saturday: 9 AM – 5 PM</p>
        <p>Sunday: Closed</p>
    </div>
    <div class="footer-column">
        <h3>Address</h3>
        <p>34, Netaji Subhas Road</p>
        <p>Kolkata – 700 01</p>
        <a href="#">Check Location</a>
    </div>
    <div class="footer-column">
        <h3>Get in Touch</h3>
        <p>Telephone: +033 - 71342693</p>
        <p>Email: <a href="mailto:efht52@gmail.com">efht52@gmail.com</a></p>
        <a href="#">Contact Form</a>
    </div>
</footer>

<!-- Sticky Buttons -->
<div class="sticky-buttons">
    <a href="https://wa.me/+1234567890" target="_blank" title="WhatsApp">
        <span>&#128172;</span>
    </a>
    <a href="#top" class="up-btn" title="Back to Top">
        <span>&uarr;</span>
    </a>
</div>

