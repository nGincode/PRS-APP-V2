@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createPOS', $user_permission))
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b> {{ $title . ' ' . $subtitle }} </b></h3>

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

                            <div class="col-sm-8">
                                <div class="float-right">
                                    <b>
                                        Total
                                    </b>
                                    <h1><b id="totalbelanja"></b></h1>
                                </div>
                                <h1>
                                    <b>
                                        {{ request()->session()->get('store') }}
                                    </b>
                                </h1>
                                <br><br>
                                <div class="card card-success card-outline" style="min-height: 600px">
                                    <div class="card-header" style="display: flex">
                                        <form id="FormBarcode" action="POS/Barcode" method="POST">
                                            <input type="search" class="form-control" name="id" id="barcode"
                                                placeholder="Barcode..">
                                        </form>
                                        <i class="fa fa-barcode"
                                            style="padding: 10px;padding: 10px;margin-right:5px;border-radius: 5px;margin-left: 5px;border: solid 1px #e1e1e1;"></i>


                                        <input type="search" class="form-control" oninput="search(this.value)"
                                            id="search" placeholder="Search..">
                                        <i class="fa fa-search"
                                            style="padding: 10px;padding: 10px;border-radius: 5px;margin-left: 5px;border: solid 1px #e1e1e1;"></i>
                                    </div>
                                    <div class="card-body" style="max-height: 500px;overflow-y:auto;" id="item">
                                        <div class="waiting"
                                            style="position: absolute;height: 85%;width: 96%;background-color: #dfdfdf;z-index: 9999;border-radius: 10px;display:none;">
                                        </div>
                                        @if (count($item))
                                            @foreach ($item as $v)
                                                <div class="animate__animated animate__backInDown animate__faster item"
                                                    id="pilihan_<?= $v['id'] ?>"
                                                    onclick="pilih(<?= $v['id'] ?>, <?= $v['bahan_id'] ?> )">
                                                    <div class="float-right"><b>
                                                            @if ($v['qty'] < 5)
                                                                <i class="fa fa-exclamation-triangle"></i>
                                                            @endif
                                                            {{ $v['qty'] . ' ' . $v['satuan'] }}
                                                        </b>
                                                    </div>
                                                    <div>
                                                        <h5 class="card-title"><b>{{ $v['bahan']->nama }}</b><br>
                                                            <small>{{ $v['bahan']->kode }}</small>
                                                        </h5>

                                                        @if ($v['auto_harga'])
                                                            <p class="card-text">
                                                                {{ 'Rp ' . number_format($v['harga_auto'], 0, ',', '.') }}
                                                            </p>
                                                        @else
                                                            <p class="card-text">
                                                                {{ 'Rp ' . number_format($v['harga_manual'], 0, ',', '.') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                </div>
                                            @endforeach
                                        @else
                                            <b>!!!</b> Inventory Belum Terisi
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="card card-primary card-outline" style="min-height: 600px">
                                    <div class="card-header">
                                        <h5 class="card-title m-0"><b>POS (Point Of Sales)</b></h5>
                                    </div>
                                    <div class="card-body" id="layar" style="max-height: 600px;overflow-y:auto;">


                                    </div>
                                </div>
                                <button href="#" id="submit" disabled class="btn btn-primary btn-lg btn-block"
                                    data-toggle="modal" data-target="#transaksi"><B>--| SUBMIT |--</B></button>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>

                </div>
            @endif
            <div class="card">
                <div class="card-header text-white bg-secondary mb-3">
                    <h3 class="card-title" style="font-weight: bolder;padding:8px">Data {{ $title . ' ' . $subtitle }}
                    </h3>

                    @if (request()->session()->get('store') === 'Office')
                        <div class="btn-group float-right">
                            <button type="button" class="btn btn-info">All</button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown"
                                aria-expanded="false">
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                <a class="dropdown-item" href="#">Action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Separated link</a>
                            </div>
                        </div>
                    @endif


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
                                <th>No Bill</th>
                                <th>Nama</th>
                                <th>No Hp</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.container-fluid -->
    </section>


    <!-- Modal -->
    <div class="modal fade" id="transaksi" tabindex="-1" role="dialog" style="width:100%"
        aria-labelledby="transaksiLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>Detail Transaksi</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form>
                        <center>
                            <h4><b>IDENTITAS</b></h4>
                        </center>
                        <div class="form-group">
                            <label for="pengorder">Pengorder :</label>
                            <input type="text" class="form-control" name="nama" id="pengorder"
                                aria-describedby="Pengorder" placeholder="Masukan Data">
                        </div>

                        <div class="form-group">
                            <label for="no">No Hp:</label>
                            <input type="number" class="form-control" name="no" id="no"
                                aria-describedby="No" placeholder="Masukan Data">
                        </div>


                        <div class="form-group">
                            <label>Pemesan</label>
                            <select name="outlet_store" id="outlet_store" class="form-control select2"
                                data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option selected="true" disabled="disabled">Pilih</option>
                                @foreach ($Store as $str)
                                    @if ($str['id'] != 1)
                                        <option value="{{ $str['nama'] }}">{{ $str['nama'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <center>
                            <h4><b id="totalbelanja1"></b></h4>
                        </center>
                        <hr>

                        <div class="duit">
                        </div>
                        <br>


                        <div class="form-group">
                            <center>
                                <input type="number" class="form-control" style="width:40%" no="jumlah"
                                    id="jumlah" onkeyup="$('input[type=radio]').prop('checked', false)"
                                    aria-describedby="Jumlah" placeholder="Masukan Data">
                            </center>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="button" onclick="bayar()" class="btn btn-primary"><b>Bayar</b></button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kembalian" tabindex="-1" role="dialog" style="width:100%"
        aria-labelledby="transaksiLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Kembalian</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="StatusKembalian">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="lihat" tabindex="-1" role="dialog" style="width:100%"
        aria-labelledby="transaksiLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Bill Transaksi</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="BillTransaksi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>



    <div id="printaera" style="position: absolute;top:0; z-index: -9;"></div>

    <script>
        layar();

        function pilih(id, bahan) {
            $.ajax({
                url: "POS/Pilih",
                type: "POST",
                data: {
                    id: id,
                    bahan: bahan
                },
                beforeSend: function(xhr) {
                    $('.waiting').show('');
                },
                error: function(xhr, status, error) {
                    // popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    $('.waiting').hide('');
                    layar();

                }
            });
        }

        function search(value) {
            $.ajax({
                url: "POS/Search",
                type: "POST",
                data: {
                    id: value
                },
                beforeSend: function(xhr) {
                    $('.waiting').show('');
                },
                error: function(xhr, status, error) {
                    // popup(status, true, xhr.status + " " + error);
                    $('#item').html('');
                },
                success: function(data) {
                    $('.waiting').hide('');
                    $('#item').html(data);
                }
            });
        }

        function totalbill() {
            $.ajax({
                url: "POS/Totalbill",
                type: "POST",
                dataType: 'json',
                error: function(xhr, status, error) {
                    // popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    $('#totalbelanja').html(data.rp);
                    $('#totalbelanja1').html(data.rp);
                    if (data.no) {
                        $("#submit").prop('disabled', false);
                    } else {
                        $("#submit").prop('disabled', true);
                    }

                    var html = '';

                    html += '<label  onclick="inputkosong()" class="container">Rp. ' + formatRupiah(data
                            .no) +
                        ' <input type="radio" name="duit" value="' + data.no +
                        '" id="duit"> <span class="checkmark"></span> </label>';

                    if (data.no > 100000) {

                        if (data.no < 200000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">Rp. 200.000<input type="radio" name="duit" value="200000"  id="duit"> <span class="checkmark"></span> </label>';
                        }
                        if (data.no < 500000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">Rp. 500.000<input type="radio" name="duit" value="500000" id="duit"> <span class="checkmark"></span> </label>';
                        }
                        if (data.no < 1000000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">Rp. 1.000.000<input type="radio" name="duit" value="1000000" id="duit"> <span class="checkmark"></span> </label>';
                        }
                    }

                    if (data.no < 100000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">Rp. 100.000<input type="radio" name="duit" value="100000" id="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 50000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">Rp. 50.000<input type="radio" name="duit" value="50000" id="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 20000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">Rp. 20.000<input type="radio" name="duit" value="20000" id="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 10000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">Rp. 10.000<input type="radio" name="duit" value="10000" id="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 5000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">Rp. 5.000<input type="radio" name="duit" value="5000" id="duit"> <span class="checkmark"></span> </label>';
                    }

                    $('.duit').html(html);

                }
            });
        }

        function inputkosong() {
            $('#jumlah').val('');
        }

        function layar() {
            $.ajax({
                url: "POS/Layar",
                type: "POST",
                error: function(xhr, status, error) {
                    // popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    $('#layar').html(data);
                    totalbill()
                }
            });
        }

        function positemplus(id) {
            $.ajax({
                url: "POS/positemplus",
                type: "POST",
                data: {
                    id: id
                },
                dataType: 'json',
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                beforeSend: function(xhr) {
                    $('#TblPlus_' + id).prop('disabled', true);
                    $('#key_' + id).prop('disabled', true);
                },
                success: function(data) {
                    if (data.status) {
                        popup(data.status, data.toast, data.pesan);
                    } else {
                        layar();
                    }
                }
            });
        }

        function positemminus(id) {
            $.ajax({
                url: "POS/positemminus",
                type: "POST",
                data: {
                    id: id
                },
                dataType: 'json',
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                beforeSend: function(xhr) {
                    $('#TblMinus_' + id).prop('disabled', true);
                },
                success: function(data) {
                    if (data.status) {
                        popup(data.status, data.toast, data.pesan);
                    } else {
                        layar();
                    }
                }
            });
        }

        function positemhapus(id) {
            Swal.fire({
                title: 'Yakin Ingin Menghapus ?',
                text: "Tindakan Ini Akan Menghapus Selamanya",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "POS/positemhapus",
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
                                layar();
                            } else if (data.status === 'no') {
                                layar();
                            } else {
                                popup(data.status, data.toast, data.pesan);
                            }
                        }
                    });
                }
            })
        }

        function bayar() {
            $.ajax({
                url: "POS/Input",
                type: "POST",
                data: {
                    pengorder: $('#pengorder').val(),
                    outlet: $('#outlet_store').val(),
                    no: $('#no').val(),
                    jumlah: $('#jumlah').val(),
                    duit: $("input[name='duit']:checked").val()
                },
                dataType: 'json',
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    console.log(data);
                    if (data.status) {
                        popup(data.status, data.toast, data.pesan);
                    }

                    if (data.status !== 'error') {
                        layar();
                        $('#transaksi').modal('hide');
                        if (data.kembalian) {
                            if (data.kembalian === 0) {
                                $('#StatusKembalian').html(
                                    '<div class="modal-body"><center><h2><b style="color: green">~ LUNAS ~</b></h2></center></div><div class="modal-footer"><button type="button" onclick="Print(' +
                                    data.id +
                                    ')" class="btn btn-primary btn-block"><b>Print</b></button></div>'
                                );
                            } else {
                                $('#StatusKembalian').html(
                                    '<div class="modal-body"><center><h3><b>~ KEMBALIAN ~</b></h3></center><center><h4><b>' +
                                    data
                                    .kembalian +
                                    '</b></h4></center></div><div class="modal-footer"><button type="button" onclick="Print(' +
                                    data.id +
                                    ')" class="btn btn-primary btn-block"><b>Print</b></button></div>'
                                );
                            }
                        }
                        $('#kembalian').modal('show');
                        $('#manage').DataTable().ajax.reload();
                        search();
                    }

                }
            });
        }

        function lihat(id, judul) {
            $.ajax({
                url: "POS/LihatBill",
                type: "POST",
                data: {
                    id: id,
                    judul: judul
                },
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                beforeSend: function(xhr) {
                    $('#BillTransaksi').html('<div class="loading-bg"><div class="loading"></div></div>');
                },
                success: function(data) {
                    $('#BillTransaksi').html(data);
                }
            });
        }


        // function Print(id) {
        //     $.ajax({
        //         url: "POS/Print",
        //         type: "POST",
        //         data: {
        //             id: id,
        //         },
        //         error: function(xhr, status, error) {
        //             popup(status, true, xhr.status + " " + error);
        //         },
        //         success: function(data) {
        //             $('#printaera').html(data);

        //             $("#printaera").print({
        //                 globalStyles: true,
        //                 mediaPrint: false,
        //                 stylesheet: null,
        //                 noPrintSelector: ".no-print",
        //                 iframe: true,
        //                 append: null,
        //                 prepend: null,
        //                 manuallyCopyFormValues: true,
        //                 deferred: $.Deferred(),
        //                 timeout: 750,
        //                 title: null,
        //                 doctype: '<!doctype html>'
        //             });
        //         }
        //     });
        // }


        function qtyubah(id, qty) {

            $.ajax({
                url: "POS/positemubah",
                type: "POST",
                data: {
                    id: id,
                    qty: qty
                },
                dataType: 'json',
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                beforeSend: function(xhr) {
                    $('#TblPlus_' + id).prop('disabled', true);
                },
                success: function(data) {
                    if (data.status) {
                        popup(data.status, data.toast, data.pesan);
                    } else {
                        layar();
                    }
                }
            });
        }


        //Input
        $(document).ready(function() {

            $('#FormBarcode').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                var sound = new Audio('assets/sound/beep.mp3');

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
                        if (data.status) {
                            popup(data.status, data.toast, data.pesan);
                        } else {
                            if (!data.barcode) {
                                layar();
                                $('#barcode').val('');
                                sound.play();
                            }
                        }
                    }
                });

            });

        });
    </script>
@endsection
