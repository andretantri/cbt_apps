@extends('template.full')

@section('title', 'Edit Soal')

@section('content-bc', 'Edit Soal')

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
                    ]
                },
                removePlugins: ['MediaEmbed'],
            })
            .catch(error => {
                console.error(`Error initializing CKEditor 5 for ${selector}:`, error);
            });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const poinSelects = document.querySelectorAll('.poin-select'); // All point selects
        const correctAnswerSelect = document.getElementById('correct_answer'); // Correct answer select

        // Poin values from the database, replace these with your actual data
        const poinA = {
            {
                % 24 soal - % 3 Epoin_a
            }
        };
        const poinB = {
            {
                % 24 soal - % 3 Epoin_b
            }
        };
        const poinC = {
            {
                % 24 soal - % 3 Epoin_c
            }
        };
        const poinD = {
            {
                % 24 soal - % 3 Epoin_d
            }
        };
        const poinE = {
            {
                % 24 soal - % 3 Epoin_e
            }
        };

        const poinOptions = {
            'TWK': [0, 5],
            'TKP': [1, 2, 3, 4, 5],
            'TIU': [0, 5]
        };

        // Function to update options dynamically
        const updatePoinOptions = () => {
            let selectedValues = Array.from(poinSelects).map(select => select.value).filter(v => v);

            poinSelects.forEach(select => {
                    let currentValue = select.value; // Current value of this select
                );

                select.innerHTML = ''; // Clear existing options

                availableOptions.forEach(opt => {
                    let optionElement = document.createElement('option');
                    optionElement.value = opt;
                    optionElement.textContent = opt;
                    if (String(opt) === currentValue) {
                        optionElement.selected = true; // Keep the current value selected
                    }
                    select.appendChild(optionElement);
                });

                // If the current value is not available, set it to the first available option
                if (!availableOptions.includes(Number(currentValue))) {
                    select.value = availableOptions[0] || '';
                }
            });
    };

    // Set initial points for each option
    const setInitialPoinValues = () => {
        // Set correct answer based on which point is 5
        if (poinA == 5) {
            correctAnswerSelect.value = 'a';
        } else if (poinB == 5) {
            correctAnswerSelect.value = 'b';
        } else if (poinC == 5) {
            correctAnswerSelect.value = 'c';
        } else if (poinD == 5) {
            correctAnswerSelect.value = 'd';
        } else if (poinE == 5) {
            correctAnswerSelect.value = 'e';
        }
    };

    // Initialize on page load
    const initializePage = () => {
        setInitialPoinValues(); // Set the points from the database
        updatePoinOptions(); // Update the available options based on the category and selected values
    };

    // Listen to changes and update the options accordingly
    poinSelects.forEach(select => {
        select.addEventListener('change', function () {
            updatePoinOptions();

            // If the selected value is 5, set the corresponding option as the correct answer
            if (this.value == 5) {
                const poinName = this.getAttribute('id').replace('poin_', '');
                correctAnswerSelect.value = poinName;
            }
        });
    });

    // Initialize everything when the page loads
    initializePage();


    document.getElementById('poin_a').value = poinA; document.getElementById('poin_b').value = poinB; document
    .getElementById('poin_c').value = poinC; document.getElementById('poin_d').value = poinD; document
    .getElementById('poin_e').value = poinE;
    });

    function previewImage(input, previewId) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById(previewId);
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

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
        <h2 class="content-heading pt-0">Edit Soal & Jawaban</h2>
        <form
            action="{{ route('admin.soal.update.cat', ['id' => $soal->id]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row push">
                <div class="col-lg-12 col-xl-12 overflow-hidden">
                    <p class="text-muted">
                        (<code>*</code>) Wajib Diisi<br>
                    </p>
                    <div class="mb-4">
                        <label class="form-label">Pertanyaan<code>*</code></label>
                        <textarea class="form-control" name="question" id="soal">{{ $soal->question }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Gambar (Optional)</label>
                        <input class="form-control" type="file" name="gambar_soal" accept="image/*"
                            data-preview="soal-preview">
                        <img id="soal-preview" src="{{ $soal->gambar_soal_url }}" alt="Preview Gambar Soal"
                            style="max-width: 10%; display: {{ $soal->gambar_soal_url ? 'block' : 'none' }};">
                    </div>
                    <blade
                        foreach|%20(%5B%26%2339%3Ba%26%2339%3B%2C%20%26%2339%3Bb%26%2339%3B%2C%20%26%2339%3Bc%26%2339%3B%2C%20%26%2339%3Bd%26%2339%3B%2C%20%26%2339%3Be%26%2339%3B%5D%20as%20%24option)%0D>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Jawaban {{ strtoupper($option) }}<code>*</code></label>
                                    <textarea class="form-control" name="option_{{ $option }}"
                                        id="option_{{ $option }}">{{ $soal->{"option_{$option}"} }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Gambar {{ strtoupper($option) }} (Optional)</label>
                                    <input class="form-control" type="file" name="option_image_{{ $option }}"
                                        accept="image/*" data-preview="preview_{{ $option }}">
                                    <img id="preview_{{ $option }}"
                                        src="{{ $soal->{"option_image_{$option}_url"} }}"
                                        alt="Preview Gambar {{ strtoupper($option) }}"
                                        style="max-width: 30%; display: {{ $soal->{"option_image_{$option}_url"} ? 'block' : 'none' }};">
                                </div>
                                <div class="col-md-2 poin-input" data-name="poin_{{ $option }}">
                                    <label class="form-label">Poin {{ strtoupper($option) }}<code>*</code></label>
                                    @if($option == 'a')
                                        <select class="form-control poin-select" name="poin_a" id="poin_a">

                                            <option value="{{ $poin }}"
                                                {{ $poin == $soal->poin_a ? 'selected' : '' }}>
                                                {{ $poin }}
                                            </option>

                                        </select>
                                    @elseif($option == 'b')
                                        <select class="form-control poin-select" name="poin_b" id="poin_b">

                                            <option value="{{ $poin }}"
                                                {{ $poin == $soal->poin_b ? 'selected' : '' }}>
                                                {{ $poin }}
                                            </option>

                                        </select>
                                    @elseif($option == 'c')
                                        <select class="form-control poin-select" name="poin_c" id="poin_c">

                                            <option value="{{ $poin }}"
                                                {{ $poin == $soal->poin_c ? 'selected' : '' }}>
                                                {{ $poin }}
                                            </option>

                                        </select>
                                    @elseif($option == 'd')
                                        <select class="form-control poin-select" name="poin_d" id="poin_d">

                                            <option value="{{ $poin }}"
                                                {{ $poin == $soal->poin_d ? 'selected' : '' }}>
                                                {{ $poin }}
                                            </option>

                                        </select>
                                    @elseif($option == 'e')
                                        <select class="form-control poin-select" name="poin_e" id="poin_e">

                                            <option value="{{ $poin }}"
                                                {{ $poin == $soal->poin_e ? 'selected' : '' }}>
                                                {{ $poin }}
                                            </option>

                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <div class="mb-4">
                        <label class="form-label">Jawaban Benar<code>*</code></label>
                        <select name="correct_answer" id="correct_answer" class="form-control" required>
                            <option value="">Silahkan Pilih</option>
                            <option value="a"
                                {{ $soal->correct_option == 'a' ? 'selected' : '' }}>
                                A</option>
                            <option value="b"
                                {{ $soal->correct_option == 'b' ? 'selected' : '' }}>
                                B</option>
                            <option value="c"
                                {{ $soal->correct_option == 'c' ? 'selected' : '' }}>
                                C</option>
                            <option value="d"
                                {{ $soal->correct_option == 'd' ? 'selected' : '' }}>
                                D</option>
                            <option value="e"
                                {{ $soal->correct_option == 'e' ? 'selected' : '' }}>
                                E</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <button class="btn btn-secondary" type="button" id="reset-points">Reset Poin</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
