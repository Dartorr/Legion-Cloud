let currentFolderId = 1;

let preloader=document.getElementById('preloader');
let addFolderFormCont=document.getElementById('addFolderFormCont');
let addFileFormCont=document.getElementById('addFileFormCont');


async function removeFolder() {
    if (confirm('Вы уверены, что хотите удалить эту папку со ВСЕМИ файлами?')) {
        let form = new FormData();
        form.append('id', currentFolderId);

        let result = await (await fetch("api/deleteFolder", {
            method: 'post',
            body: form
        })).json()

        console.log(result)

        if (result.result) {
            currentFolderId = 1;
            refreshFolders();
            refreshFiles(currentFolderId, 'Корпоративная');
        } else {
            alert('Что-то пошло не так. Ошибка: ' + result.error);
        }
    }
}

async function getUrl(url) {
    let form = new FormData();
    form.append('url', url);

    let result = await (await fetch("api/getUrl", {
        method: 'post',
        body: form
    })).json()

    console.log(result)

    if (result.result) {
        return result.url;
    } else {
        alert('Что-то пошло не так. Ошибка: ' + result.error);
    }
}

async function deleteFile(id) {
    if (confirm('Вы уверены, что хотите удалить этот файл?')) {
        let form = new FormData();
        form.append('id', id);

        let resp = await fetch("/api/deleteFile", {
            method: 'post',
            body: form
        })

        let result = await resp.json();

        if (result.result) {
            refreshFiles(currentFolderId);
        } else {
            alert('Что-то пошло не так. Ошибка: ' + result.error);
        }
    }
}

async function refreshFiles(id, foldername) {
    currentFolderId = id;
    preloader.style.display='block';

    let data = new FormData();
    data.append('folderId', id);
    let resp = await fetch("api/getFiles", {
        method: 'POST',
        body: data
    });
    document.getElementById('currentFolderName').innerHTML=foldername;
    let result = await resp.json();

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
            <input type="button" value="Удалить" onclick="deleteFile(` + result.files[i].id + `)">
            </td>
        </tr>`
        innerhtml += filerow;
    }
    innerhtml += `</table>`;
    document.getElementById("filesCont").innerHTML = innerhtml;

    preloader.style.display='none';
}

async function download(url) {
    let form = new FormData();
    form.append('url', url);

    let resp = await fetch("api/downloadFile", {
        method: 'Post',
        body: form
    })

    let res = resp.json();
    if (res == undefined) location.href(resp);
    else
        alert('Что-то пошло не так. Ошибка: ' + res.error);
}

async function refreshFolders() {
    preloader.style.display='block';
    let folders = document.getElementById('folders');

    let resp = await fetch("/api/getFolders", {
        method: "POST"
    });

    let result = await resp.json();
    console.log(result.folders)

    let innerhtml = "";

    for (let i in result.folders) {
        innerhtml += `<input type="button" value="` + result.folders[i].name +
            `" onclick="refreshFiles(` + result.folders[i].id + `, '` + result.folders[i].name +`')">`
    }
    innerhtml+=`<input type="button" value="Добавить папку" onclick="showNewFolderForm()">`;
    folders.innerHTML = innerhtml;
    preloader.style.display='none';
}

document.getElementById('create_folder').onsubmit = async (e) => {
    e.preventDefault();

    let form = new FormData(document.getElementById('create_folder'));

    let resp = await fetch("/api/addfolder", {
        method: "POST",
        body: form
    });

    let result = await resp.json();
    console.log(result.error)

    if (result.result) {
        addFolderFormCont.style.display='none';
        refreshFolders();
    } else {
        alert('Что-то пошло не так. Ошибка: ' + result.error);
    }


}

document.getElementById('addForm').onsubmit = async (e) => {
    e.preventDefault();

    let form = new FormData(document.getElementById('addForm'));
    form.append('folder', currentFolderId);

    let resp = await fetch("/api/addfile", {
        method: "POST",
        body: form
    });

    let result = await resp.json();
    console.log(result.error)

    if (result.result) {
        addFileFormCont.style.display='none';
        refreshFiles(currentFolderId);
    } else {
        alert('Что-то пошло не так. Ошибка: ' + result.error);
    }
}

function showNewFolderForm(){
    addFolderFormCont.style.display='flex';
}

function showNewFileForm(){
    addFileFormCont.style.display='flex';
}

function hideNewFolderForm(){
    addFolderFormCont.style.display='none';
}

function hideNewFileForm(){
    addFileFormCont.style.display='none';
}
