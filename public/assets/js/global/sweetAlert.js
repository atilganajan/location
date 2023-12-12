class AlertMessages {
    static showAlerts(messages, icon, timer) {
        if (typeof messages === 'string') {
            messages = [messages];
        }

        let showMessages = "";
        messages.forEach(message => {
            showMessages +=`${message} <br>`
        });

        Swal.fire({
            icon: icon,
            html: showMessages,
            showConfirmButton: false,
            timer: timer
        });
    }

    static showSuccess(messages, timer) {
        this.showAlerts(messages, "success", timer);
    }

    static showError(messages, timer) {
        this.showAlerts(messages, "error", timer);
    }

    static showWarning(messages, timer) {
        this.showAlerts(messages, "warning", timer);
    }

    static showInfo(messages, timer) {
        this.showAlerts(messages, "info", timer);
    }
}

class AlertConfirmModals {
    static confirmModal(title,html,icon){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: title,
            html: html,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
               return true;
            }
            return false;
        });
    }

    static okModal(title,html,icon){
        Swal.fire({
            title: title,
            html: html,
            icon: icon
        });
    }



}
