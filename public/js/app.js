"use strict";

jQuery(document).ready(function($) {
    // Select 2
    $('.select2').select2({language: 'pt-BR'});
    $('.select2-with-tags').select2({tags: true, language: 'pt-BR'});

    // Date range picker
    $('#lending-date').daterangepicker({
        autoUpdateInput: true,
        locale: {
            applyLabel: 'OK',
            cancelLabel: 'Cancelar',
        }
    });
});
