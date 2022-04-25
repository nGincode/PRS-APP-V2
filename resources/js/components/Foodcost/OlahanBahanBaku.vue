<template>
<div>
                <div class="col-12 col-sm-12">
                    <label>Bahan Jadi</label>
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
                </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            BahanBaku: {}
        }
    },
    mounted() {
        this.GetBahanBaku();
    },
    methods: {
        GetBahanBaku() {
            axios.get('/test')
                .then(response => {
                    {
                        this.BahanBaku = response.data
                    };
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
                })
                .catch((error) => console.log(error.response))
        }
    }
}
</script>
