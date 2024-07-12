<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
        return view('kriteria.index', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias',
            'nama_kriteria' => 'required',
            'tipe_kriteria' => 'required',
            'bobot' => 'required|numeric',
        ]);

        Kriteria::create($request->all());

        return redirect()->back()->with('success', 'Kriteria created successfully.');
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias,kode_kriteria,' . $kriteria->id,
            'nama_kriteria' => 'required',
            'tipe_kriteria' => 'required',
            'bobot' => 'required|numeric',
        ]);

        $kriteria->update($request->all());

        return redirect()->back()->with('success', 'Kriteria updated successfully.');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();

        return redirect()->back()->with('success', 'Kriteria deleted successfully.');
    }
}
