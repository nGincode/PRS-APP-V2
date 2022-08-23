@extends('Layout')

@section('isi')
    <section class="content">
        <div class="container-fluid">

            @if (in_array('createTicketScan', $user_permission))
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Scan {{ $title . ' ' . $subtitle }} </b></h3>

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
                            <div class="col-12 col-sm-6" id="qr-reader"></div>
                            <hr>
                            <br>
                            <div class="col-12 col-sm-6 text-center"
                                style="border: 1px solid silver;padding:10px;min-height: 200px;" id='hasil-scan'>
                                <h4>Scanning...</h4>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            @endif





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
                                <th>Wa</th>
                                <th>Email</th>
                                <th>Jumlah</th>
                                <th>Pembuat</th>
                                <th>Ditukar</th>
                                <th>Berlaku</th>
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
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            }, false);

        function onScanSuccess(decodedText, decodedResult) {
            new Audio('/assets/sound/beep.mp3').play();
            console.log(`Code scanned = ${decodedText}`, decodedResult);

            $.ajax({
                url: "CekScan",
                type: "POST",
                data: {
                    id: decodedText
                },
                error: function(xhr, status, error) {
                    // popup(status, true, xhr.status + " " + error);
                },
                beforeSend: function(xhr) {},
                success: function(data) {
                    $('#hasil-scan').html(data);
                }
            });

        }

        html5QrcodeScanner.render(onScanSuccess);
    </script>
@endsection
