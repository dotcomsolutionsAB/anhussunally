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
                        /* content: ""; */
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background:rgb(0,0,0,0.3);
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
                    <div class="brand-card"><img src="assets/images/ALFOMEGA.png" alt="Brand 1" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/Atos.png" alt="Brand 2" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/Bearing-Pullers.png" alt="Brand 3" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/HYDROLINE.png" alt="Brand 4" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/DOWTY.png" alt="Brand 5" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/DEMCON.png" alt="Brand 6" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/DOWTY.png" alt="Brand 7" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/EPE.jpg" alt="Brand 8" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/GEMELS1.png" alt="Brand 9" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/HAWE.png" alt="Brand 10" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/HYLOC.png" alt="Brand 11" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/POLYHYDR0N.png" alt="Brand 12" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/Positron-1.png" alt="Brand 13" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/REXROTH.png" alt="Brand 14" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/Spica.jpg" alt="Brand 15" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/Minitest.png" alt="Brand 16" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/VELJAN.png" alt="Brand 17" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/WIKAI.png" alt="Brand 18" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/Water-Test-Pump.png" alt="Brand 19" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/YUKEN.png" alt="Brand 20" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/VIP.png" alt="Brand 21" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/Hose-Crimping-Machine.png" alt="Brand 22" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/STAUFF.png" alt="Brand 23" class="brand-logo"></div>
                    <div class="brand-card"><img src="assets/images/WALVOIL.png" alt="Brand 24" class="brand-logo"></div>
                    </div>
                </div>
                </div>
                <!-- <div class="swiper-slide slider__bg" data-background="assets/img/slider/slider_bg02.jpg">
                    <div class="container custom-container-two">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="slider__content">
                                    <span class="sub-title">Founded in 1985</span>
                                    <h2 class="title">We Build That Everything
                                    Possible by Us!</h2>
                                    <a href="contact.html" class="btn">Learn More <img src="assets/img/icons/right_arrow.svg" alt="" class="injectable"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide slider__bg" data-background="https://anh.ongoingwp.xyz/images/About_Us.png">
                    <div class="container custom-container-two">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="slider__content">
                                    <span class="sub-title">Founded in 1985</span>
                                    <h2 class="title">We Build That Everything
                                    Possible by Us!</h2>
                                    <a href="contact.html" class="btn">Learn More <img src="assets/img/icons/right_arrow.svg" alt="" class="injectable"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>