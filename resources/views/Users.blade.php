@extends('layout')

@section('isi')


<section class="content">
    <div class="container-fluid">
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



      
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">DataTable with default features</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Rendering engine</th>
              <th>Browser</th>
              <th>Platform(s)</th>
              <th>Engine version</th>
              <th>CSS grade</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>Trident</td>
              <td>Internet
                Explorer 4.0
              </td>
              <td>Win 95+</td>
              <td> 4</td>
              <td>X</td>
            </tr>
            <tr>
              <td>Trident</td>
              <td>Internet
                Explorer 5.0
              </td>
              <td>Win 95+</td>
              <td>5</td>
              <td>C</td>
            </tr>
            <tr>
              <td>Trident</td>
              <td>Internet
                Explorer 5.5
              </td>
              <td>Win 95+</td>
              <td>5.5</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Trident</td>
              <td>Internet
                Explorer 6
              </td>
              <td>Win 98+</td>
              <td>6</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Trident</td>
              <td>Internet Explorer 7</td>
              <td>Win XP SP2+</td>
              <td>7</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Trident</td>
              <td>AOL browser (AOL desktop)</td>
              <td>Win XP</td>
              <td>6</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Firefox 1.0</td>
              <td>Win 98+ / OSX.2+</td>
              <td>1.7</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Firefox 1.5</td>
              <td>Win 98+ / OSX.2+</td>
              <td>1.8</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Firefox 2.0</td>
              <td>Win 98+ / OSX.2+</td>
              <td>1.8</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Firefox 3.0</td>
              <td>Win 2k+ / OSX.3+</td>
              <td>1.9</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Camino 1.0</td>
              <td>OSX.2+</td>
              <td>1.8</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Camino 1.5</td>
              <td>OSX.3+</td>
              <td>1.8</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Netscape 7.2</td>
              <td>Win 95+ / Mac OS 8.6-9.2</td>
              <td>1.7</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Netscape Browser 8</td>
              <td>Win 98SE+</td>
              <td>1.7</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Netscape Navigator 9</td>
              <td>Win 98+ / OSX.2+</td>
              <td>1.8</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Mozilla 1.0</td>
              <td>Win 95+ / OSX.1+</td>
              <td>1</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Mozilla 1.1</td>
              <td>Win 95+ / OSX.1+</td>
              <td>1.1</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Mozilla 1.2</td>
              <td>Win 95+ / OSX.1+</td>
              <td>1.2</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Mozilla 1.3</td>
              <td>Win 95+ / OSX.1+</td>
              <td>1.3</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Mozilla 1.4</td>
              <td>Win 95+ / OSX.1+</td>
              <td>1.4</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Mozilla 1.5</td>
              <td>Win 95+ / OSX.1+</td>
              <td>1.5</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Mozilla 1.6</td>
              <td>Win 95+ / OSX.1+</td>
              <td>1.6</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Mozilla 1.7</td>
              <td>Win 98+ / OSX.1+</td>
              <td>1.7</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Mozilla 1.8</td>
              <td>Win 98+ / OSX.1+</td>
              <td>1.8</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Seamonkey 1.1</td>
              <td>Win 98+ / OSX.2+</td>
              <td>1.8</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Gecko</td>
              <td>Epiphany 2.20</td>
              <td>Gnome</td>
              <td>1.8</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Webkit</td>
              <td>Safari 1.2</td>
              <td>OSX.3</td>
              <td>125.5</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Webkit</td>
              <td>Safari 1.3</td>
              <td>OSX.3</td>
              <td>312.8</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Webkit</td>
              <td>Safari 2.0</td>
              <td>OSX.4+</td>
              <td>419.3</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Webkit</td>
              <td>Safari 3.0</td>
              <td>OSX.4+</td>
              <td>522.1</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Webkit</td>
              <td>OmniWeb 5.5</td>
              <td>OSX.4+</td>
              <td>420</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Webkit</td>
              <td>iPod Touch / iPhone</td>
              <td>iPod</td>
              <td>420.1</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Webkit</td>
              <td>S60</td>
              <td>S60</td>
              <td>413</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Opera 7.0</td>
              <td>Win 95+ / OSX.1+</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Opera 7.5</td>
              <td>Win 95+ / OSX.2+</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Opera 8.0</td>
              <td>Win 95+ / OSX.2+</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Opera 8.5</td>
              <td>Win 95+ / OSX.2+</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Opera 9.0</td>
              <td>Win 95+ / OSX.3+</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Opera 9.2</td>
              <td>Win 88+ / OSX.3+</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Opera 9.5</td>
              <td>Win 88+ / OSX.3+</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Opera for Wii</td>
              <td>Wii</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Nokia N800</td>
              <td>N800</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Presto</td>
              <td>Nintendo DS browser</td>
              <td>Nintendo DS</td>
              <td>8.5</td>
              <td>C/A<sup>1</sup></td>
            </tr>
            <tr>
              <td>KHTML</td>
              <td>Konqureror 3.1</td>
              <td>KDE 3.1</td>
              <td>3.1</td>
              <td>C</td>
            </tr>
            <tr>
              <td>KHTML</td>
              <td>Konqureror 3.3</td>
              <td>KDE 3.3</td>
              <td>3.3</td>
              <td>A</td>
            </tr>
            <tr>
              <td>KHTML</td>
              <td>Konqureror 3.5</td>
              <td>KDE 3.5</td>
              <td>3.5</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Tasman</td>
              <td>Internet Explorer 4.5</td>
              <td>Mac OS 8-9</td>
              <td>-</td>
              <td>X</td>
            </tr>
            <tr>
              <td>Tasman</td>
              <td>Internet Explorer 5.1</td>
              <td>Mac OS 7.6-9</td>
              <td>1</td>
              <td>C</td>
            </tr>
            <tr>
              <td>Tasman</td>
              <td>Internet Explorer 5.2</td>
              <td>Mac OS 8-X</td>
              <td>1</td>
              <td>C</td>
            </tr>
            <tr>
              <td>Misc</td>
              <td>NetFront 3.1</td>
              <td>Embedded devices</td>
              <td>-</td>
              <td>C</td>
            </tr>
            <tr>
              <td>Misc</td>
              <td>NetFront 3.4</td>
              <td>Embedded devices</td>
              <td>-</td>
              <td>A</td>
            </tr>
            <tr>
              <td>Misc</td>
              <td>Dillo 0.8</td>
              <td>Embedded devices</td>
              <td>-</td>
              <td>X</td>
            </tr>
            <tr>
              <td>Misc</td>
              <td>Links</td>
              <td>Text only</td>
              <td>-</td>
              <td>X</td>
            </tr>
            <tr>
              <td>Misc</td>
              <td>Lynx</td>
              <td>Text only</td>
              <td>-</td>
              <td>X</td>
            </tr>
            <tr>
              <td>Misc</td>
              <td>IE Mobile</td>
              <td>Windows Mobile 6</td>
              <td>-</td>
              <td>C</td>
            </tr>
            <tr>
              <td>Misc</td>
              <td>PSP browser</td>
              <td>PSP</td>
              <td>-</td>
              <td>C</td>
            </tr>
            <tr>
              <td>Other browsers</td>
              <td>All others</td>
              <td>-</td>
              <td>-</td>
              <td>U</td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <!-- /.container-fluid -->
</section>
@endsection