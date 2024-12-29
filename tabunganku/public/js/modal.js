document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('modalTercapai');
    if (modalElement) {
        var myModal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });
        myModal.show();
    }
});

function redirectToHome() {
    window.location.href = 'http://localhost/tabunganku/public/home/index';
}
