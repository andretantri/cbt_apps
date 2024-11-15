@extends('template.full')

@section('title', 'Tambah Token ')

@section('content-bc', 'Tambah Token')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Setting Token</h2>
            <form action="{{ route('admin.token.store') }}" method="POST">
                @csrf
                <div class="row push">
                    <div class="col-lg-12 col-xl-12 overflow-hidden">
                        <p class="text-muted">
                            (<code>*</code>) Wajib Diisi<br>
                        </p>
                        <div class="mb-4">
                            <label class="form-label">Judul Ujian<code>*</code></label>
                            <select name="exam_id" id="exam_id" class="form-control" required>
                                <option value="">Silahkan Pilih</option>
                                @foreach ($exam as $items)
                                    <option value="{{ $items->id }}">{{ $items->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Limit Time<code>*</code></label>
                            <input type="number" name="time_limit" placeholder="Masukkan Batas Waktu (Menit)"
                                class="form-control">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Dapat Diakses<code>*</code></label>
                            <select name="has_access" id="has_access" class="form-control" required>
                                <option value="">Silahkan Pilih</option>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-primary" type="submit">Buat Token</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
