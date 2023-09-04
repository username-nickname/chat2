<x-layout.main title="Register">
    <div class="auth-container">
        <div class="auth-box">
            <h2>Register</h2>
            <x-form action="{{ route('auth.registers.store') }}">
                <x-form-input name="name" placeholder="Username" class="form-control" />
                <x-form-input name="email" placeholder="Email" type="email" class="form-control" />
                <x-form-input name="password" placeholder="Password" type="password" class="form-control" />
                <x-form-input name="password_confirmation" placeholder="Confirm Password" type="password" class="form-control" />
                <button class="btn btn-primary">Register</button>
            </x-form>
            <div class="mt-3">
                <p>Already have an account? <a href="{{ route('auth.sessions.create') }}">Login here</a></p>
            </div>
        </div>
    </div>
</x-layout.main>
