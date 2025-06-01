 

function makeRandNum(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}


function showImage(ele, event) {
    let parent = ele.closest(".imgcontainer")
    let iconWrapper = parent.querySelector(".icon-wrapper")

    const [file] = ele.files
    if (file) {
        iconWrapper.innerHTML = "";
        iconWrapper.innerHTML = `<img src="${URL.createObjectURL(file)}" >`;
    }
}
 


/* A variable to get edit modal*/
let editModal = document.getElementById('edit-item-modal');

if (editModal) {

    if (editModal.querySelector('.nav-tabs')) {
        editModal.querySelector('.nav-tabs').id = "tabEdit";
        let tabItems = editModal.querySelectorAll('.nav-link');
        let tabPanes = editModal.querySelectorAll('.tab-pane');
        tabItems.forEach(item => {
            item.href = item.getAttribute('href') + "Edit"
        })
        tabPanes.forEach(item => {
            item.id += "Edit"
        })
    }

    let labels = editModal.querySelectorAll('label');
    let inputs = editModal.querySelectorAll('input');
    let selects = editModal.querySelectorAll('select');
    labels.forEach(label => {
        if (label.getAttribute('for') != null) {
            label.setAttribute('for', label.getAttribute('for') + '-edit');
        }
    })
    inputs.forEach(input => {
        if (input.getAttribute('id') != null) {
            input.id += '-edit';
        }
    })
    selects.forEach(select => {
        if (select.getAttribute('id') != null) {
            select.id += '-edit';
        }
    })

}

/* A variable to get show modal*/
let showModal = document.getElementById('id04');


/* A function to send request for deleting the item */
function deleteItem(btn, e) {
    e.preventDefault();

    var form = $(btn).parents('form');
    var url = form.attr('action');
    var data = form.serialize();

    $.ajax({
        type: 'DELETE',
        data: data,
        url: url,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function beforeSend() {
            $(btn).button('loading');
            $('.error_txt').html('')
        },
        success: function success(data) {
            var html = '';
            if (data.status == 'success') {
                html = `<p class="alert alert-success form_msg">${data.message}</p>`;
                form[0].reset();
                location.reload();
            } else {
                //error
                html = `<p class="alert alert-danger form_msg">${data.message}</p>`;
            }
            $('#form_msg').html(html)
            $(btn).button('reset');
        },
        error: function error(res) {
            $(btn).button('reset');

            if (res.status === 422) {
                $.each(res.responseJSON.errors, function (key, value) {
                    //console.log(key,value)
                    var nKey = key.replaceAll('.', '_');
                    $('#box_' + nKey).addClass('has-error');
                    $('#msg_' + nKey).html(value);
                });
            } else {
                html = `<p class="alert alert-danger form_msg">Error</p>`;
                $('#form_msg').html(html)
            }
        }
    });
}

/* A function to send request for storing a item */
function storeItem(btn, e) {
    e.preventDefault();
    clearMsgs();

    let form = btn.closest('form');
    let url = form.getAttribute('action');
    let data = new FormData(form);

    $.ajax({
        type: 'POST',
        data: data,
        url: url,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function beforeSend() {
            $(btn).button('loading');
            $('.error_txt').html('')
        },
        success: function success(data) {

            var html = '';
            if (data.status == 'success') {
                html = `<p class="alert alert-success form_msg">${data.message}</p>`;
                form.reset();
                location.reload();
            } else {
                //error
                html = `<p class="alert alert-danger form_msg">${data.message}</p>`;
            }
            form.querySelector('.msg_form').innerHTML = html
            $(btn).button('reset');
        },
        error: function error(res) {
            $(btn).button('reset');

            if (res.status === 422) {
                $.each(res.responseJSON.errors, function (key, value) {
                    //console.log(key,value)
                    var nKey = key.replaceAll('.', '_');
                    if (form.querySelector(`[data-id=msg_${nKey}]`)) {
                        form.querySelector(`[data-id=msg_${nKey}]`).innerHTML = value;
                    }
                });
            } else {
                html = `<p class="alert alert-danger form_msg">Error</p>`;
                form.querySelector('.msg_form').innerHTML = html
            }
        }
    });
}

/* A function to send request for updating a item */
function updateItem(btn, e) {
    e.preventDefault();
    clearMsgs();

    let form = btn.closest('form');
    let url = form.getAttribute('action');
    let data = new FormData(form); 

    $.ajax({
        type: 'PUT',
        data: data,
        url: url,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function beforeSend() {
            $(btn).button('loading');
            $('.error_txt').html('')
        },
        success: function success(data) {

            let html = '';
            if (data.status == 'success') {
                html = `<p class="alert alert-success form_msg">${data.message}</p>`;
                form.reset();
                location.reload();
            } else {
                //error
                html = `<p class="alert alert-danger form_msg">${data.message}</p>`;
            }
            form.querySelector('.msg_form').innerHTML = html
            $(btn).button('reset');
        },
        error: function error(res) {
            $(btn).button('reset');

            if (res.status === 422) {
                $.each(res.responseJSON.errors, function (key, value) {
                    var nKey = key.replaceAll('.', '_');
                    if (form.querySelector(`[data-id=msg_${nKey}]`)) {
                        form.querySelector(`[data-id=msg_${nKey}]`).innerHTML = value;
                    }
                });
            } else {
                html = `<p class="alert alert-danger form_msg">Error</p>`;
                form.querySelector('.msg_form').innerHTML = html
            }
        }
    });
}

/* A function to send request  */
function send(btn, e) {
    e.preventDefault();

    clearMsgs();

    let form = btn.closest('form');
    let url = form.getAttribute('action');
    var data = new FormData(form);

    $.ajax({
        type: 'POST',
        data: data,
        url: url,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function beforeSend() {
            $(btn).button('loading');
            $('.error_txt').html('')
        },
        success: function success(data) {

            var html = '';
            if (data.status == 'success') {
                html = `<p class="alert alert-success form_msg">${data.message}</p>`;
                form.reset();
                location.reload();
            } else {
                //error
                html = `<p class="alert alert-danger form_msg">${data.message}</p>`;
            }
            form.querySelector('.msg_form').innerHTML = html
            $(btn).button('reset');
        },
        error: function error(res) {
            $(btn).button('reset');

            if (res.status === 422) {
                $.each(res.responseJSON.errors, function (key, value) {
                    //console.log(key,value)
                    var nKey = key.replaceAll('.', '_');
                    if (form.querySelector(`[data-id=msg_${nKey}]`)) {
                        form.querySelector(`[data-id=msg_${nKey}]`).innerHTML = value;
                    }
                });
            } else {
                html = `<p class="alert alert-danger form_msg">Error</p>`;
                form.querySelector('.msg_form').innerHTML = html
            }
        }
    });
}

/* A function to show the add modal*/
function showAddItemModal(btn, e) {
    let modal = document.getElementById('id01');
    clearMsgs();
    if (modal.querySelector('.icon-wrapper')) {
        modal.querySelector('.icon-wrapper').innerHTML = `<i class="fa fa-image" ></i>`;
    }

    let inputs = modal.querySelectorAll('input[type]:not([type="hidden"],[type="radio"],[type="checkbox"])');
    inputs.forEach(ele => {
        ele.value = '';
    })
    let textareas = modal.querySelectorAll('textarea');
    textareas.forEach(ele => {
        ele.value = '';
    })
    let selects = modal.querySelectorAll('select');
    selects.forEach(ele => {
        ele.value = '';
    })

    modal.style.display = 'block';
}

/* A function to update fcm for firebase */
function updateFcmToken(token, url) {

    $.ajax({
        type: 'PATCH',
        data: { token },
        url: url,
        success: function success(data) {
            // console.log(data)
        },
        error: function error(res) {

        }
    });
}

  
function generatePassword(btn) {
    let modal = btn.closest('.modal');
    let element = modal.querySelector('[name="password"');
    element.value = makeRandNum(8);
}
 
 