const form = document.getElementById('comments_form');
const output = document.getElementById('output');

form.onsubmit = function(event) {
    event.preventDefault();
    xhttp.postForm(this, function (response) {
        displayImage(response.id);
    });
}

xhttp.get('https://gratis-gap.000webhostapp.com/api.php?object=image&action=getAll', function (response) {
    for (let image of response.images) {
        displayImage(image.id);
    }
});

function displayImage(id) {
    const div = document.createElement('div');
    div.classList.add('image_wraper');

    const button = document.createElement('button');
    button.classList.add('delete');
    button.dataset.id = id;
    button.textContent = 'x';
    button.onclick = deleteImage;

    const img = document.createElement('img');
    const url = 'https://gratis-gap.000webhostapp.com/endpoint.php?name=png&id=' + id;
    img.src = url
    img.width = 200;


    div.append(img,button);
    output.append(div);
}

function deleteImage (event) {
    const btn = this;
    const id = this.dataset.id;
    const data = new FormData();
    data.set('id', id);
    xhttp.post('https://gratis-gap.000webhostapp.com/api.php?object=image&action=delete', data, function (response) {
        btn.parentNode.remove();
    });
}