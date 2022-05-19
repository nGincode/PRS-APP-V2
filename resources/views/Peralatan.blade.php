@extends('layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormPeralatan" action="{{ url('/Master/Peralatan') }}">
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
                                    <label>Kategori</label>
                                    <select name="kategori" onchange="clickkategori(this.value)" id="kategori"
                                        class="form-control select2 select2-danger" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        <option value="1">Peralatan Dapur</option>
                                        <option value="2">Peralatan Kasir</option>
                                        <option value="3">Peralatan Bar</option>
                                        <option value="4">Peralatan Waiter</option>
                                        <option value="5">Peralatan Lainnya</option>
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
                                    <label>Satuan Pembelian</label>
                                    <select name="satuan_pembelian" onchange="pembelian(this.value)" id="satuan_pembelian"
                                        class="form-control select2 select2-danger" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        @foreach ($satuan as $s1)
                                            <option value="{{ $s1['singkat'] }}">{{ $s1['nama'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" class="form-control" id="harga" placeholder="Harga" name="harga">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Satuan Pemakaian</label>
                                    <select name="satuan_pemakaian" onchange="pemakaian(this.value)" id="satuan_pemakaian"
                                        class="form-control select2 select2-danger" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        @foreach ($satuan as $s2)
                                            <option value="{{ $s2['singkat'] }}">{{ $s2['nama'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Konversi Satuan Pemakaian</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend" id="konversid1">

                                        </div>
                                        <input type="text" name="konversi_pemakaian" id="konversi_pemakaian"
                                            class="form-control" placeholder="Satuan Pemakaian">
                                        <div class="input-group-append" id="konversib1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="kode">Kode Product</label>
                                    <input type="text" disabled class="form-control" value="Pilih Kategori" id="kode"
                                        name="kode">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Penggunaan Ke</label>
                                    <select class="select2" multiple="multiple" name="pengguna[]" id="pengguna"
                                        data-placeholder="Pilih Outlet" style="width: 100%;">
                                        @foreach ($Store as $v)
                                            <option value="{{ $v['id'] }}">{{ $v['nama'] }}</option>
                                        @endforeach
                                    </select>
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
                <div class="card-header text-white bg-secondary mb-3">
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Peralatan</th>
                                <th>Kategori</th>
                                <th>Harga Pembelian</th>
                                <th>Konversi Satuan</th>
                                <th>Pengguna</th>
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
    <script>
        //Format Penulisan
        document.getElementById("harga").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });
        document.getElementById("konversi_pemakaian").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });

        function clickkategori(val) {
            if (val == 1) {
                $('#kode').val('PD{{ $kode }}');
            } else if (val == 2) {
                $('#kode').val('PK{{ $kode }}');
            } else if (val == 3) {
                $('#kode').val('PB{{ $kode }}');
            } else if (val == 4) {
                $('#kode').val('PW{{ $kode }}');
            } else if (val == 5) {
                $('#kode').val('PL{{ $kode }}');
            } else {
                $('#kode').val('Gagal, Refresh Halaman');
            }
        }
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
@endsection
