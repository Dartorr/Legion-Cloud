let form = document.getElementById('authForm');

form.onsubmit = async (e) => {
    e.preventDefault();

    let data = new FormData(form);

    let req = await fetch('api/auth', {
        method: 'post',
        body: data
    });

    let resp = await req.json();
    console.log(resp)

    if (!resp.result) {
        alert('Ошибка: ' + resp.error)
    } else location.href = resp.url;
}
