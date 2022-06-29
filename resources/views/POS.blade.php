@extends('layout')

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
                                <div class="card-header">
                                    <h5 class="card-title m-0" style="padding:5px"><b>Produk Inventory</b></h5>

                                    <div class="float-right" style="position: absolute; right:0px;">
                                        <div class="form-group col-md-12">
                                            <input type="text" class="form-control" id="search"
                                                placeholder="Search..">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="max-height: 500px;overflow-y:auto;" id="item">
                                    @foreach ($item as $v)
                                        <div class="item" id="pilihan_<?= $v['id'] ?>"
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
                            <a href="#" class="btn btn-primary btn-lg btn-block" data-toggle="modal"
                                data-target="#transaksi"><B>--| SUBMIT |--</B></a>
                        </div>

                    </div>
                    <!-- /.row -->
                </div>
                </form>


                <div class="card">
                    <div class="card-header text-white bg-secondary mb-3">
                        <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="manage1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Qty</th>
                                    <th>Qty Sebelumnya</th>
                                    <th>Total Qty</th>
                                    <th>Ket</th>
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

                    <form id="transaksi">
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
                            <input type="number" class="form-control" name="no" id="no" aria-describedby="No"
                                placeholder="Masukan Data">
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
                    <button type="button" class="btn btn-primary"><b>Bayar</b></button>
                </div>
            </div>
        </div>
    </div>
    </div>

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
    </style>
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
                    $('#pilihan_' + id).addClass('waiting');
                },
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    $('#pilihan_' + id).removeClass('waiting');
                    layar();

                }
            });
        }

        function totalbill() {
            $.ajax({
                url: "POS/Totalbill",
                type: "POST",
                dataType: 'json',
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    $('#totalbelanja').html(data.rp);
                    $('#totalbelanja1').html(data.rp);

                    var html = '';
                    if (data.no > 100000) {
                        html += '<label  onclick="inputkosong()" class="container">' + data.no +
                            ' <input type="radio" name="duit"> <span class="checkmark"></span> </label>';


                        if (data.no < 150000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">150.000<input type="radio" name="duit"> <span class="checkmark"></span> </label>';
                        }
                        if (data.no < 200000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">200.000<input type="radio" name="duit"> <span class="checkmark"></span> </label>';
                        }
                        if (data.no < 500000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">500.000<input type="radio" name="duit"> <span class="checkmark"></span> </label>';
                        }
                        if (data.no < 1000000) {
                            html +=
                                '<label  onclick="inputkosong()" class="container">1.000.000<input type="radio" name="duit"> <span class="checkmark"></span> </label>';
                        }
                    }

                    if (data.no < 100000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">100.000<input type="radio" name="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 50000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">50.000<input type="radio" name="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 20000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">20.000<input type="radio" name="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 10000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">10.000<input type="radio" name="duit"> <span class="checkmark"></span> </label>';
                    }

                    if (data.no < 5000) {
                        html +=
                            '<label  onclick="inputkosong()" class="container">5.000<input type="radio" name="duit"> <span class="checkmark"></span> </label>';
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
                    popup(status, true, xhr.status + " " + error);
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
    </script>
@endsection
