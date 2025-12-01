@extends('layout_login')
@section('title', 'Login | Kourekama')
@section('suite')



    <body class="login-bg">

        <!-- Form start -->
        <form action="{{ route('login.authenticate') }}" method="POST" class="my-5">@csrf
            <div class="auth-box border border-dark">

                <h4 class="my-4 text-center">Se Connecter</h4>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label" for="email">Votre Email<span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email" autocomplete="username"
                        placeholder="Entrer votre Email" required />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Votre Mot de passe <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe" required />
                </div>

                <div class="d-grid py-3 mt-3">
                    <button type="submit" class="btn btn-lg btn-primary">Connectez-vous</button>
                </div>

            </div>
        </form>
        <!-- Form end -->

    </body>


@endsection
