const form = document.getElementById('comments_form');
const comment_block = document.querySelector('.comments');
const comment_template = comment_block.querySelector('.template');

xhttp.get('api.php?name=get-comments', function (response) {
    for (let comment of response.comments) {
        addComment(comment.author, comment.message);
    }
})

form.onsubmit = function (event) {
    event.preventDefault();
    xhttp.postForm(this, function (response) {
        addComment(response.author, response.message);
    });
};

function addComment(author, message) {
    const new_comment = comment_template.cloneNode(true);
    new_comment.classList.remove('template');
    new_comment.querySelector('.message').textContent = message;
    new_comment.querySelector('.author').textContent = author;

    comment_block.append(new_comment)
}