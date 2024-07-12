@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Perhitungan TOPSIS') }}</h1>

    <!-- Matriks Normalisasi -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Matriks Normalisasi</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
                            @foreach ($kriterias as $kriteria)
                                <th>{{ $kriteria->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matrixNormalisasi as $altId => $nilai)
                            <tr>
                                <td>{{ $alternatifs->find($altId)->nama }}</td>
                                @foreach ($kriterias as $kriteria)
                                    <td>{{ number_format($nilai[$kriteria->id], 4) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Matriks Normalisasi Terbobot -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Matriks Normalisasi Terbobot</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
                            @foreach ($kriterias as $kriteria)
                                <th>{{ $kriteria->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matrixTerbobot as $altId => $nilai)
                            <tr>
                                <td>{{ $alternatifs->find($altId)->nama }}</td>
                                @foreach ($kriterias as $kriteria)
                                    <td>{{ number_format($nilai[$kriteria->id], 4) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Solusi Ideal Positif -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Solusi Ideal Positif</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach ($kriterias as $kriteria)
                                <th>{{ $kriteria->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($solusiIdealPositif as $kriteriaId => $nilai)
                                <td>{{ number_format($nilai, 4) }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Solusi Ideal Negatif -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Solusi Ideal Negatif</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach ($kriterias as $kriteria)
                                <th>{{ $kriteria->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($solusiIdealNegatif as $kriteriaId => $nilai)
                                <td>{{ number_format($nilai, 4) }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Jarak Solusi Ideal Positif -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Jarak Solusi Ideal Positif</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
                            @foreach ($kriterias as $kriteria)
                                <th>{{ $kriteria->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jarakPositif as $altId => $nilai)
                            <tr>
                                <td>{{ $alternatifs->find($altId)->nama }}</td>
                                @foreach ($kriterias as $kriteria)
                                    <td>{{ number_format($nilai, 4) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Jarak Solusi Ideal Negatif -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Jarak Solusi Ideal Negatif</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
                            @foreach ($kriterias as $kriteria)
                                <th>{{ $kriteria->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jarakNegatif as $altId => $nilai)
                            <tr>
                                <td>{{ $alternatifs->find($altId)->nama }}</td>
                                @foreach ($kriterias as $kriteria)
                                    <td>{{ number_format($nilai, 4) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Nilai Preferensi dan Perankingan -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>Nilai Preferensi dan Perankingan</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Alternatif</th>
                            <th>Nilai Preferensi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $rank = 1; @endphp
                        @foreach ($nilaiPreferensi as $altId => $nilai)
                            <tr>
                                <td>{{ $rank++ }}</td>
                                <td>{{ $alternatifs->find($altId)->nama }}</td>
                                <td>{{ number_format($nilai, 4) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
