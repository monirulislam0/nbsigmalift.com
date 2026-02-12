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
      <li class="breadcrumb-item active">Edit Product</li>
      <li>
        <a href="/admin/manager/products" class="btn btn-primary">Manage Products</a>
      </li>
    </ol>
    <hr>
    <div class="row justify-content-center">
      <div class="col-md-8"> 
        <?php if(session_get("message")) : ?> 
          <div class="card text-bg-primary mb-3">
            <div class="card-body">
              <p class="card-text"> <?= session_get("message") ?> </p>
            </div>
          </div> 
        <?php endif ; ?> 
        <h1 class="mb-4">Edit Product</h1>
        <form action="/admin/product/update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="update">
          <input type="hidden" name="id" id="product_id" value="<?= $product['id'] ?>">
          <!-- Product Name -->
          <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" id="productName" class="form-control" placeholder="Enter product name" name="productName" value="<?php 
              if(old('productName')) {
                  echo trim(old('productName'));
              }else{
                  echo trim($product['product_title']);
              }
            ?>"> 
            <?php if(error("productName")): ?>
              <p class="text-danger" style="margin-bottom:-20px">
                <sub> <?= error('productName') ?> </sub>
              </p>
              <div class="p-1"></div> 
            <?php endif; ?>
          </div>

          <div class="mb-3">
                <label for="productModel" class="form-label">Product Model</label>
               
                <input type="text" id="productModel" class="form-control" placeholder="Enter product model" name="productModel" value="<?= old('productModel') ?? $product['product_model'] ?>">
               
              </div>
          <!-- Product Category -->
          <div class="mb-3">
            <label for="productCategory" class="form-label">Category</label>
            <select id="productCategory" name="productCategory" class="form-select" onchange="updateSubCategories(event)">
              <option value="">Select a category</option> 
              <?php foreach($categories as $category) : ?> 
                <option value="<?= $category['id'] ?>" 
                  <?php if($category['id'] == old("productCategory") || $category['id'] == $product['product_category']) { echo "selected" ; } ?>> 
                  <?= $category['category_name'] ?> 
                </option> 
              <?php endforeach; ?>
            </select> 
            <?php if(error("productCategory")): ?>
              <p class="text-danger" style="margin-bottom:-20px">
                <sub> <?= error('productCategory') ?> </sub>
              </p>
              <div class="p-1"></div> 
            <?php endif; ?>
          </div>
          <!-- Product Sub-Category -->
          <div class="mb-3">
            <label for="productSubCategory" class="form-label">Sub-Category</label>
            <select id="productSubCategory" class="form-select" name="productSubCategory">
              <option value="">Select a sub-category</option> 
              <?php foreach($subcategories as $subcategory) : ?> 
                <option value="<?= $subcategory['id'] ?>" 
                  <?php if($product['product_subcategory'] == $subcategory['id'] ) echo "selected"; ?>> 
                  <?= $subcategory['subcategory_name'] ?> 
                </option> 
              <?php endforeach ; ?>
            </select>
          </div>
          <!-- Product Price -->
          <div class="mb-3">
            <label for="productPrice" class="form-label">Price ($)</label>
            <input type="number" id="productPrice" class="form-control" placeholder="Enter price" min="1" name="productPrice" value="<?php
              if( old("productPrice")){
                echo  old("productPrice");
              }else{
                echo $product['price'];
              }
            ?>"> 
            <?php if(error("productPrice")): ?>
              <p class="text-danger" style="margin-bottom:-20px">
                <sub> <?= error('productPrice') ?> </sub>
              </p>
              <div class="p-1"></div> 
            <?php endif; ?>
          </div>
          <!-- Product Description -->
          <div class="mb-3">
    <label for="productShortDescription" class="form-label">Short Description</label>
    <textarea id="productShortDescription" class="form-control" rows="4" placeholder="Enter product description" name="productShortDescription">
        <?php 
        if(old('productShortDescription')) {
            echo trim(old('productShortDescription'));
        } else {
            echo trim($product['short_description']);
        }
        ?>
    </textarea>
    <?php if(error("productShortDescription")): ?>
        <p class="text-danger mt-2"><sub><?= error('productShortDescription') ?></sub></p>
    <?php endif; ?>
    
    <!-- TinyMCE Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#productShortDescription',
                plugins: 'lists',
                toolbar: 'bold underline | bullist numlist',
                height: 200,
                setup: function(editor) {
                    // Ensure <br> on Enter (next line behavior)
                    editor.on('keydown', function(e) {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            editor.execCommand('InsertLineBreak');
                        }
                    });
                }
            });
        });
    </script>
</div>
          <div class="mb-3">
            <label for="productLongDescription" class="form-label">Long Description</label>
            <textarea id="productLongDescription" class="form-control" rows="4" placeholder="Product Description" name="productLongDescription">
              <?= old("productLongDescription") ?? $product['long_description']?>
            </textarea>
            <?php if(error("productLongDescription")): ?>
              <p class="text-danger" style="margin-bottom:-20px">
                <sub> <?= error('productLongDescription') ?> </sub>
              </p>
              <div class="p-1"></div> 
            <?php endif; ?>
          </div>
          <script>
            tinymce.init({
              selector: 'textarea#productLongDescription',
              plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code', toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            });
          </script>
          <!-- Product Image -->
          <div class="mb-3">
            <label for="productThumbnail" class="form-label">Upload Thumbnail</label>
            <input type="file" id="productThumbnail" class="form-control" accept="image/*" name="productThumbnail" onchange="previewImage(event)" > 
            <?php if(error("productThumbnail")): ?>
              <p class="text-danger" style="margin-bottom:-20px">
                <sub> <?= error('productThumbnail') ?> </sub>
              </p>
              <div class="p-1"></div> 
            <?php endif; ?>
          </div>
          <!-- Product Image -->
          <div class="mb-3">
            <div class="card" style="width: 18rem;">
              <img id="thumbnailPreview" src="<?= assets('/uploads/'.$product['product_thumbnail']) ?? assets('/uploads/no_image.jpg') ?>" class="card-img-top" alt="...">
            </div>
          </div>

          <script>
            function previewImage(event) {
              const file = event.target.files[0]; // Get the selected file
              const reader = new FileReader(); // Create a FileReader instance

              reader.onload = function(e) {
                // Update the img element's src with the file's data URL
                document.getElementById('thumbnailPreview').src = e.target.result;
              };

              if (file) {
                reader.readAsDataURL(file); // Read the file as a data URL
              }
            }
          </script>
          <!-- Product Alt Text -->
          <div class="mb-3">
            <label for="productThumbnailAltText" class="form-label">Alt Text</label>
            <input type="text" id="productThumbnailAltText" class="form-control" name="productThumbnailAltText" value="<?php 
              if(old('productThumbnailAltText')){
                echo trim(old('productThumbnailAltText'));
              }else{
                echo trim($product['product_thumbnail_alt_text']);
              }
            ?>">
          </div>
          <!-- Product Sliders -->
          <div class="mb-3">
            <label for="productGallaries" class="form-label">Product Gallary</label>
            <input type="file" id="productGallaries" class="form-control" accept="image/*"  name="productGallaries[]" multiple> 
            <?php if(error("productGallaries")): ?>
              <p class="text-danger" style="margin-bottom:-20px">
                <sub> <?= error('productGallaries') ?> </sub>
              </p>
              <div class="p-1"></div> 
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <div class="container text-center">
              <div class="row" id="target_gallarey">
                <?php
                $gallaries = unserialize($product['product_galleries']);
                if(! $gallaries) $gallaries = [];
                foreach($gallaries as $key => $val) : ?>
                  <div class="col-4 mb-3 gallary_view" >
                    <div class="card">
                      <img src="<?= assets('/uploads/'.$val)?>" class="card-img-top" alt="..." style="height: 280px;">
                      <div class="d-flex justify-content-between pb-3">
                        <div class="mt-3">
                          <!-- <form action="">
                            <div class="p-1 d-flex justify-content-between">
                              <input type="file" name="" class="form-control">
                              <button class="btn btn-primary">Change</button>
                            </div>
                          </form> -->
                        </div>
                        <div class="mt-3">
                          <a href="/admin/product/image/gallaries/delete?target=<?php echo $product['id']?>&index=<?= $key ?>" class="btn btn-danger" onClick="CallGallaryDelete(event, this)"  style="margin-right: 4px; margin-top:4px" data-index="<?= $key ?>" data-id="<?= $product['id'] ?>">Delete</a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php  endforeach; ?>
              </div>
            </div>
          </div>

          <!-- Product PDF -->
          <div class="mb-3">
            <label for="productPDF" class="form-label">Upload PDF</label>
            <input type="file" id="productPDF" class="form-control" name="productPDF" accept="application/pdf">
          </div>
          
          <div class="mb-3">
            <div id="pdf-container"></div>
          </div>

          <h1 class="mb-4 mt-2">Open Graph Information to share social media</h1>
          <hr class="border border-primary border-3 opacity-75">
          
          <div class="mb-3">
            <label for="OgTitle" class="form-label">OG Title</label>
            <input type="text" name="OgTitle" class="form-control" id="OgTitle" value="<?= old("OgTitle") ?? $product['og_title'] ?>">
          </div>
          <div class="mb-3">
            <label for="OgDesription" class="form-label">OG Description</label>
            <textarea id="OgDesription" class="form-control" rows="4" placeholder="Enter product description" name="OgDesription"><?php 
              if(old('OgDesription')){
                echo trim(old('OgDesription'));
              }else{
                echo trim($product['og_description']);
              }
            ?></textarea>
          </div>
          <div class="mb-3">
            <label for="OgImage" class="form-label">OG Image</label>
            <input type="file" name="OgImage" class="form-control" id="OgImage" onChange="previewOgImage(event, this)">
          </div>
          <!-- Product Image -->
          <div class="mb-3">
            <div class="card" style="width: 18rem;">
              <img id="ogShow" src="<?= assets('/uploads/'.$product['og_image']) ?? assets('/uploads/no_image.jpg') ?>" class="card-img-top" alt="...">
            </div>
          </div>
          
          <script>
            function previewOgImage(event) {
              const file = event.target.files[0]; // Get the selected file
              const reader = new FileReader(); // Create a FileReader instance

              reader.onload = function(e) {
                // Update the img element's src with the file's data URL
                document.getElementById('ogShow').src = e.target.result;
              };

              if (file) {
                reader.readAsDataURL(file); // Read the file as a data URL
              }
            }
          </script>
          
           <h1 class="mb-4 mt-2">SEO Here</h1>
              <hr class="border border-primary border-3 opacity-75">
              
               <div class="mb-3">
                <label for="productTags" class="form-label">Meta Keywords</label>
                <input type="text" id="productTags" value="<?= $product["meta_tags"] ?? 'Tags....'?>" data-role="tagsinput"  class="form-control" name="productTags"/>
              </div>
              
              <div class="mb-3">
                <label for="meta_title" class="form-label">Meta Title</label>
               <input type="text" name="meta_title" class="form-control" id="meta_title" value="<?php 
                        if(!empty($product['meta_title'])){
                            echo $product['meta_title'];
                        }else{
                            echo  trim(old('meta_title'));
                        }
                    
                    ?>">
              </div>

<div class="mb-3">
  <label for="meta_description" class="form-label">Meta Description (Recommended: 150-160 characters)</label>
  <textarea 
    id="meta_description" 
    class="form-control" 
    rows="4" 
    placeholder="Enter product description" 
    name="meta_description"
    oninput="countMetaDescriptionChars(this)"
  ><?= htmlspecialchars(trim(old('meta_description') ?? $product['meta_description'] ?? '')) ?></textarea>
  <div class="text-muted">
    <span id="meta_desc_counter">0</span>/160 characters
  </div>
  <?php if(error("meta_description")): ?>
    <p class="text-danger"><sub><?= error('meta_description') ?></sub></p>
  <?php endif; ?>
</div>

<script>
  function countMetaDescriptionChars(textarea) {
    const counter = document.getElementById('meta_desc_counter');
    const text = textarea.value;
    
    // Count characters (including spaces)
    const charCount = text.length;
    
    // Update counter
    counter.textContent = charCount;
    
    // Visual feedback
    if (charCount > 160) {
      counter.classList.add('text-danger');
      counter.classList.remove('text-success');
    } else {
      counter.classList.add('text-success');
      counter.classList.remove('text-danger');
    }
  }

  // Initialize counter on page load
  document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('meta_description');
    if (textarea) {
      countMetaDescriptionChars(textarea);
    }
  });
</script>
          
          <!-- Submit Button -->
          <div class="mb-3 p-3">
            <input type="submit" class="btn btn-success w-100" value="Update Product" />
          </div>
          <div class="mb-3 p-3"></div>
        </form>
        
        <!--New FAq Implementation-->
        
              <style>


    h2 {
      color: #333;
      margin-bottom: 20px;
    }

    #addFaqBtn {
      padding: 12px 20px;
      background-color: #198754;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    #addFaqBtn:hover {
      background-color: #0056b3;
    }

    .faq-container {
      margin-top: 30px;
    }

    .faq-form {
      margin-top: 20px;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
    }

    .faq-form input,
    .faq-form textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 10px;
      margin-bottom: 15px;
      font-size: 16px;
      box-sizing: border-box;
    }

    .faq-form button {
      background-color: #198754;
      color: white;
      padding: 10px 18px;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .faq-form button:hover {
      background-color: #218838;
    }

    .faq-display {
      margin-top: 30px;
    }

    .faq {
      background-color: #fff;
      border-radius: 12px;
      margin-bottom: 15px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .faq-question {
      padding: 15px 20px;
      background-color: #e9f5ff;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .faq-question:hover {
      background-color: #d6ecff;
    }

    .faq-answer {
      display: none;
      padding: 15px 20px;
      border-top: 1px solid #ddd;
      background: #fefefe;
    }

    .faq.open .faq-answer {
      display: block;
    }
  </style>
          
         <h1 class="mb-4 mt-2">Frequently Asked Questions</h1>
        <hr class="border border-primary border-3 opacity-75">

  <div class="faq-display" id="faqDisplay">

    
    <?php
        $faqs = \app\http\models\Faq::where($product['id'],'product_id')->get();
        foreach($faqs as $faq):
    ?>
      <div class="faq">
        <div class="faq-question d-flex justify-content-between"><?=  $faq['question'] ?>
        <div> 
          <a class="btn btn-danger" onclick="deleteFaq(event, <?= $faq['id'] ?>)">Delete</a>
          <a class="btn btn-info"  onclick="editFaq(event, <?= $faq['id'] ?>)">Edit</a>
          </div>
        </div>
        <div class="faq-answer"><?=  $faq['answer'] ?></div>
      </div>
    <?php endforeach; ?>
  </div>
  

  <button id="addFaqBtn">➕ Add FAQ</button>

  <div id="faqFormContainer"></div>


  <script>
    // Toggle FAQ
    document.querySelectorAll('.faq-question').forEach(q => {
      q.addEventListener('click', () => {
        q.parentElement.classList.toggle('open');
      });
    });

    const addBtn = document.getElementById('addFaqBtn');
    const formContainer = document.getElementById('faqFormContainer');
    const faqDisplay = document.getElementById('faqDisplay');

    addBtn.addEventListener('click', () => {
      if (formContainer.innerHTML !== '') return;

      formContainer.innerHTML = `
        <div class="faq-form">
          <input type="text" id="questionInput" placeholder="Enter question">
          <textarea id="answerInput" placeholder="Enter answer" rows="4"></textarea>
          <button id="saveFaqBtn">✅ Save FAQ</button>
        </div>
      `;

      document.getElementById('saveFaqBtn').addEventListener('click', () => {
        const question = document.getElementById('questionInput').value.trim();
        const answer = document.getElementById('answerInput').value.trim();
        const id = document.getElementById('product_id').value.trim();
        if (!question || !answer || !id) {
          alert('Please fill in both fields.');
          return;
        }

        fetch('/admin/faq/create', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ question, answer, id })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
              console.log(data)
            const newFaq = document.createElement('div');
            newFaq.className = 'faq open';
            newFaq.innerHTML = `
              <div class="faq-question">${data.question}</div>
              <div class="faq-answer">${data.answer}</div>
            `;
            newFaq.querySelector('.faq-question').addEventListener('click', () => {
              newFaq.classList.toggle('open');
            });

            faqDisplay.appendChild(newFaq);
            formContainer.innerHTML = '';
          } else {
            alert('Failed to save FAQ.');
          }
        })
        .catch(err => {
          console.error(err);
          alert('An error occurred.');
        });
      });
    });
    
    // Delete
    
    
    function deleteFaq(event, id) {
    event.preventDefault();

    if (!confirm("Are you sure you want to delete this FAQ?")) return;

    fetch(`/admin/faq/delete`, {
        method: 'POST',
        body:JSON.stringify({id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Optionally remove the DOM element
            event.target.closest('.faq').remove();
        } else {
            alert("Failed to delete FAQ.");
        }
    })
    .catch(err => {
        console.error(err);
        alert("An error occurred.");
    });
}


  
    function editFaq(event, id) {
        
     fetch(`/admin/faq/get?target=${id}`)
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(data => {
            // Now `data` is your FAQ object
            console.log(data);
            createModal(data.question, data.answer, data.id); // use your modal
        })
        .catch(err => {
            console.error('Failed to fetch FAQ:', err);
        });
    }
    function createModal(title, text, id) {
              // Create overlay
              const overlay = document.createElement('div');
              Object.assign(overlay.style, {
                position: 'fixed',
                top: 0,
                left: 0,
                width: '100vw',
                height: '100vh',
                backgroundColor: 'rgba(0,0,0,0.5)',
                display: 'flex',
                justifyContent: 'center',
                alignItems: 'center',
                zIndex: 1000,
              });
            
              // Create modal
              const modal = document.createElement('div');
              Object.assign(modal.style, {
                backgroundColor: '#fff',
                padding: '20px',
                borderRadius: '8px',
                width: '600px',
                display: 'flex',
                flexDirection: 'column',
                gap: '10px',
                boxShadow: '0 2px 10px rgba(0,0,0,0.2)',
              });
            
              // Modal title
              const modalTitle = document.createElement('h2');
              modalTitle.textContent = title;
            
              // Input field
              const input = document.createElement('input');
              input.type = 'text';
              input.value = title;
            
              // Textarea
              const textarea = document.createElement('textarea');
              textarea.rows = 4;
              textarea.value = text;
            
              // Update button
              const updateBtn = document.createElement('button');
              updateBtn.textContent = 'Update';
              updateBtn.style.backgroundColor = '#007BFF';
              updateBtn.style.color = '#fff';
              updateBtn.style.border = 'none';
              updateBtn.style.padding = '10px';
              updateBtn.style.cursor = 'pointer';
              updateBtn.style.borderRadius = '4px';
            
              // Close button
              const closeBtn = document.createElement('button');
              closeBtn.textContent = 'Close';
              closeBtn.style.backgroundColor = '#ccc';
              closeBtn.style.border = 'none';
              closeBtn.style.padding = '10px';
              closeBtn.style.cursor = 'pointer';
              closeBtn.style.borderRadius = '4px';
            
              closeBtn.addEventListener('click', () => {
                document.body.removeChild(overlay);
              });
            
              // Handle update
              updateBtn.addEventListener('click', () => {
                const updatedData = {
                  id,
                  title: input.value,
                  content: textarea.value,
                };
               console.log(updatedData);
                fetch('/admin/product/faq/update', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json'
                  },
                  body: JSON.stringify(updatedData)
                })
                .then(res => {
                  if (!res.ok) throw new Error("Server error");
                  return res.json();
                })
                .then(response => {
                    
                  alert('Data updated successfully!');
                  document.body.removeChild(overlay);
                 window.location.reload();
                })
                .catch(error => {
                  console.error('Error:', error);
                  alert('Update failed.');
                });
              });
            
              // Append everything
              modal.appendChild(modalTitle);
              modal.appendChild(input);
              modal.appendChild(textarea);
              modal.appendChild(updateBtn);
              modal.appendChild(closeBtn);
            
              overlay.appendChild(modal);
              document.body.appendChild(overlay);
            }
    
    
    
  </script>

        
        
        <!--New Faq Implementation End-->
      </div>
    </div>
  </div>
</main>
<script>
  function updateSubCategories(event) {
    categoryId = parseInt(event.target.value);

    var url = "<?php echo getEnv('SITE_URL'); ?>";
    url = url.replace(/\/$/, ""); 

    // Construct the full URL with categoryId
    fetch(url + "/subcategories/target?id=" + categoryId)
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      console.log(data);
      subCategories = data;
      const subCategory = document.getElementById('productSubCategory');
      subCategory.innerHTML = '<option value="">Select a sub-category</option>'; // Reset sub-categories
      if (subCategories) {
        subCategories.forEach(sub => {
          const option = document.createElement('option');
          option.value = sub.id;
          option.textContent = sub.subcategory_name;
          subCategory.appendChild(option);
        });
      }
    })
    .catch(error => {
      console.error('There was a problem with the fetch operation:', error);
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    ContentTrim();
    document.getElementById("productGallaries").addEventListener('change', MultipleImage);
  });

  function ContentTrim() {
    document.getElementById("productShortDescription").innerHTML = (document.getElementById("productShortDescription").innerHTML).trim() ;
    document.getElementById("OgDesription").innerHTML = (document.getElementById("OgDesription").innerHTML).trim() ;
  }

  function CallGallaryDelete(event, element) {
    event.preventDefault(); // Prevent page reload

    let target = element.getAttribute("data-id");
    let index = element.getAttribute("data-index");
    let url = `/admin/product/image/gallaries/delete?target=${target}&index=${index}`;

    if (confirm("Are you sure you want to delete this image?")) {
      fetch(url, { method: "GET" })
        .then(response => response.json())
        .then(data => {
          if (data.status) {
            event.target.closest('.gallary_view').style.display = "none" ; 
          } else {
            // Handle error
          }
        })
        .catch(error => console.error("Error deleting image:", error));
    }
  }

  function MultipleImage(event) {
    const images = event.target.files; // Get selected files
    Object.entries(images).forEach(function ([index, file]) { 
      const reader = new FileReader();
      reader.onload = function (e) {
        data = `
        <div class="col-4 mb-3 gallary_view" >
          <div class="card">
            <img src="${e.target.result}" class="card-img-top" alt="..." style="height: 280px;">
          </div>
        </div>
        `;
        document.getElementById("target_gallarey").insertAdjacentHTML('beforeend',data);
      };
      reader.readAsDataURL(file); 
    });
  }
</script>
<!-- ============================================================================ -->
<!-- ============================================================================ -->
<!-- ============================================================================ --> 
<?php

template_include("/backend/partials/footer");

?>