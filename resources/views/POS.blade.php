@extends('layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormInventoryOpname" action="{{ url('/Inventory/Opname') }}">
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
                                    <h1 id="totalbelanja"><b>Rp. 3000</b></h1>
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
                                            <div class="item">
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
                                    <div class="card-body">
                                        <div class="float-right" style="position: absolute; right:10px"><button
                                                class="btn btn-danger"><i class="fa fa-trash"></i></button></div>
                                        <h5 class="card-title">Ayam Geprek x1</h5>
                                        <p class="card-text">Rp. 3000</p>
                                        <hr>


                                        <div class="float-right" style="position: absolute; right:10px"><button
                                                class="btn btn-danger"><i class="fa fa-trash"></i></button></div>
                                        <h5 class="card-title">Ayam Geprek x1</h5>
                                        <p class="card-text">Rp. 3000</p>
                                        <hr>

                                    </div>
                                </div>
                                <a href="#" class="btn btn-primary btn-lg btn-block">Bayar</a>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
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
    <style>
        .item {
            cursor: pointer;
            transition: 0.3s;
        }

        .item:hover {
            color: #007bff;
        }
    </style>
@endsection
