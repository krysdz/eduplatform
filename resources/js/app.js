import { Tooltip } from 'bootstrap';

let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl);
});

tinymce.init({
    selector: '.tinymce',
    language: 'pl',
    plugins: [
        'advlist autolink link lists charmap hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
        'table emoticons paste help'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | link | ' +
        'forecolor backcolor emoticons | help',
    menubar: 'edit view insert format tools table help',
    height: 300,
});
