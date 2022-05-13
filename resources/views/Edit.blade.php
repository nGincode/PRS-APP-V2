@isset($UsersData)
    <form id="UsersEdit" action="{{ url('/Users/TambahEdit') }}">
        <div class="modal-body">
            <div class="row">

                @if ($UsersData['img'])
                    <div class="col-12 col-sm-12">
                        <img src="{{ $UsersData['img'] }}" alt="Foto Pegawai"
                            class="rounded mx-auto d-block img-thumbnail">
                        <br>
                    </div>
                @endif
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
                        <label for="izin">Izin Penampilan</label>
                        <select name="izin" id="izin" class="form-control select2 select2-danger"
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="1" @if ($UsersData['id'] == 1) selected @endif>Keseluruhan</option>
                            <option value="0" @if ($UsersData['id'] == 0) selected @endif>Khusus</option>
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
            $('.select2').select2().on("change", function(e) {
                $(this).valid()
            });
            bsCustomFileInput.init();
        });

        $(document).ready(function() {
            //users Edit
            if ($("#UsersEdit").length) {
                $("#UsersEdit").validate({
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                        $(element).removeClass('is-valid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    success: function(validClass, element) {
                        $(element).addClass('is-valid');
                    },
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
                        },
                        "izin": {
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
@endisset


@isset($StoreData)
    <form id="StoreEdit" action="{{ url('/Store/TambahEdit') }}">
        @csrf
        <div class="modal-body">
            <div class="row">

                @if ($StoreData['img'])
                    <div class="col-12 col-sm-12">
                        <img src="{{ $StoreData['img'] }}" alt="Foto Pegawai"
                            class="rounded mx-auto d-block img-thumbnail">
                        <br>
                    </div>
                @endif
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
                            <option value="Khusus" @if ($StoreData['tipe'] == 'Dapro') selected @endif>Dapur Produksi
                            </option>
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
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                        $(element).removeClass('is-valid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    success: function(validClass, element) {
                        $(element).addClass('is-valid');
                    },
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
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                        $(element).removeClass('is-valid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    success: function(validClass, element) {
                        $(element).addClass('is-valid');
                    },
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
@endisset


@isset($SupplierData)
    <form id="SupplierEdit" action="{{ url('/Master/Supplier/SupplierEdit') }}">
        @csrf
        <div class="modal-body">
            <div class="row">


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nama">Nama Supplier</label>
                        <input type="text" class="form-control" value="{{ $SupplierData['nama'] }}" id="nama"
                            placeholder="Nama Supplier" name="nama">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" value="{{ $SupplierData['alamat'] }}" id="alamat"
                            placeholder="Alamat" name="alamat">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Pembayaran</label>
                        <select name="hutang" id="hutang" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="1" @if ($SupplierData['hutang'] == 1) selected @endif>Hutang</option>
                            <option value="0" @if ($SupplierData['hutang'] == 0) selected @endif>Dimuka</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Tipe Pembayaran</label>
                        <select name="tipe" id="tipe" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Tunai" @if ($SupplierData['tipe'] == 'Tunai') selected @endif>Tunai</option>
                            <option value="Tranfer" @if ($SupplierData['tipe'] == 'Tranfer') selected @endif>Tranfer</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="rekening">No Rekening</label>
                        <input type="number" class="form-control" value="{{ $SupplierData['rekening'] }}"
                            id="rekening" placeholder="No Rekening" name="rekening">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="wa">No Whatsapp</label>
                        <input type="number" class="form-control" id="wa" value="{{ $SupplierData['wa'] }}"
                            placeholder="No Wa" name="wa">
                    </div>
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
            var id = $("#SupplierEdit");

            if (id.length) {
                id.validate({
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                        $(element).removeClass('is-valid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    success: function(validClass, element) {
                        $(element).addClass('is-valid');
                    },
                    rules: {
                        'nama': {
                            required: true
                        },
                        'alamat': {
                            required: true
                        }
                    },
                    messages: {
                        // OutletUsers : "Masih Kosong"
                    }
                });

                id.on("submit", function(event) {
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
                                    id[0].reset();
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

@isset($BahanData)
    <form id="BahanEdit" action="{{ url('/Master/Bahan/BahanEdit') }}">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" id="kategori" onchange="clickkategoriedit(this.value)"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="1" @if ($BahanData['kategori'] == 1) selected @endif>Bahan Baku Segar</option>
                            <option value="2" @if ($BahanData['kategori'] == 2) selected @endif>Bahan Baku Beku</option>
                            <option value="3" @if ($BahanData['kategori'] == 3) selected @endif>Bahan Baku Dalam Kemasan
                            </option>
                            <option value="4" @if ($BahanData['kategori'] == 4) selected @endif>Bahan Baku Dingin</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nama">Nama Bahan</label>
                        <input type="text" class="form-control" value="{{ $BahanData['nama'] }}" id="nama"
                            placeholder="Nama Bahan" name="nama">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Satuan Pembelian</label>
                        <select name="satuan_pembelian" onchange="pembelianedit(this.value)" id="satuan_pembelian"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Kilogram" @if ($BahanData['satuan_pembelian'] == 'Kilogram') selected @endif>Kilogram</option>
                            <option value="Gram" @if ($BahanData['satuan_pembelian'] == 'Gram') selected @endif>Gram</option>
                            <option value="Ons" @if ($BahanData['satuan_pembelian'] == 'Ons') selected @endif>Ons</option>
                            <option value="Pack" @if ($BahanData['satuan_pembelian'] == 'Pack') selected @endif>Pack</option>
                            <option value="Pieces" @if ($BahanData['satuan_pembelian'] == 'Pieces') selected @endif>Pieces</option>
                            <option value="Butir" @if ($BahanData['satuan_pembelian'] == 'Butir') selected @endif>Butir</option>
                            <option value="Potong" @if ($BahanData['satuan_pembelian'] == 'Potong') selected @endif>Potong</option>
                            <option value="Liter" @if ($BahanData['satuan_pembelian'] == 'Liter') selected @endif>Liter</option>
                            <option value="Mililiter" @if ($BahanData['satuan_pembelian'] == 'Mililiter') selected @endif>Mililiter</option>
                            <option value="Galon" @if ($BahanData['satuan_pembelian'] == 'Galon') selected @endif>Galon</option>
                            <option value="Pouch" @if ($BahanData['satuan_pembelian'] == 'Pouch') selected @endif>Pouch</option>
                            <option value="Lembar" @if ($BahanData['satuan_pembelian'] == 'Lembar') selected @endif>Lembar</option>
                            <option value="Roll" @if ($BahanData['satuan_pembelian'] == 'Roll') selected @endif>Roll</option>
                            <option value="Ikat" @if ($BahanData['satuan_pembelian'] == 'Ikat') selected @endif>Ikat</option>
                            <option value="Bal" @if ($BahanData['satuan_pembelian'] == 'Bal') selected @endif>Bal</option>
                            <option value="Karung" @if ($BahanData['satuan_pembelian'] == 'Karung') selected @endif>Karung</option>
                            <option value="Kaleng" @if ($BahanData['satuan_pembelian'] == 'Kaleng') selected @endif>Kaleng</option>
                            <option value="Dus" @if ($BahanData['satuan_pembelian'] == 'Dus') selected @endif>Dus</option>
                            <option value="Botol" @if ($BahanData['satuan_pembelian'] == 'Botol') selected @endif>Botol</option>
                            <option value="Jerigen" @if ($BahanData['satuan_pembelian'] == 'Jerigen') selected @endif>Jerigen</option>
                            <option value="Tabung" @if ($BahanData['satuan_pembelian'] == 'Tabung') selected @endif>Tabung</option>
                            <option value="Ekor" @if ($BahanData['satuan_pembelian'] == 'Papan') selected @endif>Papan</option>
                            <option value="Bungkus" @if ($BahanData['satuan_pembelian'] == 'Bungkus') selected @endif>Bungkus</option>
                            <option value="Ember" @if ($BahanData['satuan_pembelian'] == 'Ember') selected @endif>Ember</option>
                            <option value="Toples" @if ($BahanData['satuan_pembelian'] == 'Toples') selected @endif>Toples</option>
                            <option value="Shot" @if ($BahanData['satuan_pembelian'] == 'Shot') selected @endif>Shot</option>
                            <option value="Cup" @if ($BahanData['satuan_pembelian'] == 'Cup') selected @endif>Cup</option>
                            <option value="Batang" @if ($BahanData['satuan_pembelian'] == 'Batang') selected @endif>Batang</option>
                            <option value="Tusuk" @if ($BahanData['satuan_pembelian'] == 'Tusuk') selected @endif>Tusuk</option>
                            <option value="Porsi" @if ($BahanData['satuan_pembelian'] == 'Porsi') selected @endif>Porsi</option>
                            <option value="Centimeter" @if ($BahanData['satuan_pembelian'] == 'Centimeter') selected @endif>Centimeter
                            </option>
                            <option value="Meter" @if ($BahanData['satuan_pembelian'] == 'Meter') selected @endif>Meter</option>
                            <option value="Slop" @if ($BahanData['satuan_pembelian'] == 'Slop') selected @endif>Slop</option>
                            <option value="Loaf" @if ($BahanData['satuan_pembelian'] == 'Loaf') selected @endif>Loaf</option>
                            <option value="Pasang" @if ($BahanData['satuan_pembelian'] == 'Pasang') selected @endif>Pasang</option>
                            <option value="Slice" @if ($BahanData['satuan_pembelian'] == 'Slice') selected @endif>Slice</option>
                            <option value="Sendok Teh" @if ($BahanData['satuan_pembelian'] == 'Sendok Teh') selected @endif>Sendok Teh
                            </option>
                            <option value="Sendok Makan" @if ($BahanData['satuan_pembelian'] == 'Sendok Makan') selected @endif>Sendok Makan
                            </option>
                        </select>
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="hargaa">Harga</label>
                        <input type="text" value="{{ $BahanData['harga'] }}" class="form-control" id="hargaa"
                            placeholder="Harga" name="hargaa">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Satuan Pemakaian</label>
                        <select name="satuan_pemakaian" onchange="pemakaianedit(this.value)" id="satuan_pemakaian"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">

                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Kilogram" @if ($BahanData['satuan_pemakaian'] == 'Kilogram') selected @endif>Kilogram</option>
                            <option value="Gram" @if ($BahanData['satuan_pemakaian'] == 'Gram') selected @endif>Gram</option>
                            <option value="Ons" @if ($BahanData['satuan_pemakaian'] == 'Ons') selected @endif>Ons</option>
                            <option value="Pack" @if ($BahanData['satuan_pemakaian'] == 'Pack') selected @endif>Pack</option>
                            <option value="Pieces" @if ($BahanData['satuan_pemakaian'] == 'Pieces') selected @endif>Pieces</option>
                            <option value="Butir" @if ($BahanData['satuan_pemakaian'] == 'Butir') selected @endif>Butir</option>
                            <option value="Potong" @if ($BahanData['satuan_pemakaian'] == 'Potong') selected @endif>Potong</option>
                            <option value="Liter" @if ($BahanData['satuan_pemakaian'] == 'Liter') selected @endif>Liter</option>
                            <option value="Mililiter" @if ($BahanData['satuan_pemakaian'] == 'Mililiter') selected @endif>Mililiter</option>
                            <option value="Galon" @if ($BahanData['satuan_pemakaian'] == 'Galon') selected @endif>Galon</option>
                            <option value="Pouch" @if ($BahanData['satuan_pemakaian'] == 'Pouch') selected @endif>Pouch</option>
                            <option value="Lembar" @if ($BahanData['satuan_pemakaian'] == 'Lembar') selected @endif>Lembar</option>
                            <option value="Roll" @if ($BahanData['satuan_pemakaian'] == 'Roll') selected @endif>Roll</option>
                            <option value="Ikat" @if ($BahanData['satuan_pemakaian'] == 'Ikat') selected @endif>Ikat</option>
                            <option value="Bal" @if ($BahanData['satuan_pemakaian'] == 'Bal') selected @endif>Bal</option>
                            <option value="Karung" @if ($BahanData['satuan_pemakaian'] == 'Karung') selected @endif>Karung</option>
                            <option value="Kaleng" @if ($BahanData['satuan_pemakaian'] == 'Kaleng') selected @endif>Kaleng</option>
                            <option value="Dus" @if ($BahanData['satuan_pemakaian'] == 'Dus') selected @endif>Dus</option>
                            <option value="Botol" @if ($BahanData['satuan_pemakaian'] == 'Botol') selected @endif>Botol</option>
                            <option value="Jerigen" @if ($BahanData['satuan_pemakaian'] == 'Jerigen') selected @endif>Jerigen</option>
                            <option value="Tabung" @if ($BahanData['satuan_pemakaian'] == 'Tabung') selected @endif>Tabung</option>
                            <option value="Ekor" @if ($BahanData['satuan_pemakaian'] == 'Papan') selected @endif>Papan</option>
                            <option value="Bungkus" @if ($BahanData['satuan_pemakaian'] == 'Bungkus') selected @endif>Bungkus</option>
                            <option value="Ember" @if ($BahanData['satuan_pemakaian'] == 'Ember') selected @endif>Ember</option>
                            <option value="Toples" @if ($BahanData['satuan_pemakaian'] == 'Toples') selected @endif>Toples</option>
                            <option value="Shot" @if ($BahanData['satuan_pemakaian'] == 'Shot') selected @endif>Shot</option>
                            <option value="Cup" @if ($BahanData['satuan_pemakaian'] == 'Cup') selected @endif>Cup</option>
                            <option value="Batang" @if ($BahanData['satuan_pemakaian'] == 'Batang') selected @endif>Batang</option>
                            <option value="Tusuk" @if ($BahanData['satuan_pemakaian'] == 'Tusuk') selected @endif>Tusuk</option>
                            <option value="Porsi" @if ($BahanData['satuan_pemakaian'] == 'Porsi') selected @endif>Porsi</option>
                            <option value="Centimeter" @if ($BahanData['satuan_pemakaian'] == 'Centimeter') selected @endif>Centimeter
                            </option>
                            <option value="Meter" @if ($BahanData['satuan_pemakaian'] == 'Meter') selected @endif>Meter</option>
                            <option value="Slop" @if ($BahanData['satuan_pemakaian'] == 'Slop') selected @endif>Slop</option>
                            <option value="Loaf" @if ($BahanData['satuan_pemakaian'] == 'Loaf') selected @endif>Loaf</option>
                            <option value="Pasang" @if ($BahanData['satuan_pemakaian'] == 'Pasang') selected @endif>Pasang</option>
                            <option value="Slice" @if ($BahanData['satuan_pemakaian'] == 'Slice') selected @endif>Slice</option>
                            <option value="Sendok Teh" @if ($BahanData['satuan_pemakaian'] == 'Sendok Teh') selected @endif>Sendok Teh
                            </option>
                            <option value="Sendok Makan" @if ($BahanData['satuan_pemakaian'] == 'Sendok Makan') selected @endif>Sendok Makan
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Konversi Satuan Pemakaian</label>
                        <div class="input-group">
                            <div class="input-group-prepend" id="konversid1edit"> <span
                                    class="input-group-text">{{ $BahanData['satuan_pembelian'] }}</span>
                            </div>
                            <input type="text" value="{{ $BahanData['konversi_pemakaian'] }}" name="konversi_pemakaiann"
                                id="konversi_pemakaiann" class="form-control" placeholder="Satuan Pemakaian">
                            <div class="input-group-append" id="konversib1edit"> <span
                                    class="input-group-text">{{ $BahanData['satuan_pemakaian'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Satuan Pengeluaran</label>
                        <select name="satuan_pengeluaran" onchange="pengeluaranedit(this.value)" id="satuan_pengeluaran"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">

                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Kilogram" @if ($BahanData['satuan_pengeluaran'] == 'Kilogram') selected @endif>Kilogram</option>
                            <option value="Gram" @if ($BahanData['satuan_pengeluaran'] == 'Gram') selected @endif>Gram</option>
                            <option value="Ons" @if ($BahanData['satuan_pengeluaran'] == 'Ons') selected @endif>Ons</option>
                            <option value="Pack" @if ($BahanData['satuan_pengeluaran'] == 'Pack') selected @endif>Pack</option>
                            <option value="Pieces" @if ($BahanData['satuan_pengeluaran'] == 'Pieces') selected @endif>Pieces</option>
                            <option value="Butir" @if ($BahanData['satuan_pengeluaran'] == 'Butir') selected @endif>Butir</option>
                            <option value="Potong" @if ($BahanData['satuan_pengeluaran'] == 'Potong') selected @endif>Potong</option>
                            <option value="Liter" @if ($BahanData['satuan_pengeluaran'] == 'Liter') selected @endif>Liter</option>
                            <option value="Mililiter" @if ($BahanData['satuan_pengeluaran'] == 'Mililiter') selected @endif>Mililiter
                            </option>
                            <option value="Galon" @if ($BahanData['satuan_pengeluaran'] == 'Galon') selected @endif>Galon</option>
                            <option value="Pouch" @if ($BahanData['satuan_pengeluaran'] == 'Pouch') selected @endif>Pouch</option>
                            <option value="Lembar" @if ($BahanData['satuan_pengeluaran'] == 'Lembar') selected @endif>Lembar</option>
                            <option value="Roll" @if ($BahanData['satuan_pengeluaran'] == 'Roll') selected @endif>Roll</option>
                            <option value="Ikat" @if ($BahanData['satuan_pengeluaran'] == 'Ikat') selected @endif>Ikat</option>
                            <option value="Bal" @if ($BahanData['satuan_pengeluaran'] == 'Bal') selected @endif>Bal</option>
                            <option value="Karung" @if ($BahanData['satuan_pengeluaran'] == 'Karung') selected @endif>Karung</option>
                            <option value="Kaleng" @if ($BahanData['satuan_pengeluaran'] == 'Kaleng') selected @endif>Kaleng</option>
                            <option value="Dus" @if ($BahanData['satuan_pengeluaran'] == 'Dus') selected @endif>Dus</option>
                            <option value="Botol" @if ($BahanData['satuan_pengeluaran'] == 'Botol') selected @endif>Botol</option>
                            <option value="Jerigen" @if ($BahanData['satuan_pengeluaran'] == 'Jerigen') selected @endif>Jerigen</option>
                            <option value="Tabung" @if ($BahanData['satuan_pengeluaran'] == 'Tabung') selected @endif>Tabung</option>
                            <option value="Ekor" @if ($BahanData['satuan_pengeluaran'] == 'Papan') selected @endif>Papan</option>
                            <option value="Bungkus" @if ($BahanData['satuan_pengeluaran'] == 'Bungkus') selected @endif>Bungkus</option>
                            <option value="Ember" @if ($BahanData['satuan_pengeluaran'] == 'Ember') selected @endif>Ember</option>
                            <option value="Toples" @if ($BahanData['satuan_pengeluaran'] == 'Toples') selected @endif>Toples</option>
                            <option value="Shot" @if ($BahanData['satuan_pengeluaran'] == 'Shot') selected @endif>Shot</option>
                            <option value="Cup" @if ($BahanData['satuan_pengeluaran'] == 'Cup') selected @endif>Cup</option>
                            <option value="Batang" @if ($BahanData['satuan_pengeluaran'] == 'Batang') selected @endif>Batang</option>
                            <option value="Tusuk" @if ($BahanData['satuan_pengeluaran'] == 'Tusuk') selected @endif>Tusuk</option>
                            <option value="Porsi" @if ($BahanData['satuan_pengeluaran'] == 'Porsi') selected @endif>Porsi</option>
                            <option value="Centimeter" @if ($BahanData['satuan_pengeluaran'] == 'Centimeter') selected @endif>Centimeter
                            </option>
                            <option value="Meter" @if ($BahanData['satuan_pengeluaran'] == 'Meter') selected @endif>Meter</option>
                            <option value="Slop" @if ($BahanData['satuan_pengeluaran'] == 'Slop') selected @endif>Slop</option>
                            <option value="Loaf" @if ($BahanData['satuan_pengeluaran'] == 'Loaf') selected @endif>Loaf</option>
                            <option value="Pasang" @if ($BahanData['satuan_pengeluaran'] == 'Pasang') selected @endif>Pasang</option>
                            <option value="Slice" @if ($BahanData['satuan_pengeluaran'] == 'Slice') selected @endif>Slice</option>
                            <option value="Sendok Teh" @if ($BahanData['satuan_pengeluaran'] == 'Sendok Teh') selected @endif>Sendok Teh
                            </option>
                            <option value="Sendok Makan" @if ($BahanData['satuan_pengeluaran'] == 'Sendok Makan') selected @endif>Sendok Makan
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Konversi Satuan Pengeluaran</label>
                        <div class="input-group">
                            <div class="input-group-prepend" id="konversid2edit"><span
                                    class="input-group-text">{{ $BahanData['satuan_pembelian'] }}</span>
                            </div>
                            <input type="text" value="{{ $BahanData['konversi_pengeluaran'] }}"
                                name="konversi_pengeluarann" id="konversi_pengeluarann" class="form-control"
                                placeholder="Satuan Pengeluaran">
                            <div class="input-group-append" id="konversib2edit"><span
                                    class="input-group-text">{{ $BahanData['satuan_pengeluaran'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="kodeedit">Kode Product</label>
                        <input type="text" disabled class="form-control" value="{{ $BahanData['kode'] }}"
                            id="kodeedit" name="kodeedit">
                    </div>
                </div>



                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Penggunaan Ke</label>
                        <select class="select2" multiple="multiple" name="pengguna[]" id="pengguna"
                            data-placeholder="Pilih Outlet" style="width: 100%;">
                            @foreach ($Store as $v)
                                <option value="{{ $v['id'] }}" @if (in_array($v['id'], json_decode($BahanData['pengguna']))) selected @endif>
                                    {{ $v['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <script>
        $(function() {
            $('.select2').select2().on("change", function(e) {
                $(this).valid()
            });
        });
        $(document).ready(function() {
            var id = $("#BahanEdit");

            if (id.length) {
                id.validate({
                    rules: {
                        'nama': {
                            required: true
                        },
                        'kategori': {
                            required: true
                        },
                        'satuan_pembelian': {
                            required: true
                        },
                        'hargaa': {
                            required: true
                        },
                        'satuan_pemakaian': {
                            required: true
                        },
                        'konversi_pemakaiann': {
                            required: true
                        },
                        'satuan_pengeluaran': {
                            required: true
                        },
                        'konversi_pengeluarann': {
                            required: true
                        }
                    },
                    messages: {
                        // OutletUsers : "Masih Kosong"
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                        $(element).removeClass('is-valid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    success: function(validClass, element) {
                        $(element).addClass('is-valid');
                    }
                });

                id.on("submit", function(event) {
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
                                    id[0].reset();
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

        function clickkategoriedit(val) {
            if (val == 1) {
                $('#kodeedit').val('BBS{{ $kode }}');
            } else if (val == 2) {
                $('#kodeedit').val('BBB{{ $kode }}');
            } else if (val == 3) {
                $('#kodeedit').val('BBK{{ $kode }}');
            } else if (val == 4) {
                $('#kodeedit').val('BBD{{ $kode }}');
            } else {
                $('#kodeedit').val('Gagal, Refresh Halaman');
            }
        }

        //Format Penulisan
        document.getElementById("hargaa").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });
        document.getElementById("konversi_pemakaiann").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });
        document.getElementById("konversi_pengeluarann").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });
    </script>
@endisset

@isset($PeralatanData)
    <form id="PeralatanEdit" action="{{ url('/Master/Peralatan/PeralatanEdit') }}">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" id="kategori" onchange="clickkategoriedit(this.value)"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="1" @if ($PeralatanData['kategori'] == 1) selected @endif>Peralatan Dapur</option>
                            <option value="2" @if ($PeralatanData['kategori'] == 2) selected @endif>Peralatan Kasir</option>
                            <option value="3" @if ($PeralatanData['kategori'] == 3) selected @endif>Peralatan Bar</option>
                            <option value="4" @if ($PeralatanData['kategori'] == 4) selected @endif>Peralatan Waiter
                            </option>
                            <option value="5" @if ($PeralatanData['kategori'] == 5) selected @endif>Peralatan Lainnya
                            </option>

                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nama">Nama Peralatan</label>
                        <input type="text" class="form-control" value="{{ $PeralatanData['nama'] }}" id="nama"
                            placeholder="Nama Peralatan" name="nama">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Satuan Pembelian</label>
                        <select name="satuan_pembelian" onchange="pembelianedit(this.value)" id="satuan_pembelian"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Buah" @if ($PeralatanData['satuan_pembelian'] == 'Buah') selected @endif>Buah</option>
                            <option value="Tabung" @if ($PeralatanData['satuan_pembelian'] == 'Tabung') selected @endif>Tabung</option>
                            <option value="Pack" @if ($PeralatanData['satuan_pembelian'] == 'Pack') selected @endif>Pack</option>
                            <option value="Helai" @if ($PeralatanData['satuan_pembelian'] == 'Helai') selected @endif>Helai</option>
                        </select>
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="hargaa">Harga</label>
                        <input type="text" value="{{ $PeralatanData['harga'] }}" class="form-control" id="hargaa"
                            placeholder="Harga" name="hargaa">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Satuan Pemakaian</label>
                        <select name="satuan_pemakaian" onchange="pemakaianedit(this.value)" id="satuan_pemakaian"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">

                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Buah" @if ($PeralatanData['satuan_pembelian'] == 'Buah') selected @endif>Buah</option>
                            <option value="Tabung" @if ($PeralatanData['satuan_pembelian'] == 'Tabung') selected @endif>Tabung</option>
                            <option value="Pack" @if ($PeralatanData['satuan_pembelian'] == 'Pack') selected @endif>Pack</option>
                            <option value="Helai" @if ($PeralatanData['satuan_pembelian'] == 'Helai') selected @endif>Helai</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Konversi Satuan Pemakaian</label>
                        <div class="input-group">
                            <div class="input-group-prepend" id="konversid1edit"> <span
                                    class="input-group-text">{{ $PeralatanData['satuan_pembelian'] }}</span>
                            </div>
                            <input type="text" value="{{ $PeralatanData['konversi_pemakaian'] }}"
                                name="konversi_pemakaiann" id="konversi_pemakaiann" class="form-control"
                                placeholder="Satuan Pemakaian">
                            <div class="input-group-append" id="konversib1edit"> <span
                                    class="input-group-text">{{ $PeralatanData['satuan_pemakaian'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="kodeedit">Kode Product</label>
                        <input type="text" disabled class="form-control" value="{{ $PeralatanData['kode'] }}"
                            id="kodeedit" name="kodeedit">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Penggunaan Ke</label>
                        <select class="select2" multiple="multiple" name="pengguna[]" id="pengguna"
                            data-placeholder="Pilih Outlet" style="width: 100%;">
                            @foreach ($Store as $v)
                                <option value="{{ $v['id'] }}" @if (in_array($v['id'], json_decode($PeralatanData['pengguna']))) selected @endif>
                                    {{ $v['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <script>
        $(function() {
            $('.select2').select2().on("change", function(e) {
                $(this).valid()
            });
        });
        $(document).ready(function() {
            var id = $("#PeralatanEdit");

            if (id.length) {
                id.validate({
                    rules: {
                        'nama': {
                            required: true
                        },
                        'kategori': {
                            required: true
                        },
                        'satuan_pembelian': {
                            required: true
                        },
                        'hargaa': {
                            required: true
                        },
                        'satuan_pemakaian': {
                            required: true
                        },
                        'konversi_pemakaiann': {
                            required: true
                        }
                    },
                    messages: {
                        // OutletUsers : "Masih Kosong"
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                        $(element).removeClass('is-valid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    success: function(validClass, element) {
                        $(element).addClass('is-valid');
                    }
                });

                id.on("submit", function(event) {
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
                                    id[0].reset();
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

        function clickkategoriedit(val) {
            if (val == 1) {
                $('#kodeedit').val('PD{{ $kode }}');
            } else if (val == 2) {
                $('#kodeedit').val('PK{{ $kode }}');
            } else if (val == 3) {
                $('#kodeedit').val('PB{{ $kode }}');
            } else if (val == 4) {
                $('#kodeedit').val('PW{{ $kode }}');
            } else if (val == 5) {
                $('#kodeedit').val('PL{{ $kode }}');
            } else {
                $('#kodeedit').val('Gagal, Refresh Halaman');
            }
        }

        //Format Penulisan
        document.getElementById("hargaa").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });
        document.getElementById("konversi_pemakaiann").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });
    </script>
@endisset


@isset($PegawaiData)
    <form id="PegawaiEdit" action="{{ url('/Master/Pegawai/PegawaiEdit') }}">
        @csrf
        <div class="modal-body">
            <div class="row">

                @if ($PegawaiData['img'])
                    <div class="col-12 col-sm-12">
                        <img src="{{ $PegawaiData['img'] }}" alt="Foto Pegawai"
                            class="rounded mx-auto d-block img-thumbnail">
                        <br>
                    </div>
                @endif
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Store</label>
                        <select name="store" id="store" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            @foreach ($Datastore as $v)
                                @if ($v['id'] != 1)
                                    <option value="{{ $v['id'] }}"
                                        @if ($PegawaiData['store_id'] == $v['id']) selected @endif>
                                        {{ $v['nama'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nama">Nama Pegawai</label>
                        <input type="text" value="{{ $PegawaiData['nama'] }}" class="form-control" id="nama"
                            placeholder="Nama Pegawai" name="nama">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" value="{{ $PegawaiData['tempat_lahir'] }}" class="form-control"
                            id="tempat_lahir" placeholder="Tempat Lahir" name="tempat_lahir">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" value="{{ $PegawaiData['tanggal_lahir'] }}" class="form-control"
                                id="tanggal_lahir" name="tanggal_lahir" data-inputmask-alias="datetime"
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
                            <input type="date" value="{{ $PegawaiData['tanggal_masuk'] }}" class="form-control"
                                id="tanggal_masuk" name="tanggal_masuk" data-inputmask-alias="datetime"
                                data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <select name="agama" id="agama" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Islam" @if ($PegawaiData['agama'] == 'Islam') selected @endif>Islam</option>
                            <option value="Kristen" @if ($PegawaiData['agama'] == 'Kristen') selected @endif>Kristen</option>
                            <option value="Katholik" @if ($PegawaiData['agama'] == 'Katholik') selected @endif>Katholik</option>
                            <option value="Budha" @if ($PegawaiData['agama'] == 'Budha') selected @endif>Budha</option>
                            <option value="Hindu" @if ($PegawaiData['agama'] == 'Hindu') selected @endif>Hindu</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Pria" @if ($PegawaiData['gender'] == 'Pria') selected @endif>Pria</option>
                            <option value="Wanita" @if ($PegawaiData['gender'] == 'Wanita') selected @endif>Wanita</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" value="{{ $PegawaiData['alamat'] }}" class="form-control" id="alamat"
                            placeholder="Alamat" name="alamat">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="wa">No Whatsapp</label>
                        <input type="number" value="{{ $PegawaiData['wa'] }}" class="form-control" id="wa"
                            placeholder="No Whatsapp" name="wa">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="divisi">Divisi</label>
                        <select name="divisi" id="divisi" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Accounting" @if ($PegawaiData['divisi'] == 'Accounting') selected @endif>Accounting
                            </option>
                            <option value="Enginering" @if ($PegawaiData['divisi'] == 'Enginering') selected @endif>Enginering
                            </option>
                            <option value="Marketing" @if ($PegawaiData['divisi'] == 'Marketing') selected @endif>Marketing
                            </option>
                            <option value="HR & GA" @if ($PegawaiData['divisi'] == 'HR & GA') selected @endif>HR & GA</option>
                            <option value="Logistik" @if ($PegawaiData['divisi'] == 'Logistik') selected @endif>Logistik</option>
                            <option value="Dapro" @if ($PegawaiData['divisi'] == 'Dapro') selected @endif>Dapur Produksi
                            </option>
                            <option value="Chief Leader" @if ($PegawaiData['divisi'] == 'Chief Leader') selected @endif>Chief Leader
                            </option>
                            <option value="Kitchen" @if ($PegawaiData['divisi'] == 'Bar') selected @endif>Kitchen</option>
                            <option value="Bar" @if ($PegawaiData['divisi'] == '') selected @endif>Bar</option>
                            <option value="Service Crew" @if ($PegawaiData['divisi'] == 'Service Crew') selected @endif>Service Crew
                            </option>
                            <option value="Akustik" @if ($PegawaiData['divisi'] == 'Akustik') selected @endif>Akustik</option>
                            <option value="Parkir" @if ($PegawaiData['divisi'] == 'Parkir') selected @endif>Akustik</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="Supervisor" @if ($PegawaiData['jabatan'] == 'Supervisor') selected @endif>Supervisor
                            </option>
                            <option value="Manager" @if ($PegawaiData['jabatan'] == 'Manager') selected @endif>Manager</option>
                            <option value="Leader" @if ($PegawaiData['jabatan'] == 'Leader') selected @endif>Leader</option>
                            <option value="Staf" @if ($PegawaiData['jabatan'] == 'Staf') selected @endif>Staf</option>
                            <option value="Freelance" @if ($PegawaiData['jabatan'] == 'Freelance') selected @endif>Freelance
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="status_pekerja">Status Pekerja</label>
                        <select name="status_pekerja" id="status_pekerja" class="form-control select2 select2-success"
                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="1" @if ($PegawaiData['active'] == 1) selected @endif>Active</option>
                            <option value="0" @if ($PegawaiData['active'] == 0) selected @endif>Resign</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="img">Foto</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" accept="image/*" id="img" name="img">
                            <label class="custom-file-label" for="img">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <script>
        $(function() {
            $('.select2').select2().on("change", function(e) {
                $(this).valid()
            });
            bsCustomFileInput.init();
        });
        $(document).ready(function() {
            var id = $("#PegawaiEdit");

            if (id.length) {
                id.validate({
                    rules: {
                        'nama': {
                            required: true
                        },
                        'store': {
                            required: true
                        },
                        'tempat_lahir': {
                            required: true
                        },
                        'tanggal_lahir': {
                            required: true
                        },
                        'tanggal_masuk': {
                            required: true
                        },
                        'agama': {
                            required: true
                        },
                        'gender': {
                            required: true
                        },
                        'alamat': {
                            required: true
                        },
                        'wa': {
                            required: true
                        },
                        'divisi': {
                            required: true
                        },
                        'jabatan': {
                            required: true
                        },
                        'status_pekerja': {
                            required: true
                        }
                    },
                    messages: {
                        // OutletUsers : "Masih Kosong"
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                        $(element).removeClass('is-valid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    success: function(validClass, element) {
                        $(element).addClass('is-valid');
                    }
                });

                id.on("submit", function(event) {
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
                                    id[0].reset();
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


@isset($OlahanDataBahanBaku)
    <form id="formItemBahanBaku" action="{{ url('Foodcost/Olahan/TambahItemBahanBaku') }}">
        @csrf
        <div class="modal-body">
            <table id="pilihbahanolahan" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="check" id="checkAll"></th>
                        <th>Kode Bahan</th>
                        <th>Nama Bahan</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($OlahanDataBahanBaku as $v)
                        @if (!in_array($v['id'], $cekid))
                            <tr>
                                <td><input type="checkbox" name="id[]" value="{{ $v['id'] }}" class="check">
                                </td>
                                <td>{{ $v['kode'] }}</td>
                                <td>{{ $v['nama'] }}</td>
                                <td>
                                    @if ($v['kategori'] == 1)
                                        Bahan Baku Segar
                                    @endif
                                    @if ($v['kategori'] == 2)
                                        Bahan Baku Beku
                                    @endif
                                    @if ($v['kategori'] == 3)
                                        Bahan Baku Dalam Kemasan
                                    @endif
                                    @if ($v['kategori'] == 4)
                                        Bahan Baku Dingin
                                    @endif
                                </td>
                                <td>{{ $v['harga'] . '/' . $v['satuan_pembelian'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-block">Tambah</button>
        </div>
        </div>
    </form>
    <script>
        //DataTable
        $("#checkAll").click(function() {
            $(".check").prop('checked', $(this).prop('checked'));
        });

        if ($("#pilihbahanolahan").length) {
            $("#pilihbahanolahan").DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [2, "asc"]
                ],
                "responsive": true,
                "autoWidth": false,
                "processing": true,
                "searching": true,
                "sort": true,
                "paging": true,
                'info': true,
                "destroy": true
            });
        }


        $('#ModalLabel').html('Pilih Item Bahan Baku');
        $(document).ready(function() {
            if ($('#formItemBahanBaku').length) {
                $('#formItemBahanBaku').validate({
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    success: function(validClass, element) {
                        $(element).addClass('is-valid');
                    },
                    rules: {
                        'id[]': {
                            required: true
                        }
                    },
                    messages: {
                        // id : "pesan"
                    }
                });

                $('#formItemBahanBaku').on('submit', function(event) {
                    var isValid = $(this).valid();
                    event.preventDefault();
                    var formData = new FormData(this);

                    if (isValid) {
                        $.ajax({
                            url: $(this).attr('action'),
                            type: "POST",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            error: function(xhr, status, error) {
                                popup(status, true, xhr.status + " " + error);
                            },
                            success: function(data) {
                                if (data.status === 'success') {
                                    $('#Modal').modal('hide');
                                    $('#managebahanbaku').DataTable().ajax.reload();
                                    popup(data.status, data.toast, data.pesan);
                                } else {
                                    popup(data.status, data.toast, data.pesan);
                                }
                            }
                        });

                    } else {
                        popup('error', true, 'Belum Memilih Bahan');
                    }
                });
            }
        });
    </script>
@endisset



@isset($OlahanDataBahanOlahan)
    <form id="formItemBahanOlahan" action="{{ url('Foodcost/Olahan/TambahItemBahanOlahan') }}">
        @csrf
        <div class="modal-body">
            <table id="pilihbahanolahan" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="check" id="checkAll"></th>
                        <th>Kode Bahan</th>
                        <th>Nama Olahan</th>
                        <th>Hasil Jadi</th>
                        <th>Biaya Produksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($OlahanDataBahanOlahan as $v)
                        @if (!in_array($v['id'], $cekid) && session('IdEdit') != $v['id'])
                            <tr>
                                <td><input type="checkbox" name="id[]" value="{{ $v['id'] }}" class="check">
                                </td>
                                <td>{{ $v['kode'] }}</td>
                                <td>{{ $v['nama'] }}</td>
                                <td>
                                    @if ($v['kategori'] == 1)
                                        Bahan Baku Segar
                                    @endif
                                    @if ($v['kategori'] == 2)
                                        Bahan Baku Beku
                                    @endif
                                    @if ($v['kategori'] == 3)
                                        Bahan Baku Dalam Kemasan
                                    @endif
                                    @if ($v['kategori'] == 4)
                                        Bahan Baku Dingin
                                    @endif
                                </td>
                                <td>{{ $v['harga'] . '/' . $v['satuan_pembelian'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-block">Tambah</button>
        </div>
        </div>
    </form>
    <script>
        //DataTable
        $("#checkAll").click(function() {
            $(".check").prop('checked', $(this).prop('checked'));
        });

        if ($("#pilihbahanolahan").length) {
            $("#pilihbahanolahan").DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [2, "asc"]
                ],
                "responsive": true,
                "autoWidth": false,
                "processing": true,
                "searching": true,
                "sort": true,
                "paging": true,
                'info': true,
                "destroy": true
            });
        }


        $('#ModalLabel').html('Pilih Item Bahan Olahan');

        $(document).ready(function() {
            if ($('#formItemBahanOlahan').length) {
                $('#formItemBahanOlahan').validate({
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    success: function(validClass, element) {
                        $(element).addClass('is-valid');
                    },
                    rules: {
                        'id[]': {
                            required: true
                        }
                    },
                    messages: {
                        // id : "pesan"
                    }
                });

                $('#formItemBahanOlahan').on('submit', function(event) {
                    var isValid = $(this).valid();
                    event.preventDefault();
                    var formData = new FormData(this);

                    if (isValid) {
                        $.ajax({
                            url: $(this).attr('action'),
                            type: "POST",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            error: function(xhr, status, error) {
                                popup(status, true, xhr.status + " " + error);
                            },
                            success: function(data) {
                                if (data.status === 'success') {
                                    $('#Modal').modal('hide');
                                    $('#managebahanolahan').DataTable().ajax.reload();
                                    popup(data.status, data.toast, data.pesan);
                                } else {
                                    popup(data.status, data.toast, data.pesan);
                                }
                            }
                        });

                    } else {
                        popup('error', true, 'Belum Memilih Bahan');
                    }
                });
            }
        });
    </script>
@endisset
