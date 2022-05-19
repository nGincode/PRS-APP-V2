@extends('layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormSupplier" action="{{ url('/Master/Supplier') }}">
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
                        <div class="row">


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="tgl">Tanggal Laporan</label>
                                    <input type="date" disabled class="form-control" id="tgl" value="<?= date('Y-m-d') ?>"
                                        name="tgl">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12">
                                <label for="nama">Input</label>
                                <table id="tambahbelanja" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Kategori</th>
                                            <th style="min-width: 300px">Qty Belanja</th>
                                            <th style="min-width: 150px">Konversi</th>
                                            <th>Total</th>
                                            <th>Keterangan</th>
                                            <th>Hutang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7">
                                                <a class="btn btn-success btn-block" id="add_row_belanja"><i
                                                        class="fas fa-plus"></i></a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="card-footer">
                        *Belanja hanya dapat input sesuai tanggal sekarang
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header text-white bg-secondary mb-3">
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Pembayaran</th>
                                <th>Tipe</th>
                                <th>Rekening</th>
                                <th>No Wa</th>
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
        //Input
        $(document).ready(function() {
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

        function clicknama(id, row) {
            if (id === 'Oprasional') {
                $('#kategori_' + row).val('Oprasional');
                $('#kategori_' + row).trigger('change');
                $('#master_' + row).html('-');
                $('#uombelanja_' + row).prop('disabled', false);

            } else if (id === 'Supplay') {
                $('#kategori_' + row).val('Supplay');
                $('#kategori_' + row).trigger('change');
                $('#master_' + row).html('-');
                $('#uombelanja_' + row).prop('disabled', false);
            } else {
                $('#kategori_' + row).val('Item');
                $('#kategori_' + row).trigger('change');

                $.ajax({
                    url: 'Belanja/Masterbahan',
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        // $('#master_' + row).html('-');

                        // $('#master_' + row).html(
                        //     ' <div class="row"> <div class="col"> <input type="text" class="form-control" value="1 ' +
                        //     data.satuan_pembelian +
                        //     '"></div> <div class="col"><input type="text" class="form-control" value="1 ' +
                        //     data.satuan_pembelian + '"></div></div>');
                        $('#master_' + row).html(
                            '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">1 ' +
                            data.satuan_pembelian +
                            '</span></div><input style="text-align: right;max-width:50px;" type="text" disabled value="1" name="konversi" id="konversi_' +
                            row +
                            '" class="form-control" placeholder="Konversi"><div class="input-group-append"><span class="input-group-text" id="belanja_uom_' +
                            row + '">' +
                            data.satuan_pembelian + '</span></div></div><input type="hidden" value="' + data
                            .satuan_pembelian + '" id="konversi_satuan_' + row + '">'
                        );
                        // $('#uombelanja_' + row).prop('disabled', true);
                        $('#uombelanja_' + row).val(data.satuan_pembelian);
                        $('#uombelanja_' + row).trigger('change.select2');
                        $('#harga_' + row).val(data.harga);
                    }
                })
            }
        }

        function hitung_belanja(id, row) {
            qty = parseInt($('#qty_' + row).val());
            harga = parseInt($('#harga_' + row).val());
            if (qty && harga) {
                total = qty + harga;
                $('#total_' + row).html('Rp. ' + total);
            }
        }

        function konversi_belanja(row) {
            let satuan = $('#konversi_satuan_' + row).val();
            let kon = $('#konversi_' + row).val();
            let belanja_uom = $('#belanja_uom_' + row).html(satuan);
            console.log(belanja_uom);
            if (satuan == kon) {
                $('#konversi_' + row).prop('disabled', false);
            }
        }
    </script>
@endsection
