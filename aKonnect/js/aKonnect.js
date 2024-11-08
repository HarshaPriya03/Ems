document.getElementById('btn').addEventListener('click', function() {
    const contentContainer = document.getElementById('container');

    const content3 = document.createElement('div');
    content3.className = 'content-3';

    const inside = document.createElement('div');
    inside.className = 'inside';

    const ins = document.createElement('div');
    ins.className = 'ins';
    
    const img = document.createElement('img');
    img.src = 'public/OIP.jpg'; 
    img.alt = '';

    const insideIn = document.createElement('div');
    insideIn.className = 'inside-in';

    const h4 = document.createElement('h4');
    h4.textContent = 'Kannur Lokesh Rahul';

    const pDate = document.createElement('p');
    pDate.textContent = '2024-07-01 08:41 AM';

    insideIn.appendChild(h4);
    insideIn.appendChild(pDate);

    ins.appendChild(img);
    ins.appendChild(insideIn);

    const icon = document.createElement('div');
    icon.className = 'icon';

    const ellipsisIcon = document.createElement('i');
    ellipsisIcon.className = 'fa-solid fa-ellipsis';

    const dropdown = document.createElement('div');
    dropdown.className = 'dropdown';
    
    const deleteLink = document.createElement('a');
    deleteLink.href = '#';
    deleteLink.textContent = 'Delete';
    deleteLink.addEventListener('click', function(event) {
        event.preventDefault();
        if (confirm('The post will get deleted. Are you sure?')) {
            content3.remove();
        }
    });

    dropdown.appendChild(deleteLink);
    icon.appendChild(ellipsisIcon);
    icon.appendChild(dropdown);

    inside.appendChild(ins);
    inside.appendChild(icon);

    const hr1 = document.createElement('hr');
    const photo = document.createElement('div');
    photo.className = 'photo';
    const hr2 = document.createElement('hr');

    const conIcons = document.createElement('div');
    conIcons.className = 'con-icons';

    const icons = document.createElement('div');
    icons.className = 'icons';

    const iconHeart = document.createElement('div');
    iconHeart.className = 'icons-1';
    iconHeart.innerHTML = '<i class="fa-regular fa-thumbs-up"></i>';

    const iconComment = document.createElement('div');
    iconComment.className = 'icons-1';
    iconComment.innerHTML = '<i class="fa-regular fa-comment-dots"></i>';

    icons.appendChild(iconHeart);
    icons.appendChild(iconComment);

    const likes = document.createElement('div');
    likes.className = 'likes';

    const like = document.createElement('div');
    like.className = 'like';
    like.innerHTML = '<p>0 Likes</p>';

    const comments = document.createElement('p');
    comments.className = 'comments-count';
    comments.textContent = '0 comments';

    likes.appendChild(like);
    likes.appendChild(comments);

    conIcons.appendChild(icons);
    conIcons.appendChild(likes);

    content3.appendChild(inside);
    content3.appendChild(hr1);
    content3.appendChild(photo);
    content3.appendChild(hr2);
    content3.appendChild(conIcons);

    contentContainer.appendChild(content3);

    iconHeart.addEventListener('click', function() {
        const likeCount = likes.querySelector('.like p');
        let currentLikes = parseInt(likeCount.textContent);
        likeCount.textContent = `${++currentLikes} Likes`;
    });

    iconComment.addEventListener('click', function() {
        let accordion = content3.querySelector('.accordion');
        if (!accordion) {
            accordion = document.createElement('div');
            accordion.className = 'accordion';
            accordion.style.display = 'none'; 

            const commentInput = document.createElement('input');
            commentInput.className = 'comment-input';
            commentInput.type = 'text';
            commentInput.placeholder = 'Add a comment...';

            const postButton = document.createElement('button');
            postButton.className = 'post-button';
            postButton.textContent = 'Post';

            accordion.appendChild(commentInput);
            accordion.appendChild(postButton);
            content3.appendChild(accordion);

            postButton.addEventListener('click', function() {
                const commentText = commentInput.value;
                if (commentText) {
                    const commentCount = comments;
                    let currentComments = parseInt(commentCount.textContent);
                    commentCount.textContent = `${++currentComments} comments`;
                }
            });
        }
        accordion.style.display = accordion.style.display === 'none' ? 'block' : 'none';
    });

    ellipsisIcon.addEventListener('click', function() {
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    });
});