@extends('layout_stock')
@section('title', 'Modfifier un stock | Kourekama')
@section('text','Modifier un stocks')
@section('suite')

    <div class="app-body">

        <!-- Row starts -->

        <div class="row gx-4 mt-4">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title"><i class="bi bi-pencil-square me-2"></i>Modifier le stock
                        </h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.stocks.update.post', Crypt::encrypt($stock->id)) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nom du produit</label>
                                        <input type="text" name="nom_produit" value="{{ $stock->nom_produit }}" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Quantité entrée</label>
                                        <input type="number" name="quantite_entree" value="{{ $stock->quantite_entree }}" class="form-control" min="0">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Prix unitaire (FCFA)</label>
                                        <input type="number" name="prix_unitaire" value="{{ $stock->prix_unitaire }}" class="form-control" min="0">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control" value="{{ old('date', optional($stock->date) ? date('Y-m-d', strtotime($stock->date)) : '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>

                                    @if ($stock->image)
                                        <div class="mb-3">
                                            <label class="form-label">Image actuelle</label>
                                            <div>
                                                <img src="{{ asset('storage/' . $stock->image) }}" class="img-thumbnail" style="max-width:180px;">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-primary">Mettre à jour</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <!-- Row ends -->
        <!-- Row ends -->

    </div>


@endsection
