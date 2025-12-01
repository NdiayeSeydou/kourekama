@extends('layout_stock')
@section('title', 'Modifier une entrée de stock')
@section('text','Modifier une entrée')
@section('suite')

<div class="app-body">
    <div class="row gx-4 mt-4 justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Modifier l'entrée</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.stocks.entry.update', Crypt::encrypt($entry->id)) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                

                                <div class="mb-3">
                                    <label class="form-label">Quantité entrée</label>
                                    <input type="number" name="quantite_entree" value="{{ old('quantite_entree', $entry->quantite_entree) }}" class="form-control" min="0" required>
                                </div>

                               
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="date" class="form-control" value="{{ old('date', optional($entry->date) ? date('Y-m-d', strtotime($entry->date)) : '') }}">
                                </div>

                               

                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('admin.stocks.show', Crypt::encrypt($entry->id)) }}" class="btn btn-secondary me-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
