<div>
    @livewire('user.component.shift-details', [
        'shiftData' => $shiftData,
    ], key('shift-details-' . ($shiftData['api_id'] ?? uniqid())))
</div> 