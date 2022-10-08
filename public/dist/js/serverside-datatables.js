// $(document).ready(function () {
//     $('#pdf-datatables').DataTable({
//         processing: true,
//         serverSide: true,
//         ajax: "serverside-companies-render.php",
//         "columns": [
//             { data: "id",  name: "id" },
//             { data: "logo",  name: "logo" },
//             { data: "name",  name: "name" },
//             { data: "email",  name: "email" },
//             { data: "employees_count",  name: "employees_count" },
//             { data: "created_at",  name: "created_at" },
//             { data: 'action', name: 'action' }
//         ]
//     });
// });

$("#pdf-datatables").DataTable({
    "responsive": true,
    "buttons": [
        "copy", "csv", "excel", "pdf", "print", "colvis"
    ]
}).buttons().container().appendTo('#datatable-wrapper .col-md-6:eq(0)');