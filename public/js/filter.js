let formF=document.getElementById('filterForm');

formF.onsubmit=async (e)=>{
    e.preventDefault();

    let formdata=new FormData(formF);

    let resp=await fetch('api/getFilesFilter',{
        method: 'post',
        body: formdata
    })

    let res=await resp.json();

    await refreshFilesFromResult(res);
}


async function refreshFilesFromResult(result) {
    preloader.style.display='block';

    let innerhtml = `<table id="filesTable">
            <tr class="fileRow">
                <td class="fileInfo">
                    Имя
                </td>
                <td class="fileInfo">
                    Расширение
                </td>
                <td class="fileInfo">
                    Размер
                </td>
                <td class="fileInfo">
                    Загружен
                </td>
                <td class="fileInfo">

                </td>
                <td class="fileInfo">

                </td>
            </tr>`;

    for (let i in result.files) {
        let filerow = `
            <tr class="fileRow">
            <td class="fileInfo">` + result.files[i].fileName + `
            </td>
            <td class="fileInfo">` + result.files[i].ext + `
            </td>
            <td class="fileInfo">` + result.files[i].size + `
            </td>
            <td class="fileInfo">` + result.files[i].created_at + `
            </td>
            <td class="fileInfo">
            <form action="/downloadFile">
            <input style="display: none"  type="text" value="` + result.files[i].url + `" name="url">
            <input  class="downloadButton" value="Скачать" type="submit">
            </form>
            </td>
            <td class="fileInfo">
            <input type="button" value="Удалить" onclick="deleteFileInFilter(` + result.files[i].id + `)">
            </td>
        </tr>`
        innerhtml += filerow;
    }

    innerhtml += `</table>`;

    document.getElementById("filesCont").innerHTML = innerhtml;
    preloader.style.display='none';
}


async function deleteFileInFilter(id) {
    if (confirm('Вы уверены, что хотите удалить этот файл?')) {
        let form = new FormData();
        form.append('id', id);

        let resp = await fetch("/api/deleteFile", {
            method: 'post',
            body: form
        })

        let result = await resp.json();

        if (result.result) {
            let formdata=new FormData(formF);

            let resp=await fetch('api/getFilesFilter',{
                method: 'post',
                body: formdata
            })

            let res=await resp.json();

            await refreshFilesFromResult(res);
        } else {
            alert('Что-то пошло не так. Ошибка: ' + result.error);
        }
    }
}

