@php
    // Define all possible tabs with their conditions and content
    $availableTabs = [
        'details' => [
            'label' => 'Details',
            'icon' => 'heroicon-o-information-circle',
            'condition' => true, // Always show details tab
            'content' => 'user.components.shift.tabs.details'
        ],
        'workers' => [
            'label' => 'Workers',
            'icon' => 'heroicon-o-users',
            'condition' => $hasWorkers ?? false,
            'content' => 'user.components.shift.tabs.workers'
        ],
        'punches' => [
            'label' => 'Punches',
            'icon' => 'heroicon-o-clock',
            'condition' => $hasPunches ?? false,
            'content' => 'user.components.shift.tabs.punches'
        ],
        'shiftNotes' => [
            'label' => 'Shift Notes',
            'icon' => 'heroicon-o-document-text',
            'condition' => $hasShiftNotes ?? false,
            'content' => 'user.components.shift.tabs.shift-notes'
        ],
        'scheduleDocuments' => [
            'label' => 'Documents',
            'icon' => 'heroicon-o-folder',
            'condition' => $hasDocuments ?? false,
            'content' => 'user.components.shift.tabs.documents'
        ]
    ];

    // Filter tabs based on conditions
    $activeTabs = collect($availableTabs)->filter(function ($tab, $key) {
        return $tab['condition'];
    });
@endphp

<div x-data="{ activeTab: '{{ $activeTab ?? 'details' }}' }">
    <div class="px-4 mt-6">
        <x-filament::tabs class="bg-transparent">
            @foreach($activeTabs as $tabKey => $tab)
                <x-filament::tabs.item 
                    :active="$activeTab === $tabKey"
                    :icon="$tab['icon']"
                    x-on:click="activeTab = '{{ $tabKey }}'; $wire.setActiveTab('{{ $tabKey }}')"
                >
                    {{ $tab['label'] }}
                </x-filament::tabs.item>
            @endforeach
        </x-filament::tabs>
    </div>

    <div class="px-4 mt-5 mb-5">
        @foreach($activeTabs as $tabKey => $tab)
            <div x-show="activeTab === '{{ $tabKey }}'" class="space-y-4">
                @include($tab['content'], [
                    'shift' => $shift ?? null,
                    'loading' => $loading ?? false
                ])
            </div>
        @endforeach
    </div>
</div> 