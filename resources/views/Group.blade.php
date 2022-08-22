@extends('Layout')

@section('isi')
    <?php
    use App\Models\GroupsUsers; ?>

    <section class="content">
        <div class="container-fluid">
            <form id="FormGroup" action="{{ url('/Group') }}">
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>Tambah {{ $title }} </b></h3>

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

                        <div class="form-group">
                            <label for="nama">Nama Group</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan Nama Group">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="permission">Permission</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Jenis Izin</th>
                                        <th scope="col"><i class="fa fa-plus"></i> Tambah</th>
                                        <th scope="col"><i class="fa fa-pen"></i> Edit</th>
                                        <th scope="col"><i class="fa fa-eye"></i> lihat</th>
                                        <th scope="col"><i class="fa fa-trash"></i> Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border: none;"><b>Akun</b></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; User</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="createUser"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="updateUser"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewUser"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteUser"
                                                class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Store</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="createStore"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="updateStore"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewStore"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteStore"
                                                class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Group</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="createGroup"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="updateGroup"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewGroup"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteGroup"
                                                class="minimal"></td>
                                    </tr>

                                    <tr>
                                        <td style="border: none;"><b>Report</b></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Penjualan</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createReportPenjualan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateReportPenjualan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewReportPenjualan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteReportPenjualan" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Belanja</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createReportBelanja" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateReportBelanja" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewReportBelanja" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteReportBelanja" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Inventory</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createReportInventory" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateReportInventory" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewReportInventory" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteReportInventory" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Foodcost</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createReportFoodcost" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateReportFoodcost" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewReportFoodcost" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteReportFoodcost" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;"><b>Master Data</b></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; 1.) Supplier</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createSupplier" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateSupplier" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewSupplier" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteSupplier" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; 2.) Satuan</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createSatuan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateSatuan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewSatuan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteSatuan" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; 3.) Bahan</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createBahan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateBahan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewBahan"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteBahan" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; 4.) Peralatan</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createPeralatan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updatePeralatan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewPeralatan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deletePeralatan" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; 5.) Pegawai</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createPegawai" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updatePegawai" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewPegawai" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deletePegawai" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;"><b>Foodcost</b></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; 1.) Bahan Olahan</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createFoodcostBahanOlahan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateFoodcostBahanOlahan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewFoodcostBahanOlahan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteFoodcostBahanOlahan" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; 2.) Varian</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createFoodcostVarian" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateFoodcostVarian" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewFoodcostVarian" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteFoodcostVarian" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; 3.) Resep Menu</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createFoodcostResep" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateFoodcostResep" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewFoodcostResep" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteFoodcostResep" class="minimal"></td>
                                    </tr>

                                    <tr>
                                        <td style="border: none;"><b>Oprasional</b></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; POS (Point Of Sales)</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="createPOS"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="updatePOS"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewPOS"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="deletePOS"
                                                class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Belanja</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createBelanja" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateBelanja" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewBelanja" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteBelanja" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Inventory (STOCK)</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createInventoryStock" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateInventoryStock" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewInventoryStock" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteInventoryStock" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Inventory (MENU)</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createInventoryMenu" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateInventoryMenu" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewInventoryMenu" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteInventoryMenu" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Inventory (OPNAME)</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createInventoryOpname" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateInventoryOpname" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewInventoryOpname" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteInventoryOpname" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Order </td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createOrder" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateOrder" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" value="viewOrder"
                                                class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteOrder" class="minimal"></td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;&nbsp; Ticket (Nama)</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createTicketNama" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateTicketNama" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewTicketNama" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteTicketNama" class="minimal"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp; Ticket (Scan)</td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="createTicketScan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="updateTicketScan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="viewTicketScan" class="minimal"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission"
                                                value="deleteTicketScan" class="minimal"></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="form-group">
                            <label>Users</label>
                            <select class="select2" multiple="multiple" name="users[]" id="users"
                                data-placeholder="Pilih User" style="width: 100%;">
                                @foreach ($Users as $v)
                                    <?php $us = GroupsUsers::where('users_id', $v['id'])->count(); ?>
                                    @if (!$us)
                                        <option value="{{ $v['id'] }}">{{ $v['username'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header text-white bg-secondary mb-3">
                    <h3 class="card-title" style="font-weight: bolder">Data {{ $title }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="manage" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama Group</th>
                                <th>Permission</th>
                                <th>User</th>
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
@endsection
