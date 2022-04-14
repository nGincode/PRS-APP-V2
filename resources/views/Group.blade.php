@extends('layout')

@section('isi')
    <?php
    use App\Models\GroupsUsers; ?>

    <section class="content">
        <div class="container-fluid">
            <form id="FormGroup" action="{{ url('/Group') }}">
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

                        <div class="form-group">
                            <label for="nama">Nama Group</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan Nama Group">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="permission">Permission</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Jenis Izin</th>
                                        <th scope="col"><i class="fa fa-plus"></i> Tambah</th>
                                        <th scope="col"><i class="fa fa-pen"></i> Edit</th>
                                        <th scope="col"><i class="fa fa-eye"></i> lihat</th>
                                        <th scope="col"><i class="fa fa-trash"></i> Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>User</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="createUser"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="updateUser"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewUser"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteUser"
                                                class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Store</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="createStore"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="updateStore"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewStore"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteStore"
                                                class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Group</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="createGroup"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="updateGroup"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewGroup"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteGroup"
                                                class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>Master Data</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="createMaster"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="updateMaster"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewMaster"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteMaster"
                                                class="minimal"></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="form-group">
                            <label>Users</label>
                            <select class="select2" multiple="multiple" name="users[]" id="users"
                                data-placeholder="Pilih User" style="width: 100%;">
                                @foreach ($Users as $v)
                                    <?php $us = GroupsUsers::where('users_id', $v['id'])->count(); ?>
                                    @if (!$us)
                                        <option value="{{ $v['id'] }}">{{ $v['username'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header text-white bg-secondary mb-3">
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Group</th>
                                <th>Permission</th>
                                <th>User</th>
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
