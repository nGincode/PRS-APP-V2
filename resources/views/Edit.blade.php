@isset($UsersData)
    <form id="UsersEdit" action="{{ url('/Users/TambahEdit') }}">
        <div class="modal-body">
            <div class="row">

                @if ($UsersData['img'])
                    <div class="col-12 col-sm-12">
                        <img src="{{ $UsersData['img'] }}" alt="Foto Pegawai" class="rounded mx-auto d-block img-thumbnail">
                        <br>
                    </div>
                @endif
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Outlet Users</label>
                        <select name="OutletUsers" id="OutletUsers_edit" class="form-control select2 select2-danger"
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
                        <select name="izin" id="izin_edit" class="form-control select2 select2-danger"
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="1" @if ($UsersData['izin'] == 1) selected @endif>Keseluruhan</option>
                            <option value="0" @if ($UsersData['izin'] == 0) selected @endif>Khusus</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="Email_edit">Email</label>
                        <input value="{{ $UsersData['email'] }}" type="email" class="form-control" id="Email_edit"
                            placeholder="Email" name="Email">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="Username_edit">Username</label>
                        <input value="{{ $UsersData['username'] }}" type="text" class="form-control" id="Username"_edit
                            placeholder="Username" name="Username">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="PasswordUsersLama_edit">Password Lama</label>
                        <input type="password" class="form-control" id="PasswordUsersLama_edit" placeholder="Password"
                            name="PasswordUsersLama">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="PasswordUsers_edit">Password Baru</label>
                        <input type="password" class="form-control" id="PasswordUsers_edit" placeholder="Password"
                            name="PasswordUsersEdit">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="PasswordRipet_edit">Password Ulangi</label>
                        <input type="password" class="form-control" id="PasswordRipet_edit" placeholder="Passworrd"
                            name="PasswordRipetEdit">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="NamaDepanUsers_edit">Nama Depan</label>
                        <input value="{{ $UsersData['firstname'] }}" type="text" class="form-control"
                            id="NamaDepanUsers_edit" placeholder="Nama Depan" name="NamaDepanUsers">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="NamaBelakangUsers_edit">Nama Belakang</label>
                        <input value="{{ $UsersData['lastname'] }}" type="text" class="form-control"
                            id="NamaBelakangUsers" placeholder="Nama Belakang" name="NamaBelakangUsers_edit">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="NoUsers_edit">No Whatsapp</label>
                        <input value="{{ $UsersData['phone'] }}" type="number" class="form-control" id="NoUsers_edit"
                            placeholder="No Whatsapp" name="NoUsers">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="img_edit">Image Profil</label>
                        <div class="custom-file">
                            <input type="file" accept="image/*" class="custom-file-input" id="img_edit"
                                name="img">
                            <label class="custom-file-label" for="img">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group clearfix">
                        <label>Gender</label><br>
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="GenderUsersPerempuan_edit" name="gender" value="1"
                                @if ($UsersData['gender'] == 'Wanita') checked @endif>
                            <label for="GenderUsersPerempuanedit"> Perempuan</label>
                        </div>
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="GenderUsersPria_edit" value="2" name="gender"
                                @if ($UsersData['gender'] == 'Pria') checked @endif>
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
                                    popup(data.status, data.toast, data.pesan, "#UsersEdit");
                                    $('#Modal').modal('hide');
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
                        <select name="status" id="status_edit" class="form-control select2 select2-danger" required
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
                        <select name="tipe" id="tipe_edit" class="form-control select2 select2-danger" required
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
                        <label for="nama_edit">Nama Store</label>
                        <input type="text" class="form-control" value="{{ $StoreData['nama'] }}" id="nama_edit"
                            placeholder="Nama Store" name="nama">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="alamat_edit">Alamat</label>
                        <input type="text" class="form-control" value="{{ $StoreData['alamat'] }}" id="alamat_edit"
                            placeholder="alamat" name="alamat">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="wa_edit">No Whatsapp</label>
                        <input type="number" class="form-control" value="{{ $StoreData['wa'] }}" id="wa_edit"
                            placeholder="No Wa" name="wa">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="img_edit">Logo Store</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" accept="image/*" id="img_edit"
                                name="img">
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
                                <label for="nama_shift_edit">Nama Shift</label>
                                <input type="text" class="form-control" value="{{ $v['Nama'] }}"
                                    id="nama_shift_edit" placeholder="Nama Shift" name="nama_shift[]">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="masuk_kerja_edit">Masuk </label>
                                <input type="time" class="form-control" value="{{ $v['Masuk'] }}"
                                    id="masuk_kerja_edit" name="masuk_kerja[]">
                            </div>
                        </div>

                        <div class="col-12 col-sm-6" id='akhir_isi_jam_kerja_edit'>
                            <div class="form-group">
                                <label for="pulang_kerja_edit">Pulang </label>
                                <input type="time" class="form-control" value="{{ $v['Pulang'] }}"
                                    id="pulang_kerja_edit" name="pulang_kerja[]">
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 col-sm-12" id="isi_jam_kerja_edit">
                        <div class="form-group">
                            <label for="nama_shift_edit">Nama Shift</label>
                            <input type="text" class="form-control" id="nama_shift_edit" placeholder="Nama Shift"
                                name="nama_shift[]">
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="masuk_kerja_edit">Masuk </label>
                            <input type="time" class="form-control" id="masuk_kerja_edit" name="masuk_kerja[]">
                        </div>
                    </div>

                    <div class="col-12 col-sm-6" id='akhir_isi_jam_kerja_edit'>
                        <div class="form-group">
                            <label for="pulang_kerja_edit">Pulang </label>
                            <input type="time" class="form-control" id="pulang_kerja_edit" name="pulang_kerja[]">
                        </div>
                    </div>
                @endif

                <a class="col-12 col-sm-12 btn btn-success" id="add_row_jam_kerja_edit"> + Tambah Shift</a>

            </div>
            <!-- /.row -->
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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
                                    popup(data.status, data.toast, data.pesan, "#StoreEdit");
                                    $('#Modal').modal('hide');
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
                <input type="text" class="form-control" id="nama" value="{{ $GroupsData['nama'] }}"
                    name="nama" placeholder="Masukkan Nama Group">
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
                            <td style="border: none;"><b>Akun</b></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; User</td>
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
                            <td>&nbsp;&nbsp; Store</td>
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
                            <td>&nbsp;&nbsp; Group</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createGroup"
                                    @if (in_array('createGroup', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateGroup"
                                    @if (in_array('updateGroup', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewGroup"
                                    @if (in_array('viewGroup', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteGroup"
                                    @if (in_array('deleteGroup', $permission)) checked @endif class="minimal"></td>
                        </tr>

                        <tr>
                            <td style="border: none;"><b>Master Data</b></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; 1.) Supplier</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createSupplier"
                                    @if (in_array('createSupplier', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateSupplier"
                                    @if (in_array('updateSupplier', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewSupplier"
                                    @if (in_array('viewSupplier', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteSupplier"
                                    @if (in_array('deleteSupplier', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; 2.) Satuan</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createSatuan"
                                    @if (in_array('createSatuan', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateSatuan"
                                    @if (in_array('updateSatuan', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewSatuan"
                                    @if (in_array('viewSatuan', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteSatuan"
                                    @if (in_array('deleteSatuan', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; 3.) Bahan</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createBahan"
                                    @if (in_array('createBahan', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateBahan"
                                    @if (in_array('updateBahan', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewBahan"
                                    @if (in_array('viewBahan', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteBahan"
                                    @if (in_array('deleteBahan', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; 4.) Peralatan</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createPeralatan"
                                    @if (in_array('createPeralatan', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updatePeralatan"
                                    @if (in_array('updatePeralatan', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewPeralatan"
                                    @if (in_array('viewPeralatan', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deletePeralatan"
                                    @if (in_array('deletePeralatan', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; 5.) Pegawai</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createPegawai"
                                    @if (in_array('createPegawai', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updatePegawai"
                                    @if (in_array('updatePegawai', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewPegawai"
                                    @if (in_array('viewPegawai', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deletePegawai"
                                    @if (in_array('deletePegawai', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td style="border: none;"><b>Foodcost</b></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; 1.) Bahan Olahan</td>
                            <td><input type="checkbox" name="permission[]" id="permission"
                                    @if (in_array('createFoodcostBahanOlahan', $permission)) checked @endif value="createFoodcostBahanOlahan"
                                    class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission"
                                    @if (in_array('updateFoodcostBahanOlahan', $permission)) checked @endif value="updateFoodcostBahanOlahan"
                                    class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission"
                                    @if (in_array('viewFoodcostBahanOlahan', $permission)) checked @endif value="viewFoodcostBahanOlahan"
                                    class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission"
                                    @if (in_array('deleteFoodcostBahanOlahan', $permission)) checked @endif value="deleteFoodcostBahanOlahan"
                                    class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; 2.) Varian</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createFoodcostVarian"
                                    @if (in_array('createFoodcostVarian', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateFoodcostVarian"
                                    @if (in_array('updateFoodcostVarian', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewFoodcostVarian"
                                    @if (in_array('viewFoodcostVarian', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteFoodcostVarian"
                                    @if (in_array('deleteFoodcostVarian', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; 3.) Resep Menu</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createFoodcostResep"
                                    @if (in_array('createFoodcostResep', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateFoodcostResep"
                                    @if (in_array('updateFoodcostResep', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewFoodcostResep"
                                    @if (in_array('viewFoodcostResep', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteFoodcostResep"
                                    @if (in_array('deleteFoodcostResep', $permission)) checked @endif class="minimal"></td>
                        </tr>

                        <tr>
                            <td style="border: none;"><b>Oprasional</b></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; POS (Point Of Sales)</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createPOS"
                                    @if (in_array('createPOS', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updatePOS"
                                    @if (in_array('updatePOS', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewPOS"
                                    @if (in_array('viewPOS', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deletePOS"
                                    @if (in_array('deletePOS', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; Belanja</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createBelanja"
                                    @if (in_array('createBelanja', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateBelanja"
                                    @if (in_array('updateBelanja', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewBelanja"
                                    @if (in_array('viewBelanja', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteBelanja"
                                    @if (in_array('deleteBelanja', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; Inventory (STOCK)</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createInventoryStock"
                                    @if (in_array('createInventoryStock', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateInventoryStock"
                                    @if (in_array('updateInventoryStock', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewInventoryStock"
                                    @if (in_array('viewInventoryStock', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteInventoryStock"
                                    @if (in_array('deleteInventoryStock', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; Inventory (OPNAME)</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createInventoryOpname"
                                    @if (in_array('createInventoryOpname', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateInventoryOpname"
                                    @if (in_array('updateInventoryOpname', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewInventoryOpname"
                                    @if (in_array('viewInventoryOpname', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteInventoryOpname"
                                    @if (in_array('deleteInventoryOpname', $permission)) checked @endif class="minimal"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp; Order</td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="createOrder"
                                    @if (in_array('createOrder', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="updateOrder"
                                    @if (in_array('updateOrder', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="viewOrder"
                                    @if (in_array('viewOrder', $permission)) checked @endif class="minimal"></td>
                            <td><input type="checkbox" name="permission[]" id="permission" value="deleteOrder"
                                    @if (in_array('deleteOrder', $permission)) checked @endif class="minimal"></td>
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
                                @foreach ($GroupsUsers as $v1) @if ($v1['users_id'] == $v['id']) selected @endif
                                @endforeach>
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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

@isset($SatuanData)
    <form id="SatuanEdit" action="{{ url('/Master/Satuan/SatuanEdit') }}">
        @csrf
        <div class="modal-body">
            <div class="row">


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nama">Nama Satuan</label>
                        <input type="text" style="text-transform:capitalize" class="form-control"
                            value="{{ $SatuanData['nama'] }}" id="nama" placeholder="Kilogram" name="nama">
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="singkat">Singkatan</label>
                        <input type="text" style="text-transform:capitalize" class="form-control"
                            value="{{ $SatuanData['singkat'] }}" id="singkat" placeholder="Kg" name="singkat">
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
        </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            var id = $("#SatuanEdit");

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
                        'singkat': {
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
                        <select disabled name="kategori" id="kategori_edit" onchange="clickkategoriedit(this.value)"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="1" @if ($BahanData['kategori'] == 1) selected @endif>Bahan Baku Segar
                            </option>
                            <option value="2" @if ($BahanData['kategori'] == 2) selected @endif>Bahan Baku Beku
                            </option>
                            <option value="3" @if ($BahanData['kategori'] == 3) selected @endif>Bahan Baku Dalam
                                Kemasan
                            </option>
                            <option value="4" @if ($BahanData['kategori'] == 4) selected @endif>Bahan Baku Dingin
                            </option>
                            <option value="11" @if ($BahanData['kategori'] == 11) selected @endif>Bahan Supplay
                            </option>
                            <option value="21" @if ($BahanData['kategori'] == 21) selected @endif>Bahan Oprasional
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="nama">Nama Bahan</label>
                        <input type="text" class="form-control" value="{{ $BahanData['nama'] }}" id="nama_edit"
                            placeholder="Nama Bahan" name="nama">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Satuan Pembelian</label>
                        <select name="satuan_pembelian" onchange="pembelianedit(this.value)" id="satuan_pembelian_edit"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            @foreach ($satuan as $s1)
                                <option value="{{ $s1['singkat'] }}" @if ($BahanData['satuan_pembelian'] == $s1['singkat']) selected @endif>
                                    {{ $s1['nama'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="hargaa">Harga</label>
                        <input type="text" value="{{ $BahanData['harga'] }}" class="form-control" id="harga_edit"
                            placeholder="Harga" name="harga">
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Satuan Pemakaian</label>
                        <select name="satuan_pemakaian" onchange="pemakaianedit(this.value)" id="satuan_pemakaian_edit"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">

                            <option selected="true" disabled="disabled">Pilih</option>
                            @foreach ($satuan as $s2)
                                <option value="{{ $s2['singkat'] }}" @if ($BahanData['satuan_pemakaian'] == $s2['singkat']) selected @endif>
                                    {{ $s2['nama'] }}
                                </option>
                            @endforeach
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
                            <input type="text" value="{{ $BahanData['konversi_pemakaian'] }}"
                                name="konversi_pemakaian" id="konversi_pemakaian_edit" class="form-control"
                                placeholder="Satuan Pemakaian">
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

                            @foreach ($satuan as $s3)
                                <option value="{{ $s3['singkat'] }}" @if ($BahanData['satuan_pengeluaran'] == $s3['singkat']) selected @endif>
                                    {{ $s3['nama'] }}
                                </option>
                            @endforeach
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
                                name="konversi_pengeluaran" id="konversi_pengeluaran_edit" class="form-control"
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
                            id="kode_edit" name="kodeedit">
                    </div>
                </div>



                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Penggunaan Ke</label>
                        <select class="select2" multiple="multiple" name="pengguna[]" id="pengguna_edit"
                            data-placeholder="Pilih Outlet" style="width: 100%;">
                            @foreach ($Store as $v)
                                <option value="{{ $v['id'] }}"
                                    @if (json_decode($BahanData['pengguna'])) @if (in_array($v['id'], json_decode($BahanData['pengguna']))) selected @endif
                                    @endif>
                                    {{ $v['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            var id = $("#BahanEdit");

            if (id.length) {
                id.validate({
                    rules: {
                        'nama': {
                            required: true
                        },
                        'satuan_pembelian': {
                            required: true
                        },
                        'harga': {
                            required: true
                        },
                        'satuan_pemakaian': {
                            required: true
                        },
                        'konversi_pemakaian': {
                            required: true
                        },
                        'satuan_pengeluaran': {
                            required: true
                        },
                        'konversi_pengeluaran': {
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
        //Format Penulisan
        document.getElementById("harga_edit").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });
        document.getElementById("konversi_pemakaian_edit").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });
        document.getElementById("konversi_pengeluaran_edit").addEventListener("keyup", function(e) {
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
                        <select disabled name="kategori" id="kategori" onchange="clickkategoriedit(this.value)"
                            class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger"
                            style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>
                            <option value="1" @if ($PeralatanData['kategori'] == 1) selected @endif>Peralatan Dapur
                            </option>
                            <option value="2" @if ($PeralatanData['kategori'] == 2) selected @endif>Peralatan Kasir
                            </option>
                            <option value="3" @if ($PeralatanData['kategori'] == 3) selected @endif>Peralatan Bar
                            </option>
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
                        <select name="satuan_pembelian" id="satuan_pembelian" class="form-control select2 select2-danger"
                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>

                            @foreach ($satuan as $s1)
                                <option value="{{ $s1['singkat'] }}" @if ($PeralatanData['satuan_pembelian'] == $s1['singkat']) selected @endif>
                                    {{ $s1['nama'] }}
                                </option>
                            @endforeach
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

                            @foreach ($satuan as $s2)
                                <option value="{{ $s2['singkat'] }}" @if ($PeralatanData['satuan_pemakaian'] == $s2['singkat']) selected @endif>
                                    {{ $s2['nama'] }}
                                </option>
                            @endforeach
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
                        <select class="select2" multiple="multiple" name="pengguna[]" id="pengguna_edit"
                            data-placeholder="Pilih Outlet" style="width: 100%;">
                            @foreach ($Store as $v)
                                <option value="{{ $v['id'] }}"
                                    @if ($PeralatanData['pengguna']) @if (in_array($v['id'], json_decode($PeralatanData['pengguna']))) selected @endif
                                    @endif>
                                    {{ $v['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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
                            <option value="Katholik" @if ($PegawaiData['agama'] == 'Katholik') selected @endif>Katholik
                            </option>
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
                        <input type="text" value="{{ $PegawaiData['alamat'] }}" class="form-control"
                            id="alamat" placeholder="Alamat" name="alamat">
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
                            <option value="Logistik" @if ($PegawaiData['divisi'] == 'Logistik') selected @endif>Logistik
                            </option>
                            <option value="Dapro" @if ($PegawaiData['divisi'] == 'Dapro') selected @endif>Dapur Produksi
                            </option>
                            <option value="Chief Leader" @if ($PegawaiData['divisi'] == 'Chief Leader') selected @endif>Chief
                                Leader
                            </option>
                            <option value="Kitchen" @if ($PegawaiData['divisi'] == 'Bar') selected @endif>Kitchen</option>
                            <option value="Bar" @if ($PegawaiData['divisi'] == '') selected @endif>Bar</option>
                            <option value="Service Crew" @if ($PegawaiData['divisi'] == 'Service Crew') selected @endif>Service
                                Crew
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
                            <input type="file" class="custom-file-input" accept="image/*" id="img"
                                name="img">
                            <label class="custom-file-label" for="img">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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
                                <td><input type="checkbox" name="id[]" value="{{ $v['id'] }}"
                                        class="check">
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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
                                <td><input type="checkbox" name="id[]" value="{{ $v['id'] }}"
                                        class="check">
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
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

<script>
    $(function() {

        $('.select2').select2().on("change", function(e) {
            $(this).valid()
        });

        $('input').keyup(function() {
            if (this.type === 'text') {
                this.value = this.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
            }
        });

    });
</script>
