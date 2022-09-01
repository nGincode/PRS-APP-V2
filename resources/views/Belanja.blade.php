@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">

            @if (in_array('createBelanja', $user_permission))
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
                                    @if (!$AutoUpload['status'])
                                        @foreach ($AutoUpload['pesan'] as $item)
                                            <small style="color: red;" class="animate__animated animate__flash"> <i
                                                    class="fas fa-times"></i> {{ $item }}</small><br>
                                        @endforeach
                                    @else
                                        @if ($AutoUpload['pesan'])
                                            @foreach ($AutoUpload['pesan'] as $item)
                                                <small style="color: green;" class="animate__animated animate__bounce"> <i
                                                        class="fas fa-check"></i> {{ $item }}</small><br>
                                            @endforeach
                                        @else
                                            <small> <i class="fas fa-check"></i> Autosave on</small>
                                        @endif
                                    @endif
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
                                                <th style="min-width: 250px">Nama Barang</th>
                                                <th>Kategori</th>
                                                <th style="min-width: 350px">Qty Nota</th>
                                                <th style="min-width: 300px">Stock</th>
                                                <th style="min-width: 100px">Total</th>
                                                <th style="min-width: 130px">Keterangan</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            </tr>
                                            <?php
                                            $totalitem = 0;
                                            $totalopr = 0;
                                            $totalsup = 0;
                                            $totalart = 0;
                                            $totaldapro = 0;
                                            ?>
                                            @foreach ($Data as $key => $v)
                                                <?php
                                                if ($v['kategori'] == 'Item') {
                                                    $totalitem += $v['stock'] * $v['stock_harga'];
                                                }
                                                
                                                if ($v['kategori'] == 'Oprasional') {
                                                    $totalopr += $v['qty'] * $v['harga'];
                                                }
                                                
                                                if ($v['kategori'] == 'ART') {
                                                    $totalart += $v['qty'] * $v['harga'];
                                                }
                                                
                                                if ($v['kategori'] == 'Supplay') {
                                                    $totalsup += $v['qty'] * $v['harga'];
                                                }
                                                
                                                if ($v['kategori'] == 'DAPRO') {
                                                    $totaldapro += $v['qty'] * $v['harga'];
                                                }
                                                
                                                ?>
                                                <tr id="tr_{{ $key }}"
                                                    @if ($v['up']) style="background-color: #a9a9a966;" @endif>
                                                    <td
                                                        @if (!$v['up']) style="padding-left: 50px;" @endif>
                                                        @if (!$v['up'])
                                                            <a class="btn btn-danger btn-sm"
                                                                onclick="hapusbelanja({{ $v['id'] }}, {{ $key }})"
                                                                style="margin-top: 3px;position: absolute;z-index: 9;left:20px;"><i
                                                                    class="fa fa-times"></i>
                                                            </a>
                                                        @endif

                                                        @if ($v['bahan_id'])
                                                            <select @if ($v['up']) disabled @endif
                                                                name="nama[]"
                                                                onchange="clicknama(this.value, {{ $key }}, {{ $v['bahan_id'] }})"
                                                                id="nama_{{ $key }}"
                                                                class="form-control select2 select2-danger"
                                                                data-dropdown-css-class="select2-danger"
                                                                style="width: 100%;margin-left:100px;">
                                                                <option selected="true" disabled="disabled">Pilih</option>
                                                                <option value="Oprasional">Oprasional
                                                                </option>
                                                                <option value="Supplay">Supplay
                                                                </option>
                                                                <option value="ART">ART
                                                                </option>
                                                                <option value="DAPRO">DAPRO
                                                                </option>

                                                                @foreach ($bahan as $bhn)
                                                                    <option value="{{ $bhn['id'] }}"
                                                                        @if ($v['bahan_id'] == $bhn['id']) selected @endif>
                                                                        {{ $bhn['nama'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            <input title="Nama Barang" type="text" class="form-control"
                                                                onchange="$('#FormBelanja').submit()"
                                                                id="nama_{{ $key }}"
                                                                @if ($v['up']) disabled @endif
                                                                value="{{ $v['nama'] }}" placeholder="Nama Barang"
                                                                name="nama[]">
                                                        @endif
                                                        @if (!$v['up'])
                                                            <input type="hidden" value="{{ $v['id'] }}"
                                                                id="id_{{ $key }}" name="id[]">
                                                            <input type="hidden" value="{{ $key }}"
                                                                id="key_{{ $key }}" name="key[]">
                                                        @endif
                                                    </td>
                                                    <td>

                                                        @if ($v['bahan_id'])
                                                            <select disabled id="kategori_{{ $key }}"
                                                                class="form-control select2 select2-danger"
                                                                data-dropdown-css-class="select2-danger"
                                                                style="width: 100%;">
                                                                <option selected="true" disabled="disabled">Pilih</option>
                                                                <option value="Item"
                                                                    @if ($v['bahan_id'] > 0) selected @endif>Item
                                                                </option>
                                                                <option value="Oprasional"
                                                                    @if ($v['kategori'] == 'Oprasional') selected @endif>
                                                                    Oprasional
                                                                </option>
                                                                <option value="Supplay"
                                                                    @if ($v['kategori'] == 'Supplay') selected @endif>
                                                                    Supplay
                                                                </option>
                                                                <option value="ART"
                                                                    @if ($v['kategori'] == 'ART') selected @endif>ART
                                                                </option>
                                                                <option value="DAPRO"
                                                                    @if ($v['kategori'] == 'DAPRO') selected @endif>DAPRO
                                                                </option>
                                                            </select>
                                                            <input @if ($v['up']) disabled @endif
                                                                type="hidden" name="kategori[]"
                                                                id="kategori_val_{{ $key }}"
                                                                value="<?= $v['kategori'] ?>">
                                                        @else
                                                            <select @if ($v['up']) disabled @endif
                                                                onchange="$('#FormBelanja').submit()"
                                                                id="kategori_{{ $key }}" name="kategori[]"
                                                                class="form-control select2 select2-danger"
                                                                data-dropdown-css-class="select2-danger"
                                                                style="width: 100%;">
                                                                <option selected="true" disabled="disabled">Pilih</option>
                                                                <option value="Oprasional"
                                                                    @if ($v['kategori'] == 'Oprasional') selected @endif>
                                                                    Oprasional
                                                                </option>
                                                                <option value="Supplay"
                                                                    @if ($v['kategori'] == 'Supplay') selected @endif>
                                                                    Supplay
                                                                </option>
                                                                <option value="ART"
                                                                    @if ($v['kategori'] == 'ART') selected @endif>ART
                                                                </option>
                                                                <option value="DAPRO"
                                                                    @if ($v['kategori'] == 'DAPRO') selected @endif>
                                                                    DAPRO
                                                                </option>
                                                            </select>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col">
                                                                <input @if ($v['up']) disabled @endif
                                                                    type="number" class="form-control"
                                                                    id="qty_{{ $key }}"
                                                                    value="{{ $v['qty'] }}"
                                                                    onchange="hitung_belanja(this.value, {{ $key }})"
                                                                    placeholder="Qty" name="qty[]">
                                                            </div>
                                                            <div class="col">
                                                                <select @if ($v['up']) disabled @endif
                                                                    name="uombelanja[]"
                                                                    onchange="$('#FormBelanja').submit()"
                                                                    id="uombelanja_{{ $key }}"
                                                                    class="form-control select2 select2-danger"
                                                                    data-dropdown-css-class="select2-danger"
                                                                    style="width: 100%;">
                                                                    <option selected="true" disabled="disabled">UOM
                                                                    </option>
                                                                    4
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
                                                                    title="Harga 1 nya" data-toggle="tooltip"
                                                                    data-placement="top" type="number"
                                                                    class="form-control"
                                                                    onchange="hitung_belanja(this.value, {{ $key }})"
                                                                    id="harga_{{ $key }}"
                                                                    value="{{ $v['harga'] }}" placeholder="Harga"
                                                                    name="harga[]">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="item_{{ $key }}">
                                                        <div style="display: flex;">
                                                            @if ($v['bahan_id'])
                                                                <div class="input-group">
                                                                    <input
                                                                        @if ($v['up']) disabled @endif
                                                                        onchange="hitung_belanja(this.value,{{ $key }})"
                                                                        style="text-align: right;max-width:100px;"
                                                                        type="number" value="{{ $v['stock'] }}"
                                                                        name="stock[]" id="stock_{{ $key }}"
                                                                        class="form-control" placeholder="Stock">
                                                                    <div class="input-group-append"><span
                                                                            class="input-group-text"
                                                                            id="belanja_uom_{{ $key }}">
                                                                            {{ $v['stock_uom'] }}</span></div>
                                                                </div>

                                                                <input @if ($v['up']) disabled @endif
                                                                    type="hidden" name="stock_uom[]"
                                                                    value="{{ $v['stock_uom'] }}"
                                                                    id="stock_satuan_{{ $key }}">

                                                                &nbsp;

                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span
                                                                            class="input-group-text"
                                                                            id="belanja_uom_{{ $key }}">Rp.</span>
                                                                    </div>

                                                                    <input
                                                                        @if ($v['up']) disabled @endif
                                                                        title="Harga 1 nya" data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        onchange="hitung_belanja(this.value,{{ $key }})"
                                                                        style="text-align: right;max-width:100px;"
                                                                        type="number" value="{{ $v['stock_harga'] }}"
                                                                        name="stock_harga[]"
                                                                        id="stock_harga_{{ $key }}"
                                                                        class="form-control" placeholder="Stock Harga">

                                                                </div>
                                                            @else
                                                                <input type="hidden"
                                                                    @if ($v['up']) disabled @endif
                                                                    value="{{ $v['stock'] }}" name="stock[]"
                                                                    class="form-control">
                                                                <input type="hidden"
                                                                    @if ($v['up']) disabled @endif
                                                                    name="stock_uom[]" value="{{ $v['stock_uom'] }}"
                                                                    id="stock_satuan_{{ $key }}">
                                                                <input type="hidden"
                                                                    @if ($v['up']) disabled @endif
                                                                    value="{{ $v['stock_harga'] }}" name="stock_harga[]">

                                                                -
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td id="total_{{ $key }}">
                                                        @if ($v['total'])
                                                            Rp. {{ $v['total'] }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td> <input @if ($v['up']) disabled @endif
                                                            type="text" class="form-control"
                                                            value="{{ $v['ket'] }}" id="ket" placeholder="Ket"
                                                            name="ket[]" onchange="$('#FormBelanja').submit()">
                                                    </td>
                                                    <td>
                                                        <select @if ($v['up']) disabled @endif
                                                            style="border: unset;background: transparent;" name="hutang[]"
                                                            onchange="$('#FormBelanja').submit()">
                                                            <option value="0">Lunas</option>
                                                            <option value="1"
                                                                @if ($v['hutang']) selected @endif>
                                                                Hutang</option>
                                                        </select>
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

                            <div class="row">
                                <table class="table col-12 col-sm-6">
                                    <tr>
                                        <td><b>Total Item</b></td>
                                        <td><b>:</b></td>
                                        <td id="total_item">{{ 'Rp ' . number_format($totalitem, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Oprasional</b></td>
                                        <td><b>:</b></td>
                                        <td id="total_oprasional">
                                            {{ 'Rp ' . number_format($totalopr, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Supplay</b></td>
                                        <td><b>:</b></td>
                                        <td id="total_supplay">{{ 'Rp ' . number_format($totalsup, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Total ART</b></td>
                                        <td><b>:</b></td>
                                        <td id="total_art">{{ 'Rp ' . number_format($totalart, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Total DAPRO</b></td>
                                        <td><b>:</b></td>
                                        <td id="total_dapro">{{ 'Rp ' . number_format($totaldapro, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </table>
                                <div class="col-12 col-sm-6">
                                    <div style="padding: 30px; font-size: xx-large; ">
                                        <b>Total :</b>
                                        <h2 style="font-size:50px;border-bottom: 2px #007bff solid"><b
                                                id="total_seluruh">{{ 'Rp ' . number_format($totaldapro + $totalart + $totalsup + $totalopr + $totalitem, 0, ',', '.') }}</b>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>

                        <div class="card-footer">
                            <a onclick="uploadbelanja()" class="btn btn-primary">Upload</a>
                            <br><br>
                            <font color="red">*</font> Upload akan menambah inventory dan akan terkunci<br>
                            <font color="red">*</font> Jika tanggal sebelumnya belum terupload maka akan upload
                            otomatis<br>
                        </div>
                    </div>
                </form>
            @endif
            <div class="card">
                <div class="card-header text-white bg-secondary mb-3">
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text"
                            value="<?= date('m/d/Y', strtotime('-29 days', strtotime(date('Y-m-d')))) ?> - <?= date('m/d/Y') ?>"
                            onchange="manage()" name="manage_date" class="form-control" id="manage_date">
                    </div>
                    <br>

                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
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


    <div class="modal fade" id="lihat" tabindex="-1" role="dialog" style="width:100%"
        aria-labelledby="transaksiLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog  modal-xl" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Lihat Belanja</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="Lihat" style="overflow: auto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function clicknama(id, row, tersimpan = null) {
            var itemss =
                '<input type="hidden" value="" name="stock[]" class="form-control"> <input type="hidden" name="stock_uom[]" value=""id="stock_satuan_' +
                row + '"><input type="hidden" value="" name="stock_harga[]"></input> -';

            if (id === 'Oprasional') {

                var isi = prompt('Nama Barang Oprasional');
                var html = '<input title="Nama Barang" type="text" class="form-control" onchange="$(' + "'" +
                    '#FormBelanja' + "'" + ').submit()" id="nama_' +
                    row + '" value="' + isi + '" placeholder="Nama Barang" name="nama[]">';


                if (isi) {
                    if (isi == 'Oprasional' || isi == 'Supplay' || isi == 'ART' || isi == 'DAPRO' || isi > 0) {
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

                        $('#nama_' + row).replaceWith(html);
                        $("#nama_" + row).select2('destroy');
                    }
                } else {
                    if (tersimpan) {
                        $('#nama_' + row).val(tersimpan).trigger("change.select2");
                    } else {
                        hapusbelanja(false, row)
                    }
                }


                $('#item_' + row).html(itemss);

            } else if (id === 'Supplay') {
                var isi = prompt('Nama Barang Supplay');
                var html = '<input title="Nama Barang" type="text" class="form-control" onchange="$(' + "'" +
                    '#FormBelanja' + "'" + ').submit()" id="nama_' +
                    row + '" value="' + isi + '" placeholder="Nama Barang" name="nama[]">';


                if (isi) {
                    if (isi == 'Oprasional' || isi == 'Supplay' || isi == 'ART' || isi == 'DAPRO') {
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

                        $('#nama_' + row).replaceWith(html);
                        $("#nama_" + row).select2('destroy');
                    }
                } else {
                    if (tersimpan) {
                        $('#nama_' + row).val(tersimpan).trigger("change.select2");
                    } else {
                        hapusbelanja(false, row)
                    }
                }


                $('#item_' + row).html(itemss);
            } else if (id == 'ART') {
                var isi = prompt('Nama Barang ART');
                var html = '<input title="Nama Barang" type="text" class="form-control" onchange="$(' + "'" +
                    '#FormBelanja' + "'" + ').submit()" id="nama_' +
                    row + '" value="' + isi + '" placeholder="Nama Barang" name="nama[]">';

                if (isi) {
                    if (isi == 'Oprasional' || isi == 'Supplay' || isi == 'ART' || isi == 'DAPRO') {
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

                        $('#nama_' + row).replaceWith(html);
                        $("#nama_" + row).select2('destroy');
                    }
                } else {
                    if (tersimpan) {
                        $('#nama_' + row).val(tersimpan).trigger("change.select2");
                    } else {
                        hapusbelanja(false, row)
                    }
                }


                $('#item_' + row).html(itemss);
            } else if (id == 'DAPRO') {
                var isi = prompt('Nama Barang DAPRO');
                var html = '<input title="Nama Barang" type="text" class="form-control" onchange="$(' + "'" +
                    '#FormBelanja' + "'" + ').submit()" id="nama_' +
                    row + '" value="' + isi + '" placeholder="Nama Barang" name="nama[]">';

                if (isi) {
                    if (isi == 'Oprasional' || isi == 'Supplay' || isi == 'ART' || isi == 'DAPRO') {
                        alert('Nama Tidak diizinkan');
                        hapusbelanja(false, row);
                    } else {
                        $('#kategori_val_' + row).val('DAPRO');
                        $('#kategori_' + row).val('DAPRO');
                        $('#kategori_' + row).trigger('change');
                        $('#item_' + row).html('-');
                        $('#uombelanja_' + row).prop('disabled', false);
                        $('#qty_' + row).val('');
                        $('#total_' + row).html('-');

                        $('#nama_' + row).replaceWith(html);
                        $("#nama_" + row).select2('destroy');
                    }
                } else {
                    if (tersimpan) {
                        $('#nama_' + row).val(tersimpan).trigger("change.select2");
                    } else {
                        hapusbelanja(false, row)
                    }
                }


                $('#item_' + row).html(itemss);
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
                            '<div style="display: flex;"><div class="input-group" style="height: fit-content;" ><input onchange="hitung_belanja(this.value,' +
                            row +
                            ')" style="text-align: right;max-width:100px;" type="number" value="1" name="stock[]" id="stock_' +
                            row +
                            '" class="form-control" placeholder="Stock"><div class="input-group-append"><span class="input-group-text">' +
                            data.satuan +
                            '</span></div></div><input type="hidden" name="stock_uom[]" value="' + data
                            .satuan + '" id="stock_uom_' + row + '"> &nbsp; ' +
                            '<div class="input-group" style="height: fit-content;"><div class="input-group-prepend" ><span class="input-group-text">Rp.</span></div><input onchange="hitung_belanja(this.value,' +
                            row +
                            ')" style="text-align: right;max-width:100px;" type="number" value="1" name="stock_harga[]" id="stock_harga_' +
                            row +
                            '" class="form-control" placeholder="Harga"></div></div>'
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
            harga_stock = parseInt($('#stock_harga_' + row).val());
            stock = parseInt($('#stock_' + row).val());
            if (qty && harga) {
                if (stock) {
                    total = stock * harga_stock;
                    $('#total_' + row).html('Rp. ' + total);
                } else {
                    total = qty * harga;
                    $('#total_' + row).html('Rp. ' + total);
                }
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

                        $('#total_item').html('Rp ' + formatRupiah(data.totalitem));
                        $('#total_oprasional').html('Rp ' + formatRupiah(data.totalopr));
                        $('#total_supplay').html('Rp ' + formatRupiah(data.totalsup));
                        $('#total_art').html('Rp ' + formatRupiah(data.totalart));
                        $('#total_dapro').html('Rp ' + formatRupiah(data.totaldapro));
                        $('#total_seluruh').html('Rp ' + formatRupiah(data.totalseluruh));
                    }
                });

            });

        });

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


        function lihat(id, judul) {
            $.ajax({
                url: "Belanja/ViewItem",
                type: "POST",
                data: {
                    id: id,
                    judul: judul
                },
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                beforeSend: function(xhr) {
                    $('#Lihat').html('<div class="loading-bg"><div class="loading"></div></div>');
                },
                success: function(data) {
                    $('#Lihat').html(data);
                }
            });
        }

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
