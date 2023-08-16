import Swal from 'sweetalert2';
export class Alert {
    static success(message, options = {}) {

        const defaultOptions = {
            confirmButtonColor: '#357B7C',
            ...options,
        };

        return Swal.fire({
            titleText: 'Succès', 
            html: message,
            icon: 'success',
            ...defaultOptions,
        })
    }

    static error(message, options = {}) {
        return Swal.fire({
            titleText: 'Oups', 
            html: message,
            icon: 'error',
            ...options,
        })
    }

    static async confirm(message, callable, options = {}) {
        const defaultOptions = {
            confirmButtonColor: '#357B7C',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'Valider',
            reverseButtons: true,
            ...options,
        };

        return Swal.fire({
            titleText: 'Confirmation',
            html: message,
            icon: 'warning',
            showCancelButton: true,
            ...defaultOptions,
          }).then(callable);
    }
}
