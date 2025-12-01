@extends('layout')
@section('title', 'Liste des produits vendus | Kourekama')
@section('text','Listes des ventes')
@section('suite')

    <div class="app-body">


        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-lg" onclick="window.location.href='{{ route('admin.products.create') }}'">
                Ajouter une vente
            </button>
        </div>


        
            


        <!-- Row starts -->
        <div class="row gx-4 mt-4">
            <div class="col-xl-12 col-sm-12">
                <!-- Card start -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Liste des ventes</h5>
                    </div>
                    <div class="card-body">

                        <!-- Table start -->
                        <div class="table-outer">
                            <div class="table-responsive">
                                <table class="table truncate align-middle" id="salesTable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Nom du produit</th>
                                            <th>Quantité</th>
                                            <th>Prix unitaire</th>
                                            <th>Prix total</th>
                                            <th>Date</th>
                                            <th>Action</th>
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
                                                <td>


                                                    <a href="{{ route('admin.products.show', Crypt::encrypt($produit->id)) }}"
                                                        class="btn btn-sm btn-primary me-1">Voir</a>

                                                    <a href="{{ route('admin.products.edit', Crypt::encrypt($produit->id)) }}"
                                                        class="btn btn-sm btn-primary">Modifier</a>

                                                    <form
                                                        action="{{ route('admin.products.destroy', Crypt::encrypt($produit->id)) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger">Supprimer</button>
                                                    </form>

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
                             @if ($products->hasPages())
                                <div class="border-top d-flex justify-content-between align-items-center px-3 py-2">
                                    <!-- Texte manuel en français -->
                                    <span>
                                        Affichage de {{ $products->firstItem() }} à
                                        {{ $products->lastItem() }} sur {{ $products->total() }} produits
                                    </span>

                                    <!-- Pagination uniquement, sans texte "Showing ..." -->
                                    <nav>
                                        {{ $products->links('pagination::simple-bootstrap-5') }}
                                    </nav>
                                </div>
                            @endif
                        </nav>

                    </div>
                </div>
                <!-- Card end -->
            </div>
        </div>


        <script>
            // Pagination JS
            const table = document.getElementById('salesTable').getElementsByTagName('tbody')[0];
            const rows = Array.from(table.getElementsByTagName('tr'));
            const rowsPerPage = 5;
            let currentPage = 1;
            const totalPages = Math.ceil(rows.length / rowsPerPage);
            const pagination = document.getElementById('pagination');

            function showPage(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                rows.forEach((row, i) => {
                    row.style.display = (i >= start && i < end) ? '' : 'none';
                });
                renderPagination();
            }

            function renderPagination() {
                pagination.innerHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = 'page-item ' + (i === currentPage ? 'active' : '');
                    const a = document.createElement('a');
                    a.className = 'page-link';
                    a.href = '#';
                    a.textContent = i;
                    a.addEventListener('click', (e) => {
                        e.preventDefault();
                        currentPage = i;
                        showPage(currentPage);
                    });
                    li.appendChild(a);
                    pagination.appendChild(li);
                }
            }

            // Afficher la première page au chargement
            showPage(1);
        </script>


        <!-- Row ends -->

    </div>

@endsection
