@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createBahan', $user_permission))
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
                                            <option value="11">Bahan Supplay</option>
                                            <option value="21">Bahan Oprasional</option>
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
                                        <select name="satuan_pembelian" onchange="pembelian(this.value)"
                                            id="satuan_pembelian" class="form-control select2 select2-danger" required
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
                                        <input type="text" class="form-control" id="harga" placeholder="Harga"
                                            name="harga">
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Satuan Pemakaian</label>
                                        <select name="satuan_pemakaian" onchange="pemakaian(this.value)"
                                            id="satuan_pemakaian" class="form-control select2 select2-danger" required
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
                                            <input type="number" name="konversi_pemakaian" id="konversi_pemakaian"
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
                                            @foreach ($satuan as $s3)
                                                <option value="{{ $s3['singkat'] }}">{{ $s3['nama'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Konversi Satuan Pengeluaran</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend" id="konversid2">
                                            </div>
                                            <input type="number" name="konversi_pengeluaran" id="konversi_pengeluaran"
                                                class="form-control" placeholder="Satuan Pengeluaran">
                                            <div class="input-group-append" id="konversib2">
                                            </div>
                                        </div>
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
                                        <small>
                                            <font color="red">*</font> Kosongkan untuk keseluruhan
                                        </small>
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
            @endif
            <div class="card">
                <div class="card-header text-white bg-secondary mb-3">
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a class="btn btn-primary float-lg-right" target="_blank" href="Bahan/PrintBarcode"><i
                            class="fa fa-barcode"></i>
                        Print Barcode</a><br>
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Bahan</th>
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
        $(function() {
            $('input').keyup(function() {
                // if (this.type === 'text') {
                //     this.value = this.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
                // }
                if (this.type === 'text') {
                    this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
                }
            });
        });
    </script>
@endsection
