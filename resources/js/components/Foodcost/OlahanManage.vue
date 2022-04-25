<template>
<div class="card-body">
    <table id="manageOlahan" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Biaya Produksi</th>
                <th>Hasil Jadi</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

</template>

<script>
export default {
    data() {
        return {
            ManageOlahan: {}
        }
    },
    mounted() {
        this.manageOlahan();
    },
    methods: {
        manageOlahan() {
            axios.post('/Foodcost/Manage/Olahan')
                .then(response => {

                    {
                        this.ManageOlahan = response.data.data
                    };

                    var cells = this.ManageOlahan.length - 1;
                    var jmlcolm = '';
                    for (let index = 0; index < cells; index++) {
                        if (cells - 1 == index) {
                            jmlcolm += index;
                        } else {
                            jmlcolm += index + ',';
                        }
                    }

                    $("#manageOlahan").DataTable({
                        "data": this.ManageOlahan,
                        "columns": [{
                                'data': 0
                            },
                            {
                                'data': 1
                            },
                            {
                                'data': 2
                            },
                            {
                                'data': 3
                            },
                            {
                                'data': 4
                            },
                        ],
                        "responsive": true,
                        "autoWidth": true,
                        "processing": true,
                        "searching": false,
                        "sort": false,
                        "paging": false,
                        'info': false,
                        "destroy": true,
                        "language": {
                            'Paginate': {
                                'previous': '<',
                                'next': '>'
                            }
                        },

                        // "lengthChange": true,
                        "dom": '<"dt-buttons"Bf><"clear">lirtp',
                        "buttons": [{
                                extend: 'copyHtml5',
                                title: '1',
                                exportOptions: {
                                    columns: [jmlcolm]
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                title: '1',
                                exportOptions: {
                                    columns: [jmlcolm]
                                }
                            },
                            {
                                extend: 'csvHtml5',
                                title: '2',
                                exportOptions: {
                                    columns: [jmlcolm]
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                title: '2',
                                exportOptions: {
                                    columns: [jmlcolm]
                                }
                            },
                            {
                                extend: 'print',
                                messageTop: '',
                                title: '2',
                                exportOptions: {
                                    columns: [jmlcolm]
                                }
                            }
                        ]
                    }).buttons().container().appendTo('#manage_wrapper .col-md-6:eq(0)');
                })
                .catch((error) => console.log(error.response))
        }
    }
}
</script>
