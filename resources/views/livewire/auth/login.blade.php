<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sign In</h2>
    
    {{-- Global Error Message --}}
    @if($errorMessage)
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-sm text-red-600">{{ $errorMessage }}</p>
        </div>
    @endif

    {{-- Success Message from Session --}}
    @if(session('message'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-600">{{ session('message') }}</p>
        </div>
    @endif
    
    <form wire:submit="login" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input 
          type="email" 
          wire:model="email"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
          placeholder="your@email.com"
          wire:loading.attr="disabled"
          wire:target="login"
        />
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input 
          type="password" 
          wire:model="password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all @error('password') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
          placeholder="••••••••"
          wire:loading.attr="disabled"
          wire:target="login"
        />
        @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center">
          <input 
            type="checkbox" 
            wire:model="remember"
            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
            wire:loading.attr="disabled"
            wire:target="login"
          />
          <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot password?</a>
      </div>

      <button 
        type="submit"
        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
        wire:loading.attr="disabled"
        wire:target="login"
      >
        <span wire:loading.remove wire:target="login">Sign In</span>
        <span wire:loading wire:target="login" class="flex items-center">
          <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Signing in...
        </span>
      </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      Don't have an account? 
      <a href="#" class="text-indigo-600 hover:text-indigo-500 font-medium">Contact your administrator</a>
    </div>
  </div>
</div>