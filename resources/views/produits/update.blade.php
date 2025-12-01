@extends('layout')
@section('title', 'Modifier une vente | Kourekama')
@section('text','Modifier une vente')
@section('suite')

    <div class="row gx-4 mt-4">
        <div class="col-12">
            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-pencil-square me-2"></i>Modifier la vente
                    </h5>
                </div>

                <div class="card-body">

                    {{-- FORMULAIRE --}}
                    <form action="{{ route('admin.products.update', Crypt::encrypt($produit->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card border mb-4">
                            <div class="card-header bg-primary-subtle">
                                <h5 class="card-title">Détails du produit</h5>
                            </div>
                            <div class="card-body">

                                <table class="table">
                                    <tr>
                                        <th>Nom du produit</th>
                                        <td>

                                            <input type="text" class="form-control" value="{{ $produit->nom_produit }}"
                                                disabled>

                                            <!-- On envoie quand même la valeur au controller via hidden -->
                                            <input type="hidden" name="nom_produit" value="{{ $produit->nom_produit }}">
                                        </td>
                                    </tr>


                                    <tr>
                                        <th>Quantité</th>
                                        <td>
                                            <input type="number" name="quantite" class="form-control"
                                                value="{{ old('quantite', $produit->quantite) }}" min="1">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Prix unitaire</th>
                                        <td>
                                            <input type="number" name="prix_unitaire" class="form-control"
                                                value="{{ old('prix_unitaire', $produit->prix_unitaire) }}" min="0">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Image</th>
                                        <td>
                                            <input type="file" name="image" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>
                                            <input type="date" name="date" class="form-control"
                                                value="{{ old('date', optional($produit->date) ? date('Y-m-d', strtotime($produit->date)) : '') }}">
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>

                        <button class="btn btn-primary">Mettre à jour la vente</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection
