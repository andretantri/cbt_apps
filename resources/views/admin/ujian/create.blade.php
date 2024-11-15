@extends('template.full')

@section('title', 'Tambah Ujian ')

@section('content-bc', 'Tambah Ujian')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Setting Ujian</h2>
            <form action="{{ route('admin.ujian.store') }}" method="POST">
                @csrf
                <div class="row push">
                    <div class="col-lg-12 col-xl-12 overflow-hidden">
                        <p class="text-muted">
                            (<code>*</code>) Wajib Diisi<br>
                        </p>
                        <div class="mb-4">
                            <label class="form-label">Judul Ujian<code>*</code></label>
                            <input type="text" name="name" placeholder="Masukkan Judul Ujian" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Mulai<code>*</code></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="time" name="start_time" class="form-control" required  min="00:00" max="23:59">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Selesai<code>*</code></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="time" name="end_time" class="form-control" required  min="00:00" max="23:59">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Tampil Pada Halaman User<code>*</code></label>
                            <select name="has_access" id="has_access" class="form-control" required>
                                <option value="">Silahkan Pilih</option>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
