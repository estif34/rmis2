<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Risk Details') }}
        </h2>
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

            <!-- Action buttons at the top of the content area -->
            <div class="mb-4 flex justify-end space-x-2">
                @if (Auth::id() === $risk->user_id)
                    <a href="{{ route('risks.collaborators', $risk) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Manage Collaborators
                    </a>
                @endif
                
                @if (Auth::id() === $risk->user_id || $risk->collaborators->where('user_id', Auth::id())->where('permission', 'edit')->count() > 0)
                    <a href="{{ route('risks.edit', $risk) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit Risk
                    </a>
                @endif
                
                <a href="{{ route('risks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>

            <!-- Risk Header Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $risk->title }}</h2>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="px-3 py-1 text-sm rounded-full
                                    {{ $risk->level === 'high' ? 'bg-red-100 text-red-800' : 
                                    ($risk->level === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($risk->level ?? 'Not set') }} Risk
                                </span>
                                <span class="px-3 py-1 text-sm rounded-full
                                    {{ $risk->status === 'open' ? 'bg-blue-100 text-blue-800' : 
                                    ($risk->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 
                                    ($risk->status === 'mitigated' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $risk->status ?? 'Not set')) }}
                                </span>
                                <span class="text-sm text-gray-600">Category: <span class="font-medium">{{ $risk->category->name }}</span></span>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 flex flex-col items-end">
                            <span class="text-sm text-gray-600">Risk ID: {{ $risk->id }}</span>
                            <span class="text-sm text-gray-600">Created By: {{ $risk->user->name }}</span>
                            <span class="text-sm text-gray-600">Created On: {{ $risk->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Main Content (Risk, Impact, Mitigation) - 3 columns -->
                <div class="md:col-span-3">
                    <!-- Risk Details Section -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Risk Details</h3>
                            
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-900 mb-2">Description</h4>
                                <p class="text-gray-700">{{ $risk->description ?? 'No description provided.' }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 border-b pb-2 mb-3">Assessment Details</h4>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Likelihood:</span>
                                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $risk->likelihood ?? 'Not set')) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Proximity:</span>
                                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $risk->proximity ?? 'Not set')) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Risk Area:</span>
                                            <span class="font-medium">{{ $risk->risk_area ?? 'Not set' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Department:</span>
                                            <span class="font-medium">{{ $risk->department ?? 'Not set' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 border-b pb-2 mb-3">Risk Timeline</h4>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Created:</span>
                                            <span class="font-medium">{{ $risk->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Last Updated:</span>
                                            <span class="font-medium">{{ $risk->updated_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Current Status:</span>
                                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $risk->status ?? 'Not set')) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Impact Assessment Section -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Impact Assessment</h3>
                            
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-900 mb-2">Impact Description</h4>
                                <p class="text-gray-700">{{ $risk->impact_description ?? 'No impact description provided.' }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 border-b pb-2 mb-3">Impact Metrics</h4>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Impact Level:</span>
                                            <span class="font-medium">{{ ucfirst($risk->impact_level ?? 'Not set') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Impact Likelihood:</span>
                                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $risk->impact_likelihood ?? 'Not set')) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Impact Proximity:</span>
                                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $risk->impact_proximity ?? 'Not set')) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Impact Type:</span>
                                            <span class="font-medium">{{ ucfirst($risk->impact_type ?? 'Not set') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 border-b pb-2 mb-3">Financial Impact</h4>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Financial Impact:</span>
                                            <span class="font-medium">${{ number_format($risk->financial_impact ?? 0, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Cause of Impact:</span>
                                            <span class="font-medium">{{ $risk->cause_of_impact ?? 'Not specified' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Impact Status:</span>
                                            <span class="font-medium px-2 py-1 text-xs rounded-full
                                                {{ $risk->impact_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                ($risk->impact_status === 'active' ? 'bg-red-100 text-red-800' : 
                                                ($risk->impact_status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                                {{ ucfirst($risk->impact_status ?? 'Not set') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mitigation Strategy Section -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Mitigation Strategy</h3>
                            
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-900 mb-2">Strategy Details</h4>
                                <p class="text-gray-700">{{ $risk->mitigation_strategy ?? 'No mitigation strategy provided.' }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 border-b pb-2 mb-3">Response Details</h4>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Response Type:</span>
                                            <span class="font-medium">{{ ucfirst($risk->response_type ?? 'Not set') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Responsible Department:</span>
                                            <span class="font-medium">{{ $risk->mitigation_department ?? 'Not assigned' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Residual Risk:</span>
                                            <span class="font-medium">{{ $risk->residual_risk ?? 'Not assessed' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 border-b pb-2 mb-3">Implementation Status</h4>
                                    <div class="mt-4 w-full bg-gray-200 rounded-full h-2.5">
                                        @php
                                            $statusPercentage = 0;
                                            if ($risk->mitigation_status === 'pending') $statusPercentage = 0;
                                            elseif ($risk->mitigation_status === 'in_progress') $statusPercentage = 50;
                                            elseif ($risk->mitigation_status === 'completed') $statusPercentage = 100;
                                        @endphp
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $statusPercentage }}%"></div>
                                    </div>
                                    <div class="flex justify-between mt-2 text-sm">
                                        <span>Pending</span>
                                        <span>In Progress</span>
                                        <span>Completed</span>
                                    </div>
                                    <div class="mt-4 flex justify-center">
                                        <span class="px-3 py-1 text-sm rounded-full
                                            {{ $risk->mitigation_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                            ($risk->mitigation_status === 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                            ($risk->mitigation_status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ ucfirst($risk->mitigation_status ?? 'Not set') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

                <!-- Sidebar - 1 column -->
                <div class="md:col-span-1">
                    <!-- Comments Section -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Comments</h3>
                            
                            <!-- Comments List -->
                            <div class="space-y-4 mb-4">
                                @forelse($risk->comments as $comment)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-start mb-2">
                                            <div class="flex-shrink-0">
                                                <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-semibold">
                                                    {{ substr($comment->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $comment->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                            
                                            <!-- Delete Comment Button (for comment owner, risk owner, or admin) -->
                                            @if(Auth::id() === $comment->user_id)
                                                <form method="POST" action="{{ route('risks.comments.destroy', [$risk, $comment]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm" 
                                                            onclick="return confirm('Are you sure you want to delete this comment?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-700 whitespace-pre-line">{{ $comment->content }}</div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 text-center italic">No comments yet. Be the first to comment!</p>
                                @endforelse
                            </div>
                            <!-- Comment Form -->
                            @if(Auth::id() === $risk->user_id || $risk->collaborators->where('user_id', Auth::id())->count() > 0)
                                <form method="POST" action="{{ route('risks.comments.store', $risk) }}" class="mb-6">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea name="content" rows="3" placeholder="Add a comment..." 
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                required></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            Post Comment
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                    <!-- Risk Owner Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-3">Risk Owner</h3>
                            <div class="flex items-center mb-4">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-semibold">
                                    {{ substr($risk->user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $risk->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $risk->user->email }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">Department: {{ $risk->user->department }}</p>
                        </div>
                    </div>
                    <!-- Collaborators Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-lg font-medium text-gray-900">Collaborators</h3>
                                @if (Auth::id() === $risk->user_id)
                                    <a href="{{ route('risks.collaborators', $risk) }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                        Manage
                                    </a>
                                @endif
                            </div>
                            
                            @if ($risk->collaborators->count() > 0)
                                <ul class="divide-y divide-gray-200">
                                    @foreach ($risk->collaborators as $collaborator)
                                        <li class="py-2">
                                            <div class="flex items-center space-x-3">
                                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold">
                                                    {{ substr($collaborator->user->name, 0, 1) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        {{ $collaborator->user->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 truncate">
                                                        {{ $collaborator->user->email }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $collaborator->permission == 'edit' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                        {{ ucfirst($collaborator->permission) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-600">No collaborators assigned.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Activity Info Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-3">Activity Log</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Created</h4>
                                    <p class="text-sm text-gray-600">By: {{ $risk->user->name }}</p>
                                    <p class="text-sm text-gray-600">Date: {{ $risk->created_at->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">At: {{ $risk->created_at->format('h:i A') }}</p>
                                </div>
                                
                                @if ($risk->updated_at->gt($risk->created_at))
                                    <div class="pt-3 border-t border-gray-200">
                                        <h4 class="text-sm font-medium text-gray-700">Last Updated</h4>
                                        <p class="text-sm text-gray-600">
                                            By: {{ $risk->updated_by ? $risk->updatedByUser->name : 'Unknown' }}
                                        </p>
                                        <p class="text-sm text-gray-600">Date: {{ $risk->updated_at->format('M d, Y') }}</p>
                                        <p class="text-sm text-gray-600">Time: {{ $risk->updated_at->format('h:i A') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>