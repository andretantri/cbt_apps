@extends('template.full')

@section('title', 'Ubah Password User ')

@section('content-bc', 'Ubah Password User')

@section('js')
@endsection

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Reset Password</h2>
            <form action="{{ route('admin.operator.update', $data->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row push">
                    <div class="col-lg-12 col-xl-12 overflow-hidden">
                        <p class="text-muted">
                            (<code>*</code>) Wajib Diisi<br>
                        </p>
                        <div class="mb-4">
                            <label class="form-label">Password<code>*</code></label>
                            <input type="password" name="password" placeholder="Masukkan Password" class="form-control"
                                required>
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-primary" type="submit">Reset Password</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
