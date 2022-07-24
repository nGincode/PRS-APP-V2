@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormInventory" action="{{ url('/Inventory/Stock') }}">
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
                                    <label for="nama">Nama Bahan</label>
                                    <select class="select2" name="nama" id="nama"
                                        data-placeholder="Pilih Nama Bahan" style="width: 100%;">
                                        @if ($bahan)
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            @foreach ($bahan as $v)
                                                <option value="{{ $v['id'] }}">
                                                    {{ $v['nama'] . ' (' . $v['satuan'] . ')' }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option selected="true" disabled="disabled">Master Bahan Kosong</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <input type="number" class="form-control" id="qty" placeholder="Qty"
                                        name="qty">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select name="satuan" id="satuan" class="form-control select2 select2-danger"
                                        required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        @foreach ($satuan as $s1)
                                            <option value="{{ $s1['singkat'] }}">{{ $s1['nama'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" id="harga" placeholder="Harga Satuannya"
                                        name="harga">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="auto_harga">Auto Harga</label>
                                    <select class="select2" name="auto_harga" id="auto_harga" data-placeholder="Pilih"
                                        style="width: 100%;">
                                        <option value="1">True</option>
                                        <option value="0">False</option>
                                    </select>
                                    <small>*Harga akan berubah menyesuiakan belanja</small>
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="harga">Margin</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="margin"
                                            placeholder="Harga Margin %" name="margin">
                                        <div class="input-group-append"><span class="input-group-text">%</span></div>
                                    </div>
                                </div>
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
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Margin</th>
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
