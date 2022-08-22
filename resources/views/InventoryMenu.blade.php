@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createInventoryStock', $user_permission))
                <form id="FormInventoryStock" action="{{ url('/Inventory/Stock') }}">
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
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="nama">Nama Menu</label>
                                        <select class="select2" onchange="InventoryMenu(this.value)" name="nama"
                                            id="nama" data-placeholder="Pilih Nama Menu" style="width: 100%;">
                                            @if ($nama)
                                                <option selected="true" disabled="disabled">Pilih</option>
                                                @foreach ($nama as $v)
                                                    <option value="{{ $v['id'] }}">
                                                        {{ $v['nama'] }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option selected="true" disabled="disabled">Master Bahan Kosong</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div id="pesanMenu">

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
                                @if (request()->session()->get('tipe') == 'Office')
                                    <th>Store</th>
                                @endif
                                <th>Nama</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Margin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            @if (request()->session()->get('tipe') == 'Logistik')
                <div class="card">
                    <div class="card-header text-white bg-secondary mb-3">
                        <h3 class="card-title" style="font-weight: bolder">Custom Print Barcode</h3>
                    </div>
                    <!-- /.card-header -->

                    <form action="Bahan/BarcodeCustom" method="GET">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="nama_barcode">Nama Bahan</label>
                                        <select required class="select2" name="idbarcode" id="nama_barcode"
                                            data-placeholder="Pilih Nama Bahan" style="width: 100%;">
                                            @if ($BahanPrint)
                                                <option selected="true" disabled="disabled">Pilih</option>
                                                @foreach ($BahanPrint as $v)
                                                    <option value="{{ $v['bahan']->kode }}">
                                                        {{ $v['bahan']->nama }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option selected="true" disabled="disabled">Master Bahan Kosong</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input required type="number" class="form-control" id="jumlah"
                                            placeholder="Jumlah Barcode" name="jumlah">
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-print"></i> Print</button>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
            @endif
            <!-- /.card -->
        </div>

        <!-- /.container-fluid -->
    </section>
    <script>
        function InventoryMenu(id) {
            $.ajax({
                url: "Nama",
                type: "POST",
                data: {
                    id: id
                },
                error: function(xhr, status, error) {
                    popup(status, true, xhr.status + " " + error);
                },
                success: function(data) {
                    $('#pesanMenu').html(data);
                }
            });
        }
    </script>
@endsection
