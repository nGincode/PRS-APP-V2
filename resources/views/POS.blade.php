@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @csrf
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
                                    <input type="text" class="form-control" onkeyup="barcode(this.value)" id="search"
                                        placeholder="Barcode..">
                                    <i class="fa fa-barcode"
                                        style="padding: 10px;padding: 10px;margin-right:5px;border-radius: 5px;margin-left: 5px;border: solid 1px #e1e1e1;"></i>


                                    <input type="text" class="form-control" onkeyup="search(this.value)" id="search"
                                        placeholder="Search..">
                                    <i class="fa fa-search"
                                        style="padding: 10px;padding: 10px;border-radius: 5px;margin-left: 5px;border: solid 1px #e1e1e1;"></i>
                                </div>
                                <div class="card-body" style="max-height: 500px;overflow-y:auto;" id="item">
                                    <div class="waiting"
                                        style="position: absolute;height: 85%;width: 96%;background-color: #dfdfdf;z-index: 9999;border-radius: 10px;display:none;">
                                    </div>
                                    @foreach ($item as $v)
                                        @if (!$v['bahan']->delete)
                                            <div class="animate__animated animate__backInDown animate__faster item"
                                                id="pilihan_<?= $v['id'] ?>"
                                                onclick="pilih(<?= $v['id'] ?>, <?= $v['bahan_id'] ?> )">
                                                <div class="float-right"><b>
                                                        @if ($v['qty'] < 5)
                                                            <i class="fa fa-exclamation-triangle"></i>
                                                        @endif {{ $v['qty'] . ' ' . $v['satuan'] }}
                                                    </b>
                                                </div>
                                                <h5 class="card-title"><b>{{ $v['bahan']->nama }}</b></h5>
                                                <p class="card-text">
                                                    {{ 'Rp ' . number_format($v['harga_last'], 0, ',', '.') }}</p>
                                                <hr>
                                            </div>
                                        @endif
                                    @endforeach
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


                <div class="card">
                    <div class="card-header text-white bg-secondary mb-3">
                        <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
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
            </div>

            <!-- /.container-fluid -->
    </section>


    <!-- Modal -->
    <div class="modal fade" id="transaksi" tabindex="-1" role="dialog" style="width:100%" aria-labelledby="transaksiLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
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

    <style>
        .duit {
            display: flex;
            flex-direction: row;
        }

        @media (max-width: 1000px) {
            .duit {
                flex-direction: column;
            }
        }

        /* The container */
        .container {
            display: block;
            border: #007bff 2px solid;
            position: relative;
            padding: 10px;
            padding-left: 35px;
            margin: 8px;
            cursor: pointer;
            font-size: 15px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            transition: 0.3s;
        }


        .container:hover {
            border-radius: 15px;
            background-color: #007bff;
            color: white;
        }


        /* Hide the browser's default radio button */
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark {
            position: absolute;
            top: 9px;
            left: 5px;
            height: 25px;
            width: 25px;
            background-color: #eee;
            border-radius: 50%;
            transition: 0.3s;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input~.checkmark {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container input:checked~.checkmark {
            background-color: #2196F3;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container input:checked~.checkmark:after {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .container .checkmark:after {
            top: 9px;
            left: 9px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }

        .waiting {
            cursor: wait;
            color: black;

        }

        .item {
            cursor: pointer;
            transition: 0.3s;
        }

        .item:hover {
            color: #007bff;
        }

        .loading-bg {
            width: 100%;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loading {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script src="assets/js/jQuery.print.min.js"></script>
    <script>
        layar();

        function pilih(id, bahan) {
            $.ajax({
                url: "POS/Pilih",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
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
                    if (data.no > 100000) {
                        html += '<label  onclick="inputkosong()" class="container">' + data.no +
                            ' <input type="radio" name="duit" value="' + data.no +
                            '" id="duit"> <span class="checkmark"></span> </label>';


                        if (data.no < 150000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">150.000<input type="radio" name="duit" value="150000" id="duit"> <span class="checkmark"></span> </label>';
                        }
                        if (data.no < 200000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">200.000<input type="radio" name="duit" value="200000"  id="duit"> <span class="checkmark"></span> </label>';
                        }
                        if (data.no < 500000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">500.000<input type="radio" name="duit" value="500000" id="duit"> <span class="checkmark"></span> </label>';
                        }
                        if (data.no < 1000000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">1.000.000<input type="radio" name="duit" value="1000000" id="duit"> <span class="checkmark"></span> </label>';
                        }
                    }

                    if (data.no < 100000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">100.000<input type="radio" name="duit" value="100000" id="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 50000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">50.000<input type="radio" name="duit" value="50000" id="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 20000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">20.000<input type="radio" name="duit" value="20000" id="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 10000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">10.000<input type="radio" name="duit" value="10000" id="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 5000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">5.000<input type="radio" name="duit" value="5000" id="duit"> <span class="checkmark"></span> </label>';
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
                data: {
                    "_token": "{{ csrf_token() }}",
                },
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
                    no: $('#no').val(),
                    jumlah: $('#jumlah').val(),
                    duit: $("input[name='duit']:checked").val()
                },
                dataType: 'json',
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {

                    if (data.status) {
                        popup(data.status, data.toast, data.pesan);
                    }

                    if (data.status == 'success') {
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


        function Print(id) {
            $.ajax({
                url: "POS/Print",
                type: "POST",
                data: {
                    id: id,
                },
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    $('#printaera').html(data);

                    $("#printaera").print({
                        globalStyles: true,
                        mediaPrint: false,
                        stylesheet: null,
                        noPrintSelector: ".no-print",
                        iframe: true,
                        append: null,
                        prepend: null,
                        manuallyCopyFormValues: true,
                        deferred: $.Deferred(),
                        timeout: 750,
                        title: null,
                        doctype: '<!doctype html>'
                    });
                }
            });
        }
    </script>
@endsection
