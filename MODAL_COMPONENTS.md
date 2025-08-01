# Modal Components Documentation

This document describes the HalfScreen and FullScreen modal components for Livewire v3 applications.

## Overview

The modal components provide interactive, draggable modal experiences with Alpine.js integration for smooth animations and user interactions.

## Components

### HalfScreen Modal

A bottom-sliding modal that can be dragged to adjust height and expanded/collapsed.

#### Features
- Slide up from bottom animation
- Draggable height adjustment (25%, 50%, 75% screen height)
- Expand/collapse functionality
- Drag handle with visual indicator
- Close on drag down
- Keyboard escape support
- Backdrop click to close

#### Usage

```php
// In your Livewire component
<livewire:ui.modal.halfscreen 
    :child="'user.component.shift-details'" 
    :size="'50'" 
/>
```

#### Parameters
- `child` (string): The Livewire component to render inside the modal
- `size` (string): Initial height percentage ('25', '50', '75')

#### Events
- `open-halfscreen`: Opens the modal
- `close-halfscreen`: Closes the modal

#### Example Implementation

```php
// In your component
public function openHalfScreenModal()
{
    $this->dispatch('open-halfscreen', [
        'child' => 'user.component.shift-details',
        'size' => '50'
    ]);
}
```

### FullScreen Modal

A right-sliding modal with drag handles on both sides for Snapchat-style interactions.

#### Features
- Slide in from right animation
- Drag handles on left and right sides
- Snapchat-style swipe to close
- Custom title support
- Responsive design
- Keyboard escape support
- Backdrop click to close

#### Usage

```php
// In your Livewire component
<livewire:ui.modal.full-screen 
    :child="'user.component.shift-details'" 
    :title="'Shift Details'" 
/>
```

#### Parameters
- `child` (string): The Livewire component to render inside the modal
- `title` (string): Optional title for the modal header

#### Events
- `open-fullscreen`: Opens the modal
- `close-fullscreen`: Closes the modal

#### Example Implementation

```php
// In your component
public function openFullScreenModal()
{
    $this->dispatch('open-fullscreen', [
        'child' => 'user.component.shift-details',
        'title' => 'Shift Details'
    ]);
}
```

## Alpine.js Integration

Both components use Alpine.js for:
- Drag interactions
- Smooth animations
- State management
- Event handling

### Key Alpine.js Features Used

1. **Drag Functionality**
   - Touch and mouse event handling
   - Real-time position updates
   - Threshold-based actions

2. **Animations**
   - CSS transitions
   - Transform-based animations
   - Smooth enter/leave transitions

3. **State Management**
   - Reactive data binding
   - Component state synchronization
   - Event dispatching

## Styling

The components use Tailwind CSS classes for:
- Responsive design
- Dark theme support
- Smooth transitions
- Modern UI elements

### Key Styling Features

1. **Responsive Design**
   - Mobile-first approach
   - Flexible layouts
   - Touch-friendly interactions

2. **Dark Theme**
   - Gray color palette
   - Proper contrast ratios
   - Consistent styling

3. **Animations**
   - CSS transitions
   - Transform animations
   - Smooth interactions

## Implementation Details

### File Structure

```
app/Livewire/Ui/Modal/
├── HalfScreen.php
├── FullScreen.php
├── Demo.php
└── DemoContent.php

resources/views/livewire/ui/modal/
├── half-screen.blade.php
├── full-screen.blade.php
├── demo.blade.php
└── demo-content.blade.php
```

### Component Architecture

1. **Livewire Components**
   - Handle state management
   - Process events
   - Manage child component rendering

2. **Blade Templates**
   - Alpine.js integration
   - Responsive markup
   - Accessibility features

3. **Alpine.js Logic**
   - Drag interactions
   - Animation controls
   - Event handling

## Testing

Visit `/modal-demo` to test both modal components with various configurations.

### Demo Features

1. **HalfScreen Examples**
   - 25% height modal
   - 50% height modal
   - 75% height modal

2. **FullScreen Examples**
   - Basic fullscreen modal
   - Custom title modal

3. **Interactive Features**
   - Drag demonstrations
   - Animation showcases
   - Responsive testing

## Best Practices

### Performance
- Use lazy loading for child components
- Optimize Alpine.js event handlers
- Minimize DOM manipulations

### Accessibility
- Keyboard navigation support
- Screen reader compatibility
- Focus management

### Mobile Optimization
- Touch-friendly interactions
- Responsive design
- Performance optimization

## Troubleshooting

### Common Issues

1. **Modal not opening**
   - Check event dispatching
   - Verify component registration
   - Ensure proper routing

2. **Drag not working**
   - Check Alpine.js initialization
   - Verify event listeners
   - Test touch/mouse events

3. **Styling issues**
   - Check Tailwind CSS classes
   - Verify responsive design
   - Test dark theme compatibility

### Debug Tips

1. **Console Logging**
   - Add Alpine.js debug statements
   - Check Livewire events
   - Monitor performance

2. **Component Testing**
   - Test individual features
   - Verify event handling
   - Check state management

## Future Enhancements

### Planned Features
- Multiple modal stacking
- Custom animation options
- Advanced drag configurations
- Theme customization
- Accessibility improvements

### Extension Points
- Custom drag handlers
- Animation customization
- Theme integration
- Plugin architecture

## Support

For issues or questions:
1. Check the demo page at `/modal-demo`
2. Review this documentation
3. Test with different configurations
4. Check browser console for errors 