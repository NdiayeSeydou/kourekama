@extends('layout_stock')
@section('title', ' Ajouter une entrée de stock')
@section('text','Listes des stocks')
@section('suite')

    <div class="app-body">

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-lg" onclick="window.location.href='{{ route('admin.stocks.create') }}'">
                Ajouter une entrée de stock
            </button>

        </div>

        <div class="row gx-4 mt-4">
            <div class="col-xl-12 col-sm-12">
                <!-- Card start -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Liste des stocks</h5>
                    </div>
                    <div class="card-body">

                        <!-- Table start -->
                        <div class="table-outer">
                            <div class="table-responsive">
                                <table class="table truncate align-middle" id="salesTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Image</th>
                                            <th>Nom du produit</th>
                                            <th>Quantité entrée</th>
                                            <th>Quantité sortie</th>
                                            <th>Quantité restante</th>
                                            <th>Prix unitaire (FCFA)</th>
                                            <th>Prix total (FCFA)</th>
                                            <th>Alertes stock</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($stocks as $index => $stock)
                                            @php
                                                $qtyRemaining = $stock->quantite_entree - $stock->quantite_sortie;
                                                $threshold = 5;

                                                // Gestion des alertes
                                                if ($qtyRemaining <= 0) {
                                                    $alertMessage =
                                                        '<span class="text-danger fw-bold">Produit fini</span>';
                                                } elseif ($qtyRemaining < $threshold) {
                                                    $alertMessage =
                                                        '<span class="text-warning fw-bold">Stock faible</span>';
                                                } else {
                                                    $alertMessage = '';
                                                }

                                                // Vérifier si l'image existe réellement
                                                                                $hasImage =
                                                                                    $stock->image && Storage::disk('public')->exists($stock->image);
                                            @endphp

                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if (!empty($stock->date))
                                                        {{ \Carbon\Carbon::parse($stock->date)->format('d/m/Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                @php
                                                    $hasImage =
                                                        $stock->image && Storage::disk('public')->exists($stock->image);
                                                @endphp

                                                <td>
                                                    @if ($hasImage)
                                                        <img src="{{ asset('storage/' . $stock->image) }}"
                                                            alt="{{ $stock->nom_produit }}" class="img-fluid rounded-1"
                                                            style="max-width: 80px; max-height: 80px; object-fit: contain;">
                                                    @endif
                                                </td>


                                                <td>{{ strlen($stock->nom_produit) > 20 ? substr($stock->nom_produit, 0, 20) . '...' : $stock->nom_produit }}
                                                </td>


                                                <td>{{ $stock->quantite_entree }}</td>

                                                <td>{{ $stock->quantite_sortie }}</td>


                                                <td>{{ $qtyRemaining }}</td>

                                                <td>{{ number_format($stock->prix_unitaire, 0, ',', ' ') }}
                                                </td>

                                                <td>{{ number_format($qtyRemaining * $stock->prix_unitaire, 0, ',', ' ') }}
                                                </td>

                                                <td>{!! $alertMessage !!}</td>

                                                <td>
                                                    <a href="{{ route('admin.stocks.show', Crypt::encrypt($stock->id)) }}"
                                                        class="btn btn-sm btn-primary me-1">
                                                        Voir
                                                    </a>


                                                    <a href="{{ route('admin.stocks.update', Crypt::encrypt($stock->id)) }}"
                                                        class="btn btn-sm btn-primary me-1">
                                                        Modifier
                                                    </a>
                                                    <form
                                                        action="{{ route('admin.stocks.destroy', Crypt::encrypt($stock->id)) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center">Aucun stock
                                                    enregistré.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>


                                </table>
                            </div>
                        </div>

                        <!-- Table end -->

                        <!-- Pagination -->
                        <nav>
                            @if ($stocks->hasPages())
                                <div class="border-top d-flex justify-content-between align-items-center px-3 py-2">
                                    <!-- Texte manuel en français -->
                                    <span>
                                        Affichage de {{ $stocks->firstItem() }} à
                                        {{ $stocks->lastItem() }} sur {{ $stocks->total() }} stocks
                                    </span>

                                    <!-- Pagination uniquement, sans texte "Showing ..." -->
                                    <nav>
                                        {{ $stocks->links('pagination::simple-bootstrap-5') }}
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


    </div>

@endsection
