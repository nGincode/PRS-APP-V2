//ajax setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//penggunaan library
$(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
      })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date picker
      $('#reservationdate').datetimepicker({
        format: 'L'
      });

      //Date and time picker
      $('#reservationdatetime').datetimepicker({
        icons: {
          time: 'far fa-clock'
        }
      });

      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })

      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()

      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()

      $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
      })

      $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      })

      bsCustomFileInput.init();


})


//alert
function popup($icon, $toast, $pesan) {
      if ($toast == true) {
        if ($icon === 'success') {
          Swal.fire({
            "toast": true,
            "icon": $icon,
            "position": "top-end",
            "title": $pesan,
            "text": "",
            "timer": 5000,
            "width": "32rem",
            "padding": "1.25rem",
            "showConfirmButton": false,
            "showCloseButton": true,
            "timerProgressBar": false,
            "customClass": {
              "container": null,
              "popup": null,
              "header": null,
              "title": null,
              "closeButton": null,
              "icon": null,
              "image": null,
              "content": null,
              "input": null,
              "actions": null,
              "confirmButton": null,
              "cancelButton": null,
              "footer": null
            },
          });
        } else if ($icon === 'info') {
          Swal.fire({
            "toast": true,
            "icon": $icon,
            "position": "top-end",
            "title": $pesan,
            "text": "",
            "timer": 5000,
            "width": "32rem",
            "padding": "1.25rem",
            "showConfirmButton": false,
            "showCloseButton": true,
            "timerProgressBar": false,
            "customClass": {
              "container": null,
              "popup": null,
              "header": null,
              "title": null,
              "closeButton": null,
              "icon": null,
              "image": null,
              "content": null,
              "input": null,
              "actions": null,
              "confirmButton": null,
              "cancelButton": null,
              "footer": null
            },
          });
        } else if ($icon === 'warning') {
          Swal.fire({
            "toast": true,
            "icon": $icon,
            "position": "top-end",
            "title": $pesan,
            "text": "",
            "timer": 5000,
            "width": "32rem",
            "padding": "1.25rem",
            "showConfirmButton": false,
            "showCloseButton": true,
            "timerProgressBar": false,
            "customClass": {
              "container": null,
              "popup": null,
              "header": null,
              "title": null,
              "closeButton": null,
              "icon": null,
              "image": null,
              "content": null,
              "input": null,
              "actions": null,
              "confirmButton": null,
              "cancelButton": null,
              "footer": null
            },
          });
        } else if ($icon === 'question') {
          Swal.fire({
            "toast": true,
            "icon": $icon,
            "position": "top-end",
            "title": $pesan,
            "text": "",
            "timer": 5000,
            "width": "32rem",
            "padding": "1.25rem",
            "showConfirmButton": false,
            "showCloseButton": true,
            "timerProgressBar": false,
            "customClass": {
              "container": null,
              "popup": null,
              "header": null,
              "title": null,
              "closeButton": null,
              "icon": null,
              "image": null,
              "content": null,
              "input": null,
              "actions": null,
              "confirmButton": null,
              "cancelButton": null,
              "footer": null
            },
          });
        } else {
          Swal.fire({
            "toast": true,
            "icon": "error",
            "position": "top-end",
            "title": $pesan,
            "text": "",
            "timer": 5000,
            "width": "32rem",
            "padding": "1.25rem",
            "showConfirmButton": false,
            "showCloseButton": true,
            "timerProgressBar": false,
            "customClass": {
              "container": null,
              "popup": null,
              "header": null,
              "title": null,
              "closeButton": null,
              "icon": null,
              "image": null,
              "content": null,
              "input": null,
              "actions": null,
              "confirmButton": null,
              "cancelButton": null,
              "footer": null
            },
          });
        }
      } else {

      }

}

//form
$(document).ready(function() {
      //users
    if ($('#FormUsers').length) {
        $('#FormUsers').validate({
          errorClass: 'error',
          rules: {
            'OutletUsers': {
              required: true
            },
            'GroupsUsers': {
              required: true
            },
            'Email': {
              required: true,
              email: true
            },
            'Username': {
              required: true,
              minlength: 6
            },
            'PasswordUsers': {
              required: true,
              minlength: 6
            },
            'PasswordRipet': {
              required: true,
              equalTo: "#PasswordUsers"
            },
            'NamaDepanUsers': {
              required: true
            },
            'NamaBelakangUsers': {
              required: true
            },
            'NoUsers': {
              required: true
            }
          },
          messages: {
            // OutletUsers : "Masih Kosong"
          }
        });

        $('#FormUsers').on('submit', function(event) {
          var isValid = $(this).valid();
          event.preventDefault();
          var formData = new FormData(this);

          if (isValid) {
            $.ajax({
              url: $(this).attr('action'),
              type: "POST",
              data: formData,
              cache:false,
              contentType: false,
              processData: false,
              dataType: 'json',
              success: function(data) {
                if (data.status === 'success') {
                  popup(data.status, data.toast, data.pesan);
                  $('#FormUsers')[0].reset();
                } else {
                  popup(data.status, data.toast, data.pesan);
                }
              }
            });

          }
        });
    }
});


//popup
function Edit(id, title) {
    $.ajax({
            url: title + "/Edit",
            type: "POST",
            data: {
                id:id
            },
            success: function(data) {
                $('#ModalLabel').html('Edit ' + title);
                $('#ModelView').html(data);
            }
    })
        
}


function Hapus(id, title) {
    Swal.fire({
    title: 'Yakin Menghapus?',
    text: "Data Akan Dihapus Permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Hapus'
  }).then((result) => {
    if (result.isConfirmed) {
      
      $.ajax({
              url: title + "/Hapus",
              type: "POST",
              data: {
                  id:id
              },
              dataType: 'json',
              success: function(data) {
                  if (data.status === 'success') {
                    popup(data.status, data.toast, data.pesan);
                    $('#FormUsers')[0].reset();
                  } else {
                    popup(data.status, data.toast, data.pesan);
                  }
              }
      })
    }
})

        
}

