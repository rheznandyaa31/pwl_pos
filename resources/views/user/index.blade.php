@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('user/create') }}" class="btn btn-sm btn-primary mt-1">Tambah</a>
                <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="level_id" id="level_id" class="form-control" required>
                                <option value="">- Semua -</option>
                                @foreach($level as $item)
                                @foreach ($level as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Userename</th>
                        <th>Nama</th>
                        <th>Level Pengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var dataUser;
        $(document).ready(function() {
            var dataUser = $('#table_user').DataTable({
            dataUser = $('#table_user').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('user/list') }}",
                    "dataType" : "json",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.level_id = $('#level_id').val();
                    }
                },
                columns: [
                    {
                        // nomor urut dari laravel datatable addIndexColumn()
                        data: "DT_RowIndex",
                        ClassName: "text-center",
                        orderable: false,
                        searchable: false
                    },{
                        data: "username",
                        ClassName: "",
                        // orderable: true, jika ingin kolom ini bisa diurutkan
                        orderable: true,
                        // searchable: true, jika ingin kolom ini bisa dicari
                        searchable: true
                    },{
                        // mengambil data level hasil dari ORM berelasi
                        data: "nama",
                        ClassName: "",
                        orderable: true,
                        searchable: true
                    },{
                        data: "level.level_nama",
                        ClassName: "",
                        orderable: false,
                        searchable: false
                    },{
                        data: "aksi",
                        ClassName: "",
                        orderable: false,
                        searchable: false
                    }
                ]
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    ClassName: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "username",
                    ClassName: "",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                }, {
                    // mengambil data level hasil dari ORM berelasi
                    data: "nama",
                    ClassName: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "level.level_nama",
                    ClassName: "",
                    orderable: false,
                    searchable: false
                }, {
                    data: "aksi",
                    ClassName: "",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#level_id').on('change', function() {
                dataUser.ajax.reload();
            });
        });
    </script>
@endpush
@endpush