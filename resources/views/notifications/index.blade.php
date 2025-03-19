<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Unread Notifications</h3>
                        
                        @if ($notifications->count() > 0)
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Mark All as Read
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach ($notifications as $notification)
                                <div class="p-4 rounded-lg border bg-blue-50 border-blue-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium text-blue-800">
                                                {{ $notification->data['message'] ?? 'Notification' }}
                                            </p>
                                            
                                            @if (isset($notification->data['user_name']))
                                                <p class="text-sm text-gray-600 mt-1">
                                                    User: {{ $notification->data['user_name'] }} ({{ $notification->data['user_email'] ?? '' }})
                                                </p>
                                            @endif
                                            
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">
                                                    Mark as Read
                                                </button>
                                            </form>
                                            
                                            @if (isset($notification->data['user_id']))
                                                <a href="{{ route('admin.users') }}" class="text-sm text-indigo-600 hover:text-indigo-800 py-0.5">
                                                    View User
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No unread notifications.</p>
                        <p class="text-center">
                            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">Return to Dashboard</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>