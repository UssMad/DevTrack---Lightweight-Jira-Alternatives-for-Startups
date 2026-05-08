<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-h1 text-on-surface mb-1">Create your account</h2>
        <p class="text-body-md text-on-surface-variant">Enter your details to get started.</p>
    </div>

    <div class="glass-panel rounded-xl p-6">
        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Full Name -->
            <div class="flex flex-col gap-1">
                <label class="text-label-sm text-on-surface-variant" for="name">Full Name</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">person</span>
                    <input class="devtrack-input w-full rounded-lg pl-10 pr-4 py-2 text-body-md text-on-surface placeholder:text-outline/50"
                           id="name" name="name" type="text" :value="old('name')" placeholder="Jane Doe" required autofocus autocomplete="name"/>
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-1">
                <label class="text-label-sm text-on-surface-variant" for="email">Email</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">mail</span>
                    <input class="devtrack-input w-full rounded-lg pl-10 pr-4 py-2 font-mono text-code text-on-surface placeholder:text-outline/50"
                           id="email" name="email" type="email" :value="old('email')" placeholder="jane.doe@example.com" required autocomplete="username"/>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1">
                <label class="text-label-sm text-on-surface-variant" for="password">Password</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                    <input class="devtrack-input w-full rounded-lg pl-10 pr-4 py-2 font-mono text-code text-on-surface placeholder:text-outline/50"
                           id="password" name="password" type="password" placeholder="••••••••" required autocomplete="new-password"/>
                </div>
                <p class="text-label-sm text-outline mt-1">Must be at least 8 characters.</p>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="flex flex-col gap-1">
                <label class="text-label-sm text-on-surface-variant" for="password_confirmation">Confirm Password</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock</span>
                    <input class="devtrack-input w-full rounded-lg pl-10 pr-4 py-2 font-mono text-code text-on-surface placeholder:text-outline/50"
                           id="password_confirmation" name="password_confirmation" type="password" placeholder="••••••••" required autocomplete="new-password"/>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Submit -->
            <button class="btn-primary-gradient mt-2 w-full rounded-lg text-label-sm text-white py-[10px] flex items-center justify-center gap-1 hover:opacity-90 transition-opacity active:scale-[0.98]"
                    type="submit">
                Sign Up
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </form>
    </div>

    <!-- Footer -->
    <p class="text-center mt-6 text-body-md text-on-surface-variant">
        Already have an account?
        <a class="text-dt-primary hover:text-primary-fixed-dim font-medium transition-colors" href="{{ route('login') }}">Sign in</a>
    </p>
</x-guest-layout>
