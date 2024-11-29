@extends('template.full')

@section('title', 'Tambah Soal ')

@section('content-bc', 'Tambah Soal')

@section('css')
<style>
    .preview-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .preview-wrapper img {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: block;
    }

</style>
@endsection

@section('js')
<script src="{{ asset('template/assets/js/lib/jquery.min.js') }}"></script>
<script
    src="{{ asset('template/assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}">
</script>
<script>
    const editors = ['#soal', '#option_a', '#option_b', '#option_c', '#option_d', '#option_e'];

    editors.forEach(selector => {
        ClassicEditor
            .create(document.querySelector(selector), {
                toolbar: {
                    items: [
                        'bold', 'italic', 'underline', 'bulletedList', 'numberedList', 'blockQuote',
                        'link', 'undo', 'redo'
                        // Hapus item toolbar 'imageUpload' dan 'mediaEmbed' untuk menonaktifkan gambar dan video
                    ]
                },
                removePlugins: ['MediaEmbed'], // Jika hanya ingin menonaktifkan video
            })
            .catch(error => {
                console.error(`Error initializing CKEditor 5 for ${selector}:`, error);
            });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const poinSelects = document.querySelectorAll('.poin-select'); // Ambil semua elemen select untuk poin
        const correctAnswerSelect = document.getElementById('correct_answer'); // Dropdown jawaban benar

        const poinOptions = {
            'TWK': [0, 5],
            'TKP': [1, 2, 3, 4, 5],
            'TIU': [0, 5]
        };

        // Fungsi untuk memperbarui opsi poin yang tersedia pada setiap select
        const updatePoinOptions = () => {
            // Ambil semua nilai yang telah dipilih dari select
            let selectedValues = Array.from(poinSelects).map(select => select.value).filter(v => v);

            poinSelects.forEach(select => {
                    let currentValue = select.value; // Nilai yang saat ini dipilih
                );

                // Hapus opsi yang ada sebelumnya
                while (select.firstChild) {
                    select.removeChild(select.firstChild);
                }

                // Tambahkan kembali opsi yang tersedia ke dropdown
                availableOptions.forEach(opt => {
                    let optionElement = document.createElement('option');
                    optionElement.value = opt;
                    optionElement.textContent = opt;
                    if (String(opt) === currentValue) {
                        optionElement.selected = true; // Pertahankan pilihan saat ini
                    }
                    select.appendChild(optionElement);
                });
            });
    };

    // Menambahkan event listener untuk setiap select poin
    poinSelects.forEach(select => {
        select.addEventListener('change', function () {
            updatePoinOptions(); // Update opsi setelah salah satu select berubah

            // Jika poin 5 dipilih, otomatis ubah jawaban benar
            if (this.value == 5) {
                const poinName = this.getAttribute('id').replace('poin_',
                    ''); // Ambil huruf opsi (a, b, c, d, e)
                correctAnswerSelect.value = poinName; // Atur jawaban benar otomatis
            }
        });
    });

    // Inisialisasi opsi poin saat halaman dimuat
    updatePoinOptions();
    });

    function previewImage(input, previewId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById(previewId);
                preview.src = e.target.result;
                preview.style.display = 'block'; // Ubah display menjadi block setelah gambar dimuat
            };
            reader.readAsDataURL(file);
        }
    }

    // Event listener untuk menambahkan preview gambar ketika ada file yang di-upload
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function () {
            const previewId = this.getAttribute('data-preview');
            previewImage(this, previewId);
        });
    });

</script>
@endsection

@section('content-isi')
<div class="block block-rounded">
    <div class="block-content block-content-full">
        <h2 class="content-heading pt-0">Setting Soal & Jawaban</h2>
        <form action="{{ route('admin.soal.store.cat') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row push">
                <div class="col-lg-12 col-xl-12 overflow-hidden">
                    <p class="text-muted">
                        (<code>*</code>) Wajib Diisi<br>
                    </p>

                    <div class="mb-4">
                        <label class="form-label">Pertanyaan<code>*</code></label>
                        <textarea class="form-control" type="text" name="question" id="soal"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Gambar (Optional)</label>
                        <input class="form-control" type="file" name="gambar_soal" accept="image/*"
                            data-preview="soal-preview">
                        <img id="soal-preview" src="#" alt="Preview Gambar Soal" style="max-width: 10%; display: none;">
                    </div>
                    <blade
                        foreach|%20(%5B%26%2339%3Ba%26%2339%3B%2C%20%26%2339%3Bb%26%2339%3B%2C%20%26%2339%3Bc%26%2339%3B%2C%20%26%2339%3Bd%26%2339%3B%2C%20%26%2339%3Be%26%2339%3B%5D%20as%20%24option)%0D>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Jawaban
                                        {{ strtoupper($option) }}<code>*</code></label>
                                    <textarea class="form-control" type="text" name="option_{{ $option }}"
                                        id="option_{{ $option }}"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Gambar {{ strtoupper($option) }} (Optional)</label>
                                    <input class="form-control" type="file" name="option_image_{{ $option }}"
                                        accept="image/*" data-preview="preview_{{ $option }}">
                                    <img id="preview_{{ $option }}" src="#"
                                        alt="Preview Gambar {{ strtoupper($option) }}"
                                        style="max-width: 30%; display: none;">
                                </div>
                                <div class="col-md-2 poin-input" data-name="poin_{{ $option }}">
                                    <label class="form-label">Poin {{ strtoupper($option) }}<code>*</code></label>
                                    <select class="form-control poin-select" name="poin_{{ $option }}"
                                        id="poin_{{ $option }}" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mb-4">
                        <label class="form-label">Jawaban Benar<code>*</code></label>
                        <select name="correct_answer" id="correct_answer" class="form-control" required>
                            <option value="">Silahkan Pilih</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                            <option value="e">E</option>
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
