@extends('components.layouts.app')

@section('content')
    <div class="pt-4 md:p-6 space-y-8">
        <!-- Welcome Card -->
        <div>
            <div>
                <h2 class="card-title text-2xl font-bold text-white mb-2 mt-8">
                    Howdy, {{ $user && $user['name'] ? $user['name'] : 'User' }}!
                </h2>
                <div class="text-gray-400 leading-relaxed mb-6">
                    Welcome to your scheduling platform dashboard!
                </div>

                <!-- Dashboard Action Buttons -->
                <livewire:dashboard.ui.shift-actions />
            </div>
        </div>

        <!-- Week Calendar -->
        <livewire:dashboard.ui.week-calendar />
    </div>
@endsection