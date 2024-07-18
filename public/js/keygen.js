async function generate(){
    let res=await (await fetch('/api/genCode',{
        method: 'post'
    })).json();
    console.log(res);

    if (res.result){
        document.getElementById('Code').innerHTML=res.code;
    }
    else {
        alert('Что-то пошло не так. Код ошибки: '+res.error);
    }
}
