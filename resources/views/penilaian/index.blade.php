@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Penilaian Alternatif') }}</h1>

    @if (session('toast_success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('toast_success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Penilaian</h6>
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#createPenilaianModal">Tambah Penilaian</button>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Alternatif</th>
                        @foreach($kriterias as $kriteria)
                            <th>{{ $kriteria->nama_kriteria }}</th>
                        @endforeach
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alternatifs as $alternatif)
                        <tr>
                            <td>{{ $alternatif->nama }}</td>
                            @foreach($kriterias as $kriteria)
                                <td>{{ optional($penilaians->where('alternatif_id', $alternatif->id)->where('kriteria_id', $kriteria->id)->first())->nilai }}</td>
                            @endforeach
                            <td>
                                <button class="btn btn-warning" data-toggle="modal" data-target="#editPenilaianModal{{ $alternatif->id }}">Edit</button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editPenilaianModal{{ $alternatif->id }}" tabindex="-1" role="dialog" aria-labelledby="editPenilaianModalLabel{{ $alternatif->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editPenilaianModalLabel{{ $alternatif->id }}">Edit Penilaian {{ $alternatif->nama }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('penilaian.update', $alternatif->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="alternative_id" value="{{ $alternatif->id }}">
                                            @foreach($kriterias as $kriteria)
                                                <div class="form-group">
                                                    <label for="kriteria_{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</label>
                                                    <input type="number" class="form-control" id="kriteria_{{ $kriteria->id }}" name="{{ $kriteria->id }}" value="{{ optional($penilaians->where('alternatif_id', $alternatif->id)->where('kriteria_id', $kriteria->id)->first())->nilai }}" required>
                                                </div>
                                            @endforeach
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createPenilaianModal" tabindex="-1" role="dialog" aria-labelledby="createPenilaianModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPenilaianModalLabel">Tambah Penilaian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penilaian.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="alternative_id">Alternatif</label>
                            <select class="form-control" id="alternative_id" name="alternative_id" required>
                                @foreach($alternatifs as $alternatif)
                                    <option value="{{ $alternatif->id }}">{{ $alternatif->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @foreach($kriterias as $kriteria)
                            <div class="form-group">
                                <label for="kriteria_{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</label>
                                <input type="number" class="form-control" id="kriteria_{{ $kriteria->id }}" name="{{ $kriteria->id }}" required>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
