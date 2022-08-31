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
                                        <label for="barcode">Barcode</label>
                                        <input type="number" placeholder="Barcode" class="form-control" id="barcode"
                                            name="barcode">
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

                    <div class="float-lg-right">

                        <a class="btn btn-info" data-toggle="modal" data-target="#import"><i class="fa fa-upload"></i>
                            Import</a> &nbsp;

                        <a class="btn btn-success" href="Bahan/BahanExport"><i class="fa fa-download"></i>
                            Export</a> &nbsp;

                        <a class="btn btn-default " target="_blank" href="Bahan/PrintBarcode"><i
                                class="fa fa-barcode"></i>
                            Print</a>
                    </div><br>

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


    <div class="modal fade" id="import" tabindex="-1" role="dialog" style="width:100%" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <form id="FormImport" method="POST" enctype="multipart/form-data"
                    action="{{ url('Master/Bahan/BahanImport') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Import Master Data Bahan</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Ket :<br>

                            <font color="red">*</font> Untuk Format Import Anda Bisa Download File Tersebut Pada Tombol
                            Export<br>
                            <font color="red">*</font> Pastikan Kode Barang Tidak Ada Duplikat<br>
                            <font color="red">* Penting !!!</font> Jika Anda Ingin Edit Maka Pastikan Kolom ID Terisi
                            Benar<br>
                            <font color="red">* Penting !!!</font> Jika ID Kosong Maka Data Bersifat Baru<br>


                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="import_file">Import</label>
                                <div class="custom-file">
                                    <input type="file" onclick="importfile()" class="custom-file-input"
                                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                        id="import_file" name="import">
                                    <label class="custom-file-label" for="import_file">Choose file</label>
                                </div>
                            </div>
                        </div>

                        <div id="cekfile">

                        </div>
                        </p>


                    </div>
                    <div class="modal-footer">
                        <div class="float-left"><button type="submit" class="btn btn-primary">Upload</button></div>
                        <a class="btn btn-success" href="Bahan/BahanExport"><i class="fa fa-download"></i>
                            Export</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        #spin {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 3px;
            border: 3px solid rgba(156, 152, 152, 0.3);
            border-radius: 50%;
            border-top-color: rgb(255, 11, 11);
            animation: spin 1s ease-in-out infinite;
            -webkit-animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
            }
        }
    </style>
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

        function importfile() {
            $('#cekfile').html('');
        }

        $(document).ready(function() {
            if ($('#FormImport').length) {
                $('#FormImport').validate({
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
                        'import': {
                            required: true
                        }
                    },
                    messages: {}
                });

                $('#FormImport').on('submit', function(event) {
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
                                $('#cekfile').html(
                                    '<div style="color:red"><i class="fa fa-times"></i> ' +
                                    error + '</div>');
                            },
                            beforeSend: function() {
                                $('#cekfile').html('<div id="spin"></div> Cek File');
                            },
                            success: function(data) {
                                if (data.status === 'success') {
                                    $('#cekfile').html(
                                        '<font style="color:green"><i class="fa fa-check"></i> Cek File </font><br><font style="color:green"><i class="fa fa-check"></i> Format File Oke </font><br><div style="color:green"><i class="fa fa-check"></i> ' +
                                        data.pesan + '</div>');
                                    $('#manage').DataTable().ajax.reload();
                                    $('#import_file').val("");
                                    $('#import_file').next('label').html('Choose File');
                                } else {
                                    $('#cekfile').html(data.pesan);
                                    $('#import_file').next('label').html('Choose File');
                                }
                            }
                        });

                    }
                });
            }



        });
    </script>
@endsection
