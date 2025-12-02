@extends('layout_stock')
@section('title', 'Créer un nouveau stock')
@section('text', 'Ajouter un stock')
@section('suite')

    <div class="app-body">

        <!-- Row starts -->
        <div class="row gx-4 mt-4">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title"><i class="bi bi-box-seam me-2"></i>Créer un nouveau stock
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="stock-form" action="{{ route('admin.stocks.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Stock Items -->
                            <div class="card border mb-4">
                                <div class="card-header bg-primary-subtle"></div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" id="stock-items">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Image</th>
                                                    <th>Nom du produit</th>
                                                    <th>Quantité entrée</th>
                                                    <th>Prix unitaire (FCFA)</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>

                                                    <td>
                                                        <input type="date" name="date[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ now()->format('Y-m-d') }}">
                                                    </td>

                                                    <td>
                                                        <input type="file" name="images[]"
                                                            class="form-control form-control-sm" accept="image/*">
                                                        <small class="text-danger error-message d-none"></small>
                                                    </td>

                                                    <td>
                                                        <input type="text" name="nom_produit[]"
                                                            class="form-control form-control-sm"
                                                            placeholder="Nom du produit" required>
                                                        <small class="text-danger error-message d-none"></small>
                                                    </td>

                                                    <td>
                                                        <input type="number" name="quantite_entree[]"
                                                            class="form-control form-control-sm qty" value="1"
                                                            min="1" required>
                                                        <small class="text-danger error-message d-none"></small>
                                                    </td>

                                                    <td>
                                                        <input type="number" name="prix_unitaire[]"
                                                            class="form-control form-control-sm unit-price" value="0"
                                                            min="0" required>
                                                        <small class="text-danger error-message d-none"></small>
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
                                        <i class="bi bi-plus-circle me-1"></i>Ajouter un autre produit
                                    </button>
                                </div>
                            </div>

                            <!-- Submit -->
                          
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                   <i class="bi bi-save me-1"></i>Enregistrer le
                                    stock
                                </button>
                                <button type="button" class="btn btn-secondary"
                                    onclick="window.history.back();">Annuler</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gx-4 mt-4">

            <div class="col-12">
                <div class="card mb-4 border-primary">
                    <div class="card-header bg-primary-subtle">
                        <h5 class="card-title"><i class="bi bi-pencil-square me-2"></i>Ajouter une entrée
                            à un stock existant</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.stocks.addquantite') }}" method="POST">
                            @csrf

                            @method('PUT')

                            <div class="mb-3">
                                <label for="stock_id" class="form-label">Sélectionnez le produit</label>
                                <select id="stock_id" name="stock_id" class="form-select" required>
                                    <option value="">-- Choisir un produit --</option>
                                    @foreach ($stocks as $stock)
                                        <option value="{{ $stock->id }}">
                                            {{ $stock->nom_produit }} (Quantité restante:
                                            {{ $stock->quantite_entree - $stock->quantite_sortie }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="quantite_entree" class="form-label">Quantité ajoutée</label>
                                <input type="number" id="quantite_entree" name="quantite_entree" class="form-control"
                                    min="1" value="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="date_add" class="form-label">Date</label>
                                <input type="date" id="date_add" name="date" class="form-control"
                                    value="{{ now()->format('Y-m-d') }}">
                            </div>


                            <div class="card-footer d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Mettre à jour le stock
                                </button>
                                <button type="button" class="btn btn-secondary"
                                    onclick="window.history.back();">Annuler</button>
                            </div>

                        </form>
                    </div>



                    <!-- JS pour ajouter/supprimer dynamiquement des lignes -->


                    <script>
                        document.addEventListener('DOMContentLoaded', function() {

                            const addBtn = document.getElementById('add-item');
                            const tbody = document.querySelector('#stock-items tbody');

                            // Vérifie si une ligne est entièrement remplie
                            function validateRow(row) {
                                let valid = true;
                                let inputs = row.querySelectorAll("input");

                                inputs.forEach(input => {
                                    let errorBox = input.parentNode.querySelector(".error-message");
                                    errorBox.classList.add("d-none");

                                    if (input.hasAttribute("required") && !input.value.trim()) {
                                        errorBox.textContent = "Ce champ est obligatoire.";
                                        errorBox.classList.remove("d-none");
                                        valid = false;
                                    }

                                    if (input.type === "number" && input.value < 1) {
                                        errorBox.textContent = "Valeur invalide.";
                                        errorBox.classList.remove("d-none");
                                        valid = false;
                                    }
                                });

                                return valid;
                            }

                            // Ajout de ligne (ne bloque plus si la dernière est vide)
                            addBtn.addEventListener('click', () => {

                                const rowCount = tbody.rows.length + 1;
                                const tr = document.createElement('tr');

                                tr.innerHTML = `
            <td>${rowCount}</td>
            <td>
                <input type="date" name="date[]" class="form-control form-control-sm">
            </td>
            <td>
                <input type="file" name="images[]" class="form-control form-control-sm" accept="image/*">
                <small class="text-danger error-message d-none"></small>
            </td>
            <td>
                <input type="text" name="nom_produit[]" class="form-control form-control-sm" placeholder="Nom du produit" required>
                <small class="text-danger error-message d-none"></small>
            </td>
            <td>
                <input type="number" name="quantite_entree[]" class="form-control form-control-sm qty" value="1" min="1" required>
                <small class="text-danger error-message d-none"></small>
            </td>
            <td>
                <input type="number" name="prix_unitaire[]" class="form-control form-control-sm unit-price" value="0" min="0" required>
                <small class="text-danger error-message d-none"></small>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

                                tbody.appendChild(tr);

                                // set default date (YYYY-MM-DD) for the new row
                                const dateInput = tr.querySelector('input[type="date"]');
                                if (dateInput) {
                                    const now = new Date();
                                    const yyyy = now.getFullYear();
                                    const mm = String(now.getMonth() + 1).padStart(2, '0');
                                    const dd = String(now.getDate()).padStart(2, '0');
                                    dateInput.value = `${yyyy}-${mm}-${dd}`;
                                }

                                attachEvents(tr);
                            });

                            // Suppression + réindexation
                            function attachEvents(tr) {
                                tr.querySelector('.remove-row').addEventListener('click', () => {
                                    if (tbody.rows.length === 1) {
                                        alert("Vous ne pouvez pas supprimer la seule ligne !");
                                        return;
                                    }
                                    tr.remove();

                                    Array.from(tbody.rows).forEach((row, idx) => {
                                        row.cells[0].textContent = idx + 1;
                                    });
                                });
                            }

                            // Attacher les events à la première ligne
                            Array.from(tbody.rows).forEach(tr => attachEvents(tr));

                        });
                    </script>

                    {{-- -mettre a jour un stock  --}}



                    <!-- Row ends -->

                </div>
                <!-- App body ends -->

                <!-- App footer starts -->

                <!-- App footer ends -->

            </div>
            <!-- App container ends -->

        </div>
        <!-- Main container ends -->

    </div>
@endsection
