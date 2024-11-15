@extends('template.full')

@section('title', 'Tambah Soal Ujian')

@section('content-bc', 'Tambah Soal Ujian')

@section('content-isi')
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Setting Soal Ujian</h2>
            <form action="{{ route('admin.ujian.question-store', $ujian->id) }}" method="POST">
                @csrf
                <input type="hidden" name="order" value="{{ $order }}">
                <div class="row push">
                    <div class="col-lg-12 col-xl-12 overflow-hidden">
                        <h4>({{ $ujian->name }})</h4>
                        <p class="text-muted">
                            Checklist soal yang akan digunakan
                        </p>

                        <div class="form-group">
                            <label for="questions">Pilih Soal:</label>
                            <div class="checkbox-list">
                                @foreach ($pertanyaan as $question)
                                    @php
                                        $us = [];
                                        foreach ($question->hasUse as $use) {
                                            $us[] = $use->exam->name;
                                        }
                                        $x = implode(', ', $us);
                                    @endphp
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="questions[]"
                                            value="{{ $question->id }}" id="question-{{ $question->id }}"
                                            @if (in_array($question->id, $list)) checked @endif>
                                        <label class="form-check-label" for="question-{{ $question->id }}">
                                            @if ($us != [])
                                                [Digunakan Pada : ({{ $x }})]
                                            @endif
                                            {!! $question->question !!}
                                            @if($question->image != null)
                                                <img src="{{ asset('images') }}/{{ $question->image }}" width="100px">
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
