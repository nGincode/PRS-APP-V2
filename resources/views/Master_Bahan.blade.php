@extends('layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormBahan" action="{{ url('/Master/Bahan') }}">
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
                                    <select name="kategori" id="kategori" class="form-control select2 select2-danger"
                                        required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        <option value="1">Bahan Baku Segar</option>
                                        <option value="2">Bahan Baku Beku</option>
                                        <option value="3">Bahan Baku Dalam Kemasan</option>
                                        <option value="4">Bahan Baku Dingin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="nama">Nama Bahan</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Bahan"
                                        name="nama">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Satuan Pembelian</label>
                                    <select name="satuan_pembelian" onchange="pembelian(this.value)" id="satuan_pembelian"
                                        class="form-control select2 select2-danger" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        <option value="Kilogram">Kilogram</option>
                                        <option value="Gram">Gram</option>
                                        <option value="Ons">Ons</option>
                                        <option value="Pack">Pack</option>
                                        <option value="Pieces">Pieces</option>
                                        <option value="Butir">Butir</option>
                                        <option value="Pieces">Pieces</option>
                                        <option value="Potong">Potong</option>
                                        <option value="Liter">Liter</option>
                                        <option value="Mililiter">Mililiter</option>
                                        <option value="Butir">Butir</option>
                                        <option value="Galon">Galon</option>
                                        <option value="Pouch">Pouch</option>
                                        <option value="Lembar">Lembar</option>
                                        <option value="Roll">Roll</option>
                                        <option value="Ikat">Ikat</option>
                                        <option value="Bal">Bal</option>
                                        <option value="Karung">Karung</option>
                                        <option value="Kaleng">Kaleng</option>
                                        <option value="Dus">Dus</option>
                                        <option value="Botol">Botol</option>
                                        <option value="Jerigen">Jerigen</option>
                                        <option value="Tabung">Tabung</option>
                                        <option value="Ekor">Ekor</option>
                                        <option value="Papan">Papan</option>
                                        <option value="Bungkus">Bungkus</option>
                                        <option value="Ember">Ember</option>
                                        <option value="Toples">Toples</option>
                                        <option value="Shot">Shot</option>
                                        <option value="Cup">Cup</option>
                                        <option value="Batang">Batang</option>
                                        <option value="Tusuk">Tusuk</option>
                                        <option value="Porsi">Porsi</option>
                                        <option value="Centimeter">Centimeter</option>
                                        <option value="Meter">Meter</option>
                                        <option value="Slop">Slop</option>
                                        <option value="Loaf">Loaf</option>
                                        <option value="Pasang">Pasang</option>
                                        <option value="Slice">Slice</option>
                                        <option value="Sendok Teh">Sendok Teh</option>
                                        <option value="Sendok Makan">Sendok Makan</option>
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
                                        <option value="Kilogram">Kilogram</option>
                                        <option value="Gram">Gram</option>
                                        <option value="Ons">Ons</option>
                                        <option value="Pack">Pack</option>
                                        <option value="Pieces">Pieces</option>
                                        <option value="Butir">Butir</option>
                                        <option value="Pieces">Pieces</option>
                                        <option value="Potong">Potong</option>
                                        <option value="Liter">Liter</option>
                                        <option value="Mililiter">Mililiter</option>
                                        <option value="Butir">Butir</option>
                                        <option value="Galon">Galon</option>
                                        <option value="Pouch">Pouch</option>
                                        <option value="Lembar">Lembar</option>
                                        <option value="Roll">Roll</option>
                                        <option value="Ikat">Ikat</option>
                                        <option value="Bal">Bal</option>
                                        <option value="Karung">Karung</option>
                                        <option value="Kaleng">Kaleng</option>
                                        <option value="Dus">Dus</option>
                                        <option value="Botol">Botol</option>
                                        <option value="Jerigen">Jerigen</option>
                                        <option value="Tabung">Tabung</option>
                                        <option value="Ekor">Ekor</option>
                                        <option value="Papan">Papan</option>
                                        <option value="Bungkus">Bungkus</option>
                                        <option value="Ember">Ember</option>
                                        <option value="Toples">Toples</option>
                                        <option value="Shot">Shot</option>
                                        <option value="Cup">Cup</option>
                                        <option value="Batang">Batang</option>
                                        <option value="Tusuk">Tusuk</option>
                                        <option value="Porsi">Porsi</option>
                                        <option value="Centimeter">Centimeter</option>
                                        <option value="Meter">Meter</option>
                                        <option value="Slop">Slop</option>
                                        <option value="Loaf">Loaf</option>
                                        <option value="Pasang">Pasang</option>
                                        <option value="Slice">Slice</option>
                                        <option value="Sendok Teh">Sendok Teh</option>
                                        <option value="Sendok Makan">Sendok Makan</option>
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
                                    <label>Satuan Pengeluaran</label>
                                    <select name="satuan_pengeluaran" onchange="pengeluaran(this.value)"
                                        id="satuan_pengeluaran" class="form-control select2 select2-danger" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        <option value="Kilogram">Kilogram</option>
                                        <option value="Gram">Gram</option>
                                        <option value="Ons">Ons</option>
                                        <option value="Pack">Pack</option>
                                        <option value="Pieces">Pieces</option>
                                        <option value="Butir">Butir</option>
                                        <option value="Pieces">Pieces</option>
                                        <option value="Potong">Potong</option>
                                        <option value="Liter">Liter</option>
                                        <option value="Mililiter">Mililiter</option>
                                        <option value="Butir">Butir</option>
                                        <option value="Galon">Galon</option>
                                        <option value="Pouch">Pouch</option>
                                        <option value="Lembar">Lembar</option>
                                        <option value="Roll">Roll</option>
                                        <option value="Ikat">Ikat</option>
                                        <option value="Bal">Bal</option>
                                        <option value="Karung">Karung</option>
                                        <option value="Kaleng">Kaleng</option>
                                        <option value="Dus">Dus</option>
                                        <option value="Botol">Botol</option>
                                        <option value="Jerigen">Jerigen</option>
                                        <option value="Tabung">Tabung</option>
                                        <option value="Ekor">Ekor</option>
                                        <option value="Papan">Papan</option>
                                        <option value="Bungkus">Bungkus</option>
                                        <option value="Ember">Ember</option>
                                        <option value="Toples">Toples</option>
                                        <option value="Shot">Shot</option>
                                        <option value="Cup">Cup</option>
                                        <option value="Batang">Batang</option>
                                        <option value="Tusuk">Tusuk</option>
                                        <option value="Porsi">Porsi</option>
                                        <option value="Centimeter">Centimeter</option>
                                        <option value="Meter">Meter</option>
                                        <option value="Slop">Slop</option>
                                        <option value="Loaf">Loaf</option>
                                        <option value="Pasang">Pasang</option>
                                        <option value="Slice">Slice</option>
                                        <option value="Sendok Teh">Sendok Teh</option>
                                        <option value="Sendok Makan">Sendok Makan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Konversi Satuan Pengeluaran</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend" id="konversid2">
                                        </div>
                                        <input type="text" name="konversi_pengeluaran" id="konversi_pengeluaran"
                                            class="form-control" placeholder="Satuan Pengeluaran">
                                        <div class="input-group-append" id="konversib2">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="kode">Kode Product</label>
                                    <input type="text" disabled class="form-control" id="kode" value="{{ $kode }}"
                                        name="kode">
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
                                <th>Nama Bahan</th>
                                <th>Kategori</th>
                                <th>Pembelian</th>
                                <th>Harga</th>
                                <th>Konversi Satuan</th>
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
        document.getElementById("konversi_pengeluaran").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
@endsection
