@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormResep" action="{{ url('/Foodcost/Resep') }}">
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
                                @if ($Resep)
                                    <small> <i class="fas fa-check"></i> Autosave dari resep
                                        {{ $Resep['nama'] }}</small>
                                @else
                                    <small> <i class="fas fa-check"></i> Autosave on</small>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="nama">Nama Resep</label>
                                    <input type="text" class="form-control"
                                        @isset($Resep['nama']) value="{{ $Resep['nama'] }}" @endisset
                                        id="nama" placeholder="Nama Resep" name="nama">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control select2" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        <option value="Makanan"
                                            @if ($Resep) @if ($Resep['kategori'] == 'Makanan') selected @endif
                                            @endif>Makanan</option>
                                        <option value="Minuman"
                                            @if ($Resep) @if ($Resep['kategori'] == 'Minuman') selected @endif
                                            @endif>Minuman</option>
                                        <option value="Dessert"
                                            @if ($Resep) @if ($Resep['kategori'] == 'Dessert') selected @endif
                                            @endif>Dessert</option>
                                        <option value="Snack"
                                            @if ($Resep) @if ($Resep['kategori'] == 'Snack') selected @endif
                                            @endif>Snack</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Satuan </label>
                                    <select name="satuan" id="satuan" class="form-control select2" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        @foreach ($satuan as $s1)
                                            <option value="{{ $s1['singkat'] }}"
                                                @if (isset($Resep['satuan'])) @if ($Resep['satuan'] == $s1['singkat']) selected @endif
                                                @endif>
                                                {{ $s1['nama'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="kode">Kode Product</label>
                                    <input type="text"
                                        @isset($Resep['nama']) value="{{ $Resep['kode'] }}" @else  value="{{ $kode }}" @endisset
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
                                    @isset($Resep['id'])
                                        <a class="btn btn-sm btn-success btn-block" data-toggle='modal' data-target='#Modal'
                                            onclick="pilihbahanbaku({{ $Resep['id'] }})"><i class="fas fa-plus"></i></a>
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
                                    @isset($Resep['id'])
                                        <a class="btn btn-sm btn-success btn-block" data-toggle='modal' data-target='#Modal'
                                            onclick="pilihbahanolahan({{ $Resep['id'] }})"><i class="fas fa-plus"></i></a>
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
                                        <td>HPP : </td>
                                        <td id="hpp">{{ $totaljml }}</td>
                                    </tr>
                                </table>
                            </div>

                            @if (request()->session()->get('IdResep'))
                                <div>Ket : <br>
                                    <font color="red">*</font> Jika anda ubah akan menjadi draft (nonaktif)<br>
                                    <font color="red">*</font> Simpan untuk aktif
                                </div>
                            @endif
                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        @if (request()->session()->get('IdResep'))
                            <a href="{{ url('/Foodcost/Resep/Session') }}" class="btn btn-danger">Keluar</a>
                        @endif
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
        //item bahan baku
        if ($("#managebahanbaku").length) {
            $("#managebahanbaku").DataTable({
                "ajax": {
                    url: "/Foodcost/Resep/ResepItemBahanBaku",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
                        '_method': 'patch'
                    },
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
                url: 'Resep/PilihBahanBaku',
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
                    url: "/Foodcost/Resep/ResepItemBahanOlahan",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
                        '_method': 'patch'
                    },
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
                url: 'Resep/PilihBahanOlahan',
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
            if ($('#FormResep').length) {
                $('#FormResep').validate({
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
                        'satuan': {
                            required: true
                        },
                        'kategori': {
                            required: true
                        }
                    },
                    messages: {
                        // id : "pesan"
                    }
                });

                $('#FormResep').on('submit', function(event) {
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

            $('#FormResep').on('change', function(event) {

                $('#FormResep').validate({
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
                        'satuan': {
                            required: true
                        },
                        'kategori': {
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
            $('#jmlbahan_' + id).html('Rp ' + formatRupiah(jml.toFixed()) + '');
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
            $('#totalbahanbaku').html('Total : Rp ' + formatRupiah(total.toFixed()) + '');

            jumlah(total, 0);

        }

        function jumlaholahan(id, value) {

            harga = $('#hargaolah_' + id).val();
            konversi = $('#hasil_' + id).val();


            jml = (harga / konversi) * value;
            $('#jmlolah_' + id).html('Rp ' + formatRupiah(jml.toFixed()) + '');
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
            $('#totalolahan').html('Total : Rp ' + formatRupiah(total.toFixed()) + '');

            jumlah(0, total);

        }


        function jumlah(bahan, olahan) {
            if (bahan) {
                var totalolahan = parseInt($('#totalolahan').html().replace('Total : Rp', '').replace('.', ''));
                j = formatRupiah((bahan + totalolahan).toFixed());
                $('#hpp').html('Rp ' + j + '');
            } else if (olahan) {
                var totalbahan = parseInt($('#totalbahanbaku').html().replace('Total : Rp', '').replace('.', ''));
                j = formatRupiah((olahan + totalbahan).toFixed());
                $('#hpp').html('Rp ' + j + '');
            } else {
                var totalolahan = parseInt($('#totalolahan').html().replace('Total : Rp', '').replace('.', ''));
                var totalbahanbaku = parseInt($('#totalbahanbaku').html().replace('Total : Rp', '').replace('.', ''));
                j = formatRupiah((totalbahanbaku + totalolahan).toFixed());
                $('#hpp').html('Rp ' + j + '');
            }

        }

        //delete
        function hapusitemresep(id) {
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
                        url: '/Foodcost/Resep/ResepItemHapus',
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
    </script>
@endsection
