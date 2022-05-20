const form = document.getElementById('comments_form');

form.onsubmit = function(event) {
    event.preventDefault();
    xhttp.postForm(this, function (response) {
        console.log(response);
    });

}