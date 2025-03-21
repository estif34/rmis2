<div>
    <!-- Search and Filter Form -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6">
            <div class="mb-4">
                <h3 class="text-lg font-medium mb-2">Search & Filter</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Keyword -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Keyword</label>
                        <input type="text" id="search" wire:model.live.debounce.300ms="search" placeholder="Search by title, description..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category" wire:model.live="category" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Risk Level Filter -->
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Risk Level</label>
                        <select id="level" wire:model.live="level" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Levels</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level }}">{{ ucfirst($level) }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" wire:model.live="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Reset Filters Button -->
                <div class="mt-4 flex justify-end">
                    <button wire:click="resetFilters" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Results Section -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <!-- Add button to the top right of the content area -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium text-gray-900">
                    Risks
                    @if ($search || $category || $level || $status)
                        <span class="text-sm font-normal text-gray-500">(Filtered results)</span>
                    @endif
                </h3>
                <a href="{{ route('risks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Risk
                </a>
            </div>
            
            <!-- Risks Table -->
            <div class="overflow-x-auto">
                @if ($risks->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th> -->
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($risks as $risk)
                                <tr class="hover:bg-gray-100 cursor-pointer" onclick="window.location.href='{{ route('risks.show', $risk) }}'">
                                    <!-- <td class="px-6 py-4 whitespace-nowrap">{{ $risk->id }}</td> -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('risks.show', $risk) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $risk->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $risk->category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($risk->level === 'high')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                High
                                            </span>
                                        @elseif ($risk->level === 'medium')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Medium
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Low
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($risk->status === 'open')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Open
                                            </span>
                                        @elseif ($risk->status === 'in_progress')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                In Progress
                                            </span>
                                        @elseif ($risk->status === 'mitigated')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Mitigated
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Closed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $risk->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('risks.show', $risk) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                        
                                        @if (Auth::id() === $risk->user_id || Auth::user()->isAdmin() || ($risk->collaborators->where('user_id', Auth::id())->where('permission', 'edit')->count() > 0))
                                            <a href="{{ route('risks.edit', $risk) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                            
                                            @if (Auth::id() === $risk->user_id || Auth::user()->isAdmin())
                                                <form action="{{ route('risks.destroy', $risk) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this risk?')">Delete</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- <div class="text-xs text-gray-500 mb-2">
                        Last updated: {{ now() }}
                    </div> -->
                    
                    <div class="mt-4">
                        {{ $risks->links() }}
                    </div>
                @else
                    <p>No risks found matching your criteria. <a href="{{ route('risks.create') }}" class="text-blue-500 hover:text-blue-700">Create a new risk</a>.</p>
                @endif
            </div>
        </div>
    </div>
</div>