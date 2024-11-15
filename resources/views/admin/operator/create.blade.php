@extends('template.full')

@section('title', 'Tambah Operator ')

@section('content-bc', 'Tambah Operator')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Setting Operator</h2>
            <form action="{{ route('admin.operator.store') }}" method="POST">
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
                                required>
                        </div>

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label class="form-label">Email<code>*</code></label>
                            <input type="email" name="email" placeholder="Masukkan Email" class="form-control" required>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-4">
                            <label class="form-label">Password<code>*</code></label>
                            <input type="password" name="password" placeholder="Masukkan Password" class="form-control"
                                required>
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-4">
                            <button class="btn btn-primary" type="submit">Simpan Pengguna</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
