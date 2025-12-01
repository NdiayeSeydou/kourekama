@extends('layout')
@section('title','Enregistré une vente')
@section('text','Ajouter une vente | Kourekama')
@section('suite')
    <div class="app-body">

        <!-- Row starts -->

        <div class="row gx-4 mt-4">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-receipt-cutoff me-2"></i>Créer une nouvelle vente
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Formulaire pour enregistrer plusieurs ventes -->
                        <form action="{{ route('admin.products.store') }}" method="POST">
                            @csrf

                            <div class="card border mb-4">
                                <div class="card-header bg-primary-subtle">
                                    <h5>Nouvelle vente</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" id="invoice-items">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Nom du produit</th>
                                                    <th>Quantité</th>
                                                    <th>Prix unitaire (FCFA)</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <img src="" class="preview-img" width="50">
                                                    </td>
                                                    <td>
                                                        <select name="nom_produit[]"
                                                            class="form-control form-control-sm product-select">
                                                            <option value="">-- Choisir un produit --
                                                            </option>
                                                            @foreach ($stocks as $stock)
                                                                <option value="{{ $stock->nom_produit }}"
                                                                    data-price="{{ $stock->prix_unitaire }}"
                                                                    data-image="{{ asset('storage/' . $stock->image) }}">
                                                                    {{ $stock->nom_produit }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="quantite[]"
                                                            class="form-control form-control-sm qty" value="1"
                                                            min="1">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="prix_unitaire[]"
                                                            class="form-control form-control-sm unit-price" value="0"
                                                            min="0">
                                                    </td>
                                                    <td>
                                                        <input type="date" name="date[]" class="form-control form-control-sm" value="{{ now()->format('Y-m-d') }}">
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger remove-row">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-item">
                                        <i class="bi bi-plus-circle me-1"></i>Ajouter une autre vente
                                    </button>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Enregistrer toutes les
                                        ventes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script pour gérer le tableau dynamique -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tbody = document.querySelector('#invoice-items tbody');

                // Fonction pour re-numéroter les lignes
                function updateRowNumbers() {
                    document.querySelectorAll('#invoice-items tbody tr').forEach((tr, index) => {
                        tr.querySelector('td:first-child').textContent = index + 1;
                    });
                }

                    // Ajout d'une ligne
                document.getElementById('add-item').addEventListener('click', function() {
                    let firstRow = tbody.querySelector('tr');
                    let newRow = firstRow.cloneNode(true);

                    // Réinitialiser valeurs des inputs et image
                    newRow.querySelector('.preview-img').src = '';
                    newRow.querySelector('.qty').value = 1;
                    newRow.querySelector('.unit-price').value = 0;
                    newRow.querySelector('.product-select').selectedIndex = 0;
                    const dateInput = newRow.querySelector('input[name="date[]"]');
                    if (dateInput) {
                        dateInput.value = new Date().toISOString().slice(0,10);
                    }

                    tbody.appendChild(newRow);
                    updateRowNumbers();
                });

                // Suppression d'une ligne
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-row')) {
                        let rows = document.querySelectorAll('#invoice-items tbody tr');
                        if (rows.length > 1) {
                            e.target.closest('tr').remove();
                            updateRowNumbers();
                        }
                    }
                });

                // Changement de produit : mettre à jour image et prix
                document.addEventListener('change', function(e) {
                    if (e.target.classList.contains('product-select')) {
                        let option = e.target.selectedOptions[0];
                        let row = e.target.closest('tr');
                        let price = option.dataset.price || 0;
                        let image = option.dataset.image || '';

                        row.querySelector('.unit-price').value = price;
                        row.querySelector('.preview-img').src = image;
                    }
                });
            });
        </script>



        <!-- Row ends -->

    </div>
@endsection
