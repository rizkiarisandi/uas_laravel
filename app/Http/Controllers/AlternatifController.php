<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::all();
        return view('alternatif.index', compact('alternatifs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:alternatifs',
            'nama' => 'required',
        ]);

        Alternatif::create($request->all());

        return redirect()->back()->with('success', 'Alternatif created successfully.');
    }

    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate([
            'kode' => 'required|unique:alternatifs,kode,' . $alternatif->id,
            'nama' => 'required',
        ]);

        $alternatif->update($request->all());

        return redirect()->back()->with('success', 'Alternatif updated successfully.');
    }

    public function destroy(Alternatif $alternatif)
    {
        $alternatif->delete();

        return redirect()->back()->with('success', 'Alternatif deleted successfully.');
    }
}
