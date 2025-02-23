<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-danger" :status="session('status')" />

    <div class="card mt-4">

        <div class="card-body p-4">
            <div class="text-center mt-2">
                <h5 class="text-primary">Welcome Back !</h5>
                <p class="text-muted">Sign in to continue to System.</p>
            </div>
            <div class="p-2 mt-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username" placeholder="Enter email address" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>
                    <div class="mb-3">
                        <div class="float-end">
                            <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                        </div>
                        <x-input-label for="password-input" :value="__('Password')" />
                        <div class="position-relative auth-pass-inputgroup mb-3">

                            <x-text-input id="password" placeholder="Enter password" class="pe-5 password-input"
                                type="password" name="password" required autocomplete="current-password" />

                            <button
                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                    </div>

                    <div class="mt-4">
                        <x-primary-button>
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end card body -->
    </div>
</x-guest-layout>
