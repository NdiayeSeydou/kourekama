@extends('layout_settings')
@section('title', 'Paramétre | Kourekama')
@section('suite')

    <div class="app-body">

        <!-- Row starts -->
        <div class="row gx-4">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body">

                        <!-- Custom tabs start -->
                        <div class="custom-tabs-container">

                            <!-- Nav tabs start -->
                            <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA"
                                        role="tab" aria-controls="oneA" aria-selected="true"><i
                                            class="bi bi-person me-2"></i>
                                        Informations personnelles
                                    </a>
                                </li>


                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="tab-fourA" data-bs-toggle="tab" href="#fourA" role="tab"
                                        aria-controls="fourA" aria-selected="false"><i
                                            class="bi bi-eye-slash me-2"></i>Modification du mot de passe
                                    </a>
                                </li>
                            </ul>
                            <!-- Nav tabs end -->

                            <!-- Tab content start -->
                            <div class="tab-content h-300">
                                <div class="tab-pane fade show active" id="oneA" role="tabpanel">

                                    <!-- Row starts -->
                                    <form action="{{ route('admin.settings.update') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                    <div class="row gx-4">
                                        <div class="col-sm-12 col-12">
                                            <div class="card border mb-3">
                                                <div class="card-body">

                                                    <!-- Row starts -->
                                                    <div class="row gx-4">
                                                        <div class="col-sm-3 col-12">

                                                            <!-- Form field start -->
                                                            <div class="mb-3">
                                                                <label for="fullName" class="form-label">Nom Complet</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-person"></i>
                                                                    </span>
                                                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control"
                                                                        id="fullName" placeholder="Votre nom" required>
                                                                </div>
                                                                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                                                            </div>
                                                            <!-- Form field end -->

                                                        </div>
                                                        <div class="col-sm-3 col-12">

                                                            <!-- Form field start -->
                                                            <div class="mb-3">
                                                                <label for="yourEmail" class="form-label">Email</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-envelope"></i>
                                                                    </span>
                                                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control"
                                                                        id="yourEmail" placeholder="Votre email" required>
                                                                </div>
                                                                @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                                                            </div>
                                                            <!-- Form field end -->

                                                        </div>
                                                     
                                                        <div class="col-sm-3 col-12">
                                                            @if(
                                                                \Illuminate\Support\Facades\Schema::hasColumn('users', 'level')
                                                            )
                                                            <div class="mb-3">
                                                                <label for="level" class="form-label">Niveau</label>
                                                                <select name="level" id="level" class="form-select">
                                                                    <option value="">-- Choisir --</option>
                                                                    <option value="user" {{ old('level', auth()->user()->level ?? '') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                                                                    <option value="admin" {{ old('level', auth()->user()->level ?? '') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                                                </select>
                                                                @error('level') <div class="text-danger small">{{ $message }}</div> @enderror
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-12">

                                                            <!-- Form field start -->
                                                            @if(\Illuminate\Support\Facades\Schema::hasColumn('users', 'confirmed'))
                                                            <div class="form-check mb-3">
                                                                <input class="form-check-input" type="checkbox" name="confirmed" value="1" id="confirmed" {{ old('confirmed', auth()->user()->confirmed ?? false) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="confirmed">Confirmé</label>
                                                            </div>
                                                            @endif
                                                            <!-- Form field end -->

                                                        </div>

                                                    </div>
                                                    <!-- Row ends -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row ends -->

                                </div>
                                <div class="tab-pane fade" id="twoA" role="tabpanel">

                                    <!-- Row starts -->
                                    <div class="row gx-5 align-items-center">
                                        <div class="col-sm-4 col-12">
                                            <div class="p-3">
                                                <img src="assets/images/notifications.svg" alt="Notifications"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-12">

                                            <!-- List group start -->
                                            <ul class="list-group mb-4">
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    Desktop Notifications
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="switchOne" checked />
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    Email Notifications
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="switchTwo" checked />
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    Chat Notifications
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="switchThree" checked />
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    New Message
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="switchFour" />
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    New Follower
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="switchFive" />
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    New Review
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="switchSix" />
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    New Order
                                                    <div class="form-check form-switch m-0">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="switchSeven" />
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- List group end -->

                                        </div>

                                    </div>
                                    <!-- Row ends -->

                                </div>
                                <div class="tab-pane fade" id="threeA" role="tabpanel">



                                </div>
                                <div class="tab-pane fade" id="fourA" role="tabpanel">

                                    <!-- Row starts -->
                                    <div class="row align-items-end">

                                        <div class="col-sm-4 col-12">
                                            <div class="card border mb-3">
                                                <div class="card-body">

                                                    <div class="mb-3">
                                                        <label class="form-label" for="current_password">Mot de passe actuel</label>
                                                        <div class="input-group">
                                                            <input type="password" name="current_password" id="current_password" placeholder="Entrez votre mot de passe actuel" class="form-control">
                                                        </div>
                                                        @error('current_password') <div class="text-danger small">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="new_password">Nouveau mot de passe</label>
                                                        <div class="input-group">
                                                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Entrez votre nouveau mot de passe.">
                                                        </div>
                                                        @error('new_password') <div class="text-danger small">{{ $message }}</div> @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
                                                        <div class="input-group">
                                                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirmer votre nouveau mot de passe" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row ends -->

                                </div>
                            </div>
                            <!-- Tab content end -->

                        </div>
                        <!-- Custom tabs end -->

                        <!-- Buttons start -->
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Mettre à jour
                            </button>
                        </div>
                        <!-- Buttons end -->

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- Row ends -->

    </div>


@endsection
