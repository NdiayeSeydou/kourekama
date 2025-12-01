@extends('layout')
@section('title', 'Détails de la vente | Kourekama')
@section('text','Consulter une vente')
@section('suite')

    <div class="app-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Détails de la vente</h4>
            <div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm me-2">Retour</a>
                <a href="{{ route('admin.products.edit', Crypt::encrypt($produit->id)) }}" class="btn btn-primary btn-sm">Modifier</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        @php
                            $productImage = $produit->image ?? null;
                            $stockImage = optional($produit->stock)->image ?? null;
                        @endphp

                        <div class="border rounded p-2 text-center bg-light">
                            @if ($productImage && Storage::disk('public')->exists($productImage))
                                <img src="{{ asset('storage/' . $productImage) }}" class="img-fluid" alt="{{ $produit->nom_produit }}">
                            @elseif ($stockImage && Storage::disk('public')->exists($stockImage))
                                <img src="{{ asset('storage/' . $stockImage) }}" class="img-fluid" alt="{{ $produit->nom_produit }}">
                            @else
                                <div class="py-5">Pas d'image</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <h5 class="mb-1">{{ $produit->nom_produit }}</h5>
                            @if(!empty($produit->date))
                                <small class="text-muted">Vendu le {{ \Carbon\Carbon::parse($produit->date)->format('d/m/Y') }}</small>
                            @else
                                <small class="text-muted">Vente enregistrée</small>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-2"><strong>Quantité :</strong> {{ $produit->quantite }}</div>
                                <div class="mb-2"><strong>Prix unitaire :</strong> {{ number_format($produit->prix_unitaire, 0, ',', ' ') }} FCFA</div>
                                <div class="mb-2"><strong>Prix total :</strong> {{ number_format($produit->prix_total, 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div class="col-sm-6">
                                @if ($produit->stock)
                                    @php
                                        $qtyRemaining = $produit->stock->quantite_entree - $produit->stock->quantite_sortie;
                                    @endphp
                                    <div class="mb-2"><strong>Stock disponible :</strong> {{ $qtyRemaining }}</div>
                                    <div class="mb-2"><strong>Quantité entrée :</strong> {{ $produit->stock->quantite_entree }}</div>
                                    <div class="mb-2"><strong>Quantité sortie :</strong> {{ $produit->stock->quantite_sortie }}</div>
                                @else
                                    <div class="mb-2">Aucun stock associé</div>
                                @endif
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
