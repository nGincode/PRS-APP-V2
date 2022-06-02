@extends('layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormBelanja" action="{{ url('/Belanja') }}">
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
                                <small> <i class="fas fa-check"></i> Autosave on</small>
                            </div>
                        </div>
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
                                        @foreach ($Data as $key => $v)
                                            <tr>
                                                <td style="padding-left: 15px;">
                                                    <a class="btn btn-danger btn-sm" onclick="hapus({{ $v['id'] }})"
                                                        style="margin-top: 3px;position: absolute;z-index: 9;left: -10px;"><i
                                                            class="fa fa-times"></i>
                                                    </a>
                                                    <select name="nama[]"
                                                        onchange="clicknama(this.value, {{ $key }})"
                                                        id="nama_{{ $key }}"
                                                        class="form-control select2 select2-danger"
                                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                        <option selected="true" disabled="disabled">Pilih</option>
                                                        <option value="Oprasional"
                                                            @if ($v['nama'] == 'Oprasional') selected @endif>Oprasional
                                                        </option>
                                                        <option value="Supplay"
                                                            @if ($v['nama'] == 'Supplay') selected @endif> Supplay
                                                        </option>
                                                        @foreach ($bahan as $bhn)
                                                            <option value="{{ $bhn['id'] }}"
                                                                @if ($v['bahan_id'] == $bhn['id']) selected @endif>
                                                                {{ $bhn['nama'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td> <select name="kategori[]" id="kategori_{{ $key }}" disabled
                                                        class="form-control select2 select2-danger"
                                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                        <option selected="true" disabled="disabled">Pilih Nama</option>
                                                        <option value="Item"
                                                            @if ($v['bahan_id'] > 0) selected @endif>Item</option>
                                                        <option value="Oprasional"
                                                            @if ($v['nama'] == 'Oprasional') selected @endif>Oprasional
                                                        </option>
                                                        <option value="Supplay"
                                                            @if ($v['nama'] == 'Supplay') selected @endif>Supplay
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="number" class="form-control"
                                                                id="qty_{{ $key }}" value="{{ $v['qty'] }}"
                                                                onkeyup="hitung_belanja(this.value, {{ $key }})"
                                                                placeholder="Qty" name="qty[]">
                                                        </div>
                                                        <div class="col">
                                                            <select name="uombelanja[]"
                                                                onchange="konversi_belanja({{ $key }})"
                                                                id="uombelanja_{{ $key }}"
                                                                class="form-control select2 select2-danger"
                                                                data-dropdown-css-class="select2-danger"
                                                                style="width: 100%;">
                                                                <option selected="true" disabled="disabled">UOM</option>4
                                                                @foreach ($satuan as $stn)
                                                                    <option value="{{ $stn['singkat'] }}"
                                                                        @if ($v['uom'] == $stn['singkat']) selected @endif>
                                                                        {{ $stn['nama'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" class="form-control"
                                                                onkeyup="hitung_belanja(this.value, {{ $key }})"
                                                                id="harga_{{ $key }}" value="{{ $v['harga'] }}"
                                                                placeholder="Harga" name="harga[]">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="item_{{ $key }}">
                                                    @if ($v['bahan_id'])
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">{{ $v['item_uom'] }}
                                                                </span>
                                                            </div>
                                                            <input onkeyup="hitung_belanja(this.value,{{ $key }})"
                                                                style="text-align: right;max-width:50px;" type="text"
                                                                @if ($v['item_uom'] == $v['uom']) disabled value="1" @else value="{{ $v['konversi'] }}" @endif
                                                                name="konversi[]" id="konversi_{{ $key }}"
                                                                class="form-control" placeholder="Konversi">
                                                            <div class="input-group-append"><span class="input-group-text"
                                                                    id="belanja_uom_{{ $key }}">
                                                                    {{ $v['uom'] }}</span></div>
                                                        </div><input type="hidden" value="{{ $v['item_uom'] }}"
                                                            id="konversi_satuan_{{ $key }}">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td id="total_{{ $key }}">
                                                    @if ($v['total'])
                                                        Rp. {{ $v['total'] }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td> <input type="text" class="form-control" value="{{ $v['ket'] }}"
                                                        id="ket" placeholder="Keterangan" name="ket[]"
                                                        onchange="$('#FormBelanja').submit()">
                                                </td>
                                                <td><input name="hutang[]" class="form-control"
                                                        @if ($v['hutang']) checked @endif type="checkbox"
                                                        value="1" onchange="$('#FormBelanja').submit()">
                                                </td>
                                            </tr>
                                        @endforeach
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
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
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
        function clicknama(id, row) {
            if (id === 'Oprasional') {
                $('#kategori_' + row).val('Oprasional');
                $('#kategori_' + row).trigger('change');
                $('#item_' + row).html('-');
                $('#uombelanja_' + row).prop('disabled', false);
                $('#FormBelanja').submit();

            } else if (id === 'Supplay') {
                $('#kategori_' + row).val('Supplay');
                $('#kategori_' + row).trigger('change');
                $('#item_' + row).html('-');
                $('#uombelanja_' + row).prop('disabled', false);
                $('#FormBelanja').submit();
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
                        $('#item_' + row).html(
                            '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text">1 ' +
                            data.satuan_pembelian +
                            '</span></div><input onkeyup="hitung_belanja(this.value,' + row +
                            ')" style="text-align: right;max-width:50px;" type="text" disabled value="1" name="konversi[]" id="konversi_' +
                            row +
                            '" class="form-control" placeholder="Konversi"><div class="input-group-append"><span class="input-group-text" id="belanja_uom_' +
                            row + '">' +
                            data.satuan_pembelian + '</span></div></div><input type="hidden" value="' + data
                            .satuan_pembelian + '" id="konversi_satuan_' + row + '">'
                        );
                        $('#uombelanja_' + row).val(data.satuan_pembelian);
                        $('#uombelanja_' + row).trigger('change.select2');
                        $('#harga_' + row).val(data.harga);
                    }
                });
                $('#FormBelanja').submit();
            }
        }

        function hitung_belanja(id, row) {
            qty = parseInt($('#qty_' + row).val());
            harga = parseInt($('#harga_' + row).val());
            konversi = parseInt($('#konversi_' + row).val());
            if (qty && harga) {
                if (konversi) {
                    total = qty * harga;
                    jmlttl = total * konversi;
                    $('#total_' + row).html('Rp. ' + jmlttl);
                } else {
                    total = qty * harga;
                    $('#total_' + row).html('Rp. ' + total);
                }
            }
            $('#FormBelanja').submit();
        }

        function konversi_belanja(row) {
            let satuan = $('#konversi_satuan_' + row).val();
            let uom = $('#uombelanja_' + row).val();

            $('#belanja_uom_' + row).html(uom);

            if (satuan == uom) {
                $('#konversi_' + row).prop('disabled', true);
            } else {
                $('#konversi_' + row).prop('disabled', false);
            }

            $('#FormBelanja').submit();
        }


        //Input
        $(document).ready(function() {

            $('#FormBelanja').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
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
                            $('#autosave').html(
                                '<small style="color:green;"> <i class="fas fa-check"></i> ' +
                                data.pesan +
                                '</small>'
                            );
                            animateCSS('#autosave', 'flash');
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

            });

        });


        function hapus(id) {
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
                                $('#manage').DataTable().ajax.reload();
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                popup(data.status, data.toast, data.pesan);
                            }
                        }
                    })
                }
            })


        }
    </script>
@endsection
