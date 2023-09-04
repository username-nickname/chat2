<x-layout.main title="Enter to site">
    <div class="auth-container">
        <div class="auth-box">
            <h2>Login</h2>
            <x-form action="{{ route('auth.sessions.store') }}">
                <x-form-input name="email" placeholder="Email" type="email" class="form-control" />
                <x-form-input name="password" type="password" placeholder="Password" class="form-control"/>
                <div class="mb-3">
                    <x-form-checkbox name="remember" label="Запомнить" />
                </div>
                <button class="btn btn-primary">Login</button>
            </x-form>
            <div class="mt-3">
                <p>Don't have an account? <a href="{{ route('auth.registers.create') }}">Register here</a></p>
            </div>
        </div>
    </div>
</x-layout.main>
