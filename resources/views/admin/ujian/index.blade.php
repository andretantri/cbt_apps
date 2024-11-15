@extends('template.full')

@section('title', 'Ujian ')

@section('content-bc', 'Data Ujian ')

@section('css')
    <link rel="stylesheet" href="{{ asset('template/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('js')
    <script src="{{ asset('template/assets/js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('template/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('template/assets/js/pages/be_tables_datatables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            $('#tabelData').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.get.ujian') }}',
                    type: 'GET',
                },
                dataSrc: function(json) {
                    if (json.recordsTotal === undefined || json.recordsFiltered === undefined) {
                        json.recordsTotal = 0;
                        json.recordsFiltered = 0;
                    }
                    return json.data;
                },
                language: {
                    emptyTable: "Belum Ada Data Tersedia"
                },
                columns: [{
                        data: null,
                        name: 'number',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: function(row) {
                            return row.start_date + ' ' + row.start_time;
                        },
                        name: 'start_date'
                    },
                    {
                        data: function(row) {
                            return row.end_date + ' ' + row.end_time;
                        },
                        name: 'end_date'
                    },
                    {
                        data: function(row) {
                            if (row.has_accessed == 1) {
                                return '<btn class="btn btn-primary"><i class="fas fa-eye"></i></span>';
                            } else {
                                return '<span class="btn btn-primary"><i class="fas fa-eye-slash"></i></span>';
                            }
                        },
                        name: 'has_accessed',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let questionUrl = '{{ route('admin.ujian.tabel', ':id') }}'.replace(
                                ':id', data.id);
                            let exportUrl = '{{ route('admin.ujian.export', ':id') }}'.replace(
                                ':id', data.id);
                            return `
                            <a href="{{ route('admin.ujian.edit', ['id' => ':id']) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${data.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <a href="${questionUrl}" class="btn btn-sm btn-primary">
                                <i class="fas fa-list"></i>
                            </a>
                            <a href="${exportUrl}" class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i>
                            </a>
                        `.replace(':id', data.id);
                        }
                    }
                ]
            });

            $('#tabelData').on('click', '.delete-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus data ini?',
                    text: "Anda tidak akan dapat mengembalikannya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lanjutkan Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let deleteUrl = '{{ route('admin.ujian.delete', ':id') }}';
                        deleteUrl = deleteUrl.replace(':id', id);
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $('#tabelData').DataTable().ajax
                                    .reload();
                                Swal.fire(
                                    'Deleted!',
                                    'Data Ujian Berhasil Dihapus.',
                                    'success'
                                );

                            },
                            error: function(response) {
                                Swal.fire(
                                    'Failed!',
                                    'Gagal Hapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
@endsection

@section('content-isi')
    <div class="row items-push">
        <div class="col-xl-12">
            <!-- Pie Chart -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Data Ujian</h3>
                    <div class="block-options">
                        <a href="{{ route('admin.ujian.create') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                </div>
                <div class="block-content block-content-full">

                    <div class="progress push" style="height: 10px; display: none;" role="progressbar" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 0%;"></div>
                    </div>
                    <table id="tabelData" class="display table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Ujian</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Dapat Diakses</th>
                                <th width='20%'>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
