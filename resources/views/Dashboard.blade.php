@extends('layout')

@section('isi')


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          @isset($JumlahOrder)
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $JumlahOrder }}</h3>

                <p>Total Order</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ url('/order') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endisset
          
          @isset($JumlahIvn)
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $JumlahIvn }}</h3>

                <p>Total Inventaris</p>
              </div>
              <div class="icon">
                <i class="fa fa-cubes"></i>
              </div>
              <a href="{{ url('/ivn') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endisset

          @isset($JumlahUsers)
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $JumlahUsers }}</h3>

                <p>Total Pegawai</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ url('/users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endisset

          @isset($JumlahPengadaan)
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $JumlahPengadaan }}</h3>

                <p>Total Pengadaan</p>
              </div>
              <div class="icon">
                <i class="fa fa-download"></i>
              </div>
              <a href="{{ url('/pengadaan') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endisset
          
          @isset($JumlahProductLogistik)
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $JumlahProductLogistik }}</h3>

                <p>Total Barang</p>
              </div>
              <div class="icon">
                <i class="fa fa-box"></i>
              </div>
              <a href="{{ url('/barang') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endisset
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">

          
          <!-- Left col -->
          <section class="col-lg-5 connectedSortable">

          </section>
          <!-- /.Left col -->

          <section class="col-lg-7 connectedSortable">
          </section>

        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
@endsection