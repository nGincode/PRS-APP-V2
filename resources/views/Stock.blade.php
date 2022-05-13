@extends('layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormOlahan" action="{{ url('/Foodcost/Olahan') }}">
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
                                    <label for="nama">Qty</label>
                                    <input type="number" class="form-control" id="nama" placeholder="Nama Olahan"
                                        name="nama">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="nama">Qty</label>
                                    <input type="number" class="form-control" id="nama" placeholder="Nama Olahan"
                                        name="nama">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12">
                                <label>Bahan Baku</label>
                                <table id="managebahanbaku" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Bahan</th>
                                            <th scope="col">Qty
                                            </th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">
                                                <i class="fas fa-trash"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url('/Foodcost/Olahan/Session') }}" class="btn btn-danger">Clear</a>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header text-white bg-secondary mb-3">
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage2" class="table table-bordered table-striped">
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
    <script></script>
@endsection
