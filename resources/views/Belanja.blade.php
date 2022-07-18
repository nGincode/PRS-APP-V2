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
                                    <input type="date" disabled class="form-control" id="tgl"
                                        value="<?= date('Y-m-d') ?>" name="tgl">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12" style="overflow: auto;">
                                <label for="nama">Input</label>
                                <table id="tambahbelanja" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 300px">Nama Barang</th>
                                            <th>Kategori</th>
                                            <th style="min-width: 300px">Qty Nota</th>
                                            <th style="min-width: 150px">Qty UOM</th>
                                            <th>Total</th>
                                            <th>Keterangan</th>
                                            <th>Hutang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        </tr>
                                        @foreach ($Data as $key => $v)
                                            <tr id="tr_{{ $key }}"
                                                @if ($v['up']) style="background-color: #a9a9a966;" @endif>
                                                <td @if (!$v['up']) style="padding-left: 50px;" @endif>
                                                    @if (!$v['up'])
                                                        <a class="btn btn-danger btn-sm"
                                                            onclick="hapusbelanja({{ $v['id'] }}, {{ $key }})"
                                                            style="margin-top: 3px;position: absolute;z-index: 9;left:20px;"><i
                                                                class="fa fa-times"></i>
                                                        </a>
                                                    @endif
                                                    <select @if ($v['up']) disabled @endif name="nama[]"
                                                        onchange="clicknama(this.value, {{ $key }}, '<?= $v['nama'] ?>')"
                                                        id="nama_{{ $key }}"
                                                        class="form-control select2 select2-danger"
                                                        data-dropdown-css-class="select2-danger"
                                                        style="width: 100%;margin-left:100px;">
                                                        <option selected="true" disabled="disabled">Pilih</option>

                                                        <option value="<?= $v['nama'] ?>" selected><?= $v['nama'] ?>
                                                        </option>
                                                        <option value="Oprasional">Oprasional
                                                        </option>
                                                        <option value="Supplay">Supplay
                                                        </option>
                                                        <option value="ART">ART
                                                        </option>

                                                        @foreach ($bahan as $bhn)
                                                            <option value="{{ $bhn['id'] }}"
                                                                @if ($v['bahan_id'] == $bhn['id']) selected @endif>
                                                                {{ $bhn['nama'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if (!$v['up'])
                                                        <input type="hidden" value="{{ $v['id'] }}"
                                                            id="id_{{ $key }}" name="id[]">
                                                        <input type="hidden" value="{{ $key }}"
                                                            id="key_{{ $key }}" name="key[]">
                                                    @endif
                                                </td>
                                                <td> <select disabled id="kategori_{{ $key }}"
                                                        class="form-control select2 select2-danger"
                                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                        <option selected="true" disabled="disabled">Pilih</option>
                                                        <option value="Item"
                                                            @if ($v['bahan_id'] > 0) selected @endif>Item</option>
                                                        <option value="Oprasional"
                                                            @if ($v['kategori'] == 'Oprasional') selected @endif>Oprasional
                                                        </option>
                                                        <option value="Supplay"
                                                            @if ($v['kategori'] == 'Supplay') selected @endif>Supplay
                                                        </option>
                                                        <option value="ART"
                                                            @if ($v['kategori'] == 'ART') selected @endif>ART
                                                        </option>
                                                    </select>
                                                    <input type="hidden" name="kategori[]"
                                                        id="kategori_val_{{ $key }}"
                                                        value="<?= $v['kategori'] ?>">
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col">
                                                            <input @if ($v['up']) disabled @endif
                                                                type="number" class="form-control"
                                                                id="qty_{{ $key }}" value="{{ $v['qty'] }}"
                                                                onkeyup="hitung_belanja(this.value, {{ $key }})"
                                                                placeholder="Qty" name="qty[]">
                                                        </div>
                                                        <div class="col">
                                                            <select @if ($v['up']) disabled @endif
                                                                name="uombelanja[]"
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
                                                            <input @if ($v['up']) disabled @endif
                                                                type="text" class="form-control"
                                                                onkeyup="hitung_belanja(this.value, {{ $key }})"
                                                                id="harga_{{ $key }}"
                                                                value="{{ $v['harga'] }}" placeholder="Harga"
                                                                name="harga[]">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="item_{{ $key }}">
                                                    @if ($v['bahan_id'])
                                                        <div class="input-group">
                                                            <input @if ($v['up']) disabled @endif
                                                                onkeyup="hitung_belanja(this.value,{{ $key }})"
                                                                style="text-align: right;max-width:50px;" type="text"
                                                                value="{{ $v['konversi'] }}" name="konversi[]"
                                                                id="konversi_{{ $key }}" class="form-control"
                                                                placeholder="Konversi">
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
                                                <td> <input @if ($v['up']) disabled @endif
                                                        type="text" class="form-control" value="{{ $v['ket'] }}"
                                                        id="ket" placeholder="Keterangan" name="ket[]"
                                                        onchange="$('#FormBelanja').submit()">
                                                </td>
                                                <td><input @if ($v['up']) disabled @endif
                                                        name="hutang[]" class="form-control"
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
                        <a onclick="uploadbelanja()" class="btn btn-primary">Upload</a>
                        <font color="red">*</font> Upload akan menambah inventory dan akan terkunci
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
        function clicknama(id, row, tersimpan = null) {
            if (id === 'Oprasional') {

                var isi = prompt('Nama Barang Oprasional');

                if (isi) {
                    if (isi == 'Oprasional' || isi == 'Supplay' || isi == 'ART') {
                        alert('Nama Tidak diizinkan');
                        hapusbelanja(false, row);
                    } else {
                        $('#kategori_val_' + row).val('Oprasional');
                        $('#kategori_' + row).val('Oprasional');
                        $('#kategori_' + row).trigger('change');
                        $('#item_' + row).html('-');
                        $('#uombelanja_' + row).prop('disabled', false);
                        $('#qty_' + row).val('');
                        $('#total_' + row).html('-');

                        var newOption = new Option(isi, isi, true, true);
                        $('#nama_' + row).append(newOption).trigger('change');
                    }
                } else {
                    if (tersimpan) {
                        $('#nama_' + row).val(tersimpan).trigger("change.select2");
                    } else {
                        hapusbelanja(false, row);
                    }
                }

            } else if (id === 'Supplay') {
                var isi = prompt('Nama Barang Supplay');
                if (isi) {

                    if (isi == 'Oprasional' || isi == 'Supplay' || isi == 'ART') {
                        alert('Nama Tidak diizinkan');
                        hapusbelanja(false, row);
                    } else {
                        $('#kategori_val_' + row).val('Supplay');
                        $('#kategori_' + row).val('Supplay');
                        $('#kategori_' + row).trigger('change');
                        $('#item_' + row).html('-');
                        $('#uombelanja_' + row).prop('disabled', false);
                        $('#qty_' + row).val('');
                        $('#total_' + row).html('-');

                        var newOption = new Option(isi, isi, true, true);
                        $('#nama_' + row).append(newOption).trigger('change');
                    }
                } else {
                    if (tersimpan) {
                        $('#nama_' + row).val(tersimpan).trigger("change.select2");
                    } else {
                        hapusbelanja(false, row)
                    }
                }
            } else if (isi == 'Oprasional' || isi == 'Supplay' || isi == 'ART') {

                var isi = prompt('Nama Barang ART');
                if (isi) {
                    if (isi == 'ART') {
                        alert('Nama Tidak diizinkan');
                        hapusbelanja(false, row);
                    } else {
                        $('#kategori_val_' + row).val('ART');
                        $('#kategori_' + row).val('ART');
                        $('#kategori_' + row).trigger('change');
                        $('#item_' + row).html('-');
                        $('#uombelanja_' + row).prop('disabled', false);
                        $('#qty_' + row).val('');
                        $('#total_' + row).html('-');

                        var newOption = new Option(isi, isi, true, true);
                        $('#nama_' + row).append(newOption).trigger('change');
                    }
                } else {
                    if (tersimpan) {
                        $('#nama_' + row).val(tersimpan).trigger("change.select2");
                    } else {
                        hapusbelanja(false, row)
                    }
                }
            } else if (id > 0) {
                $('#kategori_val_' + row).val('Item');
                $('#kategori_' + row).val('Item');
                $('#kategori_' + row).trigger('change');

                $.ajax({
                    url: 'Belanja/Inventorybahanid',
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#item_' + row).html(
                            '<div class="input-group"><input onkeyup="hitung_belanja(this.value,' + row +
                            ')" style="text-align: right;max-width:50px;" type="number" value="1" name="konversi[]" id="konversi_' +
                            row +
                            '" class="form-control" placeholder="Konversi"><div class="input-group-append"><span class="input-group-text">' +
                            data.satuan + '</span></div></div><input type="hidden" value="' + data
                            .satuan + '" id="konversi_satuan_' + row + '">'
                        );
                        $('#qty_' + row).val('');
                        $('#total_' + row).html('-');
                        $('#uombelanja_' + row).val(data.satuan);
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
                    total = konversi * harga;
                    $('#total_' + row).html('Rp. ' + total);
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
                        console.log(data);
                        if (data.status === 'success') {
                            $('#hapus_' + data.row).removeAttr('onclick id style class')
                                .html('');
                            hapus = '<a class="btn btn-danger btn-sm" onclick="hapusbelanja(' +
                                data.id + ',' + data.row +
                                ')" style="margin-top: 3px;position: absolute;z-index: 9; left:20px;"><i class="fa fa-times"></i> </a>';
                            $('#id_' + data.row).val(data.id);
                            $('#id_' + data.row).before(hapus);
                            $('#autosave').html(
                                '<small style="color:green;"> <i class="fas fa-check"></i> ' +
                                data.pesan +
                                '</small>'
                            );
                            animateCSS('#autosave', 'flash');
                        } else if (data.status === 'error') {
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
    </script>
@endsection
