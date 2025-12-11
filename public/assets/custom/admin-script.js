/* public/assets/custom/admin-script.js */

$(document).ready(function() {
    // Cek apakah ada elemen dengan ID content-editor?
    if ($('#content-editor').length) {

        // Aktifkan Summernote
        $('#content-editor').summernote({
            placeholder: 'Tulis isi konten halaman di sini...',
            tabsize: 2,
            height: 400, // Tinggi editor
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    }
});
