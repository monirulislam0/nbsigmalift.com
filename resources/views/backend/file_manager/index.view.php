<?php 

template_include("/backend/partials/header");

?>

<?php 

template_include("/backend/partials/sidebar");

?>

<!-- ============================================================================= -->
<!-- ============================================================================= -->
<!-- ============================================================================= -->
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Welcome ! Admin.</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
        <li class="breadcrumb-item active">File Manager</li>
      
        <!-- <li><a href="/admin/manager/news" class="btn btn-primary">Manage News</a></li> -->
        </ol>
        <hr>
        <style>
            #drop-area {
                border: 2px dashed #007bff;
                padding: 50px;
                text-align: center;
                border-radius: 5px;
            }
            #drop-area.hover {
                background-color: #f0f8ff;
            }
         </style>
       <div class="row">
       <div class="col-md-12">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div id="drop-area">
                            <h4>Drag and Drop Files Here</h4>
                            <p>Or click to select files</p>
                            <input type="file" id="file-input" class="d-none" multiple>
                        </div>
                        <div id="file-list" class="mt-3">
                            <!-- List of uploaded files will appear here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>

            <style>
                .image-container {
                    margin-top: 20px;
                }
                .image-card {
                    margin-bottom: 20px;
                    text-align: center;
                }
                .image-card img {
                    width: 100%; /* Adjust image size */
                    height: auto;
                    max-width: 200px;
                }
                .image-card .file-name {
                    margin-top: 10px;
                }
            </style>
            <div class="col-md-12">
                    <div class="container">
                        <div class="row" id="image-list"></div>
                        <div id="confirmation"></div>
                    </div>
            </div>
    </div>
</main>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const dropArea = document.getElementById("drop-area");
    const fileInput = document.getElementById("file-input");
    const fileList = document.getElementById("file-list");

    // Prevent default behavior for dragover and drop events
    dropArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropArea.classList.add("hover");
    });

    dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("hover");
    });

    dropArea.addEventListener("drop", (e) => {
        e.preventDefault();
        dropArea.classList.remove("hover");

        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    dropArea.addEventListener("click", () => {
        fileInput.click();
    });

    fileInput.addEventListener("change", (e) => {
        const files = e.target.files;
        handleFiles(files);
    });

    function handleFiles(files) {
        const fileListArray = Array.from(files);
        fileList.innerHTML = ""; // Clear any previous file list

        fileListArray.forEach(file => {
            const listItem = document.createElement("div");
            listItem.classList.add("alert", "alert-info");
            listItem.textContent = file.name;
            fileList.appendChild(listItem);
        });

        // Now that we have the files, let's upload them
        uploadFiles(files);
    }

    function uploadFiles(files) {
        const formData = new FormData();

        // Append each file to FormData
        Array.from(files).forEach(file => {
            formData.append("files[]", file);
        });

        // Send the FormData to the server via POST
        fetch("/admin/file-manager/store", {  // Change the endpoint to PHP script
            method: "POST",
            body: formData
        })
        .then(response => response.json())  // Assuming server responds with JSON
        .then(data => {
            // console.log("Upload successful:", data);
            const response = confirm("Do you want to upload more??")
            if(!response){
                window.location.reload();
            }
           
            // Show success message or further handling
        })
        .catch(error => {
            console.error("Error during upload:", error);
            // Handle error
        });
    }
});
document.addEventListener("DOMContentLoaded", function () {
    // Fetch image files from the server once the document is loaded
    fetchImages();

    function fetchImages() {
        fetch("/admin/file-manager/files")  // Request to the PHP file that returns images
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }

                // If there are files, display them
                if (data.files && Object.keys(data.files).length > 0) {
                    displayImages(data.files);
                } else {
                    document.getElementById('image-list').innerHTML = '<p>No images found.</p>';
                }
            })
            .catch(error => console.error("Error fetching images:", error));
    }

    function displayImages(files) {
        const imageListContainer = document.getElementById('image-list');
        imageListContainer.innerHTML = '';  // Clear any existing content

        Object.entries(files).forEach(file => {
            const imageCard = document.createElement('div');
            imageCard.classList.add('col-md-3', 'image-card');
            
           
            const img = document.createElement('div');
            img.style.height="200px";
            img.style.width="auto";
            img.style.backgroundColor="rgba(0,0,0,0.15)";
            img.style.backgroundImage = "url("+file[1].url+")";
            img.style.backgroundSize = "contain";
            img.style.backgroundRepeat = "no-repeat";
            img.style.backgroundPosition = "center center";
            
            img.setAttribute('data-url', file[1].url);  // Store the URL in a data attribute
            
            // Create the file name label
            const fileNameLabel = document.createElement('div');
            fileNameLabel.classList.add('file-name');
            fileNameLabel.classList.add('btn');
            fileNameLabel.style.width="100%"
            fileNameLabel.classList.add('btn-secondary');
            fileNameLabel.setAttribute('data-url', file[1].url);
            fileNameLabel.setAttribute('id', file[1].url);
            fileNameLabel.textContent = "Click to copy url";  // Display the file name

            const button = document.createElement('button');
            button.textContent = "Delete Me";
            button.classList.add("btn");
            button.style.width="100%"
            button.classList.add("btn-danger");
            button.classList.add("mt-2");
            button.setAttribute('data-url', file[1].url);
            button.setAttribute('id', 'delete');

            button.addEventListener('click', function() {
                const image = button.getAttribute('data-url');

                // Send the image name to the server to check if it exists
                fetch('/admin/file-manager/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ imageName: image })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        imageCard.style.display = 'none';
                        alert("You have successfully Deleted this item !!")
                    } else {
                        console.log('Image not found or failed to unlink');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });


            
            // Append the image and file name label to the card
            imageCard.appendChild(img);
            imageCard.appendChild(fileNameLabel);
            imageCard.appendChild(button);
            
            // Add the image card to the image list container
            imageListContainer.appendChild(imageCard);
            fileNameLabel.addEventListener('click', function () {
                const url = fileNameLabel.getAttribute('data-url');  // Get the URL from the data attribute
                
                // Copy the URL to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    alert("Url Copied")
                }).catch(err => {
                    console.error('Failed to copy URL:', err);
                });
            });
            // Add click event listener to copy the image URL to clipboard
            img.addEventListener('click', function () {
                const url = img.getAttribute('data-url');  // Get the URL from the data attribute
                
                // Copy the URL to clipboard
                navigator.clipboard.writeText(url).then(() => {
                    // Display confirmation message
                    const confirmation = document.getElementById('confirmation');
                    confirmation.textContent = `URL copied: ${url}`;
                    setTimeout(() => {
                        confirmation.textContent = ''; // Clear the message after 2 seconds
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy URL:', err);
                });
            });
        });
    }
});


</script>
<!-- ============================================================================ -->
<!-- ============================================================================ -->
<!-- ============================================================================ -->

<?php

template_include("/backend/partials/footer");

?>
