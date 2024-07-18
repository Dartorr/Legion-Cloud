document.getElementById('regform').onsubmit = async (e) => {
    e.preventDefault();

    let form = new FormData(document.getElementById('regform'));

    let resp = await fetch("/api/reg", {
        method: "POST",
        body: form
    });

    let result = await resp.json();
    console.log(result)

    if (result.result) {
        location.href = result.url;
    } else {
        document.getElementById('name_errors').innerHTML='';
        document.getElementById('inv_code_errors').innerHTML='';
        document.getElementById('password_errors').innerHTML='';
        let k=0;
        for (key in result.error){
            k++;
            document.getElementById(key+'_errors').innerText=result.error[key];
        }
        if (result.ex!=undefined)
            alert('Что-то пошло не так. Ошибка: '+result.ex);
    }
}

