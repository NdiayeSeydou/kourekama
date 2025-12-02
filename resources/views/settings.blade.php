@extends('layout_settings')
@section('title', 'Paramétre | Kourekama')
@section('suite')

<div class="app-body">

    <!-- Formulaire unique pour tout -->
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('POST')

        <!-- Row starts -->
        <div class="row gx-4">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Tabs start -->
                        <div class="custom-tabs-container">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA"
                                        role="tab" aria-controls="oneA" aria-selected="true"><i
                                            class="bi bi-person me-2"></i> Informations personnelles
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="tab-fourA" data-bs-toggle="tab" href="#fourA"
                                        role="tab" aria-controls="fourA" aria-selected="false"><i
                                            class="bi bi-eye-slash me-2"></i>Modification du mot de passe
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="tab-fourB" data-bs-toggle="tab" href="#fourB"
                                        role="tab" aria-controls="fourB" aria-selected="false"><i
                                            class="bi bi-eye-slash me-2"></i>Code PIN
                                    </a>
                                </li>
                            </ul>
                            <!-- Nav tabs end -->

                            <!-- Tab content -->
                            <div class="tab-content h-300 mt-3">

                                <!-- Infos personnelles -->
                                <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                    <div class="row gx-4">
                                        <div class="col-sm-3 col-12">
                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Nom Complet</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                    <input type="text" name="name"
                                                        value="{{ old('name', auth()->user()->name) }}"
                                                        class="form-control" id="fullName" placeholder="Votre nom"
                                                        required>
                                                </div>
                                                @error('name')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-12">
                                            <div class="mb-3">
                                                <label for="yourEmail" class="form-label">Email</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                    <input type="email" name="email"
                                                        value="{{ old('email', auth()->user()->email) }}"
                                                        class="form-control" id="yourEmail" placeholder="Votre email"
                                                        required>
                                                </div>
                                                @error('email')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-3 col-12">
                                            @if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'level'))
                                                <div class="mb-3">
                                                    <label for="level" class="form-label">Niveau</label>
                                                    <select name="level" id="level" class="form-select">
                                                        <option value="">-- Choisir --</option>
                                                        <option value="user"
                                                            {{ old('level', auth()->user()->level ?? '') == 'user' ? 'selected' : '' }}>
                                                            Utilisateur</option>
                                                        <option value="admin"
                                                            {{ old('level', auth()->user()->level ?? '') == 'admin' ? 'selected' : '' }}>
                                                            Administrateur</option>
                                                    </select>
                                                    @error('level')
                                                        <div class="text-danger small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-12">
                                            @if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'confirmed'))
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="confirmed"
                                                        value="1" id="confirmed"
                                                        {{ old('confirmed', auth()->user()->confirmed ?? false) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="confirmed">Confirmé</label>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <!-- Mot de passe -->
                                <div class="tab-pane fade" id="fourA" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label" for="current_password">Mot de passe actuel</label>
                                        <input type="password" name="current_password" class="form-control"
                                            placeholder="Entrez votre mot de passe actuel">
                                        @error('current_password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="new_password">Nouveau mot de passe</label>
                                        <input type="password" name="new_password" class="form-control"
                                            placeholder="Entrez votre nouveau mot de passe">
                                        @error('new_password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="new_password_confirmation">Confirmer</label>
                                        <input type="password" name="new_password_confirmation" class="form-control"
                                            placeholder="Confirmer votre nouveau mot de passe">
                                    </div>
                                </div>

                                <!-- Code PIN -->
                                <div class="tab-pane fade" id="fourB" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label" for="current_pin">Code PIN actuel</label>
                                        <input type="password" name="current_pin" class="form-control"
                                            placeholder="Entrez votre code PIN actuel">
                                        @error('current_pin')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="new_pin">Nouveau code PIN</label>
                                        <input type="password" name="new_pin" class="form-control"
                                            placeholder="Entrez votre nouveau code PIN">
                                        @error('new_pin')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="new_pin_confirmation">Confirmer</label>
                                        <input type="password" name="new_pin_confirmation" class="form-control"
                                            placeholder="Confirmer votre nouveau code PIN">
                                    </div>
                                </div>

                            </div>
                            <!-- Tab content end -->

                        </div>
                        <!-- Tabs end -->

                        <!-- Boutons -->
                        <div class="d-flex gap-2 justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Annuler</button>
                        </div>

                        @if (session('success'))
                            <div class="text-success mt-2">{{ session('success') }}</div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

    </form>

</div>

@endsection
