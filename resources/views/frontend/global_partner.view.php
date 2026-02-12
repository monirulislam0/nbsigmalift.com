<?php 
    $route = "/about";
    template_include("/frontend/partials/header" ,compact('page','route'));
    template_include("/frontend/partials/banner",compact('page'));

?>
<style>
    /* Added title styling to match projects page */
    .page-title {
        font-size: 22px;
        font-weight: 600;
        color: #000000;
        border-bottom: 2px solid #0d6efd; /* Blue underline */
        padding-bottom: 10px;
        display: inline-block;
        margin-bottom: 15px;
        letter-spacing: 0.5px;
    }

    /* Existing custom dropdown styles */
    .custom-dropdown {
        position: relative;
        width: 300px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: white;
        cursor: pointer;
    }
    
    .dropdown-header {
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .dropdown-icon {
        font-size: 12px;
        transition: transform 0.3s;
    }
    
    .custom-dropdown.open .dropdown-icon {
        transform: rotate(180deg);
    }
    
    .dropdown-options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 4px 4px;
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .options-container {
        padding: 5px 0;
    }
    
    .region-group {
        margin-bottom: 5px;
    }
    
    .region-header {
        padding: 8px 15px;
        background-color: #f5f5f5;
        font-weight: bold;
        color: #333;
    }
    
    .country-option {
        padding: 8px 15px 8px 25px;
        transition: background-color 0.2s;
    }
    
    .country-option:hover {
        background-color: #f0f8ff;
    }
</style>

<div class="p-3"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" aria-orientation="vertical">
                <a class="nav-link " href="/about">About</a>
                <a class="nav-link" href="/why-choose-us">Why Choose Us</a>
                <a class="nav-link  " href="/factory-tours">Factory Tours</a>
                <a class="nav-link" href="/products">Products</a>
                <a class="nav-link active" href="/distributor">Distributor</a>
                <a class="nav-link" href="/projects">Projects</a>
                <a class="nav-link" href="/blog">Blog</a>
                <a class="nav-link" href="/faq">FAQs</a>
                <a class="nav-link " href="/contact-us">Contacts</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="pinfo" style="width: 100%; background: #ffffff; padding: 10px; min-height: 40vh;">
                <!-- Updated H1 with blue underline -->
                <div>
                    <h1 class="page-title">Our Global Distributor</h1>
                    <p>Please select a country to locate a partner</p>
                </div>
                
                <!-- Dropdown Container -->
                <div class="custom-dropdown">
                    <div class="dropdown-header" id="dropdownHeader">
                        <span class="selected-option">Select a Country</span>
                        <span class="dropdown-icon">▼</span>
                    </div>
                    <div class="dropdown-options">
                        <div class="options-container">
                            <?php 
                                $regions = \app\http\models\Region::all()->get();
                                foreach($regions as $region):
                            ?>
                            <div class="region-group">
                                <div class="region-header"><?= $region['region'] ?></div>
                                <?php 
                                    $partners = app\http\models\Partners::where($region['id'], 'region_id')->get();
                                    foreach($partners as $partner):
                                ?>
                                <div class="country-option" data-id="<?= $partner['id'] ?>">
                                    <?= $partner['country_name'] ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <hr class="hr" />
                <div id="address_show" style="display: block; margin-top: 10px"></div>
                
                <script>
                    // Dropdown functionality
                    const dropdownHeader = document.querySelector('.dropdown-header');
                    const dropdownOptions = document.querySelector('.dropdown-options');
                    const selectedOption = document.querySelector('.selected-option');
                    const countryOptions = document.querySelectorAll('.country-option');
                    
                    // Toggle dropdown visibility
                    dropdownHeader.addEventListener('click', function() {
                        dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
                    });
                    
                    // Handle country selection
                    countryOptions.forEach(option => {
                        option.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            selectedOption.textContent = this.textContent;
                            dropdownOptions.style.display = 'none';
                            
                            // Make AJAX call to get partner details
                            let xhr = new XMLHttpRequest();
                            xhr.open('GET', "/global/partners/details?target=" + id, true);
                            xhr.onload = (e) => {
                                if(xhr.readyState === 4) {
                                    if(xhr.status === 200) {
                                        let data = JSON.parse(xhr.response);
                                        let show = document.getElementById("address_show");
                                        show.innerHTML = "";
                                        if(data.company_details) {
                                            show.innerHTML = data.company_details;
                                        } else {
                                            show.innerHTML = "<p>Nothing found for this country</p>";
                                        }
                                    }
                                } else {
                                    console.log(JSON.parse(xhr.response));
                                }
                            }
                            xhr.send(null);
                        });
                    });
                    
                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!event.target.closest('.custom-dropdown')) {
                            dropdownOptions.style.display = 'none';
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<?php 
    template_include("/frontend/partials/footer");
?>