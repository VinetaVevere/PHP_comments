const form = document.getElementById('comments_form');
const popup = document.querySelector('.popup');
const form_update = document.getElementById('comments_update_form');
const comment_block = document.querySelector('.comments');
const comment_template = comment_block.querySelector('.template');

xhttp.get('api.php?name=getAll-comment', function (response) {
    for (let comment of response.comments) {
        addComment(comment.id, comment.author, comment.message);
    }
});

form.onsubmit = function (event) {
    event.preventDefault();
    submitForm(this);
};

form_update.onsubmit = function (event) {
    event.preventDefault();

    xhttp.postForm(form_update, function (response) {
        popup.style.display = 'none';

        const update_comment = document.querySelector('[data-id="' + response.id + '"]');
        update_comment.querySelector('.message').textContent = response.comment.message;
        update_comment.querySelector('.author').textContent = response.comment.author;
    });
}

function submitForm (form) {
    xhttp.postForm(form, function (response) {
        addComment(response.id, response.author, response.message);
    });
}

function addComment(id, author, message) {
    const new_comment = comment_template.cloneNode(true);
    new_comment.classList.remove('template');
    new_comment.querySelector('.message').textContent = message;
    new_comment.querySelector('.author').textContent = author;
    new_comment.dataset.id = id;

    new_comment.querySelector('.delete').onclick = function (event) {
        const data = new FormData();
        data.set('id', id);

        xhttp.post('api.php?name=delete-comment', data, function (response) {
            new_comment.remove();
        });
    };

    new_comment.querySelector('.edit').onclick = function (event) {
        const data = new FormData();
        data.set('id', id);

        xhttp.post('api.php?name=get-comment', data, function (response) {
            popup.style.display = 'flex';
            form_update.querySelector('[name="id"]').value = response.comment.id;
            form_update.querySelector('[name="author"]').value = response.comment.author;
            form_update.querySelector('[name="message"]').value = response.comment.message;
        });
    };

    comment_block.append(new_comment);
}

let alt_is_down = false;
form.querySelector('textarea').onkeydown = function (event) {
    if (event.key === 'Alt') {
        alt_is_down = true;
    }
}
form.querySelector('textarea').onkeyup = function (event) {
    if (event.key === 'Alt') {
        alt_is_down = false;
    }
    else if (event.key === 'Enter') {
        if (alt_is_down === false) {
            submitForm(form);
        }
        else {
            this.value += '\n';
        }
    }
};

popup.onclick = function(event) {
    if (event.target == this) {
        this.style.display = 'none';
    }
};