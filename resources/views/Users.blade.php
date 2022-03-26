@extends('layout')

@section('isi')


<section class="content">
    <div class="container-fluid">
      <!-- SELECT2 EXAMPLE -->
      <form id="FormUsers">
        @csrf
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><b>Tambah Users </b></h3>

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
                  <label>Groups Users</label>
                  <select name="GroupsUsers" id="GroupsUsers" class="form-control select2 select2-danger" required data-dropdown-css-class="select2-danger" style="width: 100%;">
                    <option selected="true" disabled="disabled">Pilih</option>
                    @foreach ($Group as $grp)
                    <option value="{{ $grp['id'] }}">{{ $grp['group_name'] }}</option>
                    @endforeach
                    </select>
              </div>
              </div>
              
              <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label>Outlet Users</label>
                    <select name="OutletUsers" id="OutletUsers" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                    <option selected="true" disabled="disabled">Pilih</option>
                      @foreach ($Store as $str)
                      <option value="{{ $str['id'] }}">{{ $str['name'] }}</option>
                      @endforeach
                    </select>
                </div>
              </div>

              <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" class="form-control" id="Email" placeholder="Email" name="Email">
                  </div>
              </div>
              
              <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="Username">Username</label>
                    <input type="text" class="form-control" id="Username" placeholder="Username" name="Username">
                  </div>
              </div>

              <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="PasswordUsers">Password</label>
                    <input type="password" class="form-control" id="PasswordUsers" placeholder="Password" name="PasswordUsers">
                  </div>
              </div>

              <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="PasswordRipet">Password Ulangi</label>
                    <input type="password" class="form-control" id="PasswordRipet" placeholder="Passworrd" name="PasswordRipet">
                  </div>
              </div>

              <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="NamaDepanUsers">Nama Depan</label>
                    <input type="text" class="form-control" id="NamaDepanUsers" placeholder="Nama Depan" name="NamaDepanUsers">
                  </div>
              </div>

              <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="NamaBelakangUsers">Nama Belakang</label>
                    <input type="text" class="form-control" id="NamaBelakangUsers" placeholder="Nama Belakang" name="NamaBelakangUsers">
                  </div>
              </div>

              <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="NoUsers">No Whatsapp</label>
                    <input type="number" class="form-control" id="NoUsers" placeholder="No Whatsapp" name="NoUsers">
                  </div>
              </div>

              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label for="img">Image Profil</label>
                  <div class="custom-file">
                  <input type="file" class="custom-file-input" id="img" name="img">
                  <label class="custom-file-label" for="img">Choose file</label>
                  </div>
                </div>
            </div>

              <div class="col-12 col-sm-6"> 
                  <div class="form-group clearfix">
                      <label>Gender</label><br>
                      <div class="icheck-primary d-inline">
                      <input type="radio" id="GenderUsersPerempuan" name="gender" value="1" checked>
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
      <!-- /.card -->
    </div>

    <!-- /.container-fluid -->
</section>
@endsection