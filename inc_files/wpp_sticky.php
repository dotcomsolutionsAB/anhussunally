
<style>
    /* Sticky Buttons */
    .sticky-buttons {
        position: fixed; /* Keeps the button fixed to the viewport */
        
        left: 20px; /* Distance from the left of the viewport */
        z-index: 10000; /* Ensures it stays above all other elements */
        pointer-events: auto; /* Ensures the button is clickable */
    }

    .whatsapp-btn {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .whatsapp-btn img {
        width: 60px; /* Default size */
        height: 60px;
        border-radius: 50%;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        pointer-events: none; /* Prevents interaction issues */
    }

    .whatsapp-btn img:hover {
        opacity: 0.8;
        transform: scale(1.1); /* Slightly enlarge on hover */
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .whatsapp-btn img {
            width: 50px; /* Smaller size for mobile */
            height: 50px;
        }

        .sticky-buttons {
        left: 10px;
        }
    }
</style>

<!-- Sticky Buttons -->
<div class="sticky-buttons">
    <div class="whatsapp-btn">
        <a href="https://wa.me/+1234567890" target="_blank" title="WhatsApp">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
        </a>
    </div>
</div>