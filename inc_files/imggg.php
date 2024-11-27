<style>
        .image-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
            max-width: 1200px;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .image-section img {
            width: 100%;
            height: 200px; /* Adjusted height for a wide, flat layout */
            object-fit: cover; /* Ensures the image is cropped to fit the container */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-section img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .image-section {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        @media (max-width: 480px) {
            .image-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <div class="image-section">
        <img src="../images/imggg1.jpg" alt="Image 1">
        <img src="../images/imggg2.jpg" alt="Image 2">
        <img src="../images/imggg3.jpg" alt="Image 3">
    </div>