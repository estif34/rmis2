<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Collaborators') }}: {{ $risk->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('risks.collaborators.update', $risk) }}">
                        @csrf
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Select Users to Collaborate</h3>
                            
                            @if ($users->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($users as $user)
                                        <div class="flex items-center p-4 border rounded-lg">
                                            <div class="flex-1">
                                                <div class="flex items-center">
                                                    <input type="checkbox" id="user_{{ $user->id }}" name="collaborators[]" value="{{ $user->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ in_array($user->id, $currentCollaborators) ? 'checked' : '' }}>
                                                    <label for="user_{{ $user->id }}" class="ml-3 block text-sm font-medium text-gray-700">{{ $user->name }}</label>
                                                </div>
                                                <p class="ml-7 text-sm text-gray-500">{{ $user->email }} ({{ ucfirst($user->role) }})</p>
                                            </div>
                                            
                                            <div>
                                                <select name="permissions[{{ $user->id }}]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="view">View Only</option>
                                                    <option value="edit" {{ $risk->collaborators->where('user_id', $user->id)->where('permission', 'edit')->count() > 0 ? 'selected' : '' }}>Edit</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                            <p>No users available to collaborate with.</p>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('risks.show', $risk) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                Cancel
                            </a>
                            
                            <x-primary-button>
                                {{ __('Save Collaborators') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>