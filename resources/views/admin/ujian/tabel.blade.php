@extends('template.full')

@section('title', 'Setting Soal ')

@section('content-bc', 'Setting Soal ')

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
        function importData() {
            let id_reff = $('#ujian_id').val(); // Menggunakan .val() untuk mengambil nilai input
            let id = '{!! $id !!}';
            $.ajax({
                url: "{!! route('admin.ujian.import-list', ':id') !!}".replace(':id', id),
                method: 'POST',
                data: {
                    ujian_id: id_reff,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                },
                beforeSend: function() {
                    $('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
                    $('.progress').show();
                    var currentWidth = 0; // Mendefinisikan currentWidth di sini
                    var interval = setInterval(function() {
                        if (currentWidth < 90) {
                            var randomIncrement = Math.floor(Math.random() * 10) + 1;
                            currentWidth = currentWidth + randomIncrement;
                            $('.progress-bar').css('width', currentWidth + '%')
                                .attr('aria-valuenow', currentWidth);
                        } else {
                            clearInterval(interval);
                        }
                    }, 500);
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total * 100;
                            $('.progress-bar').css('width', percentComplete + '%')
                                .attr('aria-valuenow', percentComplete);
                        }
                    }, false);
                    return xhr;
                },
                success: function(data) {
                    if (data.result === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Berhasil Import Soal',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        window.location.reload(); // Memuat ulang halaman dengan benar
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Gagal Import Soal',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                complete: function() {
                    $('.loading').hide();
                    $('.progress-bar').css('width', '100%').attr('aria-valuenow', 100);
                    setTimeout(function() {
                        $('.progress').hide();
                    }, 500);
                },
                error: function() {
                    alert('Terjadi kesalahan dalam pengambilan data.');
                }
            });
        }
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
    <div class="row">
        <div class="col-xl-12">
            <!-- Pie Chart -->
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="mb-4">
                        <h3 class="block-title">Import Soal Dari Ujian Sebelumnya</h3>
                    </div>
                    <form id="import" method="POST">
                        @csrf <!-- Jangan lupa untuk menambahkan CSRF token jika diperlukan -->
                        <div class="mb-4">
                            <div class="form-group">
                                <div class="row align-items-end">
                                    <div class="col-md-8">
                                        <label for="ujian_id" class="form-label">Pilih Ujian</label>
                                        <select name="ujian_id" id="ujian_id" class="form-control">
                                            <option value="">Silahkan Pilih</option>
                                            @foreach ($ujian as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} (Total Pertanyaan
                                                    : {{ $item->questionsExam->count() }}) </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary w-100" type="button"
                                            onclick="importData();">Import</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row items-push">
        <div class="col-xl-12">
            <!-- Pie Chart -->
            <div class="block block-rounded">
                <div class="block-content block-content-full">

                    <div class="progress push" style="height: 10px; display: none;" role="progressbar" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 0%;"></div>
                    </div>
                    <table id="tabelData" class="display table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Subkategori</th>
                                <th>Jumlah Soal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Bagian TWK -->
                            <tr>
                                <td colspan="5" class="bg-light font-weight-bold">TWK</td>
                            </tr>

                            @foreach (['Bagian 1', 'Bagian 2', 'Bagian 3', 'Bagian 4', 'Bagian 5', 'Bagian 6'] as $index => $sub)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>TWK</td>
                                    <td>{{ $sub }}</td>
                                    <td>{{ $data->where('exam_id', $id)->where('order', $index + 1)->count() }}</td>
                                    <td>
                                        <a href="{{ route('admin.ujian.question-list', ['kategori' => 'TWK', 'sub' => $sub, 'id' => $id, 'no' => $index + 1]) }}"
                                            class="btn btn-sm btn-primary">
                                            Proses
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Bagian TIU -->
                            <tr>
                                <td colspan="5" class="bg-light font-weight-bold">TIU</td>
                            </tr>

                            @foreach (['Analogi', 'Silogisme', 'Deret', 'Hitung Cepat', 'Aritmatika Sosial', 'Perbandingan Cerita', 'Analitis', 'Figural'] as $index => $sub)
                                <tr>
                                    <td>{{ $index + 7 }}</td>
                                    <td>TIU</td>
                                    <td>{{ $sub }}</td>
                                    <td>{{ $data->where('exam_id', $id)->where('order', $index + 7)->count() }}</td>
                                    <td>
                                        <a href="{{ route('admin.ujian.question-list', ['kategori' => 'TIU', 'sub' => $sub, 'id' => $id, 'no' => $index + 7]) }}"
                                            class="btn btn-sm btn-primary">
                                            Proses
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Bagian TKP -->
                            <tr>
                                <td colspan="5" class="bg-light font-weight-bold">TKP</td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>TKP</td>
                                <td>Random</td>
                                <td>{{ $data->where('exam_id', $id)->where('order', 15)->count() }}</td>
                                <td>
                                    <a href="{{ route('admin.ujian.question-list', ['kategori' => 'TKP', 'sub' => 'Random', 'id' => $id, 'no' => '15']) }}"
                                        class="btn btn-sm btn-primary">
                                        Proses
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
