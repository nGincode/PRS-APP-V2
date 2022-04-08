@isset($UsersData)
    <form id="UsersEdit" action="{{ url('/Users/TambahEdit') }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Groups Users</label>
                        <select name="GroupsUsers" id="GroupsUsers" class="form-control select2 select2-danger" required
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>

                            @foreach ($Group as $grp)
                                @if ($UsersData['group_id'] == $grp['id'])
                                    <option value="{{ $grp['id'] }}" selected>{{ $grp['group_name'] }}
                                    </option>
                                @else
                                    <option value="{{ $grp['id'] }}">{{ $grp['group_name'] }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Outlet Users</label>
                        <select name="OutletUsers" id="OutletUsers1" class="form-control select2 select2-danger"
                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                            <option selected="true" disabled="disabled">Pilih</option>

                            @foreach ($Store as $str)
                                @if ($UsersData['store_id'] == $str['id'])
                                    <option value="{{ $str['id'] }}" selected>{{ $str['name'] }}</option>
                                @else
                                    <option value="{{ $str['id'] }}">{{ $str['name'] }}</option>
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
                        "GroupsUsers": {
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
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js"></script>
    @endif
