@extends('layout_stock')
@section('title', 'Consulter le stock et les details | Kourekama')
@section('text','Consulter un stock')
@section('suite')


    <div class="container mt-4">

        <!-- DÉTAILS DE LA VENTE -->
        <div class="card shadow-sm mb-4">

            <div class="card-header bg-primary text-white d-flex align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-receipt me-2"></i>Détails de la vente
                </h5>
            </div>

            <div class="card-body">

                <!-- IMAGE DU PRODUIT -->
                <div class="text-center mb-4">
                    @php
                        $stockImage = $stock->image ?? null;
                    @endphp

                    @if ($stockImage && Storage::disk('public')->exists($stockImage))
                        <img src="{{ asset('storage/' . $stockImage) }}" class="img-fluid rounded shadow-sm"
                            alt="{{ $stock->nom_produit }}" style="max-height: 300px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x300?text=Image+du+Produit"
                            class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
                    @endif
                </div>

                <!-- INFORMATIONS -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nom du produit :</label>
                        <div class="p-2 border rounded bg-light">
                            <span>{{ $stock->nom_produit }}</span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Date d'entrée:</label>
                        <div class="p-2 border rounded bg-light">
                            <span>
                                @if (!empty($stock->date))
                                    {{ \Carbon\Carbon::parse($stock->date)->format('d/m/Y') }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Quantité entrée :</label>
                        <div class="p-2 border rounded bg-light">
                            <span>{{ $stock->quantite_entree }}</span>
                        </div>
                    </div>
                </div>

                <!-- PRIX -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Prix unitaire :</label>
                        <div class="p-2 border rounded bg-light">
                            <span>{{ $stock->prix_unitaire }}</span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Prix total :</label>
                        <div class="p-2 border rounded bg-light">
                            <span>{{ $stock->prix_total }}</span>
                        </div>
                    </div>


                </div>

                <!-- BOUTON RETOUR -->
                <div class="d-flex justify-content-start mt-4">
                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left-circle me-1"></i>Retour
                    </a>
                </div>
                

            </div>
        </div>


        <!-- LISTE DES VENTES LIÉES -->
        <h4 class="mb-3">Historique des entrées du produit</h4>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Quantité entrée</th>

                    <th style="width: 220px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $grouped = $entries->groupBy(function ($item) {
                        return $item->date ? \Carbon\Carbon::parse($item->date)->format('Y-m-d') : 'Sans date';
                    });
                @endphp

                @foreach ($grouped as $day => $entriesByDay)
                    <tr>
                        <td>{{ $day != 'Sans date' ? \Carbon\Carbon::parse($day)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $entriesByDay->sum('quantite_entree') }}</td>
                        <td>
                            @foreach ($entriesByDay as $entry)
                                <a href="{{ route('admin.stocks.entry.edit', Crypt::encrypt($entry->id)) }}"
                                    class="btn btn-sm btn-warning me-1">Modifier</a>

                                {{-- <form action="{{ route('admin.stocks.entry.delete', Crypt::encrypt($entry->id)) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form> --}}
                            @endforeach
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>



@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-edit').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var target = document.querySelector(this.getAttribute('data-target'));
                    if (!target) return;
                    // basculer l'affichage
                    if (target.classList.contains('d-none')) {
                        target.classList.remove('d-none');
                    } else {
                        target.classList.add('d-none');
                    }
                    // scroller vers le formulaire
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                });
            });
        });
    </script>




@endsection
