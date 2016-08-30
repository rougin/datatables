$(document).ready(function () {
  $('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: 'ajax.php',
    // columns: [
    //   { 'data': 'id' },
    //   { 'data': 'name' },
    //   { 'data': 'age' },
    //   { 'data': 'gender' },
    // ]
  });
});