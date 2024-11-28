
<style>
      /* Container for the input box */
      .search-input-box {
          position: relative;
          display: flex;
          align-items: center;
          background-color: #ffeb3b; /* Yellow background */
          padding: 5px;
          border-radius: 25px; /* Rounded corners */
          width: 300px; /* Adjust the width */
          transition: width 0.3s ease;
      }

      /* Input field styling */
      .search-input-box input {
          width: 100%;
          padding: 8px 35px 8px 12px; /* Added extra padding to the right to accommodate the clear icon */
          font-size: 14px;
          border: 1px solid #d1d1d1;
          border-radius: 25px;
          outline: none;
          background-color: transparent;
          color: #333;
      }

      /* Search Icon */
      .search-input-box svg {
          position: absolute;
          right: 30px; /* Position the search icon slightly to the left */
          fill: #b5b5bf;
          cursor: pointer;
          transition: fill 0.3s ease;
          pointer-events: none; /* Prevent icon from blocking input click */
      }

      /* Cross (clear) Icon */
      .search-input-box .clear-icon {
          position: absolute;
          right: 10px; /* Place the cross button 10px from the right edge */
          fill: #b5b5bf;
          cursor: pointer;
          visibility: hidden; /* Hidden by default */
      }

      /* Show cross icon when there's text in the input */
      .search-input-box input:not(:placeholder-shown) ~ .clear-icon {
          visibility: visible;
      }

      /* Hover effect for the icons */
      .search-input-box svg:hover,
      .search-input-box .clear-icon:hover {
          fill: #ff9800; /* Change color on hover */
      }

      /* Input focus state */
      .search-input-box input:focus {
          border-color: #ff9800;
      }

      /* Focus effect for search icon */
      .search-input-box svg:hover {
          fill: #ff9800;
      }           
      #search-results {
            margin-top: 10px;
            max-height: 200px;
            overflow-y: auto;
            width: 30vw;  /* Set the width to 30% of the viewport width */
        }

        .search-result-item {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            display: flex;
            align-items: center;
            cursor: pointer;  /* Show pointer cursor on hover */
        }

        .search-result-item img {
            margin-right: 10px;
        }

        .search-result-item p {
            margin: 0;
            padding: 0;
        }

        .search-result-item strong {
            font-size: 14px;
        }

        #search-results p {
            color: #888;
        }

</style>

<div class="search-input-box">
    <input type="text" class="border border-soft-light form-control fs-14 hov-animate-outline" id="search" name="keyword" placeholder="I am shopping for..." autocomplete="off">
    <svg id="Group_723" data-name="Group 723" xmlns="http://www.w3.org/2000/svg" width="20.001" height="20" viewBox="0 0 20.001 20">
        <path id="Path_3090" data-name="Path 3090" d="M9.847,17.839a7.993,7.993,0,1,1,7.993-7.993A8,8,0,0,1,9.847,17.839Zm0-14.387a6.394,6.394,0,1,0,6.394,6.394A6.4,6.4,0,0,0,9.847,3.453Z" transform="translate(-1.854 -1.854)" fill="#b5b5bf"></path>
        <path id="Path_3091" data-name="Path 3091" d="M24.4,25.2a.8.8,0,0,1-.565-.234l-6.15-6.15a.8.8,0,0,1,1.13-1.13l6.15,6.15A.8.8,0,0,1,24.4,25.2Z" transform="translate(-5.2 -5.2)" fill="#b5b5bf"></path>
    </svg>

    <!-- Clear Icon -->
    <svg class="clear-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14">
        <path d="M7 0C3.141 0 0 3.141 0 7s3.141 7 7 7 7-3.141 7-7-3.141-7-7-7zM7 13C3.686 13 1 10.314 1 7S3.686 1 7 1s6 3.686 6 6-3.686 6-6 6z"/>
        <path d="M9.293 4.707l-2.586 2.586-2.586-2.586-1.414 1.414 2.586 2.586-2.586 2.586 1.414 1.414 2.586-2.586 2.586 2.586 1.414-1.414-2.586-2.586 2.586-2.586z"/>
    </svg>
</div>

<div id="search-results"></div>


<script>

    document.getElementById('search').addEventListener('input', function() {
    const searchQuery = this.value;

        // Only trigger search if the query has at least 3 characters
        if (searchQuery.length >= 3) {
            // Perform the AJAX request
            fetch(`search_api.php?search=${encodeURIComponent(searchQuery)}`)
                .then(response => response.json())
                .then(data => {
                    const resultsContainer = document.getElementById('search-results');
                    resultsContainer.innerHTML = ''; // Clear previous results

                    if (data.length > 0) {
                        data.forEach(product => {
                            const resultItem = document.createElement('div');
                            resultItem.classList.add('search-result-item');
                            resultItem.innerHTML = `
                                <img src="${product.image_url}" alt="${product.name}" width="50" height="50">
                                <p><strong>${product.name}</strong></p>
                                <p>SKU: ${product.sku}</p>
                                
                            `;
                            
                            // Add click event to each result item
                            resultItem.addEventListener('click', function() {
                                window.location.href = `product_detail.php?sku=${product.sku}`;
                            });

                            resultsContainer.appendChild(resultItem);
                        });
                    } else {
                        resultsContainer.innerHTML = '<p>No results found.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    alert('There was an error with the search. Please try again later.');
                });
        }
    });

</script>

