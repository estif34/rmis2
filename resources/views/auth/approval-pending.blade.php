<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <div class="mb-4 text-sm text-gray-600">
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                <p class="font-bold">Account Pending Approval</p>
                <p>Your account is currently awaiting administrator approval. You will be notified when your account has been approved.</p>
            </div>

            <p class="mt-4">
                Thank you for registering. Your account has been created but requires administrator approval before you can access the system.
            </p>
            
            <p class="mt-4">
                Once your account is approved, you will be able to access all features of the application.
            </p>
        </div>

        <form method="POST" action="{{ route('approval.logout') }}" class="mt-6">
            @csrf
            <div class="flex items-center justify-end">
                <x-primary-button>
                    {{ __('Logout') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>