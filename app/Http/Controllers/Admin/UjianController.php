<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use App\Models\Exam;

use App\Http\Controllers\Controller;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class UjianController extends Controller
{
    public function index()
    {
        return view('admin.ujian.index');
    }

    public function getData(Request $request)
    {
        $data = Exam::query();

        $recordsTotal = $data->count();

        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $data->where('question', 'like', '%' . $searchValue . '%');
        }

        $recordsFiltered = $data->count();

        $data->skip($request->start ?? 0)
            ->take($request->length ?? $recordsTotal);

        $data = $data->get();

        return response()->json([
            'draw' => intval($request->draw ?? 1),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin.ujian.create');
    }

    public function store(Request $request)
    {
        Exam::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'has_accessed' => $request->has_access,
        ]);

        return redirect()->route('admin.ujian')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $data = Exam::find($id);

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }

    public function edit($id)
    {
        $data = Exam::find($id);
        return view('admin.ujian.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = Exam::find($id);
        $data->name = $request->name;
        $data->start_date = $request->start_date;
        $data->start_time = $request->start_time;
        $data->end_time = $request->end_time;
        $data->end_date = $request->end_date;
        $data->has_accessed = $request->has_access;
        $data->save();

        return redirect()->route('admin.ujian')->with('success', 'Data berhasil diubah!');
    }

    public function tabel($id)
    {
        $data = ExamQuestion::with('questions')->where('exam_id', $id)->get();
        $ujian = Exam::where('id', '!=', $id)->get();
        return view('admin.ujian.tabel', compact('data', 'ujian', 'id'));
    }

    public function pertanyaan($id, $kategori, $sub, $order)
    {
        $pertanyaan = Question::where('scoring_type', $kategori)->where('category', $sub)->get();
        $cek = ExamQuestion::where('exam_id', $id)->count();

        if ($cek > 0) {
            $list = ExamQuestion::where('exam_id', $id)->get();
            $lq = [];
            foreach ($list as $lquest) {
                $lq[] = $lquest->question_id;
            }
        } else {
            $lq = [];
        }

        $ujian = Exam::find($id);
        return view('admin.ujian.set', ['pertanyaan' => $pertanyaan, 'ujian' => $ujian, 'list' => $lq, 'order' => $order]);
    }

    public function storex($id, Request $request)
    {
        ExamQuestion::where('exam_id', $id)->where('order', $request->order)->delete();

        if ($request->questions != null) {
            foreach ($request->questions as $qid) {
                ExamQuestion::firstOrCreate([
                    'exam_id' => $id,
                    'question_id' => $qid,
                    'order' => $request->order,
                ]);
            }
        }

        return redirect()->route('admin.ujian.tabel', ['id' => $id])->with('success', 'Data berhasil diupdate!');
    }

    public function import(Request $request, $id)
    {
        try {
            // Ambil ujian berdasarkan ID
            $ujian = ExamQuestion::where('exam_id', $request->ujian_id)->get();
            foreach ($ujian as $uji) {
                $existingQuestion = ExamQuestion::where('exam_id', $id)
                    ->where('question_id', $uji->question_id)
                    ->first();
                    
                $cekKategori = Question::whereNotNull('category')
                ->where('id', $uji->id)
                ->count();

                if (!$existingQuestion && $cekKategori != 0) {
                    // Jika soal belum ada, lakukan insert
                    ExamQuestion::create([
                        'exam_id' => $id,
                        'question_id' => $uji->question_id,
                        'order' => $uji->order,
                    ]);
                } else {
                    continue;
                }
            }

            // Jika proses berhasil
            return response()->json(['result' => 1]);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan
            return response()->json(['result' => 0, 'message' => $e->getMessage()], 500);
        }
    }

    public function generatePDF($id)
    {
        // Ambil semua pertanyaan dari database
        $questions = ExamQuestion::where('exam_id', $id)->get();
        $exam = Exam::find($id);

        // Inisialisasi MPDF
        $mpdf = new Mpdf();

        // Tambahkan CSS untuk merapikan tampilan
        $css = "
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }
            .question {
                margin-bottom: 20px;
            }
            .option {
                margin-left: 20px;
                margin-bottom: 5px;
            }
            .correct {
                font-weight: bold;
                color: green;
            }
        ";

        // Konten HTML untuk PDF
        $html = "<h3>Daftar Pertanyaan " . $exam->name . "</h3>";

        foreach ($questions as $index => $question) {
            // Hilangkan tag <p> dan </p> dari pertanyaan
            $cleaned_question = strip_tags($question->question->question);
        
            // Buat HTML untuk pertanyaan
            $html .= "<div class='question'><p>" . ($index + 1) . ". " . $cleaned_question . "</p>";
        
            // Tambahkan gambar pertanyaan jika ada
            if (!empty($question->question->image)) {
                $html .= "<div class='question-image'><img src='" . asset('images/' . $question->question->image) . "' alt='Question Image'></div>";
            }
        
            // Pilihan jawaban A
            $html .= "<div class='option'>A. " . strip_tags($question->question->option_a) . " (poin: " . ($question->question->poin_a ?? '-') . ")";
            if (!empty($question->question->image_a)) {
                $html .= "<div class='option-image'><img src='" . asset('images/' . $question->question->image_a) . "' alt='Option A Image'></div>";
            }
            $html .= "</div>";
        
            // Pilihan jawaban B
            $html .= "<div class='option'>B. " . strip_tags($question->question->option_b) . " (poin: " . ($question->question->poin_b ?? '-') . ")";
            if (!empty($question->question->image_b)) {
                $html .= "<div class='option-image'><img src='" . asset('images/' . $question->question->image_b) . "' alt='Option B Image'></div>";
            }
            $html .= "</div>";
        
            // Pilihan jawaban C
            $html .= "<div class='option'>C. " . strip_tags($question->question->option_c) . " (poin: " . ($question->question->poin_c ?? '-') . ")";
            if (!empty($question->question->image_c)) {
                $html .= "<div class='option-image'><img src='" . asset('images/' . $question->question->image_c) . "' alt='Option C Image'></div>";
            }
            $html .= "</div>";
        
            // Pilihan jawaban D
            $html .= "<div class='option'>D. " . strip_tags($question->question->option_d) . " (poin: " . ($question->question->poin_d ?? '-') . ")";
            if (!empty($question->question->image_d)) {
                $html .= "<div class='option-image'><img src='" . asset('images/' . $question->question->image_d) . "' alt='Option D Image'></div>";
            }
            $html .= "</div>";
        
            // Pilihan jawaban E
            $html .= "<div class='option'>E. " . strip_tags($question->question->option_e) . " (poin: " . ($question->question->poin_e ?? '-') . ")";
            if (!empty($question->question->image_e)) {
                $html .= "<div class='option-image'><img src='" . asset('images/' . $question->question->image_e) . "' alt='Option E Image'></div>";
            }
            $html .= "</div>";
        
            // Jawaban benar
            $html .= "<p class='correct'>Jawaban Benar: " . strtoupper($question->question->correct_option) . "</p>";
            $html .= "</div><hr>";
        }


        // Tambahkan CSS dan HTML ke MPDF
        $mpdf->WriteHTML($css, 1);
        $mpdf->WriteHTML($html, 2);

        // Output PDF ke browser
        $mpdf->Output('Rekap Pertanyaan ' . $exam->name . '.pdf', 'D');
    }
}
