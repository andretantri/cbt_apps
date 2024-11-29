@extends('template.full')

@section('title', 'Dashboard Admin')

@section('content-bc', 'Dashboard Admin')

@section('js')
@endsection

@section('content-isi')
    <div class="row items-push">
        <div class="col-xl-4">
            <div class="block block-rounded">
                <div class="block-content">
                    <h3>Grafik Skor</h3>

                </div>
            </div>
        </div>

        <!-- Active Users Count -->
        <div class="col-sm-2">
            <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                <div class="block-content block-content-full flex-grow-1">
                    <div class="fs-sm fw-semibold text-uppercase text-muted">Pengguna Aktif</div>
                    <div class="fs-2 fw-bold" id="activeUsersCount">0</div>
                </div>
            </div>
        </div>

        <!-- Participants by Date Chart -->
        <div class="col-xl-6">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <canvas id="participantsChart"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection
