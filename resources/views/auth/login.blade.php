<x-guest-layout>
    <div class="flex flex-col gap-1 mb-4">
        <h1 class="text-h1 text-on-surface">Welcome back</h1>
        <p class="text-body-md text-on-surface-variant">Enter your credentials to access your workspace.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
        @csrf

        <!-- Email -->
        <div class="flex flex-col gap-1">
            <label class="text-label-sm text-on-surface-variant" for="email">Email Address</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant text-[20px]">mail</span>
                <input class="w-full devtrack-input rounded-lg pl-[44px] pr-4 py-[10px] text-body-md text-on-surface placeholder:text-outline-variant/50"
                       id="email" name="email" type="email" :value="old('email')" placeholder="developer@company.com" required autofocus autocomplete="username"/>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-1">
            <div class="flex justify-between items-center">
                <label class="text-label-sm text-on-surface-variant" for="password">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-label-sm text-dt-primary hover:text-primary-fixed-dim transition-colors" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant text-[20px]">lock</span>
                <input class="w-full devtrack-input rounded-lg pl-[44px] pr-4 py-[10px] text-body-md text-on-surface font-mono placeholder:text-outline-variant/50"
                       id="password" name="password" type="password" placeholder="••••••••" required autocomplete="current-password"/>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2 mt-1 mb-2">
            <input class="w-4 h-4 rounded bg-surface border-outline-variant/30 text-inverse-primary focus:ring-inverse-primary focus:ring-offset-surface-container-lowest"
                   id="remember" name="remember" type="checkbox"/>
            <label class="text-body-md text-on-surface-variant cursor-pointer" for="remember">Remember me for 30 days</label>
        </div>

        <!-- Submit -->
        <button class="w-full flex items-center justify-center gap-2 btn-primary-gradient text-white text-body-md font-semibold py-[12px] rounded-lg transition-all shadow-[0_0_20px_rgba(73,75,214,0.2)] hover:shadow-[0_0_25px_rgba(73,75,214,0.4)]"
                type="submit">
            Sign In
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </button>
    </form>

    <!-- Footer -->
    <div class="mt-6 text-center border-t border-outline-variant/10 pt-6">
        <p class="text-body-md text-on-surface-variant">
            Don't have an account?
            <a class="text-dt-primary hover:text-primary-fixed-dim font-semibold transition-colors" href="{{ route('register') }}">Create Account</a>
        </p>
    </div>
</x-guest-layout>
