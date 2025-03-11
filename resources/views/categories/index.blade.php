<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Risk Categories') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Add button to the top right of the content area -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">All Categories</h3>
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add New Category
                            </a>
                        @endif  
                    </div>                  
                    @if ($categories->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($categories as $category)
                                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <div class="p-4 bg-gray-50 border-b">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                                    </div>
                                    <div class="p-4">
                                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($category->description, 100) }}</p>
                                        <p class="text-sm text-gray-800 font-medium">Risks: {{ $category->risks_count }}</p>
                                        
                                        <div class="mt-4 flex-col justify-end space-x-2">
                                            <a href="{{ route('categories.show', $category) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View</a>
                                            
                                            @if (Auth::user()->role === 'admin')
                                                <a href="{{ route('categories.edit', $category) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">Edit</a>
                                                
                                                @if ($category->risks_count == 0)
                                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                                    </form>
                                                @endif
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No risk categories found. 
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('categories.create') }}" class="text-blue-500 hover:text-blue-700">Create a new category</a>.
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>