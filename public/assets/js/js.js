//penggunaan library
$(function() {

    //Initialize Select2 Elements
    $('.select2').select2().on("change", function(e) {
        $(this).valid()
    });

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
    // $('#reservationdate').datetimepicker({
    //     format: 'L'
    // });

    //Date and time picker
    // $('#reservationdatetime').datetimepicker({
    //     icons: {
    //         time: 'far fa-clock'
    //     }
    // });

    //Date range picker with time picker
    // $('#reservationtime').daterangepicker({
    //         timePicker: true,
    //         timePickerIncrement: 30,
    //         locale: {
    //             format: 'MM/DD/YYYY hh:mm A'
    //         }
    //     })
    //Date range as a button
    // $('#daterange-btn').daterangepicker({
    //         ranges: {
    //             'Today': [moment(), moment()],
    //             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //             'This Month': [moment().startOf('month'), moment().endOf('month')],
    //             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //         },
    //         startDate: moment().subtract(29, 'days'),
    //         endDate: moment()
    //     },
    //     function(start, end) {
    //         $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    //     }
    // )

    //Timepicker
    $('#timepicker').datetimepicker({
        format: 'HH:mm',
        use24hours: true
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
function popup($icon, $toast, $pesan, reset = null) {
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

    if (reset) {
        $(".select2").val("").trigger("change.select2");
        $(".select2").select2({
            placeholder: "Pilih",
        });
        $('.form-control').removeClass('is-valid');
        $(reset)[0].reset();

        if ($('.input-group-prepend')) {
            $('.input-group-prepend').html('');
        }
        if ($('.input-group-append')) {
            $('.input-group-append').html('');
        }

    }

    if ($('#manage')) {
        $('#manage').DataTable().ajax.reload();
    }

}

//autosave panel
$(document).ready(function() {

    if ($('#divautosave').length) {

        var stickyNavTop = $('#divautosave').offset().top;

        var stickyNav = function() {

            var scrollTop = $(window).scrollTop();

            if (scrollTop > stickyNavTop) {

                $('#divautosave').css({
                    'position': 'fixed',
                    'top': 0,
                    'right': 0,
                    'padding': '10px',
                    'z-index': 9,
                    'background': 'white',
                    'border-radius': '10px 0px 10px 0px',
                    'box-shadow': '5px 0px 5px 5px #888888'
                });

            } else {

                $('#divautosave').css({
                    'position': 'relative',
                    'background': 'unset',
                    'border-radius': 'unset',
                    'box-shadow': 'unset'
                });

            }

        };

        stickyNav();

        $(window).scroll(function() {

            stickyNav();

        });
    }

});

//form
$(document).ready(function() {
    //users
    if ($('#FormUsers').length) {
        $('#FormUsers').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
            rules: {
                'OutletUsers': {
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
                },
                'izin': {
                    required: true
                }
            },
            messages: {
                // id : "pesan"
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
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan, '#FormUsers');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                });

            }
        });
    }

    //store
    if ($('#FormStore').length) {
        $('#FormStore').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
            rules: {
                'nama': {
                    required: true
                },
                'status': {
                    required: true
                },
                'tipe': {
                    required: true
                },
                'alamat': {
                    required: true
                },
                'wa': {
                    required: true
                }
            },
            messages: {
                // OutletUsers : "Masih Kosong"
            }
        });

        $('#FormStore').on('submit', function(event) {
            var isValid = $(this).valid();
            event.preventDefault();
            var formData = new FormData(this);

            if (isValid) {
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan, '#FormStore');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                });

            }
        });
    }

    //Group
    if ($('#FormGroup').length) {
        $('#FormGroup').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
            rules: {
                'NamaGroup': {
                    required: true
                },
                'permission': {
                    required: true
                },
                'users[]': {
                    required: true
                }
            },
            messages: {
                // OutletUsers : "Masih Kosong"
            }
        });

        $('#FormGroup').on('submit', function(event) {
            var isValid = $(this).valid();
            event.preventDefault();
            var formData = new FormData(this);

            if (isValid) {
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan, '#FormGroup');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                });

            }
        });
    }

    //Supplier
    if ($('#FormSupplier').length) {
        $('#FormSupplier').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
            rules: {
                'nama': {
                    required: true
                },
                'alamat': {
                    required: true
                }
            },
            messages: {
                // OutletUsers : "Masih Kosong"
            }
        });

        $('#FormSupplier').on('submit', function(event) {
            var isValid = $(this).valid();
            event.preventDefault();
            var formData = new FormData(this);

            if (isValid) {
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan, '#FormSupplier');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                });

            }
        });
    }

    //Satuan
    if ($('#FormSatuan').length) {
        $('#FormSatuan').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
            rules: {
                'nama': {
                    required: true
                },
                'singkat': {
                    required: true
                }
            },
            messages: {
                // OutletUsers : "Masih Kosong"
            }
        });

        $('#FormSatuan').on('submit', function(event) {
            var isValid = $(this).valid();
            event.preventDefault();
            var formData = new FormData(this);

            if (isValid) {
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan, '#FormSatuan');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                });

            }
        });
    }

    //Bahan
    if ($('#FormBahan').length) {
        $('#FormBahan').validate({
            rules: {
                'nama': {
                    required: true
                },
                'kategori': {
                    required: true
                },
                'satuan_pembelian': {
                    required: true
                },
                'harga': {
                    required: true
                },
                'satuan_pemakaian': {
                    required: true
                },
                'konversi_pemakaian': {
                    required: true
                },
                'satuan_pengeluaran': {
                    required: true
                },
                'konversi_pengeluaran': {
                    required: true
                }
            },
            messages: {
                // OutletUsers : "Masih Kosong"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
        });

        $('#FormBahan').on('submit', function(event) {
            var isValid = $(this).valid();
            event.preventDefault();
            var formData = new FormData(this);

            if (isValid) {
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan, '#FormBahan');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                });

            }
        });
    }

    //Peralatan
    if ($('#FormPeralatan').length) {
        $('#FormPeralatan').validate({
            rules: {
                'nama': {
                    required: true
                },
                'kategori': {
                    required: true
                },
                'satuan_pembelian': {
                    required: true
                },
                'harga': {
                    required: true
                },
                'satuan_pemakaian': {
                    required: true
                },
                'konversi_pemakaian': {
                    required: true
                }
            },
            messages: {
                // OutletUsers : "Masih Kosong"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
        });

        $('#FormPeralatan').on('submit', function(event) {
            var isValid = $(this).valid();
            event.preventDefault();
            var formData = new FormData(this);

            if (isValid) {
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan, '#FormPeralatan');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                });

            }
        });
    }

    //Pegawai
    if ($('#FormPegawai').length) {
        $('#FormPegawai').validate({
            rules: {
                'nama': {
                    required: true
                },
                'store': {
                    required: true
                },
                'tempat_lahir': {
                    required: true
                },
                'tanggal_lahir': {
                    required: true
                },
                'tanggal_masuk': {
                    required: true
                },
                'agama': {
                    required: true
                },
                'gender': {
                    required: true
                },
                'alamat': {
                    required: true
                },
                'wa': {
                    required: true
                },
                'divisi': {
                    required: true
                },
                'jabatan': {
                    required: true
                },
                'status_pekerja': {
                    required: true
                }
            },
            messages: {
                // OutletUsers : "Masih Kosong"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
        });

        $('#FormPegawai').on('submit', function(event) {
            var isValid = $(this).valid();
            event.preventDefault();
            var formData = new FormData(this);

            if (isValid) {
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan, '#FormPegawai');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                });

            }
        });
    }


    //Inventory
    if ($('#FormInventory').length) {
        $('#FormInventory').validate({
            rules: {
                'nama': {
                    required: true
                },
                'qty': {
                    required: true
                },
                'satuan': {
                    required: true
                },
                'auto_harga': {
                    required: true
                },
                'harga': {
                    required: true
                },
                'margin': {
                    required: true
                }
            },
            messages: {
                // OutletUsers : "Masih Kosong"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
        });

        $('#FormInventory').on('submit', function(event) {
            var isValid = $(this).valid();
            event.preventDefault();
            var formData = new FormData(this);

            if (isValid) {
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan, '#FormInventory');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                });

            }
        });
    }



    //Opname Tambah Stock
    if ($('#FormInventoryOpname').length) {
        $('#FormInventoryOpname').validate({
            rules: {
                'nama': {
                    required: true
                },
                'qty': {
                    required: true
                },
                'status': {
                    required: true
                },
                'ket': {
                    required: true
                }
            },
            messages: {
                // OutletUsers : "Masih Kosong"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                $(element).removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            success: function(validClass, element) {
                $(element).addClass('is-valid');
            },
        });

        $('#FormInventoryOpname').on('submit', function(event) {
            var isValid = $(this).valid();
            event.preventDefault();
            var formData = new FormData(this);

            if ($('#status').val() == 'Tambah') {
                var status = 'Menambah';
            } else {
                var status = 'Mengurangi';
            }

            if (isValid) {

                Swal.fire({
                    title: 'Yakin Ingin ' + status + ' ?',
                    text: "Anda Akan " + status + " Kedalam Inventory Stock",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: status
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $(this).attr('action'),
                            type: "POST",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            error: function(xhr, status, error) {
                                popup(status, true, xhr.status + " " + error);
                            },
                            success: function(data) {
                                if (data.status === 'success') {
                                    popup(data.status, data.toast, data.pesan, '#FormInventoryOpname');
                                } else {
                                    popup(data.status, data.toast, data.pesan);
                                }
                            }
                        });
                    }
                })

            }
        });
    }

});

//Lainnya
$(document).ready(function() {
    //Tambah Jam Kerja
    $("#add_row_jam_kerja").unbind('click').bind('click', function() {
        var row_id = $(".row #isi_jam_kerja").length + 1;
        var html = '<div class="col-12 col-sm-12" id="isi_jam_kerja"><div class="form-group"><label for="nama_shift">Nama Shift</label> <input class="form-control" id="nama_shift" placeholder="Nama Shift" value="Shift ' + row_id + '" required name="nama_shift[]"></div></div><div class="col-12 col-sm-6"><div class="form-group"><label for="masuk_kerja">Masuk</label> <input type="time" class="form-control" id="masuk_kerja" name="masuk_kerja[]" value="06:00" required></div></div><div class="col-12 col-sm-6" id="akhir_isi_jam_kerja"><div class="form-group"><label for="pulang_kerja">Pulang</label> <input type="time" class="form-control" id="pulang_kerja" name="pulang_kerja[]" value="18:00" required></div></div>';
        if (row_id >= 2) {
            $(".row #akhir_isi_jam_kerja:last").after(html);
        }
    });


    //Tambah Belanja
    $("#add_row_belanja").unbind('click').bind('click', function() {
        $.ajax({
            url: 'Belanja/Namabarang',
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(data) {
                var row_id = $("#tambahbelanja tbody tr").length - 1;
                var html = '<tr id="tr_' + row_id + '"> <td style="padding-left: 50px;"><a class="btn btn-warning btn-sm" id="hapus_' + row_id + '" onclick="hapusbelanja(false,' + row_id + ')" style="margin-top: 3px;position: absolute;z-index: 9;left:20px;"><i class="fa fa-times"></i> </a><input type="hidden" value="" id="id_' + row_id + '" name="id[]"><input type="hidden" value="' + row_id + '" id="key_' + row_id + '" name="key[]"> <select name="nama[]" onchange="clicknama(this.value, ' + row_id + ')" id="nama_' + row_id + '" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;"> <option selected="true" disabled="disabled">Pilih</option> <option value="Oprasional">Oprasional</option> <option value="Supplay">Supplay</option> <option value="ART">ART</option>';

                for (let x = 0; x <= data.bahan.length - 1; x++) {
                    html += '<option value="' + data.bahan[x]['bahan_id'] + '">' + data.bahan[x]['nama'] + '</option>';
                }

                html += '</select> </td><td> <input type="hidden" name="kategori[]" id="kategori_val_' + row_id + '" value=""> <select disabled name="kategori[]" id="kategori_' + row_id + '" readonly class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger" style="width: 100%;"> <option selected="true" disabled="disabled">Pilih</option> <option value="Item">Item</option> <option value="Oprasional">Oprasional</option> <option value="Supplay">Supplay</option> <option value="ART">ART</option> </select> </td><td> <div class="row"> <div class="col"> <input type="number"  class="form-control" id="qty_' + row_id + '" onkeyup="hitung_belanja(this.value, ' + row_id + ')" placeholder="Qty"  name="qty[]"> </div><div class="col"> <select name="uombelanja[]"  id="uombelanja_' + row_id + '" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;"> <option selected="true" disabled="disabled">UOM</option>';

                for (let y = 0; y <= data.satuan.length - 1; y++) {
                    html += '<option value="' + data.satuan[y]['singkat'] + '">' + data.satuan[y]['nama'] + '</option>';
                }

                html += '</select> </div><div class="col"> <input type="number" class="form-control" onkeyup="hitung_belanja(this.value, ' + row_id + ')" id="harga_' + row_id + '" placeholder="Harga" name="harga[]"> </div></div></td><td id="item_' + row_id + '"  > - </td><td id="total_' + row_id + '"> - </td><td> <input type="text" class="form-control" id="ket" placeholder="Keterangan" name="ket[]" onchange="$(' + "'" + '#FormBelanja' + "'" + ').submit()"> </td><td><select style="border: unset;background: transparent;" name="hutang[]" onchange="$(' + "'" + '#FormBelanja' + "'" + ').submit()"><option value="0">Lunas</option><option value="1">Hutang</option></select></td></tr>';

                if (row_id >= 0) {
                    $("#tambahbelanja tbody tr:last").after(html);
                }

                $('.select2').select2().on("change", function(e) {
                    $(this).valid()
                });


            }
        });

    });
});


//popup
function Edit(id, title) {
    $.ajax({
        url: title + "/Edit",
        type: "POST",
        data: {
            id: id
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            popup('error', true, err.Message);
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
                    id: id
                },
                dataType: 'json',
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    if (data.status === 'success') {
                        popup(data.status, data.toast, data.pesan);
                    } else {
                        popup(data.status, data.toast, data.pesan);
                    }
                }
            })
        }
    })


}

//Fungsi Tombol
function pembelian(value) {
    $('#konversid1').html('<span class="input-group-text">' + value + '</span>');
    $('#konversid2').html('<span class="input-group-text">' + value + '</span>');
}

function pembelianedit(value) {
    $('#konversid1edit').html('<span class="input-group-text">' + value + '</span>');
    $('#konversid2edit').html('<span class="input-group-text">' + value + '</span>');
}

function pengeluaran(value) {
    $('#konversib2').html('<span class="input-group-text">' + value + '</span>');
}

function pengeluaranedit(value) {
    $('#konversib2edit').html('<span class="input-group-text">' + value + '</span>');
}

function pemakaian(value) {
    $('#konversib1').html('<span class="input-group-text">' + value + '</span>');
}

function pemakaianedit(value) {
    $('#konversib1edit').html('<span class="input-group-text">' + value + '</span>');
}

function penyajian(value) {
    $('#konversib1').html('<span class="input-group-text">' + value + '</span>');
    $('#konversib2').html('<span class="input-group-text">' + value + '</span>');
}

function penyajianedit(value) {
    $('#konversib1edit').html('<span class="input-group-text">' + value + '</span>');
    $('#konversib2edit').html('<span class="input-group-text">' + value + '</span>');
}

function hapusbelanja(id, row) {
    if (id == false) {
        $('#tr_' + row).html('');
    } else {
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
                    url: "Belanja/HapusItem",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan);
                            $('#tr_' + row).html('');
                        } else {
                            popup(data.status, data.toast, data.pesan);
                        }
                    }
                })
            }
        })
    }


}

function uploadbelanja() {

    Swal.fire({
        title: 'Yakin Upload?',
        text: "Data Tidak Akan Berubah & Item Akan Langsung Menambah Inventory!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Upload'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: "Belanja/Upload",
                type: "POST",
                dataType: 'json',
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    if (data.status === 'success') {
                        popup(data.status, data.toast, data.pesan);
                        setTimeout(
                            function() {
                                location.reload();
                            },
                            1000);
                    } else {
                        popup(data.status, data.toast, data.pesan);
                        setTimeout(
                            function() {
                                location.reload();
                            },
                            1500);
                    }
                }
            })
        }
    })
}


/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
}