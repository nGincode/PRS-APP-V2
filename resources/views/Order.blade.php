@extends('Layout')

@section('isi')
<section class="content">
    <div class="container-fluid">
        @if (in_array('createOrder', $user_permission))
        <form id="FormOrder" action="{{ url('/Order/Input') }}">
            @csrf
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>
                            @isset($order)
                            Edit {{ $title . ' ' . $subtitle . ' Untuk ' . $order['nama'] }}
                            @else
                            Tambah {{ $title . ' ' . $subtitle }}
                            @endisset
                        </b></h3>

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
                            @isset($order)
                            <small> <i class="fas fa-check"></i> Autosave dari Orderan
                                {{ $order['nama'] }}</small>
                            @else
                            <small> <i class="fas fa-check"></i> Autosave on</small>
                            @endisset
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="nama">Tanggal</label>
                                <input disabled type="date" @isset($order['tgl']) value="{{ date('Y-m-d', strtotime($order['tgl'])) }}" @else value="{{ date('Y-m-d') }}" @endif class="form-control" onchange="$('#FormOrder').submit()" id="tgl" placeholder="Tanggal" name="tgl">
                            </div>
                        </div>


                        @if (request()->session()->get('tipe') === 'Logistik')
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="nama">Tanggal Laporan</label>
                                <input type="date" @if ($up) readonly @endif @isset($order['tgl_laporan']) value="{{ date('Y-m-d', strtotime($order['tgl_laporan'])) }}" @else value="{{ date('Y-m-d') }}" @endif class="form-control" onchange="$('#FormOrder').submit()" id="tgl_laporan" placeholder="Tanggal" name="tgl_laporan">
                            </div>
                        </div>


                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="outlet">Outlet</label>
                                <select @isset($order_item[0]) disabled @endisset @if (!$pemilik_order) disabled @endif @if ($up) disabled @endif onchange="$('#FormOrder').submit()" name="outlet" id="outlet" class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option selected="true">Pilih</option>
                                    @foreach ($store as $str)
                                    <option @isset($order['store_id']) @if ($order['store_id']==$str['id']) selected @endif @endisset value="{{ $str['id'] }}"> {{ $str['nama'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @else
                        <input type="hidden" class="form-control" id="outlet" name="outlet" value="<?= request()
                                                                                                        ->session()
                                                                                                        ->get('store_id') ?>">
                        @endif


                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="nama">Nama Pengorder</label>
                                <input type="text" @if (!$pemilik_order) readonly @endif @if ($up) readonly @endif @isset($order['nama']) value="{{ $order['nama'] }}" @endisset class="form-control" onchange="$('#FormOrder').submit()" id="nama" placeholder="Nama Pengorder" name="nama">
                            </div>
                        </div>


                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="nama">No Hp</label>
                                <input @if (!$pemilik_order) readonly @endif @if ($up) readonly @endif @isset($order['nohp']) value="{{ $order['nohp'] }}" @endisset type="number" class="form-control" onchange="$('#FormOrder').submit()" id="no" placeholder="No HP" name="no">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="ket">Ket</label>
                                <input @if (!$pemilik_order) readonly @endif @if ($up) readonly @endif @isset($order['ket']) value="{{ $order['ket'] }}" @endisset type="text" onchange="$('#FormOrder').submit()" class="form-control" id="ket" placeholder="Keterangan" name="ket">
                            </div>
                        </div>


                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="tujuan">Tujuan Pemesanan</label>


                                <select title="Hapus Item Untuk Ubah" @isset($order_item[0]) disabled @endisset @if ($up) disabled @endif @if (!$pemilik_order) disabled @endif onchange="items(this.value)" name="tujuan" id="tujuan" class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option selected="true" disabled="disabled">Pilih</option>
                                    @foreach ($logistik as $lgs)
                                    <option @if (isset($order['logistik'])) @if ($order['logistik']==$lgs['id']) selected @endif @endisset value="{{ $lgs['id'] }}">{{ $lgs['nama'] }}</option>
                                    @endforeach
                                </select>
                                @isset($order_item[0])
                                <small>
                                    <font color="red">*</font> Hapus Item Dibawah Untuk Mengubah
                                </small>
                                @endisset

                            </div>
                        </div>
                        <div class="col-12 col-sm-12" style="overflow: auto">
                            <label>Input</label>
                            <table id="tambahorder" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama Bahan</th>
                                        <th scope="col" style="min-width: 175px; width: 180px">Qty Order</th>
                                        <th scope="col" style="min-width: 175px; width: 180px">Qty Deliv</th>
                                        <th scope="col" style="min-width: 175px; width: 180px">Qty Arrive
                                        </th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Total</th>
                                    </tr>

                                </thead>
                                <tbody id="items">
                                    <tr></tr>
                                    @isset($order_item[0])
                                    <?php $total_seluruh = 0; ?>
                                    @foreach ($order_item as $key => $v)
                                    <tr id="tr_{{ $key }}" style="
                                                @if ($up) background-color: #0000002b;
                                                @else
                                            @if ($v['qty_deliv'] === $v['qty_arrive'] && $v['qty_arrive']) background-color: #00800036; @endif
                                            @if ($v['qty_deliv'] && !$v['qty_arrive']) background-color: #ffff0021; @endif
                                            @if ($v['qty_deliv'] !== $v['qty_arrive'] && $v['qty_arrive']) background-color: #ff00002b; @endif
                                            @endif
                                            ">

                                        @if (!$v['qty_deliv'] && $pemilik_order && !$up)
                                        <td style="padding-left: 50px;">
                                            <input type="hidden" value="{{ $v['id'] }}" id="id_{{ $key }}" name="id[]">
                                            <input type="hidden" value="{{ $key }}" id="key_{{ $key }}" name="key[]">
                                            <a class="btn btn-danger btn-sm" id="hapus_{{ $key }}" onclick="HapusOrder({{ $v['id'] }},{{ $key }})" style="margin-top: 3px;position: absolute;z-index: 9;left:20px;"><i class="fa fa-times"></i> </a>
                                            <select onchange="select(this.value,{{ $key }},{{ $v['logistik'] }})" name="select[]" id="nama_{{ $key }}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                <option selected="true" disabled="disabled">Pilih</option>
                                                @foreach ($item as $itemv)
                                                <option @if ($itemv['bahan_id']==$v['bahan_id']) selected @endif value="{{ $itemv['id'] }}">
                                                    {{ $itemv['bahan']->nama }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @else
                                        <td>
                                            <input type="hidden" value="{{ $v['id'] }}" id="id_{{ $key }}" name="id[]">
                                            <input type="hidden" value="{{ $key }}" id="key_{{ $key }}" name="key[]">

                                            <select disabled onchange="select(this.value,{{ $key }},{{ $v['logistik'] }})" name="select[]" id="nama_{{ $key }}" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                <option selected="true" disabled="disabled">Pilih</option>
                                                @foreach ($item as $itemv)
                                                <option @if ($itemv['bahan_id']==$v['bahan_id']) selected @endif value="{{ $itemv['id'] }}">
                                                    {{ $itemv['bahan']->nama }}
                                                </option>
                                                @endforeach
                                            </select>

                                            @foreach ($item as $itemval)
                                            @if ($itemval['bahan_id'] == $v['bahan_id'])
                                            <input type="hidden" name="select[]" value="{{ $itemval['id'] }}" class="form-control">
                                            @endif
                                            @endforeach
                                            @endif

                                        </td>

                                        @if (request()->session()->get('tipe') === 'Logistik')
                                        <td>
                                            <div class="input-group">
                                                <input type="number" disabled value="{{ $v['qty_order'] ?? 0 }}" id="qty_order_val_{{ $key }}" placeholder="Qty Order" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">{{ $v['satuan'] }}</span>
                                                </div>
                                            </div>

                                            <input type="hidden" name="qty_order[]" value="false" class="form-control">
                                        </td>


                                        <td id="qty_deliv_td_{{ $key }}">
                                            <div class="input-group"><input type="number" onchange="Hitung({{ $key }})" @if ($up) readonly @endif value="{{ $v['qty_deliv'] }}" class="form-control" id="qty_deliv_val_{{ $key }}" placeholder="Qty Delivery" name="qty_deliv[]" aria-invalid="false">
                                                <div class="input-group-append"><span class="input-group-text">{{ $v['satuan'] }}</span>
                                                </div>
                                            </div>
                                        </td>




                                        <td>
                                            <div class="input-group">
                                                <input type="number" disabled placeholder="Qty Arrive" value="{{ $v['qty_arrive'] ?? 0 }}" id="qty_arrive_val_{{ $key }}" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">{{ $v['satuan'] }}</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="qty_arrive[]" value="false" class="form-control">
                                        </td>
                                        @else
                                        @if (!$v['qty_deliv'])
                                        <td id="qty_order_td_{{ $key }}">
                                            <div class="input-group"><input type="number" onchange="Hitung({{ $key }})" value="{{ $v['qty_order'] }}" class="form-control" id="qty_order_val_{{ $key }}" placeholder="Qty Order" name="qty_order[]" aria-invalid="false">
                                                <div class="input-group-append"><span class="input-group-text">{{ $v['satuan'] }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        @else
                                        <td>
                                            <div class="input-group">
                                                <input type="number" disabled value="{{ $v['qty_order'] ?? 0 }}" id="qty_order_val_{{ $key }}" placeholder="Qty Order" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">{{ $v['satuan'] }}</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="qty_order[]" value="false" class="form-control">
                                        </td>
                                        @endif
                                        <td>
                                            <div class="input-group">
                                                <input type="number" disabled value="{{ $v['qty_deliv'] ?? 0 }}" id="qty_deliv_val_{{ $key }}" placeholder="Qty Delivery" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">{{ $v['satuan'] }}</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="qty_deliv[]" value="false" class="form-control">
                                        </td>

                                        @if ($v['qty_deliv'])
                                        <td id="qty_arrive_td_{{ $key }}">
                                            <div class="input-group"><input type="number" @if ($up) readonly @endif onchange="Hitung({{ $key }})" value="{{ $v['qty_arrive'] ?? $v['qty_deliv'] }}" class="form-control" id="qty_arrive_val_{{ $key }}" placeholder="Qty Arrive" name="qty_arrive[]" aria-invalid="false">
                                                <div class="input-group-append"><span class="input-group-text">{{ $v['satuan'] }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        @else
                                        <td>
                                            <div class="input-group">
                                                <input type="number" disabled placeholder="Qty Arrive" id="qty_arrive_val_{{ $key }}" value="{{ $v['qty_arrive'] ?? 0 }}" class="form-control">
                                                <div class="input-group-append"><span class="input-group-text">{{ $v['satuan'] }}</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="qty_arrive[]" value="false" class="form-control">
                                        </td>
                                        @endif
                                        @endif



                                        <td id="harga_td_{{ $key }}">
                                            Rp.
                                            {{ number_format((int) $v['harga'], 0, '.', ',') }}/{{ $v['satuan'] }}
                                        </td>

                                        <td id="total_td_{{ $key }}">
                                            Rp.
                                            {{ number_format((int) $v['harga'] * (int) ($v['qty_deliv'] ?? $v['qty_order']), 0, '.', ',') }}
                                            @if (!$v['up'] && $logistik_id)
                                            @if ($up)
                                            <div class="float-right">
                                                <a class="btn btn-danger" onclick="UpRepair({{ $v['id'] }}, 'Hapus')"><i class="fa fa-times"></i></a>
                                                <a class="btn btn-success" onclick="UpRepair({{ $v['id'] }}, 'Upload')"><i class="fa fa-upload"></i></a>
                                            </div>
                                            @endif
                                            @endif
                                        </td>

                                        <input id="harga_val_{{ $key }}" type="hidden" value="{{ $v['harga'] }}">

                                    </tr>

                                    <?php $total_seluruh += (int) $v['harga'] * (int) ($v['qty_deliv'] ?? $v['qty_order']); ?>
                                    @endforeach
                                    @else
                                    @isset($order['logistik'])
                                    @if ($up)
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Tidak ditemukan item
                                        </td>
                                    </tr>
                                    @endif
                                    @else
                                    @if ($up)
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Tidak ada item
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Pilih Tujuan Pemesanan
                                        </td>
                                    </tr>
                                    @endif
                                    @endisset
                                    @endisset
                                </tbody>
                                <tfoot id="item_tambah">
                                    @if (!$up)
                                    @if ($pemilik_order)
                                    @isset($order['logistik'])
                                    <tr>
                                        <td colspan="7" class="text-center"><a id="add_row_order" onclick="add_row_order({{ $order['logistik'] }})" class="btn btn-block btn-success"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                    @endisset
                                    @else
                                    @if (isset($order['users']->username))
                                    <tr>
                                        <td colspan="7" class="text-center"><b>Hubungi Username
                                                {{ $order['users']->username }} Untuk Menambah
                                                Orderan</b>
                                        </td>
                                    </tr>
                                    @endif
                                    @endif
                                    @else
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <h2><b> Orderan ini telah diupload</h2>
                                            </b>
                                        </td>
                                    </tr>
                                    @endif
                                </tfoot>
                            </table>
                            @isset($order)
                            <div>
                                Ket :<br>
                                <font color="red">*</font> Orderan ini dibuat Oleh Username
                                <b>{{ $order['users']->username }}</b><br>
                                <a class="btn btn-warning"></a> Qty Arive Belum
                                Terisi<br>
                                <a class="btn btn-danger"></a> Qty Arive dan Qty
                                Deliv Tidak Sama <br>
                                <a class="btn btn-success"></a> Qty Telah Sesuai
                            </div>
                            <hr>
                            @endisset
                        </div>

                    </div>
                    <!-- /.row -->

                    <div class="float-right" style=" border-bottom: 2px #007bff solid">
                        Total : <h2><b id="total_seluruh">Rp.
                                {{ number_format($total_seluruh ?? 0, 0, '.', ',') }}</b></h2>
                    </div>
                    <br><br><br>
                </div>

                <div class="card-footer">
                    @if (!$up)
                    {{-- <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button> --}}
                    @endif
                    @if (request()->session()->get('IdEditOrder'))
                    <a class="btn btn-danger" onclick="KeluarEdit()"><i class="fa fa-sign-out-alt"></i>
                        Keluar
                        Edit</a>
                    @endif
                    @if (request()->session()->get('tipe') === 'Logistik' &&
                    request()->session()->get('IdEditOrder'))
                    @if (!$up)
                    <a class="btn btn-primary" onclick="Upload({{ request()->session()->get('IdEditOrder') }})"><i class="fa fa-upload"></i>
                        Upload</a>
                    @endif
                    @endif
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
                    <input type="text" value="<?= date('m/d/Y', strtotime('-29 days', strtotime(date('Y-m-d')))) ?> - <?= date('m/d/Y') ?>" onchange="manage()" name="manage_date" class="form-control" id="manage_date">
                </div>
                <br>

                <table id="manage" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Bill</th>
                            <th>Store</th>
                            <th>Tgl</th>
                            <th>Nama</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>



        <!-- Modal -->
        <div class="modal fade" id="lihat" tabindex="-1" role="dialog" style="width:100%" aria-labelledby="transaksiLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Lihat Item</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="OrderItem" style="overflow: auto">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.card -->
    </div>

    <!-- /.container-fluid -->
</section>

<script>
    function items(id) {

        $.ajax({
            url: "Order/Items",
            type: "POST",
            data: {
                id: id
            },
            dataType: 'json',
            error: function(xhr, status, error) {
                popup(status, true, xhr.status + " " + error);
            },
            success: function(data) {
                if (data.status) {
                    $('#item_tambah').html(
                        '<tr><td colspan="6" class="text-center"><a onclick="add_row_order(' + id +
                        ')" class="btn btn-block btn-success"><i class="fa fa-plus"></i></a></td></tr>'
                    );
                    $('#items').html('<tr></tr>');
                    $('#FormOrder').submit();

                } else {
                    $('#items').html(
                        '<tr><td colspan="6" class="text-center"><i class="fa fa-times"></i> Tidak ditemukan item yang dapat di order ' +
                        data.store + '</td></tr>'
                    );
                    $('#item_tambah').html('');
                }

            }
        });
    }

    function add_row_order(id) {

        $('#FormOrder').validate({
            rules: {
                'nama': {
                    required: true
                },
                'no': {
                    required: true
                },
                'outlet': {
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

        var isValid = $('#FormOrder').valid();
        if (isValid) {
            $.ajax({
                url: 'Order/Items',
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    var row_id = $("#items tr").length - 1;
                    var html = '<tr id="tr_' + row_id + '">';


                    html +=
                        ' <td style="padding-left: 50px;"><a class="btn btn-warning btn-sm" id="hapus_' +
                        row_id + '" onclick="HapusOrder(false,' + row_id +
                        ')" style="margin-top: 3px;position: absolute;z-index: 9;left:20px;"><i class="fa fa-times"></i> </a><input type="hidden" value="" id="id_' +
                        row_id + '" name="id[]"><input type="hidden" value="' + row_id + '" id="key_' +
                        row_id +
                        '" name="key[]"><select onchange="select(this.value, ' + row_id +
                        ', ' + data.id + ')" name="select[]" id="nama_' + row_id +
                        '" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;"> <option selected="true" disabled="disabled">Pilih</option>';
                    for (let x = 0; x <= data.select.length - 1; x++) {
                        html += '<option value="' + data.select[x][
                                'id'
                            ] +
                            '">' + data.select[x]['nama'] +
                            '</option>';
                    }
                    html += '</select> </td>';

                    html +=
                        '<td id="qty_order_td_' + row_id + '"><input ' + data.disabled_order +
                        ' id="qty_order_val_' + row_id +
                        '" type="number" onchange="Hitung(' + row_id +
                        ')" class="form-control" placeholder="Qty Order" name="qty_order[]"></td>';

                    if (data.disabled_order)
                        html += '<input type="hidden" name="qty_order[]" value="false" >';


                    html +=
                        '<td id="qty_deliv_td_' + row_id + '"><input type="number" ' + data.disabled_deliv +
                        ' class="form-control" onchange="Hitung(' + row_id +
                        ')" id="qty_deliv" placeholder="Qty Delivery" name="qty_deliv[]"></td>';

                    if (data.disabled_deliv)
                        html += '<input type="hidden" name="qty_deliv[]" value="false" >';


                    html +=
                        '<td id="qty_arrive_td_' + row_id + '"><input type="number" onchange="Hitung(' +
                        row_id + ')" ' + data
                        .disabled_arrive +
                        ' class="form-control" id="qty_arrive" placeholder="Qty Arrive" name="qty_arrive[]"></td>';

                    if (data.disabled_arrive)
                        html += '<input type="hidden" name="qty_arrive[]" value="false" >';

                    html += '<td id="harga_td_' + row_id + '">-</td>';

                    html += '<td id="total_td_' + row_id + '">-</td>';

                    html +=
                        '<input id="harga_val_' + row_id +
                        '" type="hidden">';


                    html += '</tr>';

                    if (row_id >= 0) {
                        $("#items tr:last").after(html);
                    }
                    $('#add_row_order').hide();

                    $('.select2').select2().on("change", function(e) {
                        $(this).valid()
                    });


                }
            });
        }
    };

    function select(id, row, store) {
        $.ajax({
            url: 'Order/Select',
            type: "POST",
            data: {
                id: id,
                store: store
            },
            dataType: "json",
            success: function(data) {
                if (data.harga > 0) {
                    $('#harga_val_' + row).val(data.harga);
                    $('#harga_td_' + row).html('Rp. ' + formatRupiah(data.harga) + '/' + data.satuan);

                    $('#qty_order_td_' + row).html(
                        '<div class="input-group"><input ' + data.disabled_order +
                        ' type="number" onchange="Hitung(' + row +
                        ')"  class="form-control"  id="qty_order_val_' +
                        row +
                        '" placeholder="Qty Order" name="qty_order[]"><div class="input-group-append"><span class="input-group-text">' +
                        data.satuan + '</span></div></div>'
                    );

                    $('#qty_deliv_td_' + row).html(
                        '<div class="input-group"><input ' + data.disabled_deliv +
                        ' type="number" onchange="Hitung(' + row +
                        ')"  class="form-control"  id="qty_deliv_val_' +
                        row +
                        '" placeholder="Qty Delivery" name="qty_deliv[]"><div class="input-group-append"><span class="input-group-text">' +
                        data.satuan + '</span></div></div>'
                    );


                    $('#qty_arrive_td_' + row).html(
                        '<div class="input-group"><input ' + data.disabled_arrive +
                        ' type="number" onchange="Hitung(' + row +
                        ')"  class="form-control"  id="qty_arrive_val_' +
                        row +
                        '" placeholder="Qty Arrive" name="qty_arrive[]"><div class="input-group-append"><span class="input-group-text">' +
                        data.satuan + '</span></div></div>'
                    );



                    $('#total_td_' + row).html('Rp. ' + formatRupiah(data.harga));
                    $('#FormOrder').submit();
                }
            }
        });
    }


    function HapusOrder(id, row) {
        if (id == false) {
            $('#tr_' + row).html('');
            $('#add_row_order').show();
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
                        url: "Order/Hapus",
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
                                if (!data.item) {
                                    $('#tujuan').prop('disabled', false);
                                }
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

    function Hitung(row) {
        qtyorder = Number($('#qty_order_val_' + row).val());
        qtydeliv = Number($('#qty_deliv_val_' + row).val());
        qtyarrive = Number($('#qty_arrive_val_' + row).val());

        harga = Number($('#harga_val_' + row).val());

        var row_id = $("#items tr").length - 1;

        if (qtydeliv) {
            $('#total_td_' + row).html('Rp. ' + formatRupiah(qtydeliv * harga));
            total = 0;
            for (let index = 0; index < row_id; index++) {
                total += Number($('#qty_deliv_val_' + index).val()) * Number($('#harga_val_' + index).val());

                if (Number($('#qty_deliv_val_' + index).val()) == Number($('#qty_arrive_val_' + index).val()) && Number(
                        $('#qty_arrive_val_' + index).val())) {
                    $('#tr_' + index).css("background-color", "#00800036");
                }

                if (Number($('#qty_deliv_val_' + index).val()) && !Number($('#qty_arrive_val_' + index).val())) {
                    $('#tr_' + index).css("background-color", "#ffff0021");
                }

                if (Number($('#qty_deliv_val_' + index).val()) !== Number($('#qty_arrive_val_' + index).val()) &&
                    Number($('#qty_arrive_val_' + index).val())) {
                    $('#tr_' + index).css("background-color", "#ff00002b");
                }
                $('#total_seluruh').html('Rp. ' + formatRupiah(total));

            }

            $('#FormOrder').submit();
        } else {
            $('#total_td_' + row).html('Rp. ' + formatRupiah(qtyorder * harga));
            total = 0;
            for (let index = 0; index < row_id; index++) {
                total += Number($('#qty_order_val_' + index).val()) * Number($('#harga_val_' + index).val());
            }
            $('#total_seluruh').html('Rp. ' + formatRupiah(total));
            $('#FormOrder').submit();
        }
    }

    function KeluarEdit() {
        $.ajax({
            url: "Order/RemoveSessionEdit",
            type: "POST",
            dataType: 'json',
            error: function(xhr, status, error) {
                popup(status, true, xhr.status + " " + error);
            },
            success: function(data) {
                if (data.status === 'success') {
                    popup(data.status, data.toast, data.pesan);

                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    popup(data.status, data.toast, data.pesan);

                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }

            }
        });
    }

    function OrderEdit(id, judul) {
        $.ajax({
            url: "Order/SessionEdit",
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

                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    popup(data.status, data.toast, data.pesan);

                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                }

            }
        });
    }

    function Lihat(id, judul) {
        $.ajax({
            url: "Order/LihatBill",
            type: "POST",
            data: {
                id: id,
                judul: judul
            },
            error: function(xhr, status, error) {
                popup(status, true, xhr.status + " " + error);
            },
            beforeSend: function(xhr) {
                $('#OrderItem').html('<div class="loading-bg"><div class="loading"></div></div>');
            },
            success: function(data) {
                $('#OrderItem').html(data);
            }
        });
    }

    function Upload(id) {

        var row_id = $("#items tr").length - 1;

        var qtydeliv = '';
        var qtyarrive = '';
        for (let index = 0; index < row_id; index++) {
            qtydeliv += $('#qty_deliv_val_' + index).val();
            qtyarrive += $('#qty_arrive_val_' + index).val();
        }

        if (qtydeliv == qtyarrive) {
            judul = 'Yakin Ingin Upload?';
            cek = 'Upload akan mengurangi stock!';
        } else {
            judul = 'Data Berbeda Harap Perhatikan !!!';
            cek = 'System Menemukan Qty Deliv & Qty Arrive Berbeda, Qty Deliv Akan Mengurangi Stock';
        }

        Swal.fire({
            title: judul,
            text: cek,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Upload'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Order/Upload",
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

                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            popup(data.status, data.toast, data.pesan);

                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    }
                })
            }
        })
    }

    function UpRepair(id, status) {
        Swal.fire({
            title: 'Yakin Ingin ' + status + ' ?',
            text: "Anda Akan " + status + " Item Dari System!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: status
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "Order/UpRepair",
                    type: "POST",
                    data: {
                        id: id,
                        status: status
                    },
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        popup(status, true, xhr.status + " " + error);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            popup(data.status, data.toast, data.pesan);

                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            popup(data.status, data.toast, data.pesan);

                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    }
                })
            }
        })
    }


    function KePOS(id) {
        Swal.fire({
            title: 'Yakin Ingin Tranfer Order Ke POS ?',
            text: "Jika terdapat transaksi maka akan di hapus dan di gantikan ke item order!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oke'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "Order/KePOS",
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

    //Input
    $(document).ready(function() {

        $('#FormOrder').validate({
            rules: {
                'nama': {
                    required: true
                },
                'no': {
                    required: true
                },
                'outlet': {
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

        $('#FormOrder').submit(function(event) {
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
                            $('#hapus_' + data.row).removeAttr('onclick id style class')
                                .html('');
                            hapus =
                                '<a class="btn btn-danger btn-sm" onclick="HapusOrder(' +
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

                            if (!data.isiitem) {
                                $('#tujuan').prop('disabled', true);
                                $('#outlet').prop('disabled', true);
                            }
                            $('#add_row_order').show();
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
            };
        });

    });
</script>
@endsection