<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminSoalManage extends Controller
{
    public function index()
    {
        return view('admin.soals.index');
    }

    public function getData(Request $request)
    {
        $questions = Question::query();

        $recordsTotal = $questions->count();

        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $questions->where('question', 'like', '%' . $searchValue . '%');
        }

        $recordsFiltered = $questions->count();

        $questions->skip($request->start ?? 0)
            ->take($request->length ?? $recordsTotal);

        $data = $questions->get();

        return response()->json([
            'draw' => intval($request->draw ?? 1),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('admin.soals.create');
    }

    public function store(Request $request)
    {
        // Upload Image
        if ($request->file('gambar_soal')) {
            $image = $request->file('gambar_soal');
            $imageNameQ = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageNameQ);
        } else {
            $imageNameQ = null;
        }

        if ($request->file('option_image_a')) {
            $imagea = $request->file('option_image_a');
            $iopta = time() . 'a.' . $imagea->getClientOriginalExtension();
            $imagea->move(public_path('images'), $iopta);
        } else {
            $iopta = null;
        }

        if ($request->file('option_image_b')) {
            $imageb = $request->file('option_image_b');
            $ioptb = time() . 'b.' . $imageb->getClientOriginalExtension();
            $imageb->move(public_path('images'), $ioptb);
        } else {
            $ioptb = null;
        }

        if ($request->file('option_image_c')) {
            $imagec = $request->file('option_image_c');
            $ioptc = time() . 'c.' . $imagec->getClientOriginalExtension();
            $imagec->move(public_path('images'), $ioptc);
        } else {
            $ioptc = null;
        }

        if ($request->file('option_image_d')) {
            $imaged = $request->file('option_image_d');
            $ioptd = time() . 'd.' . $imaged->getClientOriginalExtension();
            $imaged->move(public_path('images'), $ioptd);
        } else {
            $ioptd = null;
        }

        if ($request->file('option_image_e')) {
            $imagee = $request->file('option_image_e');
            $iopte = time() . 'e.' . $imagee->getClientOriginalExtension();
            $imagee->move(public_path('images'), $iopte);
        } else {
            $iopte = null;
        }

        // Check for duplicates
        // $existingQuestion = Question::where('question', $request->question)
        //     ->where('option_a', $request->option_a)
        //     ->where('option_b', $request->option_b)
        //     ->where('option_c', $request->option_c)
        //     ->where('option_d', $request->option_d)
        //     ->where('option_e', $request->option_e)
        //     ->where('correct_option', $request->correct_answer)
        //     ->where('poin_a', $request->poin_a)
        //     ->where('poin_b', $request->poin_b)
        //     ->where('poin_c', $request->poin_c)
        //     ->where('poin_d', $request->poin_d)
        //     ->where('poin_e', $request->poin_e)
        //     ->first();

        // if ($existingQuestion) {
        //     return redirect()->back()->withErrors(['message' => 'This question already exists.']);
        // }

        Question::create([
            'question' => $request->question,
            'category' => $request->sub,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'option_e' => $request->option_e,
            'correct_option' => $request->correct_answer,
            'poin_a' => $request->poin_a,
            'poin_b' => $request->poin_b,
            'poin_c' => $request->poin_c,
            'poin_d' => $request->poin_d,
            'poin_e' => $request->poin_e,
            'image_a' => $iopta,
            'image_b' => $ioptb,
            'image_c' => $ioptc,
            'image_d' => $ioptd,
            'image_e' => $iopte,
            'image' => $imageNameQ,
        ]);

        return redirect()->route('admin.soal.cat')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $question = Question::find($id);

        if ($question->image) {
            $this->deleteImage($question->image);
        }

        if ($question->option_image_a) {
            $this->deleteImage($question->option_image_a);
        }

        if ($question->option_image_b) {
            $this->deleteImage($question->option_image_b);
        }

        if ($question->option_image_c) {
            $this->deleteImage($question->option_image_c);
        }

        if ($question->option_image_d) {
            $this->deleteImage($question->option_image_d);
        }

        if ($question->option_image_e) {
            $this->deleteImage($question->option_image_e);
        }

        $question->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }

    public function edit($id)
    {
        $soal = Question::find($id);

        $poinOptions = [
             [0, 1]
        ];

        return view('admin.soals.edit', compact('soal', 'poinOptions'));
    }

    public function update($id, Request $request)
    {
        $question = Question::find($id);
        $question->question = $request->question;

        $question->option_a =  $request->option_a;
        $question->option_b =  $request->option_b;
        $question->option_c =  $request->option_c;
        $question->option_d =  $request->option_d;
        $question->option_e =  $request->option_e;
        $question->correct_option =  $request->correct_answer;
        $question->poin_a =  $request->poin_a;
        $question->poin_b =  $request->poin_b;
        $question->poin_c =  $request->poin_c;
        $question->poin_d =  $request->poin_d;
        $question->poin_e =  $request->poin_e;

        // Upload Image
        if ($request->file('gambar_soal')) {
            $this->deleteImage($question->image);
            $image = $request->file('gambar_soal');
            $imageNameQ = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageNameQ);

            $question->image = $imageNameQ;
        }

        if ($request->file('option_image_a')) {
            $this->deleteImage($question->option_image_a);
            $imagea = $request->file('option_image_a');
            $iopta = time() . 'a.' . $imagea->getClientOriginalExtension();
            $imagea->move(public_path('images'), $iopta);

            $question->image_a = $iopta;
        }

        if ($request->file('option_image_b')) {
            $this->deleteImage($question->option_image_b);
            $imageb = $request->file('option_image_b');
            $ioptb = time() . 'b.' . $imageb->getClientOriginalExtension();
            $imageb->move(public_path('images'), $ioptb);

            $question->image_b = $ioptb;
        }

        if ($request->file('option_image_c')) {
            $this->deleteImage($question->option_image_c);
            $imagec = $request->file('option_image_c');
            $ioptc = time() . 'c.' . $imagec->getClientOriginalExtension();
            $imagec->move(public_path('images'), $ioptc);

            $question->image_c = $ioptc;
        }

        if ($request->file('option_image_d')) {
            $this->deleteImage($question->option_image_d);
            $imaged = $request->file('option_image_d');
            $ioptd = time() . 'd.' . $imaged->getClientOriginalExtension();
            $imaged->move(public_path('images'), $ioptd);

            $question->image_d = $ioptd;
        }

        if ($request->file('option_image_e')) {
            $this->deleteImage($question->option_image_e);
            $imagee = $request->file('option_image_e');
            $iopte = time() . 'e.' . $imagee->getClientOriginalExtension();
            $imagee->move(public_path('images'), $iopte);

            $question->image_e = $iopte;
        }

        $question->save();

        return redirect()->route('admin.soal.cat')->with('success', 'Data berhasil diubah!');
    }

    private function deleteImage($imageName)
    {
        $imagePath = public_path('images/' . $imageName);

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}