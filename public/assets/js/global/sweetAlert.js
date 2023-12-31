class AlertMessages {
    static showAlerts(messages, icon, timer) {
        if (typeof messages === 'string') {
            messages = [messages];
        }
        if (typeof messages === 'object') {
            messages = Object.keys(messages).map(function (key) { return messages[key]; });
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
    static confirmModal(title, html, icon) {
        return new Promise((resolve, reject) => {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger me-3"
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
                    resolve(true);
                } else {
                    resolve(false);
                }
            });
        });
    }

}
