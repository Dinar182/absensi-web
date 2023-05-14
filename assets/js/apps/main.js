var base_url = $('meta[name="base_url"]').attr('content'),
    base_url_ajax = base_url + 'ajax';

$(document).on('submit', 'form.ajax-form', function(e){
    e.preventDefault();
    return false;
});

$('.date-picker').datepicker({
    format: 'yyyy-mm-dd',
});

$('.date-picker-range').datepicker({
    format: 'yyyy-mm-dd',
});

const alert_successfuly = (title, message, direct_uri) => {
    return Swal.fire({
        icon: 'success',
        title: title,
        html: message,
        width: '350px',
        timer: 3000,
        timerProgressBar: true,
        onBeforeOpen: function onBeforeOpen() {
            Swal.showLoading();
        }
    }).then(function (result) {
        if (result.dismiss === Swal.DismissReason.timer) {
            window.location.href = direct_uri;
        }
    });
}

const basic_alert = (icon, title,message) => {
    return Swal.fire({
        icon: icon,
        title: title,
        html: message,
        width: '300px',
    });
}

function toaster_notification ({message, alert, position = 'top-right'}) {
    toastr.clear();

    return NioApp.Toast(message, alert, {
      position: position,
      ui: 'is-dark'
    });   
}

function blockUI() {
	$.blockUI({ 
            message: '<i class="spinner-border" role="status"></i>',
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                padding: 0,
                zIndex: 1201,
                backgroundColor: 'transparent'
            }
        });
}

function unBlockUI() {
	$.unblockUI();
}
