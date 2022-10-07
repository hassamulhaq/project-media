$("#pdf-datatables").DataTable({
    "responsive": true,
    "buttons": [
        "copy", "csv", "excel", "pdf", "print", "colvis"
    ]
}).buttons().container().appendTo('#datatable-wrapper .col-md-6:eq(0)');




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

    showSpinner();
    const jqxhr = $.ajax({
        url: url,
        method: method,
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        dataType: "JSON",
    });
    jqxhr.done(function (response) {
        removeSpinner()
        if (SHOW_CONSOLE_MSG) console.log('done:', response)
        alertAjaxResponse(response);
        if (response.success === true) $form.trigger('reset');
    })
    jqxhr.fail(function (response) {
        removeSpinner()
        if (SHOW_CONSOLE_MSG) console.log('fail:', response)
        alertAjaxResponse(response);
    })
    jqxhr.always(function (response) {
        removeSpinner()
        //if (SHOW_CONSOLE_MSG) console.log('always:', response)
        //alertAjaxResponse(response);
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