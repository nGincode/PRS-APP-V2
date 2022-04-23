@extends('layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            <form id="FormOlahan" action="{{ url('/Foodcost/Olahan') }}">
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
                        <div class="text-right" id="autosave">
                            @if ($Olahan)
                                <small> <i class="fas fa-check"></i> Autosave dari nama olahan
                                    {{ $Olahan['nama'] }}</small>
                            @else
                                <small> <i class="fas fa-check"></i> Autosave on</small>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="nama">Nama Olahan</label>
                                    <input type="text" class="form-control"
                                        @isset($Olahan['nama']) value="{{ $Olahan['nama'] }}" @endisset
                                        id="nama" placeholder="Nama Olahan" name="nama">
                                </div>
                            </div>


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Satuan Pengeluaran</label>
                                    <select name="satuan_pengeluaran" onchange="pengeluaran(this.value)"
                                        id="satuan_pengeluaran" class="form-control select2 select2-danger" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>
                                        <option value="Kilogram"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Kilogram') selected @endif @endisset>
                                            Kilogram</option>
                                        <option value="Gram"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Gram') selected @endif @endisset>
                                            Gram
                                        </option>
                                        <option value="Ons"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Ons') selected @endif @endisset>
                                            Ons
                                        </option>
                                        <option value="Pack"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Pack') selected @endif @endisset>
                                            Pack
                                        </option>
                                        <option value="Pieces"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Pieces') selected @endif @endisset>
                                            Pieces
                                        </option>
                                        <option value="Butir"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Butir') selected @endif @endisset>
                                            Butir
                                        </option>
                                        <option value="Potong"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Potong') selected @endif @endisset>
                                            Potong
                                        </option>
                                        <option value="Liter"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Liter') selected @endif @endisset>
                                            Liter
                                        </option>
                                        <option value="Mililiter"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Mililiter') selected @endif @endisset>
                                            Mililiter</option>
                                        <option value="Galon"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Galon') selected @endif @endisset>
                                            Galon
                                        </option>
                                        <option value="Pouch"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Pouch') selected @endif @endisset>
                                            Pouch
                                        </option>
                                        <option value="Lembar"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Lembar') selected @endif @endisset>
                                            Lembar</option>
                                        <option value="Roll"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Roll') selected @endif @endisset>
                                            Roll
                                        </option>
                                        <option value="Ikat"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Ikat') selected @endif @endisset>
                                            Ikat
                                        </option>
                                        <option value="Bal"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Bal') selected @endif @endisset>
                                            Bal
                                        </option>
                                        <option value="Karung"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Karung') selected @endif @endisset>
                                            Karung</option>
                                        <option value="Kaleng"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Kaleng') selected @endif @endisset>
                                            Kaleng</option>
                                        <option value="Dus"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Dus') selected @endif @endisset>
                                            Dus
                                        </option>
                                        <option value="Botol"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Botol') selected @endif @endisset>
                                            Botol
                                        </option>
                                        <option value="Jerigen"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Jerigen') selected @endif @endisset>
                                            Jerigen</option>
                                        <option value="Tabung"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Tabung') selected @endif @endisset>
                                            Tabung</option>
                                        <option value="Ekor"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Papan') selected @endif @endisset>
                                            Papan
                                        </option>
                                        <option value="Bungkus"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Bungkus') selected @endif @endisset>
                                            Bungkus</option>
                                        <option value="Ember"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Ember') selected @endif @endisset>
                                            Ember
                                        </option>
                                        <option value="Toples"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Toples') selected @endif @endisset>
                                            Toples</option>
                                        <option value="Shot"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Shot') selected @endif @endisset>
                                            Shot
                                        </option>
                                        <option value="Cup"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Cup') selected @endif @endisset>
                                            Cup
                                        </option>
                                        <option value="Batang"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Batang') selected @endif @endisset>
                                            Batang</option>
                                        <option value="Tusuk"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Tusuk') selected @endif @endisset>
                                            Tusuk
                                        </option>
                                        <option value="Porsi"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Porsi') selected @endif @endisset>
                                            Porsi
                                        </option>
                                        <option value="Centimeter"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Centimeter') selected @endif @endisset>
                                            Centimeter
                                        </option>
                                        <option value="Meter"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Meter') selected @endif @endisset>
                                            Meter
                                        </option>
                                        <option value="Slop"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Slop') selected @endif @endisset>
                                            Slop
                                        </option>
                                        <option value="Loaf"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Loaf') selected @endif @endisset>
                                            Loaf
                                        </option>
                                        <option value="Pasang"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Pasang') selected @endif @endisset>
                                            Pasang</option>
                                        <option value="Slice"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Slice') selected @endif @endisset>
                                            Slice
                                        </option>
                                        <option value="Sendok Teh"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Sendok Teh') selected @endif @endisset>
                                            Sendok Teh
                                        </option>
                                        <option value="Sendok Makan"
                                            @isset($Olahan['satuan_pengeluaran']) @if ($Olahan['satuan_pengeluaran'] == 'Sendok Makan') selected @endif @endisset>
                                            Sendok Makan
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Satuan Penyajian</label>
                                    <select name="satuan_penyajian" onchange="penyajian(this.value)" id="satuan_penyajian"
                                        class="form-control select2 select2-danger" required
                                        data-dropdown-css-class="select2-danger" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih</option>

                                        <option value="Kilogram"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Kilogram') selected @endif @endisset>
                                            Kilogram</option>
                                        <option value="Gram"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Gram') selected @endif @endisset>
                                            Gram
                                        </option>
                                        <option value="Ons"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Ons') selected @endif @endisset>
                                            Ons
                                        </option>
                                        <option value="Pack"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Pack') selected @endif @endisset>
                                            Pack
                                        </option>
                                        <option value="Pieces"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Pieces') selected @endif @endisset>
                                            Pieces
                                        </option>
                                        <option value="Butir"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Butir') selected @endif @endisset>
                                            Butir
                                        </option>
                                        <option value="Potong"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Potong') selected @endif @endisset>
                                            Potong
                                        </option>
                                        <option value="Liter"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Liter') selected @endif @endisset>
                                            Liter
                                        </option>
                                        <option value="Mililiter"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Mililiter') selected @endif @endisset>
                                            Mililiter</option>
                                        <option value="Galon"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Galon') selected @endif @endisset>
                                            Galon
                                        </option>
                                        <option value="Pouch"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Pouch') selected @endif @endisset>
                                            Pouch
                                        </option>
                                        <option value="Lembar"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Lembar') selected @endif @endisset>
                                            Lembar</option>
                                        <option value="Roll"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Roll') selected @endif @endisset>
                                            Roll
                                        </option>
                                        <option value="Ikat"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Ikat') selected @endif @endisset>
                                            Ikat
                                        </option>
                                        <option value="Bal"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Bal') selected @endif @endisset>
                                            Bal
                                        </option>
                                        <option value="Karung"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Karung') selected @endif @endisset>
                                            Karung</option>
                                        <option value="Kaleng"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Kaleng') selected @endif @endisset>
                                            Kaleng</option>
                                        <option value="Dus"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Dus') selected @endif @endisset>
                                            Dus
                                        </option>
                                        <option value="Botol"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Botol') selected @endif @endisset>
                                            Botol
                                        </option>
                                        <option value="Jerigen"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Jerigen') selected @endif @endisset>
                                            Jerigen</option>
                                        <option value="Tabung"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Tabung') selected @endif @endisset>
                                            Tabung</option>
                                        <option value="Ekor"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Papan') selected @endif @endisset>
                                            Papan
                                        </option>
                                        <option value="Bungkus"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Bungkus') selected @endif @endisset>
                                            Bungkus</option>
                                        <option value="Ember"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Ember') selected @endif @endisset>
                                            Ember
                                        </option>
                                        <option value="Toples"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Toples') selected @endif @endisset>
                                            Toples</option>
                                        <option value="Shot"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Shot') selected @endif @endisset>
                                            Shot
                                        </option>
                                        <option value="Cup"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Cup') selected @endif @endisset>
                                            Cup
                                        </option>
                                        <option value="Batang"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Batang') selected @endif @endisset>
                                            Batang</option>
                                        <option value="Tusuk"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Tusuk') selected @endif @endisset>
                                            Tusuk
                                        </option>
                                        <option value="Porsi"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Porsi') selected @endif @endisset>
                                            Porsi
                                        </option>
                                        <option value="Centimeter"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Centimeter') selected @endif @endisset>
                                            Centimeter
                                        </option>
                                        <option value="Meter"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Meter') selected @endif @endisset>
                                            Meter
                                        </option>
                                        <option value="Slop"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Slop') selected @endif @endisset>
                                            Slop
                                        </option>
                                        <option value="Loaf"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Loaf') selected @endif @endisset>
                                            Loaf
                                        </option>
                                        <option value="Pasang"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Pasang') selected @endif @endisset>
                                            Pasang</option>
                                        <option value="Slice"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Slice') selected @endif @endisset>
                                            Slice
                                        </option>
                                        <option value="Sendok Teh"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Sendok Teh') selected @endif @endisset>
                                            Sendok Teh
                                        </option>
                                        <option value="Sendok Makan"
                                            @isset($Olahan['satuan_penyajian']) @if ($Olahan['satuan_penyajian'] == 'Sendok Makan') selected @endif @endisset>
                                            Sendok Makan
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Konversi Ke Penyajian</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend" id="konversib2">
                                        </div>
                                        <input type="text"
                                            @isset($Olahan['konversi_penyajian']) value="{{ $Olahan['konversi_penyajian'] }}" @endisset
                                            name="konversi_penyajian" id="konversi_penyajian" class="form-control"
                                            placeholder="Satuan Pengeluaran">
                                        <div class="input-group-append" id="konversib1">
                                            @isset($Olahan['satuan_penyajian'])
                                                <span class="input-group-text">
                                                    {{ $Olahan['satuan_penyajian'] }}
                                                </span>
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="kode">Kode Product</label>
                                    <input type="text"
                                        @isset($Olahan['nama']) value="{{ $Olahan['kode'] }}" @else  value="{{ $kode }}" @endisset
                                        disabled class="form-control" value="Pilih Kategori" id="kode" name="kode">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12">
                                <label>Bahan Baku</label>
                                <table id="managebahanbaku" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Bahan Baku</th>
                                            <th scope="col">Satuan Pemakaian
                                            </th>
                                            <th scope="col">Harga</th>
                                            <th scope="col" style="min-width: 200px">Hasil</th>
                                            <th scope="col" style="min-width: 250px">Total Harga</th>
                                            <th scope="col">
                                                <i class="fas fa-trash"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <div id="idpilihitembahan">
                                    @isset($Olahan['id'])
                                        <a class="btn btn-sm btn-success btn-block" data-toggle='modal' data-target='#Modal'
                                            onclick="pilihbahanbaku({{ $Olahan['id'] }})"><i class="fas fa-plus"></i></a>
                                        <hr>
                                    @endisset
                                </div>

                                <div id="totalbahanbaku" class="float-right font-weight-bold">Total : {{ $Jmlbb }}
                                </div>
                            </div>

                            <div class="col-12 col-sm-12">
                                <label>Bahan Dari Olahan</label>
                                <table id="managebahanolahan" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Bahan Baku</th>
                                            <th scope="col">Hasil Jadi
                                            </th>
                                            <th scope="col">Biaya Produksi</th>
                                            <th scope="col" style="min-width: 200px">Penyajian</th>
                                            <th scope="col" style="min-width: 250px">Harga</th>
                                            <th scope="col">
                                                <i class="fas fa-trash"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <div id="olahanitemolahan">
                                    @isset($Olahan['id'])
                                        <a class="btn btn-sm btn-success btn-block" data-toggle='modal' data-target='#Modal'
                                            onclick="pilihbahanolahan({{ $Olahan['id'] }})"><i
                                                class="fas fa-plus"></i></a>
                                        <hr>
                                    @endisset
                                </div>

                                <div id="totalolahan" class="float-right font-weight-bold">Total : Rp 1</div>
                                <br><br>
                            </div>

                            <div class="col-12 col-sm-12 ">
                                <table class="table float-right font-weight-bold text-right">
                                    <tr>
                                        <td>Biaya Produksi : </td>
                                        <td id="biayaproduksi">Rp. 0</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="hasil">Hasil Jadi</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control"
                                            @isset($Olahan['hasil']) value="{{ $Olahan['hasil'] }}" @endisset
                                            id="hasil" placeholder="Hasil Jadi" name="hasil">

                                        <div class="input-group-append" id="konversib2">
                                            @isset($Olahan['satuan_penyajian'])
                                                <span class="input-group-text">
                                                    {{ $Olahan['satuan_penyajian'] }}
                                                </span>
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url('/Foodcost/Olahan/Session') }}" class="btn btn-danger">Clear</a>
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
                                <th>Nama</th>
                                <th>Biaya Produksi</th>
                                <th>Hasil Jadi</th>
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
        document.getElementById("konversi_penyajian").addEventListener("keyup", function(e) {
            this.value = numeral(this.value).format('0,0');
        });

        //item bahan baku
        if ($("#managebahanbaku").length) {
            $("#managebahanbaku").DataTable({
                "ajax": {
                    url: "/Foodcost/Olahan/OlahanItemBahanBaku",
                    type: "POST"
                },
                "responsive": true,
                "autoWidth": true,
                "processing": true,
                "searching": false,
                "sort": false,
                "paging": false,
                'info': false,
                "destroy": true,
            });
        }

        function pilihbahanbaku(id) {
            $.ajax({
                url: 'Olahan/PilihBahanBaku',
                type: "POST",
                data: {
                    id: id
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    popup('error', true, err.Message);
                },
                success: function(data) {
                    $('#ModalLabel').html('Pilih Bahan Baku');
                    $('#ModelView').html(data);
                }
            })

        }


        //Bahan Olahan
        if ($("#managebahanolahan").length) {
            $("#managebahanolahan").DataTable({
                "ajax": {
                    url: "/Foodcost/Olahan/OlahanOlahanManage",
                    type: "POST"
                },
                "responsive": true,
                "autoWidth": true,
                "processing": true,
                "searching": false,
                "sort": false,
                "paging": false,
                'info': false,
                "destroy": true,
            });
        }

        function pilihbahanolahan(id) {
            $.ajax({
                url: 'Olahan/PilihBahanOlahan',
                type: "POST",
                data: {
                    id: id
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    popup('error', true, err.Message);
                },
                success: function(data) {
                    $('#ModalLabel').html('Pilih Bahan Olahan');
                    $('#ModelView').html(data);
                }
            })

        }


        $(document).ready(function() {
            //Olahan
            if ($('#FormOlahan').length) {
                $('#FormOlahan').validate({
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
                        'nama': {
                            required: true
                        },
                        'satuan_pengeluaran': {
                            required: true
                        },
                        'satuan_penyajian': {
                            required: true
                        },
                        'konversi_penyajian': {
                            required: true
                        },
                        'pakai[]': {
                            required: true

                        }
                    },
                    messages: {
                        // id : "pesan"
                    }
                });

                $('#FormOlahan').on('submit', function(event) {
                    var isValid = $(this).valid();
                    event.preventDefault();
                    var formData = new FormData(this);
                    formData.append('submit', true);
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
                                    popup(data.status, data.toast, 'Berhasil dibuat');
                                    window.setTimeout(function() {
                                        location.reload()
                                    }, 2000);

                                } else {
                                    popup(data.status, data.toast, data.pesan);
                                }
                            }
                        });

                    }
                });
            }

            $('#FormOlahan').on('change', function(event) {

                $('#FormOlahan').validate({
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
                        'nama': {
                            required: true
                        },
                        'satuan_pengeluaran': {
                            required: true
                        },
                        'satuan_penyajian': {
                            required: true
                        },
                        'konversi_penyajian': {
                            required: true
                        }
                    },
                    messages: {
                        // id : "pesan"
                    }
                });
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
                                $('#manage').DataTable().ajax.reload();
                                $('#autosave').html(
                                    '<small style="color:green;"> <i class="fas fa-check"></i> ' +
                                    data.pesan +
                                    '</small>'
                                );
                                animateCSS('#autosave', 'flash');

                                $('#idpilihitembahan').html(
                                    '<a onclick="pilihbahanbaku(' + data.id +
                                    ',' + "'" + "Olahan" + "'" +
                                    ')" class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#Modal"><i class="fas fa-plus"></i></a><hr>'
                                );
                                $('#olahanitemolahan').html(
                                    '<a onclick="Edit(' + data.id +
                                    ',' + "'" + "Olahan" + "'" +
                                    ')" class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#Modal"><i class="fas fa-plus"></i></a><hr>'
                                );

                            } else {
                                $('#autosave').html(
                                    '<small  style="color:red;"> <i class="fas fa-times"></i> ' +
                                    data.pesan +
                                    '</small>'
                                );
                                animateCSS('#autosave', 'shakeX');
                            }
                        }
                    });
                }

            });
        });

        function jumlahbahan(id, value) {

            harga = $('#hargabahan_' + id).val();
            konversi = $('#konversi_pemakaian_' + id).val();

            jml = (harga / konversi) * value;
            $('#jmlbahan_' + id).html('Rp ' + formatRupiah(jml) + ',00');
            $('#totalbahan_' + id).val(jml);

            total = 0;
            row = $('.totalbahan').length;
            for (let i = 0; i < row; i++) {
                if (i == id) {
                    total += jml;
                } else {
                    total += parseInt($('#totalbahan_' + i).val());
                }
            }
            $('#totalbahanbaku').html('Total : Rp ' + formatRupiah(total) + ',00 ');

            jumlah(0, total);

        }

        function jumlah(olahan, totalbahanbaku) {

            if (totalbahanbaku) {
                var totalolahan = parseInt($('#totalolahan').html().replace(
                    'Total : Rp',
                    ''));
                j = formatRupiah(totalolahan + totalbahanbaku);
                $('#biayaproduksi').html('Rp. ' + j + ',00');
            } else if (olahan) {
                var totalbahanbaku = parseInt($('#totalbahanbaku').html().replace(
                    'Total : Rp',
                    ''));
                j = formatRupiah(olahan + totalbahanbaku);
                $('#biayaproduksi').html('Rp. ' + j + ',00');
            } else {

                var totalolahan = parseInt($('#totalolahan').html().replace(
                    'Total : Rp',
                    ''));
                var totalbahanbaku = parseInt($('#totalbahanbaku').html().replace(
                    'Total : Rp',
                    ''));
                j = formatRupiah(totalbahanbaku + totalolahan);
                $('#biayaproduksi').html('Rp. ' + j + ',00');
            }

        }
        jumlah();


        function hapusitemoalahan(id) {
            Swal.fire({
                title: 'Yakin Menghapus?',
                text: "Data Akan Dihapus Permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/Foodcost/Olahan/OlahanItemHapus',
                        data: {
                            id: id
                        },
                        type: "POST",
                        dataType: 'json',
                        error: function(xhr, status, error) {
                            popup(status, true, xhr.status + " " + error);
                        },
                        success: function(data) {
                            if (data.status === 'success') {
                                $('#managebahanbaku').DataTable().ajax.reload();
                                $('#autosave').html(
                                    '<small style="color:green;"> <i class="fas fa-check"></i> ' +
                                    data.pesan +
                                    '</small>'
                                );
                                animateCSS('#autosave', 'flash');

                                popup(data.status, data.toast, data.pesan);
                            } else {
                                popup(data.status, data.toast, data.pesan);
                                $('#autosave').html(
                                    '<small  style="color:red;"> <i class="fas fa-times"></i> ' +
                                    data.pesan +
                                    '</small>'
                                );
                                animateCSS('#autosave', 'shakeX');
                            }
                        }
                    });
                }
            })
        }
    </script>
@endsection
