<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Construction Company</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <div class="logo">
                <h1>Construction Co.</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#projects">Projects</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <h2>Building Your Dreams</h2>
            <p>We provide top-notch construction services to bring your visions to life.</p>
            <a href="#contact" class="btn">Get in Touch</a>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <h2>Our Services</h2>
            <div class="service-item">
                <h3>Building Construction</h3>
                <p>High-quality construction services for residential and commercial projects.</p>
            </div>
            <div class="service-item">
                <h3>Architecture Design</h3>
                <p>Innovative and sustainable architectural designs tailored to your needs.</p>
            </div>
            <div class="service-item">
                <h3>Renovation</h3>
                <p>Expert renovation services to transform and modernize existing spaces.</p>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="projects">
        <div class="container">
            <h2>Our Projects</h2>
            <div class="project-item">
                <img src="project1.jpg" alt="Project 1">
                <h3>Residential Complex</h3>
            </div>
            <div class="project-item">
                <img src="project2.jpg" alt="Project 2">
                <h3>Office Building</h3>
            </div>
            <div class="project-item">
                <img src="project3.jpg" alt="Project 3">
                <h3>Shopping Mall</h3>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <h2>About Us</h2>
            <p>With over 20 years of experience, we are committed to delivering excellence in every project.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form id="contact-form">
                <input type="text" id="name" placeholder="Your Name" required>
                <input type="email" id="email" placeholder="Your Email" required>
                <textarea id="message" placeholder="Your Message" required></textarea>
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Construction Co. All rights reserved.</p>
        </div>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>