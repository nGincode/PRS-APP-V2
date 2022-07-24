@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createSatuan', $user_permission))
                <form id="FormSatuan" action="{{ url('/Master/Satuan') }}">
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
                                        <label for="nama">Nama Satuan</label>
                                        <input type="text" class="form-control" style="text-transform:capitalize"
                                            id="nama" placeholder="Kilogram" name="nama">
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="singkat">Singkatan</label>
                                        <input type="text" class="form-control" id="singkat"
                                            style="text-transform:capitalize" placeholder="Kg" name="singkat">
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
                                <th>Nama Satuan</th>
                                <th>Singkatan</th>
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
