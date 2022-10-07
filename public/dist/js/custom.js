$("#pdf-datatables").DataTable({
    "responsive": true,
    "buttons": [
        "copy", "csv", "excel", "pdf", "print", "colvis"
    ]
}).buttons().container().appendTo('#datatable-wrapper .col-md-6:eq(0)');