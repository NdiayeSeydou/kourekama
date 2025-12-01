@extends('layout_dashboard')
@section('title', 'Bienvenue | Kourekama')
@section('text', 'Tableau de bord')
@section('suite')
    <div class="app-container">

        <!-- App header starts -->
        <div class="app-header d-flex align-items-center">

            <!-- Toggle buttons starts -->

            <!-- Toggle buttons ends -->

            <!-- App brand sm starts -->
            <div class="app-brand-sm d-lg-none d-flex">

                <!-- Logo sm starts -->
                <a href="{{ route('home') }}">
                    <img src="{{ asset('kourekama/assets/images/logo-sm.svg') }}" class="logo" alt="Bootstrap Gallery">
                </a>
                <!-- Logo sm end -->

            </div>
            <!-- App brand sm ends -->

            <!-- Page title starts -->

            <!-- Page title ends -->

            <!-- App header actions starts -->

            <!-- App header actions ends -->

        </div>
        <!-- App header ends -->

        <!-- App body starts -->
        <!-- Row starts -->
        <div class="row gx-4 mt-4">
            <div class="col-xl-12 col-sm-12">
                <!-- Card start -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Dernières ventes</h5>
                    </div>
                    <div class="card-body">

                        <!-- Table start -->
                        <div class="table-outer">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Nom du produit</th>
                                            <th>Quantité</th>
                                            <th>Prix unitaire</th>
                                            <th>Prix total</th>
                                            <th>Date</th>
                                          
                                        </tr>
                                    </thead>

                                   <tbody>
                                        @forelse($products as $index => $produit)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @php
                                                        $productImage = $produit->image ?? null;
                                                        $stockImage = $produit->stock->image ?? null;
                                                    @endphp

                                                    @if ($productImage && Storage::disk('public')->exists($productImage))
                                                        <img src="{{ asset('storage/' . $productImage) }}"
                                                            alt="{{ $produit->nom_produit }}" class="img-3x rounded-1">
                                                    @elseif ($produit->stock && $stockImage && Storage::disk('public')->exists($stockImage))
                                                        <img src="{{ asset('storage/' . $stockImage) }}"
                                                            alt="{{ $produit->nom_produit }}" class="img-3x rounded-1">
                                                    @endif
                                                </td>

                                                <td>{{ $produit->nom_produit }}</td>
                                                <td>{{ $produit->quantite }}</td>
                                                <td>{{ number_format($produit->prix_unitaire, 0, ',', ' ') }}
                                                    FCFA</td>
                                                <td>{{ number_format($produit->prix_total, 0, ',', ' ') }}
                                                    FCFA</td>
                                                <td>
                                                    @if(!empty($produit->date))
                                                        {{ \Carbon\Carbon::parse($produit->date)->format('d/m/Y') }}
                                                    @endif
                                                </td>
                                               
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Aucune vente
                                                    enregistrée.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>


                            </div>
                        </div>
                        <!-- Table end -->

                        <!-- Pagination -->
                        <nav>
                            <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
                        </nav>

                    </div>
                </div>
                <!-- Card end -->
            </div>
        </div>









        <!-- App body ends -->

        <!-- App footer starts -->

        <!-- App footer ends -->

    </div>



@endsection
