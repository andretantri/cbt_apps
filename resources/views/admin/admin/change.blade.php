@extends('template.full')

@section('title', 'Ubah Operator ')

@section('content-bc', 'Ubah Operator')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Setting Operator</h2>
            <form action="{{ route('admin.admin.modify', $id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row push">
                    <div class="col-lg-12 col-xl-12 overflow-hidden">
                        <p class="text-muted">
                            (<code>*</code>) Wajib Diisi<br>
                        </p>

                        <!-- Name Input -->
                        <div class="mb-4">
                            <label class="form-label">Nama Lengkap<code>*</code></label>
                            <input type="text" name="name" placeholder="Masukkan Nama Lengkap" class="form-control"
                                required value="{{ $data->name }}">
                        </div>

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label class="form-label">Email<code>*</code></label>
                            <input type="email" name="email" placeholder="Masukkan Email" class="form-control" required
                                value="{{ $data->email }}">
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-4">
                            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
