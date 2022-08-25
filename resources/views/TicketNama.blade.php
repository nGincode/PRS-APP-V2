@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">

            @if (in_array('createTicketNama', $user_permission) &&
                request()->session()->get('tipe') == 'Office')
                <form id="FormTicketNama" action="{{ url('/Ticket/TambahNama') }}">
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
                                        <label for="nama">Nama </label>
                                        <input type="text" class="form-control" id="nama" placeholder="Nama"
                                            name="nama">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="harga">Harga </label>
                                        <input type="text" class="form-control" id="harga" placeholder="Harga"
                                            name="harga">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Tujuan Store</label>
                                        <select name="store" id="store" class="form-control select2"
                                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="semua">Semua</option>
                                            @foreach ($store as $str)
                                                @if ($str['id'] != 1)
                                                    <option value="{{ $str['id'] }}">{{ $str['nama'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Berlaku</label>
                                        <input type="date" min="{{ date('Y-m-d') }}" class="form-control" id="berlaku"
                                            name="berlaku">
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="img_benner">Benner Ukuran (100x50)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="image/*" id="img_benner"
                                                name="img_benner">
                                            <label class="custom-file-label" for="img_benner">Choose file</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="img_voc">Voucher Ukuran (100x50)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="image/*" id="img_voc"
                                                name="img_voc">
                                            <label class="custom-file-label" for="img_voc">Choose file</label>
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
            @endif



            @if (in_array('createTicketNama', $user_permission))
                <form id="FormTicket" action="{{ url('/Ticket/TambahScan') }}">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Pembelian {{ $title }} </b></h3>

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
                                        <label>Pilih Ticket</label>
                                        <select name="ticket" id="ticket" onchange="hargaTicket(this.value)"
                                            class="form-control select2" data-dropdown-css-class="select2-danger"
                                            style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>\
                                            @foreach ($ticket as $v)
                                                <option value="{{ $v['id'] }}">
                                                    {{ $v['nama'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Harga</label>
                                        <input type="number" readonly class="form-control" id="harga_ticket"
                                            name="harga_ticket" placeholder="Harga">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="nama">Atas Nama </label>
                                        <input type="text" class="form-control" id="nama" placeholder="Nama"
                                            name="nama">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="wa">No Whatsapp</label>
                                        <input type="number" class="form-control" id="wa"
                                            placeholder="No Whatsapp" name="wa">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Email"
                                            name="email">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Jumlah</label>
                                        <input type="number" class="form-control" id="jumlah"
                                            placeholder="Jumlah Voucher" name="jumlah">
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Tipe Pembayaran</label>
                                        <select name="tipe" id="tipe" class="form-control select2 select2-danger"
                                            required data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option selected="true" disabled="disabled">Pilih</option>
                                            <option value="Tunai">Tunai</option>
                                            <option value="Tranfer">Tranfer</option>
                                            <option value="QRis">QRis</option>
                                            <option value="Dana">Dana</option>
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
            @endif


            @if (request()->session()->get('tipe') == 'Office')
                <div class="card">
                    <div class="card-header text-white bg-secondary mb-3">
                        <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="manage" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tujuan</th>
                                    <th>Nama Ticket</th>
                                    <th>Harga</th>
                                    <th>Benner</th>
                                    <th>Voucher</th>
                                    <th>Berlaku</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            @endif
        </div>

        <!-- /.container-fluid -->
    </section>
@endsection
