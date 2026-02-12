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
      <li class="breadcrumb-item active">Add new Faq</li>
      <li><a href="/faq" class="btn btn-primary">View</a></li>
    </ol>
    <hr>
        <div class="row justify-content-center">
          <div class="col-md-8">
               <form onsubmit="return AddFaq(event)" id="faq_form">
                 <div class="mb-3">
                 <label for="question_input" class="form-label">Type your question </label>
                     <input type="text" class="form-control" id="question_input" placeholder="Is this authentic ?" name="question">
                 </div>
                <div class="mb-3">
                  <label for="answer_input" class="form-label">Type your answer</label>
                  <textarea class="form-control" id="answer_input" rows="3" placeholder="Anser the question" name="answer"></textarea>
                </div>
                <div class="mb-3">
                 <input class="btn btn-success" type="submit" value="Add Faq">
                </div>
            </form>
          
          <!--//Faq Output-->
         <style>
            .faq-container {
              /*width: 600px;*/
              margin: 40px auto;
              font-family: Arial, sans-serif;
            }
        
            .faq-item {
              border-bottom: 1px solid #ccc;
              padding: 15px 0;
              position: relative;
            }
        
            .faq-question {
              display: flex;
              justify-content: space-between;
              cursor: pointer;
              font-weight: bold;
              font-size: 18px;
            }
        
            .faq-toggle {
              font-size: 22px;
              transition: transform 0.3s ease;
            }
        
            .faq-item.active .faq-toggle {
              transform: rotate(45deg);
            }
        
            .faq-answer {
              display: none;
              padding: 10px 0;
              font-size: 16px;
              color: #333;
            }
        
            .faq-item.active .faq-answer {
              display: block;
            }
        
            .faq-actions {
              margin-top: 10px;
            }
        
            .faq-actions button {
              margin-right: 10px;
              padding: 5px 10px;
              font-size: 14px;
            }
        
            .add-btn {
              display: block;
              margin: 20px auto;
              padding: 10px 20px;
              font-size: 16px;
            }
          </style>
        <div class="faq-container" id="faqList">
             <?php 
                foreach($items as $item):
            ?>
          <div class="faq-item" data-id="<?= $item['id'] ?>">
            <div class="faq-question">
              <span class="faq-title"><?= $item['faq_question'] ?></span>
              <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
             <?= $item['answer'] ?>
              <div class="faq-actions">
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Delete</button>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
          
        </div>
        <script>
          document.addEventListener('DOMContentLoaded', function () {
            const faqContainer = document.getElementById('faqList');
        
            faqContainer.addEventListener('click', function (e) {
              const questionEl = e.target.closest('.faq-question');
              if (questionEl) {
                const clickedItem = questionEl.parentElement;
        
                faqContainer.querySelectorAll('.faq-item').forEach(item => {
                  if (item !== clickedItem) {
                    item.classList.remove('active');
                  }
                });
        
                clickedItem.classList.toggle('active');
                return;
              }
        
              // Delete
              const deleteBtn = e.target.closest('.delete-btn');
              if (deleteBtn) {
                const item = deleteBtn.closest('.faq-item');
                const id = item.getAttribute('data-id');
                if (!id) return alert("No ID found!");
                if (!confirm('Are you sure you want to delete this FAQ?')) return;
                const xhr = new XMLHttpRequest();
                xhr.open('get','/admin/faq/destroy?target='+id, true)
                xhr.onload = function(){
                    if(xhr.status >= 200 && xhr.status < 300){
                        const data = JSON.parse(xhr.responseText)
                       
                        if(data.success){
                            item.remove();
                        }else{
                            alert('Someting Went Wrong')
                        }
                    }else{
                        alert('Something went wrong !!');
                    }
                }
                 xhr.send();
                // Simulated deletion (replace with real request)
               
                
                return;
              }
             
        
            //   Edit Data
              const editBtn = e.target.closest('.edit-btn');
              if (editBtn) {
                const item = editBtn.closest('.faq-item');
                const titleEl = item.querySelector('.faq-title');
                const answerEl = item.querySelector('.faq-answer');
                const oldTitle = titleEl.textContent;
                const id = item.getAttribute('data-id');
                if (!id) return alert("No ID found!");
                const oldAnswer = answerEl.childNodes[0].textContent.trim();
        
                // const newTitle = prompt("Edit question:", oldTitle);
                // const newAnswer = prompt("Edit answer:", oldAnswer);
                createModal(oldTitle, oldAnswer, id)
                
                // if (newTitle && newAnswer) {
                //   titleEl.textContent = newTitle;
                //   answerEl.childNodes[0].textContent = newAnswer;
                //   alert("FAQ updated.");
                // }
                return;
              }
            });
          });
        
//Modal Data
        
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
          
            fetch('/admin/faq/update', {
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
          <!--End Faq Options-->
          </div>
        </div>
      </div>
</main>
<script>
    function AddFaq(event){
        event.preventDefault();
        const faq_form = document.getElementById('faq_form');
        const formData = new FormData(faq_form);
        xhr = new XMLHttpRequest();
        xhr.open('POST',"/admin/faq/save", true);
        
        xhr.onload = function(){
               if (xhr.status >= 200 && xhr.status < 300) {
                   
                   
                   
                   const data = JSON.parse(xhr.responseText);
                   if(data.success){
                       const faqContainer = document.getElementById('faqList');
                        const faqItem = document.createElement('div');
                        faqItem.className = 'faq-item';
                        faqItem.setAttribute('data-id', data.faq.id);
                    
                        faqItem.innerHTML = `
                          <div class="faq-question">
                            <span class="faq-title">${data.faq.faq_question}</span>
                            <span class="faq-toggle">+</span>
                          </div>
                          <div class="faq-answer">
                            ${data.faq.answer}
                            <div class="faq-actions">
                              <button class="edit-btn">Edit</button>
                              <button class="delete-btn">Delete</button>
                            </div>
                          </div>
                        `;
                    
                        faqContainer.insertBefore(faqItem,faqContainer.firstChild);
                        
                    document.getElementById('question_input').value = "";
                    document.getElementById('answer_input').value = "";
                   }
                   
                   if(data.error){
                       alert(data.error);
                   }
                }else{
                    alert("Some thing went wrong ! try again later !")
                }
        }
        xhr.send(formData)
    }
</script>

<!-- ============================================================================ -->
<!-- ============================================================================ -->
<!-- ============================================================================ -->

<?php

template_include("/backend/partials/footer");

?>