@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createPegawai', $user_permission))
                <form id="FormPegawai" action="{{ url('/Master/Pegawai') }}">
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
                                        <label>Store</label>
                                        <select name="store" id="store" class="form-control select2 select2-danger"
                                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            @foreach ($Datastore as $v)
                                                @if ($v['id'] != 1)
                                                    <option value="{{ $v['id'] }}">{{ $v['nama'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="nama">Nama {{ $subtitle }}</label>
                                        <input type="text" class="form-control" id="nama"
                                            placeholder="Nama {{ $subtitle }}" name="nama">
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir"
                                            placeholder="Tempat Lahir" name="tempat_lahir">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="tanggal_lahir"
                                                name="tanggal_lahir" data-inputmask-alias="datetime"
                                                data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Tanggal Masuk</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="tanggal_masuk"
                                                name="tanggal_masuk" data-inputmask-alias="datetime"
                                                data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="agama">Agama</label>
                                        <select name="agama" id="agama" class="form-control select2 select2-danger"
                                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katholik">Katholik</option>
                                            <option value="Budha">Budha</option>
                                            <option value="Hindu">Hindu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control select2 select2-danger"
                                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="Pria">Pria</option>
                                            <option value="Wanita">Wanita</option>
                                        </select>
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
                                        <input type="number" class="form-control" id="wa"
                                            placeholder="No Whatsapp" name="wa">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="divisi">Divisi</label>
                                        <select name="divisi" id="divisi" class="form-control select2 select2-danger"
                                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="Accounting">Accounting</option>
                                            <option value="Enginering">Enginering</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="HR & GA">HR & GA</option>
                                            <option value="Logistik">Logistik</option>
                                            <option value="Dapro">Dapur Produksi</option>
                                            <option value="Chief Leader">Chief Leader</option>
                                            <option value="Kitchen">Kitchen</option>
                                            <option value="Bar">Bar</option>
                                            <option value="Service Crew">Service Crew</option>
                                            <option value="Akustik">Akustik</option>
                                            <option value="Parkir">Parkir</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="jabatan">Jabatan</label>
                                        <select name="jabatan" id="jabatan" class="form-control select2 select2-danger"
                                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Leader">Leader</option>
                                            <option value="Staf">Staf</option>
                                            <option value="Freelance">Freelance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="status_pekerja">Status Pekerja</label>
                                        <select name="status_pekerja" id="status_pekerja"
                                            class="form-control select2 select2-success" required
                                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="1">Active</option>
                                            <option value="0">Resign</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="img">Foto</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="image/*"
                                                id="img" name="img">
                                            <label class="custom-file-label" for="img">Choose file</label>
                                        </div>
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
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Store</th>
                                <th>Nama</th>
                                <th>Tempat Tgl Lahir</th>
                                <th>Masuk Kerja</th>
                                <th>Agama</th>
                                <th>Gender</th>
                                <th>Whatsapp</th>
                                <th>Jabatan</th>
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
