@extends('template.full')

@section('title', 'Tambah User ')

@section('content-bc', 'Tambah User')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Setting User</h2>
            <form action="{{ route('admin.user.store') }}" method="POST">
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

                        <!-- Tempat Lahir Input -->
                        <div class="mb-4">
                            <label class="form-label">Tempat Lahir<code>*</code></label>
                            <input type="text" name="tempat_lahir" placeholder="Masukkan Tempat Lahir"
                                class="form-control" required>
                        </div>

                        <!-- Tanggal Lahir Input -->
                        <div class="mb-4">
                            <label class="form-label">Tanggal Lahir<code>*</code></label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>

                        <!-- Jenis Kelamin Input -->
                        <div class="mb-4">
                            <label class="form-label">Jenis Kelamin<code>*</code></label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">Silahkan Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
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
