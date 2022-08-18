console.log('locked and loaded')

jQuery(document).ready(function() {
    jQuery('#last-login-table').DataTable( {
        pageLength: 3,
        dom: 'Bfrtip',
        buttons: [
            'copy',
            {
              extend: 'excelHtml5',
              header: false,
              title: null
            },{
              extend: 'csvHtml5',
              header: false,
              title: null
            }          
        ]
    } );
} );