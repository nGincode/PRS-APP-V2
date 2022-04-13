@isset($UsersData)
    <form id="UsersEdit" action="{{ url('/Users/TambahEdit') }}">
        <div class="modal-body">
            <div class="row">

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Outlet Users</label>
                        <select name="OutletUsers" id="OutletUsers1" class="form-control select2 select2-danger"
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>

                            @foreach ($Store as $str)
                                @if ($UsersData['store_id'] == $str['id'])
                                    <option value="{{ $str['id'] }}" selected>{{ $str['nama'] }}</option>
                                @else
                                    <option value="{{ $str['id'] }}">{{ $str['nama'] }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input value="{{ $UsersData['email'] }}" type="email" class="form-control" id="Email"
                            placeholder="Email" name="Email">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input value="{{ $UsersData['username'] }}" type="text" class="form-control" id="Username"
                            placeholder="Username" name="Username">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="PasswordUsersLama">Password Lama</label>
                        <input type="password" class="form-control" id="PasswordUsersLama" placeholder="Password"
                            name="PasswordUsersLama">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="PasswordUsersEdit">Password Baru</label>
                        <input type="password" class="form-control" id="PasswordUsersEdit" placeholder="Password"
                            name="PasswordUsersEdit">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="PasswordRipetEdit">Password Ulangi</label>
                        <input type="password" class="form-control" id="PasswordRipetEdit" placeholder="Passworrd"
                            name="PasswordRipetEdit">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="NamaDepanUsers">Nama Depan</label>
                        <input value="{{ $UsersData['firstname'] }}" type="text" class="form-control"
                            id="NamaDepanUsers" placeholder="Nama Depan" name="NamaDepanUsers">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="NamaBelakangUsers">Nama Belakang</label>
                        <input value="{{ $UsersData['lastname'] }}" type="text" class="form-control"
                            id="NamaBelakangUsers" placeholder="Nama Belakang" name="NamaBelakangUsers">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="NoUsers">No Whatsapp</label>
                        <input value="{{ $UsersData['phone'] }}" type="number" class="form-control" id="NoUsers"
                            placeholder="No Whatsapp" name="NoUsers">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="img">Image Profil</label>
                        <div class="custom-file">
                            <input type="file" accept="image/*" class="custom-file-input" id="img" name="img">
                            <label class="custom-file-label" for="img">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group clearfix">
                        <label>Gender</label><br>
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="GenderUsersPerempuanedit" name="gender" value="1"
                                @if ($UsersData['gender'] == 1) checked @endif>
                            <label for="GenderUsersPerempuanedit"> Perempuan</label>
                        </div>
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="GenderUsersPriaedit" value="2" name="gender"
                                @if ($UsersData['gender'] == 2) checked @endif>
                            <label for="GenderUsersPriaedit"> Laki-Laki</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
    <script>
        $(function() {
            $(".select2").select2();
            bsCustomFileInput.init();
        });

        $(document).ready(function() {
            //users Edit
            if ($("#UsersEdit").length) {
                $("#UsersEdit").validate({
                    errorClass: "error",
                    rules: {
                        "OutletUsers": {
                            required: true
                        },
                        "Email": {
                            required: true,
                            email: true
                        },
                        "Username": {
                            required: true,
                            minlength: 6
                        },
                        "PasswordUsersLama": {
                            required: true,
                            minlength: 6
                        },
                        "PasswordUsersEdit": {
                            required: true,
                            minlength: 6
                        },
                        "PasswordRipetEdit": {
                            required: true,
                            equalTo: "#PasswordUsersEdit"
                        },
                        "NamaDepanUsers": {
                            required: true
                        },
                        "NamaBelakangUsers": {
                            required: true
                        },
                        "NoUsers": {
                            required: true
                        }
                    },
                    messages: {
                        // OutletUsers : "Masih Kosong"
                    }
                });

                $("#UsersEdit").on("submit", function(event) {
                    var isValid = $(this).valid();
                    event.preventDefault();
                    var formData = new FormData(this);

                    if (isValid) {
                        $.ajax({
                            url: $(this).attr("action"),
                            type: "POST",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            success: function(data) {
                                if (data.status === "success") {
                                    popup(data.status, data.toast, data.pesan);
                                    $("#UsersEdit")[0].reset();
                                    $('#Modal').modal('hide');
                                    $('#manage').DataTable().ajax.reload();
                                } else {
                                    popup(data.status, data.toast, data.pesan);
                                }
                            }
                        });

                    }
                });
            }
        });
    </script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js">
    </script>
@endisset


@isset($StoreData)
    <form id="StoreEdit" action="{{ url('/Store/TambahEdit') }}">
        @csrf
        <div class="modal-body">
            <div class="row">

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="1" @if ($StoreData['active'] == 1) selected @endif>Active</option>
                            <option value="0" @if ($StoreData['active'] == 0) selected @endif>In Active</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Tipe</label>
                        <select name="tipe" id="tipe" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Office" @if ($StoreData['tipe'] == 'Office') selected @endif>Office</option>
                            <option value="Outlet" @if ($StoreData['tipe'] == 'Outlet') selected @endif>Outlet</option>
                            <option value="Logistik" @if ($StoreData['tipe'] == 'Logistik') selected @endif>Logistik</option>
                            <option value="Khusus" @if ($StoreData['tipe'] == 'Khusus') selected @endif>Khusus</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nama">Nama Store</label>
                        <input type="text" class="form-control" value="{{ $StoreData['nama'] }}" id="nama"
                            placeholder="Nama Store" name="nama">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" value="{{ $StoreData['alamat'] }}" id="alamat"
                            placeholder="alamat" name="alamat">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="wa">No Whatsapp</label>
                        <input type="number" class="form-control" value="{{ $StoreData['wa'] }}" id="wa"
                            placeholder="No Wa" name="wa">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="img">Logo Store</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" accept="image/*" id="img" name="img">
                            <label class="custom-file-label" for="img">Choose file</label>
                        </div>
                    </div>
                </div>

                <?php
                $jamkerja = json_decode($StoreData['jam_kerja'], true);
                ?>

                @if ($jamkerja)
                    @foreach ($jamkerja as $v)
                        <div class="col-12 col-sm-12" id="isi_jam_kerja_edit">
                            <div class="form-group">
                                <label for="nama_shift">Nama Shift</label>
                                <input type="text" class="form-control" value="{{ $v['Nama'] }}" id="nama_shift"
                                    placeholder="Nama Shift" name="nama_shift[]">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="masuk_kerja">Masuk </label>
                                <input type="time" class="form-control" value="{{ $v['Masuk'] }}" id="masuk_kerja"
                                    name="masuk_kerja[]">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6" id='akhir_isi_jam_kerja_edit'>
                            <div class="form-group">
                                <label for="pulang_kerja">Pulang </label>
                                <input type="time" class="form-control" value="{{ $v['Pulang'] }}" id="pulang_kerja"
                                    name="pulang_kerja[]">
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 col-sm-12" id="isi_jam_kerja_edit">
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

                    <div class="col-12 col-sm-6" id='akhir_isi_jam_kerja_edit'>
                        <div class="form-group">
                            <label for="pulang_kerja">Pulang </label>
                            <input type="time" class="form-control" id="pulang_kerja" name="pulang_kerja[]">
                        </div>
                    </div>
                @endif

                <a class="col-12 col-sm-12 btn btn-success" id="add_row_jam_kerja_edit"> + Tambah Shift</a>

            </div>
            <!-- /.row -->
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#add_row_jam_kerja_edit").unbind('click').bind('click', function() {
                var row_id = $(".row #isi_jam_kerja_edit").length + 1;
                var html =
                    '<div class="col-12 col-sm-12" id="isi_jam_kerja_edit"><div class="form-group"><label for="nama_shift">Nama Shift</label> <input class="form-control" id="nama_shift" placeholder="Nama Shift" value="Shift ' +
                    row_id +
                    '" required name="nama_shift[]"></div></div><div class="col-12 col-sm-6"><div class="form-group"><label for="masuk_kerja">Masuk</label> <input type="time" class="form-control" id="masuk_kerja" name="masuk_kerja[]" value="06:00" required></div></div><div class="col-12 col-sm-6" id="akhir_isi_jam_kerja_edit"><div class="form-group"><label for="pulang_kerja">Pulang</label> <input type="time" class="form-control" id="pulang_kerja" name="pulang_kerja[]" value="18:00" required></div></div>';
                if (row_id >= 2) {
                    $(".row #akhir_isi_jam_kerja_edit:last").after(html);
                }
            });



            if ($("#StoreEdit").length) {
                $("#StoreEdit").validate({
                    errorClass: "error",
                    rules: {
                        'nama': {
                            required: true
                        },
                        'status': {
                            required: true
                        },
                        'tipe': {
                            required: true
                        },
                        'alamat': {
                            required: true
                        },
                        'wa': {
                            required: true
                        }
                    },
                    messages: {
                        // OutletUsers : "Masih Kosong"
                    }
                });

                $("#StoreEdit").on("submit", function(event) {
                    var isValid = $(this).valid();
                    event.preventDefault();
                    var formData = new FormData(this);

                    if (isValid) {
                        $.ajax({
                            url: $(this).attr("action"),
                            type: "POST",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            success: function(data) {
                                if (data.status === "success") {
                                    popup(data.status, data.toast, data.pesan);
                                    $("#StoreEdit")[0].reset();
                                    $('#Modal').modal('hide');
                                    $('#manage').DataTable().ajax.reload();
                                } else {
                                    popup(data.status, data.toast, data.pesan);
                                }
                            }
                        });

                    }
                });
            }
        });
    </script>
@endisset


@isset($GroupsData)
    <form id="GroupsEdit" action="{{ url('/Group/TambahEdit') }}">
        @csrf
        <div class="modal-body">

            <div class="form-group">
                <label for="nama">Nama Group</label>
                <input type="text" class="form-control" id="nama" value="{{ $GroupsData['nama'] }}" name="nama"
                    placeholder="Masukkan Nama Group">
            </div>
            <br>
            <div class="form-group">
                <label for="permission">Permission</label>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Jenis Izin</th>
                            <th scope="col"><i class="fa fa-plus"></i> </th>
                            <th scope="col"><i class="fa fa-pen"></i> </th>
                            <th scope="col"><i class="fa fa-eye"></i> </th>
                            <th scope="col"><i class="fa fa-trash"></i> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>User</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createUser"
                                    @if (in_array('createUser', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateUser"
                                    @if (in_array('updateUser', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewUser"
                                    @if (in_array('viewUser', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteUser"
                                    @if (in_array('deleteUser', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>Store</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createStore"
                                    @if (in_array('createStore', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateStore"
                                    @if (in_array('updateStore', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewStore"
                                    @if (in_array('viewStore', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteStore"
                                    @if (in_array('deleteStore', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>Group</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createGroup"
                                    @if (in_array('createGroup', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateGroup"
                                    @if (in_array('updateGroup', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewGroup"
                                    @if (in_array('viewGroup', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteGroup"
                                    @if (in_array('deleteGroup', $permission)) checked @endif class="minimal"></td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="form-group">
                <label>Users</label>
                <select class="select2" multiple="multiple" name="usersedit[]" id="usersedit"
                    data-placeholder="Pilih User" style="width: 100%;">
                    @foreach ($Users as $v)
                        @if ($v['id'] != 1)
                            <option value="{{ $v['id'] }}"
                                @foreach ($GroupsUsers as $v1) @if ($v1['users_id'] == $v['id']) selected @endif @endforeach>
                                {{ $v['username'] }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <!-- /.row -->
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            var edit = $("#GroupsEdit");
            if (edit.length) {
                edit.validate({
                    errorClass: "error",
                    rules: {
                        'nama': {
                            required: true
                        },
                        'status': {
                            required: true
                        },
                        'tipe': {
                            required: true
                        },
                        'alamat': {
                            required: true
                        },
                        'wa': {
                            required: true
                        },
                        'usersedit[]': {
                            required: true
                        }
                    },
                    messages: {
                        // OutletUsers : "Masih Kosong"
                    }
                });

                edit.on("submit", function(event) {
                    var isValid = edit.valid();
                    event.preventDefault();
                    var formData = new FormData(this);

                    if (isValid) {
                        $.ajax({
                            url: edit.attr("action"),
                            type: "POST",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            success: function(data) {
                                if (data.status === "success") {
                                    popup(data.status, data.toast, data.pesan);
                                    edit[0].reset();
                                    $('#Modal').modal('hide');
                                    $('#manage').DataTable().ajax.reload();
                                } else {
                                    popup(data.status, data.toast, data.pesan);
                                }
                            }
                        });

                    }
                });
            }
        });


        $(function() {
            $(".select2").select2();
            bsCustomFileInput.init();
        });
    </script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js"></script>
@endisset
