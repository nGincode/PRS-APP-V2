@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createInventoryOpname', $user_permission))
                <form id="FormInventoryOpname" action="{{ url('/Inventory/Opname') }}">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b> {{ $title . ' Stock ' . $subtitle }} </b></h3>

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
                                        <select class="select2" name="nama" id="nama_tambah"
                                            data-placeholder="Pilih Nama Bahan" style="width: 100%;">
                                            @if ($bahan)
                                                <option selected="true" disabled="disabled">Pilih</option>
                                                @foreach ($bahan as $v)
                                                    <option value="{{ $v['id'] }}">
                                                        {{ $v['nama'] . ' (' . $v['satuan'] . ')' }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option selected="true" disabled="disabled">Inventory Kosong</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="select2" name="status" id="status" data-placeholder="Pilih"
                                            style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="Tambah">
                                                Tambah
                                            </option>
                                            <option value="Kurang">
                                                Kurang
                                            </option>
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
                                        <label for="ket">Keterangan</label>
                                        <input type="text" class="form-control" id="ket" placeholder="Keterangan"
                                            name="ket">
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            @endif


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
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Qty</th>
                                <th>Qty Sebelumnya</th>
                                <th>Total Qty</th>
                                <th>Ket</th>
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
@endsection
