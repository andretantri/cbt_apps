<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccessOperatorController extends Controller
{
    public function index()
    {
        return view('admin.operator.index');
    }

    public function getData(Request $request)
    {
        $data = Operator::query();

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
        return view('admin.operator.create');
    }

    public function store(Request $request)
    {
        Operator::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin.operator')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $data = Operator::find($id);

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }

    public function edit($id)
    {
        $data = Operator::find($id);
        return view('admin.operator.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = Operator::find($id);
        $data->password = Hash::make($request->input('password'));
        $data->save();

        return redirect()->route('admin.operator')->with('success', 'Data berhasil diubah!');
    }

    public function change($id)
    {
        $data = Operator::find($id);
        return view('admin.operator.change', compact('data', 'id'));
    }

    public function modify($id, Request $request)
    {
        $data = Operator::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->save();

        return redirect()->route('admin.operator')->with('success', 'Data berhasil diubah!');
    }
}
