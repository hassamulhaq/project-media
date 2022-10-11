function showSpinner() {
    $('#screen-spinner').removeClass('invisible');
}

function removeSpinner() {
    $('#screen-spinner').addClass('invisible');
}


$('.ajax_form').submit( function (e) {
    ajaxRequest(e);
})

let SHOW_CONSOLE_MSG = true;
function ajaxRequest(e) {
    e.preventDefault();

    const $form = $(e.currentTarget);

    const url = $form.attr('action')
    const method = $form.attr('method')
    const formData = new FormData($form[0]);

    let ajax_progress = $('#ajax_progress')
    let ajax_progress_bar = ajax_progress.children('.progress-bar');

    showSpinner();
    $.ajax({
        xhr: function () {
            const xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    const percentComplete = Math.round((evt.loaded / evt.total) * 100)
                    ajax_progress_bar.width(percentComplete + '%');
                    ajax_progress_bar.html(percentComplete + '%');
                }
            }, false);
            return xhr;
        },
        url: url,
        method: method,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "JSON",
        beforeSend: function () {
            ajax_progress_bar.width('0%');
        },
        error: function (response) {
            if (SHOW_CONSOLE_MSG) console.log('fail:', response)
            alertAjaxResponse(response);
            removeSpinner()
        },
        success: function (response) {
            if (SHOW_CONSOLE_MSG) console.log('true:', response)
            if (response.success) {
                alertAjaxResponse(response);
                $form.trigger('reset');
            } else if (response.success === false) {
                if (SHOW_CONSOLE_MSG) console.log('false:', response)
                alertAjaxResponse(response);
            } else {
                console.log(response)
            }
            removeSpinner()
        }
    });
}


function alertAjaxResponse(response) {
    if (response === '' || response === undefined || response === 'undefined') return false;

    let title, icon, html = '';

    if (response.hasOwnProperty('responseText')) {
        response = JSON.parse(response.responseText);

        if (response.success === false) {
            if (response.data) {
                title = response.message;
                icon = 'error';
            }
        }
    }

    if (response.success === false) {
        if (response.data) {
            title = response.message;
            icon = 'error';
        }
    }

    if (response.success === true) {
        if (response.data) {
            title = response.message;
            icon = 'success';
        }
    }

    // check response has data object
    if (response.data) {
        const dataObj = response.data;
        html += "<ul>";
        Object.keys(dataObj).forEach(function (key) {
            html += `<li><span class="font-medium">${key}: </span>${dataObj[key]} </li>`
        });
        html += "</ul>";
    }

    Toast.fire({
        icon: icon,
        title: title,
        html: html
    })
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})