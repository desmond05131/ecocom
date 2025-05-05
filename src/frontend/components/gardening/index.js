document.addEventListener('DOMContentLoaded', function() {
    // Post button click event
    const postBtn = document.getElementById('post-btn');
    const postContent = document.getElementById('post-content');
    const exchangeableCheck = document.getElementById('exchangeable-check');
    const feedContainer = document.querySelector('.feed-container');

    if (postBtn) {
        postBtn.addEventListener('click', function() {
            const content = postContent.value.trim();
            if (content) {
                // Create a new post
                createNewPost(content, exchangeableCheck.checked);
                // Clear the input
                postContent.value = '';
                exchangeableCheck.checked = false;
            }
        });
    }

    // Photo button click event
    const photoBtn = document.getElementById('photo-btn');
    if (photoBtn) {
        photoBtn.addEventListener('click', function() {
            alert('Photo upload functionality will be implemented soon!');
        });
    }

    // Add event listeners to exchange buttons
    const exchangeButtons = document.querySelectorAll('.exchange-btn');
    exchangeButtons.forEach(button => {
        button.addEventListener('click', function() {
            alert('Exchange request functionality will be implemented soon!');
        });
    });

    // Add event listeners to edit buttons
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postCard = this.closest('.post-card');
            const postContent = postCard.querySelector('.post-content p');

            // Create a temporary textarea to edit the content
            const currentContent = postContent.textContent;
            const textarea = document.createElement('textarea');
            textarea.value = currentContent;
            textarea.className = 'edit-textarea';
            textarea.style.width = '100%';
            textarea.style.minHeight = '100px';
            textarea.style.padding = '10px';
            textarea.style.marginBottom = '10px';
            textarea.style.borderRadius = '4px';
            textarea.style.border = '1px solid #ddd';

            // Replace the paragraph with the textarea
            postContent.replaceWith(textarea);
            textarea.focus();

            // Create save button
            const saveBtn = document.createElement('button');
            saveBtn.textContent = 'Save Changes';
            saveBtn.className = 'button button-primary';
            saveBtn.style.marginBottom = '15px';

            // Insert save button after textarea
            textarea.parentNode.insertBefore(saveBtn, textarea.nextSibling);

            // Save button event listener
            saveBtn.addEventListener('click', function() {
                const newContent = textarea.value.trim();
                if (newContent) {
                    // Create new paragraph with edited content
                    const newParagraph = document.createElement('p');
                    newParagraph.textContent = newContent;

                    // Replace textarea with new paragraph
                    textarea.replaceWith(newParagraph);
                    saveBtn.remove();
                }
            });
        });
    });

    // Add event listeners to delete buttons
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postCard = this.closest('.post-card');

            // Ask for confirmation before deleting
            if (confirm('Are you sure you want to delete this post?')) {
                // Add a fade-out animation
                postCard.style.transition = 'opacity 0.3s ease';
                postCard.style.opacity = '0';

                // Remove the post after the animation completes
                setTimeout(() => {
                    postCard.remove();
                }, 300);
            }
        });
    });

    // Function to create a new post
    function createNewPost(content, isExchangeable) {
        const newPost = document.createElement('div');
        newPost.className = 'post-card';

        // Get current date and time
        const now = new Date();

        let postHTML = `
            <div class="post-header">
                <div class="post-user-info">
                    <img src="/src/frontend/images/profile-placeholder.png" alt="User Profile" class="user-avatar">
                    <div class="post-user-details">
                        <h4>Current User</h4>
                        <p class="post-time">Just now</p>
                    </div>
                </div>
                <div class="post-actions-top">
                    <button class="action-btn-top exchange-btn" title="Request Exchange">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                    <button class="action-btn-top edit-btn" title="Edit Post">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn-top delete-btn" title="Delete Post">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="post-content">
                <p>${content}</p>
            </div>
        `;

        // Add exchangeable tag if checked
        if (isExchangeable) {
            postHTML += `
                <div class="exchangeable-tag">
                    <i class="fas fa-exchange-alt"></i> Exchangeable
                </div>
            `;
        }

        newPost.innerHTML = postHTML;

        // Insert the new post at the top of the feed
        const firstPost = feedContainer.querySelector('.post-card');
        if (firstPost) {
            feedContainer.insertBefore(newPost, firstPost);
        } else {
            feedContainer.appendChild(newPost);
        }

        // Add event listeners to the new post's buttons
        const exchangeBtn = newPost.querySelector('.exchange-btn');
        exchangeBtn.addEventListener('click', function() {
            alert('Exchange request functionality will be implemented soon!');
        });

        const editBtn = newPost.querySelector('.edit-btn');
        editBtn.addEventListener('click', function() {
            const postContent = newPost.querySelector('.post-content p');

            // Create a temporary textarea to edit the content
            const currentContent = postContent.textContent;
            const textarea = document.createElement('textarea');
            textarea.value = currentContent;
            textarea.className = 'edit-textarea';
            textarea.style.width = '100%';
            textarea.style.minHeight = '100px';
            textarea.style.padding = '10px';
            textarea.style.marginBottom = '10px';
            textarea.style.borderRadius = '4px';
            textarea.style.border = '1px solid #ddd';

            // Replace the paragraph with the textarea
            postContent.replaceWith(textarea);
            textarea.focus();

            // Create save button
            const saveBtn = document.createElement('button');
            saveBtn.textContent = 'Save Changes';
            saveBtn.className = 'button button-primary';
            saveBtn.style.marginBottom = '15px';

            // Insert save button after textarea
            textarea.parentNode.insertBefore(saveBtn, textarea.nextSibling);

            // Save button event listener
            saveBtn.addEventListener('click', function() {
                const newContent = textarea.value.trim();
                if (newContent) {
                    // Create new paragraph with edited content
                    const newParagraph = document.createElement('p');
                    newParagraph.textContent = newContent;

                    // Replace textarea with new paragraph
                    textarea.replaceWith(newParagraph);
                    saveBtn.remove();
                }
            });
        });

        const deleteBtn = newPost.querySelector('.delete-btn');
        deleteBtn.addEventListener('click', function() {
            // Ask for confirmation before deleting
            if (confirm('Are you sure you want to delete this post?')) {
                // Add a fade-out animation
                newPost.style.transition = 'opacity 0.3s ease';
                newPost.style.opacity = '0';

                // Remove the post after the animation completes
                setTimeout(() => {
                    newPost.remove();
                }, 300);
            }
        });
    }
});