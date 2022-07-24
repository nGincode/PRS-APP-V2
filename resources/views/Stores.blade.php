@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createStore', $user_permission))
                <form id="FormStore" action="{{ url('/Store') }}">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Tambah {{ $title }} </b></h3>

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
                                        <label>Status</label>
                                        <select name="status" id="status" class="form-control select2 select2-danger"
                                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="1">Active</option>
                                            <option value="0">In Active</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <select name="tipe" id="tipe" class="form-control select2 select2-danger"
                                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="Office">Office</option>
                                            <option value="Outlet">Outlet</option>
                                            <option value="Logistik">Logistik</option>
                                            <option value="Dapro">Dapur Produksi</option>
                                            <option value="Khusus">Khusus</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="nama">Nama Store</label>
                                        <input type="text" class="form-control" id="nama" placeholder="Nama Store"
                                            name="nama">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" placeholder="Alamat"
                                            name="alamat">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="wa">No Whatsapp</label>
                                        <input type="number" class="form-control" id="wa" placeholder="No Wa"
                                            name="wa">
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="img">Logo Store</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="image/*" id="img"
                                                name="img">
                                            <label class="custom-file-label" for="img">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12" id="isi_jam_kerja">
                                    <div class="form-group">
                                        <label for="nama_shift">Nama Shift</label>
                                        <input type="text" class="form-control" id="nama_shift" placeholder="Nama Shift"
                                            name="nama_shift[]">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="masuk_kerja">Masuk </label>
                                        <input type="time" class="form-control" id="masuk_kerja" name="masuk_kerja[]">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6" id='akhir_isi_jam_kerja'>
                                    <div class="form-group">
                                        <label for="pulang_kerja">Pulang </label>
                                        <input type="time" class="form-control" id="pulang_kerja"
                                            name="pulang_kerja[]">
                                    </div>
                                </div>

                                <a class="col-12 col-sm-12 btn btn-success" id="add_row_jam_kerja">+ Tambah Shift</a>

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
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Store</th>
                                <th>Status</th>
                                <th>Tipe</th>
                                <th>Alamat</th>
                                <th>No Wa</th>
                                <th>Jam Kerja</th>
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
