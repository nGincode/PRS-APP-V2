@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">
            @if (in_array('createReportPenjualan', $user_permission))
                <form id="FormReportPenjualan" method="GET" action="{{ url('/Report/PenjualanExport') }}">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Export {{ $title . ' ' . $subtitle }} </b></h3>

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

                                @if (request()->session()->get('tipe') !== 'Office')
                                    <input type="hidden" name="store" id="store"
                                        value="{{ request()->session()->get('store_id') }}">
                                @else
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label>Store</label>
                                            <select name="store" id="store"
                                                class="form-control select2 select2-danger" required
                                                data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                <option selected="true" disabled="disabled">Pilih</option>
                                                @foreach ($Store as $v)
                                                    @if ($v['id'] != 1)
                                                        <option value="{{ $v['id'] }}">{{ $v['nama'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control"
                                                value="<?= date('m/d/Y', strtotime('-29 days', strtotime(date('Y-m-d')))) ?> - <?= date('m/d/Y') ?>"
                                                name="range_date" class="form-control" id="range_date">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6">
                                    <div class="form-group clearfix">
                                        <label>Export</label><br>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="excel" name="export" value="1" checked>
                                            <label for="excel">
                                                <i class="fa fa-file-excel"></i> Excel
                                            </label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pdf" value="2" name="export">
                                            <label for="pdf">
                                                <i class="fa fa-file-pdf"></i> PDF
                                            </label>
                                        </div>
                                        &nbsp;&nbsp;
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="csv" value="3" name="export">
                                            <label for="csv">
                                                <i class="fa fa-file-csv"></i> CSV
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>

                        <div class="card-footer">Ket :<br>
                            <font color="red">*</font> Data Berasal Dari POS & Order<br><br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </section>
@endsection
