document.addEventListener('DOMContentLoaded', function () {
    const formModalUbah = document.getElementById('formModalUbah');
    if (formModalUbah) {
        formModalUbah.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nominal = button.getAttribute('data-nominal');
            const keterangan = button.getAttribute('data-keterangan');

            formModalUbah.querySelector('#id').value = id;
            formModalUbah.querySelector('#nominal').value = nominal;
            formModalUbah.querySelector('#keterangan').value = keterangan;
        });
    }
});

const formModalUbah = document.getElementById('formModalUbah');
if (!formModalUbah) {
    console.error('Elemen dengan ID "formModalUbah" tidak ditemukan.');
}


