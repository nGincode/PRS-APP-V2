@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createInventoryOpname', $user_permission))
                <form id="FormInventoryOpname" action="{{ url('/Inventory/Opname') }}">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b> {{ $title . ' Stock ' . $subtitle }} </b></h3>

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

                                @if (request()->session()->get('tipe') == 'Outlet')
                                    <input type="hidden" name="store" id="store"
                                        value="{{ request()->session()->get('store_id') }}">


                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="nama">Nama Bahan</label>
                                            <select class="select2" name="nama" id="nama_tambah"
                                                data-placeholder="Pilih Nama Bahan" style="width: 100%;">
                                                @if ($bahan)
                                                    <option selected="true" disabled="disabled">Pilih</option>
                                                    @foreach ($bahan as $v)
                                                        <option value="{{ $v['id'] }}">
                                                            {{ $v['nama'] . ' (' . $v['satuan'] . ')' }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option selected="true" disabled="disabled">Inventory Kosong</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label>Store</label>
                                            <select name="store" id="store" onchange="inventory(this.value)"
                                                class="form-control select2 select2-danger" required
                                                data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                <option selected="true" disabled="disabled">Pilih</option>
                                                @foreach ($store as $v)
                                                    @if ($v['id'] != 1)
                                                        <option value="{{ $v['id'] }}">{{ $v['nama'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="nama">Nama Bahan</label>
                                            <select class="select2" name="nama" id="nama_tambah"
                                                data-placeholder="Pilih Nama Bahan" style="width: 100%;">
                                                <option selected="true" disabled="disabled">Pilih</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif



                                <div class="col-12 col-sm-6">
                                    <div class="form-group clearfix">
                                        <label>Status</label><br>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="Tambah" name="status" value="Tambah" checked>
                                            <label for="Tambah">
                                                <i class="fa fa-plus"></i> Tambah Stock
                                            </label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="Kurang" value="Kurang" name="status">
                                            <label for="Kurang">
                                                <i class="fa fa-minus"></i> Kurang Stock
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="qty">Qty</label>
                                        <input type="number" class="form-control" id="qty" placeholder="Qty"
                                            name="qty">
                                    </div>
                                </div>



                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="ket">Keterangan</label>
                                        <input type="text" class="form-control" id="ket" placeholder="Keterangan"
                                            name="ket">
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
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title . ' ' . $subtitle }}
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Qty</th>
                                <th>Qty Sebelumnya</th>
                                <th>Total Qty</th>
                                <th>Ket</th>
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
        function inventory(id) {
            $.ajax({
                url: 'Opname/NamaInventory',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                beforeSend: function() {
                    $('#nama_tambah').prop('disabled', true);
                },
                success: function(data) {
                    if (data.status === 'success') {
                        $('#nama_tambah').prop('disabled', false);
                        $("#nama_tambah").empty();
                        $('#nama_tambah').append('<option selected="true" disabled="disabled">Pilih</option>');
                        // console.log(data.select2);

                        data.select2.forEach(id => {
                            id.forEach(id2 => {
                                var newOption = new Option(id2.nama, id2.id, false, false);
                                $('#nama_tambah').append(newOption);
                            });
                        });
                    } else {
                        popup(data.status, data.toast, data.pesan);
                    }
                }
            });
        }
    </script>
@endsection
