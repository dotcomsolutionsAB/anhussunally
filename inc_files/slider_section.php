<?php
    // Database configuration
    $host = 'localhost';
    $dbname = 'anh';
    $username = 'anh';
    $password = '9kCuzrb5tO53$xQtf';

    // Establish database connection
    $conn = mysqli_connect($host, $username, $password, $dbname);
?>
    <section class="slider__area">
        <div class="swiper slider-active">
            <div class="swiper-wrapper">
                <div class="swiper-slide slider__bg" data-background="../images/About_Us.png" style="display: flex; justify-content: center;
                            align-items: center;">
                    <style>
                        /* Full Page Section */
                        .flex {
                            position: relative;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            background:#fff;
                            background-image: url("images/About_Us.png");
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            color: white;
                            height: 100%; /* Full-screen height */
                            width: 100%;
                        }

                        .flex::before {
                            content: "";
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(0, 0, 0, 0.3); /* Light black overlay */
                            /* background-color: rgba(0, 0, 0, 0.5);  */
                            z-index: 1; /* Ensure overlay is behind content */
                        }

                        .flex > * {
                            position: relative;
                            z-index: 2; /* Bring content above the overlay */
                        }

                        /* Grid Layout */
                        .brand-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); /* Responsive grid */
                            gap: 20px; /* Space between cards */
                            max-width: 1300px;
                            padding: 40px;
                            width: 100%;
                        }

                        /* Brand Card */
                        .brand-card {
                            background: #ffffff;
                            /* border-radius: 12px; */
                            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            height: 110px;
                            transition: transform 0.3s ease, box-shadow 0.3s ease;
                            cursor: pointer;
                            overflow: hidden;
                            position: relative;
                            border: 4px solid #01406b;
                        }

                        .brand-card:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
                        }

                        /* Brand Logo */
                        .brand-logo {
                            max-width: 90%;
                            max-height: 90%;
                            transition: transform 0.3s ease;
                            /* border: 4px solid #01406b; */
                        }

                        .brand-card:hover .brand-logo {
                            transform: scale(1.1);
                        }

                        /* Responsive Text */
                        .flex h1 {
                            font-size: 36px;
                            text-align: center;
                            margin-bottom: 20px;
                        }

                        @media (max-width: 768px) {
                            .flex h1 {
                            font-size: 28px;
                            }

                            .brand-card {
                            height: 120px;
                            }
                        }
                        @media (max-width: 480px) {
                        .brand-card {
                            height: 70px;
                            width: 100px;
                        }

                        .brand-logo {
                            max-width: 100%;
                        }
                        .brand-grid {
                            grid-template-columns: 1fr 1fr 1fr;
                            gap: 15px;
                            padding: 25px;
                            width: 100%;
                        }
                        .flex {
                            height: 95vh !important;
                        }
                        }
                    </style>

                    <div class="flex">
                        <div class="brand-grid">
                        <?php
                            // Fetch brand data from the database
                            $brandsQuery = "SELECT id,name, logo, extension FROM brand";
                            $result = $conn->query($brandsQuery);

                            if ($result->num_rows > 0) {
                                while ($brand = $result->fetch_assoc()) {
                                    // Construct the logo path
                                    $logoPath = '../uploads/assets/logos/' . $brand['logo'] . '.' . $brand['extension'];
                        ?>
                            <a href="../brand-products.php?id=<?php echo htmlspecialchars($brand['id']); ?>">
                                <div class="brand-card">
                                    <img src="<?php echo htmlspecialchars($logoPath); ?>" alt="<?php echo htmlspecialchars($brand['name']); ?>" class="brand-logo">
                                </div>
                            </a>
                        <?php
                                }
                            } 
                        ?>                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>