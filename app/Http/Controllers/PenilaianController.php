<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PenilaianController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::all();

        return view('penilaian.index', compact('alternatifs', 'kriterias', 'penilaians'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $alternativeId = $request->input('alternative_id');

        DB::beginTransaction();
        foreach ($data as $key => $value) {
            if ($key != 'alternative_id') {
                Penilaian::updateOrCreate(
                    ['alternatif_id' => $alternativeId, 'kriteria_id' => $key],
                    ['nilai' => $value]
                );
            }
        }
        DB::commit();

        return redirect()->route('penilaian.index')->with('toast_success', 'Penilaian alternatif diperbarui!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method', 'alternative_id']);
        $alternativeId = $request->input('alternative_id');

        DB::beginTransaction();
        foreach ($data as $key => $value) {
            if ($key != 'alternative_id') {
                Penilaian::where('alternatif_id', $alternativeId)
                    ->where('kriteria_id', $key)
                    ->update(['nilai' => $value]);
            }
        }
        DB::commit();

        return redirect()->route('penilaian.index')->with('toast_success', 'Penilaian alternatif diperbarui!');
    }
    public function topsis()
    {
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all();
        $penilaians = Penilaian::all();

        // Pembagian
        $pembagi = $this->hitungPembagi($penilaians, $kriterias);

        // Normalisasi Matriks
        $matrixNormalisasi = $this->normalisasiMatriks($penilaians, $pembagi);

        // Normalisasi Terbobot
        $matrixTerbobot = $this->normalisasiTerbobot($matrixNormalisasi, $kriterias);

        // Hitung A+ dan A-
        list($solusiIdealPositif, $solusiIdealNegatif) = $this->hitungAplusAminus($matrixTerbobot, $kriterias);

        // Hitung D+ dan D-
        list($jarakPositif, $jarakNegatif) = $this->hitungDplusDminus($matrixTerbobot, $solusiIdealPositif, $solusiIdealNegatif);

        // Nilai Preferensi
        $nilaiPreferensi = $this->hitungNilaiPreferensi($jarakPositif, $jarakNegatif);

        return view('perhitungan.topsis', compact(
            'alternatifs', 'kriterias', 'matrixNormalisasi', 'matrixTerbobot', 
            'solusiIdealPositif', 'solusiIdealNegatif', 'jarakPositif', 
            'jarakNegatif', 'nilaiPreferensi'
        ));
    }

    private function hitungPembagi($penilaians, $kriterias)
    {
        $pembagi = [];
        foreach ($kriterias as $kriteria) {
            $sum = 0;
            foreach ($penilaians as $penilaian) {
                if ($penilaian->kriteria_id == $kriteria->id) {
                    $sum += pow($penilaian->nilai, 2);
                }
            }
            $pembagi[$kriteria->id] = sqrt($sum);
        }
        return $pembagi;
    }

    private function normalisasiMatriks($penilaians, $pembagi)
    {
        $matrixNormalisasi = [];
        foreach ($penilaians as $penilaian) {
            $matrixNormalisasi[$penilaian->alternatif_id][$penilaian->kriteria_id] = $penilaian->nilai / $pembagi[$penilaian->kriteria_id];
        }
        return $matrixNormalisasi;
    }

    private function normalisasiTerbobot($matrixNormalisasi, $kriterias)
    {
        $matrixTerbobot = [];
        foreach ($matrixNormalisasi as $alternatifId => $nilaiKriteria) {
            foreach ($nilaiKriteria as $kriteriaId => $nilai) {
                $bobot = $kriterias->find($kriteriaId)->bobot;
                $matrixTerbobot[$alternatifId][$kriteriaId] = $nilai * $bobot;
            }
        }
        return $matrixTerbobot;
    }

    private function hitungAplusAminus($matrixTerbobot, $kriterias)
    {
        $solusiIdealPositif = [];
        $solusiIdealNegatif = [];
        foreach ($kriterias as $kriteria) {
            $nilai = array_column($matrixTerbobot, $kriteria->id);
            if ($kriteria->tipe_kriteria == 'benefit') {
                $solusiIdealPositif[$kriteria->id] = max($nilai);
                $solusiIdealNegatif[$kriteria->id] = min($nilai);
            } else { // cost
                $solusiIdealPositif[$kriteria->id] = min($nilai);
                $solusiIdealNegatif[$kriteria->id] = max($nilai);
            }
        }
        return [$solusiIdealPositif, $solusiIdealNegatif];
    }

    private function hitungDplusDminus($matrixTerbobot, $solusiIdealPositif, $solusiIdealNegatif)
    {
        $jarakPositif = [];
        $jarakNegatif = [];
        foreach ($matrixTerbobot as $alternatifId => $nilaiKriteria) {
            $jarakPositif[$alternatifId] = sqrt(array_sum(array_map(function($a, $b) { return pow($a - $b, 2); }, $nilaiKriteria, $solusiIdealPositif)));
            $jarakNegatif[$alternatifId] = sqrt(array_sum(array_map(function($a, $b) { return pow($a - $b, 2); }, $nilaiKriteria, $solusiIdealNegatif)));
        }
        return [$jarakPositif, $jarakNegatif];
    }

    private function hitungNilaiPreferensi($jarakPositif, $jarakNegatif)
    {
        $nilaiPreferensi = [];
        foreach ($jarakPositif as $alternatifId => $nilai) {
            $nilaiPreferensi[$alternatifId] = $jarakNegatif[$alternatifId] / ($jarakPositif[$alternatifId] + $jarakNegatif[$alternatifId]);
        }
        arsort($nilaiPreferensi);
        return $nilaiPreferensi;
    }
}
