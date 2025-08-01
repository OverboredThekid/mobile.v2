<?php

namespace Tests\Feature;

use App\Livewire\User\Shifts;
use App\Livewire\User\Component\ShiftCard;
use App\Livewire\User\Component\ShiftDetails;
use App\Livewire\Ui\Modal\FullScreenModal;
use App\Livewire\Ui\Modal\HalfScreen;
use App\Livewire\User\Component\VenueDetails;
use App\Http\Dto\VenueDto;
use Livewire\Livewire;
use Tests\TestCase;

class ModalComponentsTest extends TestCase
{
    public function test_halfscreen_modal_can_be_rendered()
    {
        Livewire::test(HalfScreen::class, [
            'child' => 'ui.modal.demo-content',
            'size' => '50'
        ])
        ->assertSee('HalfScreen Modal')
        ->assertSee('Demo Content');
    }

    public function test_fullscreen_modal_can_be_rendered()
    {
        Livewire::test(FullScreenModal::class, [
            'child' => 'ui.modal.demo-content',
            'title' => 'Test FullScreen'
        ])
        ->assertSee('Test FullScreen')
        ->assertSee('Demo Content');
    }

    public function test_venue_details_component_works_independently()
    {
        $venueData = [
            'id' => 'test-venue-1',
            'venue_name' => 'Test Venue',
            'venue_type' => ['hotel'],
            'venue_comment' => 'Test comment',
            'address' => '123 Test St, Test City',
            'latitude' => '40.7128',
            'longitude' => '-74.0060'
        ];

        Livewire::test(VenueDetails::class, ['venue' => $venueData])
            ->assertSee('Test Venue')
            ->assertSee('hotel');
    }

    public function test_shift_details_component_works_independently()
    {
        $shiftData = [
            'api_id' => 'test-shift-1',
            'title' => 'Test Shift',
            'schedule_title' => 'Test Schedule',
            'start_time' => '2024-01-01T09:00:00Z',
            'end_time' => '2024-01-01T17:00:00Z',
            'call_time' => 30,
            'status' => 'confirmed',
            'venue_name' => 'Test Venue',
            'workers' => [
                [
                    'shift_id' => 'test-shift-1',
                    'shift_name' => 'Test Shift',
                    'start_time' => '2024-01-01T09:00:00Z',
                    'end_time' => null,
                    'worker_count' => 1,
                    'workers' => [
                        [
                            'user_id' => 'test-user-1',
                            'user_shift_id' => 'test-user-shift-1',
                            'name' => 'Test User',
                            'avatar_url' => 'https://example.com/avatar.jpg',
                            'phone_number' => '+1234567890',
                            'email' => 'test@example.com',
                            'user_shift_status' => null,
                            'shift_request_status' => 'confirmed'
                        ]
                    ]
                ]
            ],
            'venue' => [
                'id' => 'test-venue-1',
                'venue_name' => 'Test Venue',
                'venue_type' => ['hotel'],
                'venue_color' => 'blue',
                'venue_comment' => 'Test venue comment',
                'address' => '123 Test St, Test City',
                'latitude' => '40.7128',
                'longitude' => '-74.0060'
            ]
        ];

        Livewire::test(ShiftDetails::class, ['shiftData' => $shiftData])
            ->assertSee('Test Shift')
            ->assertSee('Test Schedule');
    }

    public function test_modal_data_serialization()
    {
        $testData = [
            'id' => 'test-1',
            'name' => 'Test Item',
            'nested' => [
                'key' => 'value'
            ]
        ];

        Livewire::test(HalfScreen::class, [
            'child' => 'ui.modal.demo-content',
            'size' => '75',
            'testData' => $testData
        ])
        ->assertSee('Test Item');
    }

    public function test_complete_shift_card_to_shift_details_flow()
    {
        // Test data that matches the API structure
        $shiftData = [
            'id' => '01k1d1ez6d7fkb91e3e8fct6wd',
            'api_id' => '01k1d1ez6d7fkb91e3e8fct6wd', // Add api_id field
            'shiftRequest' => [
                'id' => '01k1d1g34ts9c6qc60gnfkbhxb',
                'status' => 'confirmed',
                'requested_by' => '01k0e0a0xb6m8dekbs4vsazcew',
                'data' => [
                    'confirmed' => [
                        'by' => [
                            'id' => '01k0e0a0xb6m8dekbs4vsazcew',
                            'name' => 'Company Admin'
                        ],
                        'timestamp' => '2025-07-30 03:34:58'
                    ]
                ],
                'type' => 'admin',
                'expires_at' => null,
                'created_at' => '2025-07-30T01:49:42-05:00',
                'updated_at' => '2025-07-30T03:34:58-05:00'
            ],
            'shift_id' => '01k1d1ez58axnngbxhhv8yrw03',
            'schedule_id' => '01k1d1ez2nbzayk6xgd6q26879',
            'documents' => [],
            'schedule_worker_notes' => null,
            'schedule_admin_notes' => null,
            'venue_id' => '01k198gcfhnq1d5s1yfwzr5kfn',
            'venue_name' => 'Venue 2',
            'title' => 'Flyman',
            'schedule_title' => '713: Load Out',
            'can_punch' => false,
            'is_timeTracker' => false,
            'is_reviewer' => false,
            'can_bailout' => true,
            'call_time' => 30,
            'start_time' => '2025-07-31T15:00:00.000000Z',
            'end_time' => '2025-07-31T19:00:00.000000Z',
            'timePunches' => [],
            'worker_notes' => null,
            'admin_notes' => null,
            'workers' => [
                [
                    'shift_id' => '01k1d1ez58axnngbxhhv8yrw03',
                    'shift_name' => 'Flyman',
                    'start_time' => '2025-07-31T15:00:00.000000Z',
                    'end_time' => null,
                    'worker_count' => 1,
                    'workers' => [
                        [
                            'user_id' => '01k0e0a0xb6m8dekbs4vsazcew',
                            'user_shift_id' => '01k1d1ez6d7fkb91e3e8fct6wd',
                            'name' => 'Company Admin',
                            'avatar_url' => 'https://ui-avatars.com/api/?name=Company+Admin&color=000&background=EBF4FF',
                            'phone_number' => '+11234567892',
                            'email' => 'companyadmin@example.com',
                            'user_shift_status' => null,
                            'shift_request_status' => 'confirmed'
                        ]
                    ]
                ]
            ],
            'venue' => [
                'id' => '01k198gcfhnq1d5s1yfwzr5kfn',
                'venue_name' => 'Venue 2',
                'venue_type' => ['Restaurant'],
                'venue_color' => 'red',
                'venue_comment' => '',
                'address' => '1234 Massachusetts Ave NW, Washington, DC 20005, USA',
                'latitude' => null,
                'longitude' => null
            ]
        ];

        // Test ShiftCard component with the shift data
        $shiftCard = Livewire::test(ShiftCard::class, [
            'shift' => $shiftData,
            'showStatus' => true,
            'showVenue' => true,
            'showCallTime' => true,
            'actions' => []
        ]);

        // Verify ShiftCard renders correctly
        $shiftCard->assertSee('Flyman')
            ->assertSee('Venue 2')
            ->assertSee('713: Load Out');

        // Test opening shift details modal
        $shiftCard->call('openShiftDetails');
        
        // Debug: Check what the actual values are
        $shiftCard->assertSet('showShiftDetailsModal', true)
            ->assertSet('currentShiftData', $shiftData);

        // Test that the FullScreen modal would be rendered with ShiftDetails
        $fullScreen = Livewire::test(FullScreenModal::class, [
            'child' => 'user.component.shift-details',
            'title' => 'Shift Details',
            'shiftData' => $shiftData
        ]);

        // Verify FullScreen modal renders correctly
        $fullScreen->assertSee('Shift Details')
            ->assertSee('Flyman');
    }

    public function test_shift_details_component_with_fresh_data()
    {
        $shiftData = [
            'api_id' => 'test-shift-1',
            'title' => 'Test Shift',
            'schedule_title' => 'Test Schedule',
            'start_time' => '2024-01-01T09:00:00Z',
            'end_time' => '2024-01-01T17:00:00Z',
            'call_time' => 30,
            'status' => 'confirmed',
            'venue_name' => 'Test Venue',
            'meta_updated_at' => now()->toISOString(), // Fresh data
            'workers' => [
                [
                    'shift_id' => 'test-shift-1',
                    'shift_name' => 'Test Shift',
                    'start_time' => '2024-01-01T09:00:00Z',
                    'end_time' => null,
                    'worker_count' => 1,
                    'workers' => [
                        [
                            'user_id' => 'test-user-1',
                            'user_shift_id' => 'test-user-shift-1',
                            'name' => 'Test User',
                            'avatar_url' => 'https://example.com/avatar.jpg',
                            'phone_number' => '+1234567890',
                            'email' => 'test@example.com',
                            'user_shift_status' => null,
                            'shift_request_status' => 'confirmed'
                        ]
                    ]
                ]
            ],
            'venue' => [
                'id' => 'test-venue-1',
                'venue_name' => 'Test Venue',
                'venue_type' => ['hotel'],
                'venue_color' => 'blue',
                'venue_comment' => 'Test venue comment',
                'address' => '123 Test St, Test City',
                'latitude' => '40.7128',
                'longitude' => '-74.0060'
            ]
        ];

        $shiftDetails = Livewire::test(ShiftDetails::class, ['shiftData' => $shiftData]);

        // Verify component loads with fresh data
        $shiftDetails->assertSet('loading', false)
            ->assertSee('Test Shift')
            ->assertSee('Test Schedule');

        // Test refresh functionality
        $shiftDetails->call('refreshData')
            ->assertSet('loading', false);
    }

    public function test_shift_details_component_without_api_calls()
    {
        // Test with data that doesn't require API calls
        $shiftData = [
            'api_id' => 'test-shift-1',
            'title' => 'Test Shift',
            'schedule_title' => 'Test Schedule',
            'start_time' => '2024-01-01T09:00:00Z',
            'end_time' => '2024-01-01T17:00:00Z',
            'call_time' => 30,
            'status' => 'confirmed',
            'venue_name' => 'Test Venue',
            'meta_updated_at' => now()->toISOString(), // Fresh data - should not trigger API call
            'workers' => [],
            'venue' => []
        ];

        $shiftDetails = Livewire::test(ShiftDetails::class, ['shiftData' => $shiftData]);

        // Verify component loads without making API calls
        $shiftDetails->assertSet('loading', false)
            ->assertSee('Test Shift')
            ->assertSee('Test Schedule');
    }

    public function test_fullscreen_modal_close_functionality()
    {
        $fullScreen = Livewire::test(FullScreenModal::class, [
            'child' => 'ui.modal.demo-content',
            'title' => 'Test Modal'
        ]);

        // Verify modal starts open
        $fullScreen->assertSet('show', true)
            ->assertSet('currentHeight', 100);

        // Test close functionality
        $fullScreen->call('close')
            ->assertSet('show', false)
            ->assertSet('currentHeight', 100)
            ->assertDispatched('fullscreenmodal-closed');
    }

    public function test_fullscreen_modal_html_output()
    {
        $fullScreen = Livewire::test(FullScreenModal::class, [
            'child' => 'ui.modal.demo-content',
            'title' => 'Test Modal'
        ]);

        // Get the actual HTML output
        $html = $fullScreen->html();
        
        // Check if the HTML contains the correct @entangle syntax
        $this->assertStringContainsString('@entangle(\'show\')', $html);
        $this->assertStringContainsString('@entangle(\'currentHeight\')', $html);
        
        // Check that it doesn't contain hardcoded component IDs
        $this->assertStringNotContainsString('window.Livewire.find(', $html);
        
        // Output the HTML for debugging
        echo "\n=== FullScreen Modal HTML ===\n";
        echo $html;
        echo "\n=== End HTML ===\n";
    }

    public function test_compare_halfscreen_vs_fullscreen_html()
    {
        // Test HalfScreen
        $halfScreen = Livewire::test(HalfScreen::class, [
            'child' => 'ui.modal.demo-content',
            'size' => '50'
        ]);
        
        // Test FullScreenModal
        $fullScreen = Livewire::test(FullScreenModal::class, [
            'child' => 'ui.modal.demo-content',
            'title' => 'Test Modal'
        ]);

        // Get HTML outputs
        $halfScreenHtml = $halfScreen->html();
        $fullScreenHtml = $fullScreen->html();
        
        // Output both for comparison
        echo "\n=== HalfScreen HTML ===\n";
        echo $halfScreenHtml;
        echo "\n=== End HalfScreen HTML ===\n";
        
        echo "\n=== FullScreenModal HTML ===\n";
        echo $fullScreenHtml;
        echo "\n=== End FullScreenModal HTML ===\n";
        
        // Check if both contain the same @entangle pattern
        $this->assertStringContainsString('@entangle(\'show\')', $halfScreenHtml);
        $this->assertStringContainsString('@entangle(\'show\')', $fullScreenHtml);
        $this->assertStringContainsString('@entangle(\'currentHeight\')', $halfScreenHtml);
        $this->assertStringContainsString('@entangle(\'currentHeight\')', $fullScreenHtml);
    }
} 