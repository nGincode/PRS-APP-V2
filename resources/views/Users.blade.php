@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createUser', $user_permission))
                <form id="FormUsers" action="{{ url('/Users') }}">
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
                                        <label>Outlet Users</label>
                                        <select name="OutletUsers" id="OutletUsers" class="form-control select2"
                                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            @foreach ($Store as $str)
                                                @if ($str['id'] != 1)
                                                    <option value="{{ $str['id'] }}">{{ $str['nama'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="izin">Izin Penampilan</label>
                                        <select name="izin" id="izin" class="form-control select2"
                                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="1">Keseluruhan</option>
                                            <option value="0">Khusus</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="Email">Email</label>
                                        <input type="email" class="form-control" id="Email" placeholder="Email"
                                            name="Email">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="Username">Username</label>
                                        <input type="username" class="form-control" id="Username" placeholder="Username"
                                            name="Username">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="PasswordUsers">Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input class="form-control" type="password" id="PasswordUsers"
                                                placeholder="Password" name="PasswordUsers">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="cursor: pointer">
                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="PasswordRipet">Password Ulangi</label>
                                        <div class="input-group" id="show_hide_password_ulang">
                                            <input type="password" class="form-control" id="PasswordRipet"
                                                placeholder="Password" name="PasswordRipet">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="cursor: pointer">
                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="NamaDepanUsers">Nama Depan</label>
                                        <input type="text" class="form-control" id="NamaDepanUsers"
                                            placeholder="Nama Depan" name="NamaDepanUsers">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="NamaBelakangUsers">Nama Belakang</label>
                                        <input type="text" class="form-control" id="NamaBelakangUsers"
                                            placeholder="Nama Belakang" name="NamaBelakangUsers">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="NoUsers">No Whatsapp</label>
                                        <input type="number" class="form-control" id="NoUsers"
                                            placeholder="No Whatsapp" name="NoUsers">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="img">Image Profil</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="image/*"
                                                id="img" name="img">
                                            <label class="custom-file-label" for="img">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group clearfix">
                                        <label>Gender</label><br>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="GenderUsersPerempuan" name="gender"
                                                value="1" checked>
                                            <label for="GenderUsersPerempuan">
                                                Perempuan
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="GenderUsersPria" value="2" name="gender">
                                            <label for="GenderUsersPria">
                                                Laki-Laki
                                            </label>
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
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Store</th>
                                <th>Email</th>
                                <th>Nama Lengkap</th>
                                <th>No Wa</th>
                                <th>Last Login</th>
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
