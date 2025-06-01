/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

let csrfToken = document.querySelector('meta[name="csrf-token"]').content;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': csrfToken
    }
});

/* A function to clear messages in forms */
function clearMsgs() {
    $('[data-id^=msg_]').html('');
    $('[class^=msg_]').html('');
}


function resetForm(formID) {
    document.getElementById(formID).querySelector('form').reset();
    clearMsgs();
}


/* A function to set input values according to the item in the edit modal*/
function setInputValues(modal, link, item) {
    clearMsgs();
    resetForm('edit-item-modal')
    if (item) {

        for (const property in item) {
            if (item[property] == null) continue;
            if (property == 'translations') {
                item[property].forEach((trans, index) => {
                    for (const pro in trans) {
                        if (modal.querySelector(`[name="${trans.locale}[${pro}]"`)) {
                            let element = modal.querySelector(`[name="${trans.locale}[${pro}]"`);
                            if (element.nodeName == 'INPUT') {
                                modal.querySelector(`[name="${trans.locale}[${pro}]"`).value = item.translations[index][pro];
                            }
                            else if (element.nodeName == 'TEXTAREA') {
                                modal.querySelector(`[name="${trans.locale}[${pro}]"`).value = item.translations[index][pro];
                                modal.querySelector(`[name="${trans.locale}[${pro}]"`).innerHTML = item.translations[index][pro];
                                if (element.classList.contains('summernote')) {
                                    element.nextElementSibling.querySelector('.note-editable').innerHTML = item.translations[index][pro];
                                }
                            }
                        }
                    }
                })
            }
            else if (modal.querySelector(`[name="${property}"]`)) {
                let element = modal.querySelector(`[name="${property}"`);
                if (element.nodeName == 'INPUT' && property != 'image' && element.type != 'radio' && element.type != 'checkbox') {
                    if (item[property] == null) element.value = '';
                    element.value = item[property];
                }
                else if (element.nodeName == 'INPUT' && element.type == 'radio') {
                    modal.querySelector(`input[name="${property}"][value="${item[property]}"]`).checked = true;
                } else if (element.nodeName == 'SELECT') {
                    element.querySelector(`option[value="${item[property]}"]`).selected = true;
                }
            }
        }

    }

    modal.querySelector('form').action = link;
}


/* A function to show the delete modal*/
function showDeleteItemModal(btn, e, itemTitle) {
    let modal = document.getElementById('delete-item-modal');
    let link = btn.getAttribute('data-href');
    modal.querySelector('form').action = link;
    modal.querySelector('.item-name').innerHTML = itemTitle;
    modal.style.display = 'block';
}
 
 
/* A function to show the edit modal*/
function showEditItemModal(btn, e, item) {
    let modal = document.getElementById('edit-item-modal');
    let link = btn.getAttribute('data-href') 
    setInputValues(modal, link, item)
    modal.style.display = 'block';
}
