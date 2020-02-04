$(document).ready(function() {
    $("#basic-datatable").DataTable({
        lengthMenu: [5, 10, 50],
        columnDefs: [{ orderable: false, targets: [0,2] }],
        language: {
            sLengthMenu: "Tampilkan _MENU_ entri",
            sSearch: "Cari: ",
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    });
});
