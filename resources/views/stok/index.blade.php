@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-info">Import Stok</button>
            <a href="{{ url('/stok/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Stok Excel</a>
            <a href="{{ url('/stok/export_pdf') }}" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Export Stok PDF</a>
            <a href="{{ url('/stok/create') }}" class="btn btn-warning"> Tambah Stok</a>
            <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter data -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="supplier_id" class="col-md-1 col-form-label">Supplier</label>
                        <div class="col-md-3">
                            <select name="supplier_id" id="supplier_id" class="form-control form-control-sm">
                                <option value="">- Semua -</option>
                                @foreach($supplier as $item)
                                    <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter berdasarkan supplier</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-sm table-striped table-hover" id="table-stok">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Supplier</th>
                        <th>Barang</th>
                        <th>User</th>
                        <th>Stok Tanggal</th>
                        <th>Stok Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var tableStok;
        $(document).ready(function() {
            tableStok = $('#table-stok').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('stok/list') }}",
                    dataType: "json",
                    type: "POST",
                    data: function(d) {
                        d.supplier_id = $('#supplier_id').val();  // Kirim filter supplier_id ke server
                    }
                },

                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "supplier.supplier_nama",  // Menggunakan suplier_nama
                        className: "",
                        width: "10%",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "barang.barang_nama",  // Menggunakan barang_nama
                        className: "",
                        width: "37%",
                        orderable: true,
                        searchable: true,
                    }, {
                        data: "user.nama",  // Menggunakan nama user
                        className: "",
                        width: "10%",
                        orderable: true,
                        searchable: true,
                    }, {
                        data: "stok_tanggal",
                        className: "",
                        width: "10%",
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row) {
                            if (data) {
                                var date = new Date(data);
                                var year = date.getFullYear();
                                var month = ("0" + (date.getMonth() + 1)).slice(-2); // Tambahkan nol di depan
                                var day = ("0" + date.getDate()).slice(-2); // Tambahkan nol di depan
                                return year + "-" + month + "-" + day; // Format sebagai YYYY-MM-DD
                            }
                            return data; // Kembalikan nilai asli jika tidak ada data
                        }
                    }, {
                        data: "stok_jumlah",
                        className: "",
                        width: "14%",
                        orderable: true,
                        searchable: false
                    }, {
                        data: "aksi",
                        className: "text-center",
                        width: "14%",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#supplier_id').change(function() {
                tableStok.draw();  // Muat ulang DataTable saat supplier_id diubah
            });

            $('#table-stok_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key 
                    tableStok.search(this.value).draw();
                }
            });

            $('.filter_kategori').change(function() {
                tableStok.draw();
            });
        });
</script>
@endpush
