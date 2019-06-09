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

    // Data tables
    $('#lendings').DataTable({
        columns: [
            null,
            null,
            null,
            {type: 'date-eu'},
            {type: 'date-eu'},
            {searchable: false, orderable: false}
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json'
        }
    });

    // Confirm Before
    $('body').on('click', '.confirm-before', function(event) {
        event.preventDefault();
        var link = $(this).data('href');

        swal({
            title: 'Você tem certeza?',
            text: 'Isso não pode ser desfeito.',
            icon: 'warning',
            buttons: ['Cancelar', 'Sim'],
            dangerMode: true,
        })
        .then((willDelete) => {
            if (! willDelete) {
                return;
            }

            window.location.href = link;
        });

        return false;
    });
});
