<div class="stats-section">
  <div class="stat-item">
    <h1 class="stat-number">98</h1>
    <p class="stat-label">PROJECTS</p>
  </div>
  <div class="divider"></div>
  <div class="stat-item">
    <h1 class="stat-number">65</h1>
    <p class="stat-label">PEOPLE</p>
  </div>
  <div class="divider"></div>
  <div class="stat-item">
    <h1 class="stat-number">15</h1>
    <p class="stat-label">YEARS</p>
  </div>
  <div class="divider"></div>
  <div class="stat-item">
    <h1 class="stat-number">15</h1>
    <p class="stat-label">OFFICES</p>
  </div>
</div>
<style>
  .stats-section {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 10px 60px;
    background: #ffffff; /* Section background color */
  }

  .stat-item {
    text-align: center;
    margin: 0 20px; /* Spacing between stat items */
  }

  .stat-number {
    font-size: 140px;
    font-family: 'Oswald';
    font-weight: 700;
    color: rgba(0, 0, 0, 0.1); /* Light gray number */
    margin: 0;
  }

  .stat-label {
    font-size: 22px;
    font-weight: 600;
    color: #000;
    text-transform: uppercase;
    margin: -85px 0 0;
  }

  .divider {
    width: 1px;
    height: 143px;
    background: #ddd;
    margin: 0 0px;
    margin-top: 50px;
  }

  /* Media Queries for Mobile Devices */

/* Tablet Devices (up to 1024px) */
@media (max-width: 1024px) {
  .stats-section {
    padding: 10px 30px;
  }

  .stat-item {
    width: 45%; /* 2 items per row */
    margin: 10px 0;
  }

  .stat-number {
    font-size: 100px; /* Adjust number size for tablets */
  }

  .stat-label {
    font-size: 18px; /* Adjust label size for tablets */
    margin-top: -50px;
  }

  .divider {
    width: 60px;
    height: 1px;
    margin-top: 20px;
  }
}

/* Mobile Devices (up to 768px) */
@media (max-width: 768px) {
  .stats-section {
    flex-direction: column; /* Stack the stat items vertically */
    padding: 10px; /* Adjust padding */
    align-items: center; /* Center the items */
  }

  .stat-item {
    width: 80%; /* Adjust width for mobile (1 item per row) */
    margin: 10px 0;
  }

  .stat-number {
    font-size: 80px; /* Adjust number size for mobile */
  }

  .stat-label {
    font-size: 16px; /* Adjust label size for mobile */
    margin-top: -40px; /* Adjust label margin */
  }

  .divider {
    display: none; /* Hide dividers on mobile */
  }
}

/* Small Mobile Devices (up to 480px) */
@media (max-width: 480px) {
  .stat-number {
    font-size: 60px; /* Further reduce number size */
  }

  .stat-label {
    font-size: 14px; /* Further reduce label size */
    margin-top: -30px; /* Adjust label margin */
  }
  .stat-item {
    width: 40%; /* Adjust width for mobile (1 item per row) */
    margin: 10px 0;
  }

}

</style>


