@extends('layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormOlahan" action="{{ url('/Foodcost/Olahan') }}">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Tambah {{ $title . ' ' . $subtitle }} </b></h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="divautosave">
                            <div class="text-right" id="autosave">
                                @if ($Olahan)
                                    <small> <i class="fas fa-check"></i> Autosave dari nama olahan
                                        {{ $Olahan['nama'] }}</small>
                                @else
                                    <small> <i class="fas fa-check"></i> Autosave on</small>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="nama">Nama Olahan</label>
                                    <input type="text" class="form-control"
                                        @isset($Olahan['nama']) value="{{ $Olahan['nama'] }}" @endisset
                                        id="nama" placeholder="Nama Olahan" name="nama">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Satuan Pengeluaran</label>
                                    <select name="satuan_pengeluaran" onchange="pengeluaran(this.value)"
                                        id="satuan_pengeluaran" class="form-control select2 select2-danger" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        @foreach ($satuan as $s1)
                                            <option value="{{ $s1['singkat'] }}"
                                                @if (isset($Olahan['satuan_pengeluaran'])) @if ($Olahan['satuan_pengeluaran'] == $s1['singkat']) selected @endif
                                                @endif>
                                                {{ $s1['nama'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Satuan Penyajian</label>
                                    <select name="satuan_penyajian" onchange="penyajian(this.value)" id="satuan_penyajian"
                                        class="form-control select2 select2-danger" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        @foreach ($satuan as $s2)
                                            <option value="{{ $s2['singkat'] }}"
                                                @if (isset($Olahan['satuan_penyajian'])) @if ($Olahan['satuan_penyajian'] == $s2['singkat']) selected @endif
                                                @endif>
                                                {{ $s2['nama'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Konversi Ke Penyajian</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend" id="konversib2">
                                        </div>
                                        <input type="text"
                                            @isset($Olahan['konversi_penyajian']) value="{{ $Olahan['konversi_penyajian'] }}" @endisset
                                            name="konversi_penyajian" id="konversi_penyajian" class="form-control"
                                            placeholder="Satuan Pengeluaran">
                                        <div class="input-group-append" id="konversib1">
                                            @isset($Olahan['satuan_penyajian'])
                                                <span class="input-group-text">
                                                    {{ $Olahan['satuan_penyajian'] }}
                                                </span>
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="kode">Kode Product</label>
                                    <input type="text"
                                        @isset($Olahan['nama']) value="{{ $Olahan['kode'] }}" @else  value="{{ $kode }}" @endisset
                                        disabled class="form-control" value="Pilih Kategori" id="kode" name="kode">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12">
                                <label>Bahan Baku</label>
                                <table id="managebahanbaku" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Bahan</th>
                                            <th scope="col">Satuan Pemakaian
                                            </th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Hasil Pemakaian</th>
                                            <th scope="col">Total Harga</th>
                                            <th scope="col">
                                                <i class="fas fa-trash"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <div id="idpilihitembahan">
                                    @isset($Olahan['id'])
                                        <a class="btn btn-sm btn-success btn-block" data-toggle='modal' data-target='#Modal'
                                            onclick="pilihbahanbaku({{ $Olahan['id'] }})"><i class="fas fa-plus"></i></a>
                                        <hr>
                                    @endisset
                                </div>

                                <div id="totalbahanbaku" class="float-right font-weight-bold">Total : {{ $Jmlbb }}
                                </div>
                            </div>

                            <div class="col-12 col-sm-12">
                                <label>Bahan Dari Olahan</label>
                                <table id="managebahanolahan" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Olahan</th>
                                            <th scope="col">Hasil Jadi
                                            </th>
                                            <th scope="col">Biaya Produksi</th>
                                            <th scope="col">Penyajian</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">
                                                <i class="fas fa-trash"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <div id="olahanitemolahan">
                                    @isset($Olahan['id'])
                                        <a class="btn btn-sm btn-success btn-block" data-toggle='modal' data-target='#Modal'
                                            onclick="pilihbahanolahan({{ $Olahan['id'] }})"><i
                                                class="fas fa-plus"></i></a>
                                        <hr>
                                    @endisset
                                </div>

                                <div id="totalolahan" class="float-right font-weight-bold">Total : {{ $Jmlbo }}
                                </div>
                                <br><br>
                            </div>

                            <div class="col-12 col-sm-12 ">
                                <table class="table float-right font-weight-bold text-right">
                                    <tr>
                                        <td>Biaya Produksi : </td>
                                        <td id="biayaproduksi">{{ $totaljml }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="hasil">Hasil Jadi</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control"
                                            @isset($Olahan['hasil']) value="{{ $Olahan['hasil'] }}" @endisset
                                            id="hasil" placeholder="Hasil Jadi" name="hasil">

                                        <div class="input-group-append" id="konversib2">
                                            @isset($Olahan['satuan_penyajian'])
                                                <span class="input-group-text">
                                                    {{ $Olahan['satuan_penyajian'] }}
                                                </span>
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url('/Foodcost/Olahan/Session') }}" class="btn btn-danger">Clear</a>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header text-white bg-secondary mb-3">
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Biaya Produksi</th>
                                <th>Hasil Jadi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

        <!-- /.container-fluid -->
    </section>
    <script>
        //Format Penulisan
        document.getElementById("konversi_penyajian").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });

        //item bahan baku
        if ($("#managebahanbaku").length) {
            $("#managebahanbaku").DataTable({
                "ajax": {
                    url: "/Foodcost/Olahan/OlahanItemBahanBaku",
                    type: "POST"
                },
                "responsive": true,
                "autoWidth": true,
                "processing": true,
                "searching": false,
                "sort": false,
                "paging": false,
                'info': false,
                "destroy": true,
            });
        }

        function pilihbahanbaku(id) {
            $.ajax({
                url: 'Olahan/PilihBahanBaku',
                type: "POST",
                data: {
                    id: id
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    popup('error', true, err.Message);
                },
                success: function(data) {
                    $('#ModalLabel').html('Pilih Bahan Baku');
                    $('#ModelView').html(data);
                }
            })

        }
        //item bahan baku


        //item bahan Olahan
        if ($("#managebahanolahan").length) {
            $("#managebahanolahan").DataTable({
                "ajax": {
                    url: "/Foodcost/Olahan/OlahanItemBahanOlahan",
                    type: "POST"
                },
                "responsive": true,
                "autoWidth": true,
                "processing": true,
                "searching": false,
                "sort": false,
                "paging": false,
                'info': false,
                "destroy": true,
            });
        }

        function pilihbahanolahan(id) {
            $.ajax({
                url: 'Olahan/PilihBahanOlahan',
                type: "POST",
                data: {
                    id: id
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    popup('error', true, err.Message);
                },
                success: function(data) {
                    $('#ModalLabel').html('Pilih Bahan Olahan');
                    $('#ModelView').html(data);
                }
            })

        }
        //item bahan Olahan

        //Input
        $(document).ready(function() {
            //Olahan
            if ($('#FormOlahan').length) {
                $('#FormOlahan').validate({
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
                        'satuan_pengeluaran': {
                            required: true
                        },
                        'satuan_penyajian': {
                            required: true
                        },
                        'konversi_penyajian': {
                            required: true
                        },
                        'pakai[]': {
                            required: true

                        }
                    },
                    messages: {
                        // id : "pesan"
                    }
                });

                $('#FormOlahan').on('submit', function(event) {
                    var isValid = $(this).valid();
                    event.preventDefault();
                    var formData = new FormData(this);
                    formData.append('submit', true);
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
                                    popup(data.status, data.toast, 'Berhasil dibuat');
                                    window.setTimeout(function() {
                                        location.reload()
                                    }, 2000);

                                } else {
                                    popup(data.status, data.toast, data.pesan);
                                }
                            }
                        });

                    }
                });
            }

            $('#FormOlahan').on('change', function(event) {

                $('#FormOlahan').validate({
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
                        'satuan_pengeluaran': {
                            required: true
                        },
                        'satuan_penyajian': {
                            required: true
                        },
                        'konversi_penyajian': {
                            required: true
                        }
                    },
                    messages: {
                        // id : "pesan"
                    }
                });
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
                                $('#manage').DataTable().ajax.reload();
                                $('#autosave').html(
                                    '<small style="color:green;"> <i class="fas fa-check"></i> ' +
                                    data.pesan +
                                    '</small>'
                                );
                                animateCSS('#autosave', 'flash');

                                $('#idpilihitembahan').html(
                                    '<a onclick="pilihbahanbaku(' + data.id +
                                    ',' + "'" + "Olahan" + "'" +
                                    ')" class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#Modal"><i class="fas fa-plus"></i></a><hr>'
                                );
                                $('#olahanitemolahan').html(
                                    '<a onclick="pilihbahanolahan(' + data.id +
                                    ',' + "'" + "Olahan" + "'" +
                                    ')" class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#Modal"><i class="fas fa-plus"></i></a><hr>'
                                );

                            } else {
                                $('#autosave').html(
                                    '<small  style="color:red;"> <i class="fas fa-times"></i> ' +
                                    data.pesan +
                                    '</small>'
                                );
                                animateCSS('#autosave', 'shakeX');
                            }
                        }
                    });
                }

            });
        });


        //calculasi
        function jumlahbahan(id, value) {

            harga = $('#hargabahan_' + id).val();
            konversi = $('#konversi_pemakaian_' + id).val();

            jml = (harga / konversi) * value;
            $('#jmlbahan_' + id).html('Rp ' + formatRupiah(jml) + ',00');
            $('#totalbahan_' + id).val(jml);

            total = 0;
            row = $('.totalbahan').length;
            for (let i = 0; i < row; i++) {
                if (i == id) {
                    total += jml;
                } else {
                    total += parseInt($('#totalbahan_' + i).val());
                }
            }
            $('#totalbahanbaku').html('Total : Rp ' + formatRupiah(total) + ',00 ');

            jumlah(0, total);

        }

        function jumlaholahan(id, value) {

            harga = $('#hargaolah_' + id).val();
            konversi = $('#hasil_' + id).val();


            jml = (harga / konversi) * value;
            $('#jmlolah_' + id).html('Rp ' + formatRupiah(jml) + ',00');
            $('#totalolah_' + id).val(jml);

            total = 0;
            row = $('.totalolah').length;
            for (let i = 0; i < row; i++) {
                if (i == id) {
                    total += jml;
                } else {
                    total += parseInt($('#totalolah_' + i).val());
                }
            }
            $('#totalolahan').html('Total : Rp ' + formatRupiah(total) + ',00 ');

            jumlah(0, total);

        }


        function jumlah(olahan, totalbahanbaku) {

            if (totalbahanbaku) {
                var totalolahan = parseInt($('#totalolahan').html().replace(
                    'Total : Rp',
                    ''));
                j = formatRupiah(totalolahan + totalbahanbaku);
                $('#biayaproduksi').html('Rp. ' + j + ',00');
            } else if (olahan) {
                var totalbahanbaku = parseInt($('#totalbahanbaku').html().replace(
                    'Total : Rp',
                    ''));
                j = formatRupiah(olahan + totalbahanbaku);
                $('#biayaproduksi').html('Rp. ' + j + ',00');
            } else {

                var totalolahan = parseInt($('#totalolahan').html().replace(
                    'Total : Rp',
                    ''));
                var totalbahanbaku = parseInt($('#totalbahanbaku').html().replace(
                    'Total : Rp',
                    ''));
                j = formatRupiah(totalbahanbaku + totalolahan);
                $('#biayaproduksi').html('Rp. ' + j + ',00');
            }

        }

        //delete
        function hapusitemoalahan(id) {
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
                        url: '/Foodcost/Olahan/OlahanItemHapus',
                        data: {
                            id: id
                        },
                        type: "POST",
                        dataType: 'json',
                        error: function(xhr, status, error) {
                            popup(status, true, xhr.status + " " + error);
                        },
                        success: function(data) {
                            if (data.status === 'success') {
                                $('#managebahanbaku').DataTable().ajax.reload();
                                $('#managebahanolahan').DataTable().ajax.reload();
                                $('#autosave').html(
                                    '<small style="color:green;"> <i class="fas fa-check"></i> ' +
                                    data.pesan +
                                    '</small>'
                                );
                                animateCSS('#autosave', 'flash');

                                popup(data.status, data.toast, data.pesan);
                            } else {
                                popup(data.status, data.toast, data.pesan);
                                $('#autosave').html(
                                    '<small  style="color:red;"> <i class="fas fa-times"></i> ' +
                                    data.pesan +
                                    '</small>'
                                );
                                animateCSS('#autosave', 'shakeX');
                            }
                        }
                    });
                }
            })
        }

        // $(document).ready(function() {

        //     var stickyNavTop = $('#divautosave').offset().top;

        //     var stickyNav = function() {

        //         var scrollTop = $(window).scrollTop();

        //         if (scrollTop > stickyNavTop) {

        //             $('#divautosave').css({
        //                 'position': 'fixed',
        //                 'top': 0,
        //                 'right': 0,
        //                 'padding': '10px',
        //                 'z-index': 9999,
        //                 'background': 'white',
        //                 'border-radius': '10px 0px 10px 0px',
        //                 'box-shadow': '5px 0px 5px 5px #888888'
        //             });

        //         } else {

        //             $('#divautosave').css({
        //                 'position': 'relative',
        //                 'background': 'unset',
        //                 'border-radius': 'unset',
        //                 'box-shadow': 'unset'
        //             });

        //         }

        //     };

        //     stickyNav();

        //     $(window).scroll(function() {

        //         stickyNav();

        //     });

        // });
    </script>
@endsection
