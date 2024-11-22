
<style>
        /* Footer Section */
        .footer-section {
            background-color: #000;
            color: white;
            padding: 60px 20px;
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
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .footer-column p,
        .footer-column a {
            font-size: 18px;
            color: #aaa;
            text-decoration: none;
        }

        .footer-column a:hover {
            color: white;
            text-decoration: underline;
        }

        .icon-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
        }

        .icon-wrapper i {
            font-size: 80px;
            color: #fff;
        }

        /* Sticky WhatsApp and Up Button */
        .sticky-buttons {
            position: fixed;
            bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .sticky-buttons .whatsapp-btn {
            left: 20px;
        }

        .sticky-buttons .up-btn {
            right: 20px;
        }

        .sticky-buttons a {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            color: white;
            font-size: 24px;
            text-decoration: none;
        }

        .sticky-buttons .whatsapp-btn a {
            background-color: #25d366;
        }

        .sticky-buttons .up-btn a {
            background-color: #333;
        }

        .sticky-buttons a:hover {
            opacity: 0.8;
        }
    </style>
    <style>
    .brand-section {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
                gap: 20px;
                padding: 50px;
                background-color: #fff;
            }

            .brand-item {
                position: relative;
                perspective: 1000px;
                width: 200px;
                height: 200px;
                transform-style: preserve-3d;
                transition: transform 0.5s ease;
            }

            .brand-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 10px;
                box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            }

            /* Hover Effect with 3D Animation */
            .brand-item:hover {
                transform: rotateY(10deg) rotateX(10deg) scale(1.1);
            }

            .brand-name {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: rgba(0, 0, 0, 0.6);
                color: #fff;
                font-size: 18px;
                font-weight: bold;
                opacity: 0;
                border-radius: 10px;
                transition: opacity 0.3s ease;
            }

            .brand-item:hover .brand-name {
                opacity: 1;
            }
    </style> 
    <!-- <section class="brand-section" id="brand-section">
        
    </section> -->

    <script>
        const brands = [
            { name: "Brand 1", img: "https://picsum.photos/300/200?random=1" },
            { name: "Brand 2", img: "https://picsum.photos/250/250?random=2" },
            { name: "Brand 3", img: "https://picsum.photos/220/180?random=3" },
            { name: "Brand 4", img: "https://picsum.photos/270/200?random=4" },
            { name: "Brand 5", img: "https://picsum.photos/300/300?random=5" },
            { name: "Brand 6", img: "https://picsum.photos/280/240?random=6" },
            { name: "Brand 7", img: "https://picsum.photos/240/210?random=7" },
            { name: "Brand 8", img: "https://picsum.photos/260/230?random=8" },
            { name: "Brand 9", img: "https://picsum.photos/200/250?random=9" },
            { name: "Brand 10", img: "https://picsum.photos/230/270?random=10" },
        ];

        const brandSection = document.getElementById("brand-section");

        // Randomly shuffle the brand array
        const shuffledBrands = brands.sort(() => 0.5 - Math.random());

        // Display only 5 random brands
        shuffledBrands.slice(0, 5).forEach((brand) => {
            const brandItem = document.createElement("div");
            brandItem.classList.add("brand-item");
            brandItem.innerHTML = `
                <img src="${brand.img}" alt="${brand.name}">
                <div class="brand-name">${brand.name}</div>
            `;
            brandSection.appendChild(brandItem);
        });
    </script>
    <!-- Address Section -->
    <section class="footer-section">
		<div class="footer-column">
            <div class="icon-wrapper">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
            </div>
            <h3>Open Hours</h3>
            <p>Mon-Fri: 9 AM – 6 PM</p>
            <p>Saturday: 9 AM – 5 PM</p>
            <p>Sunday: Closed</p>
        </div>
        <div class="footer-column">
            <div class="icon-wrapper">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
            </div>
            <h3>Address</h3>
            <p>34, Netaji Subhas Road</p>
            <p>Kolkata – 700 01</p>
            <a href="#">Check Location</a>
        </div>
        <div class="footer-column">
            <div class="icon-wrapper">
                <i class="fa fa-phone" aria-hidden="true"></i>
            </div>
            <h3>Get in Touch</h3>
            <p>Telephone: +033 - 71342693</p>
            <p>Email: <a href="mailto:efht52@gmail.com">efht52@gmail.com</a></p>
            <a href="#">Contact Form</a>
        </div>
    </section>

    <!-- Sticky Buttons -->
    <div class="sticky-buttons">
        <div class="whatsapp-btn">
            <a href="https://wa.me/+1234567890" target="_blank" title="WhatsApp">&#128172;</a>
        </div>
    </div>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

