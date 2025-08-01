<?php

namespace App\Livewire\Auth;

use App\Services\AuthApiService;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:6')]
    public string $password = '';

    public bool $remember = false;
    public bool $loading = false;
    public string $errorMessage = '';

    protected AuthApiService $authService;

    public function boot(AuthApiService $authService)
    {
        $this->authService = $authService;
        
        // Redirect if already authenticated
        if ($this->authService->isAuthenticated()) {
            return $this->redirect('/', navigate: true);
        }
    }

    public function login()
    {
        $this->validate();
        
        $this->loading = true;
        $this->errorMessage = '';

        try {
            $result = $this->authService->login($this->email, $this->password);

            if ($result['success']) {
                session()->flash('message', 'Welcome back!');
                Notification::make()
                    ->title('System Notification')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->body('Success! You are now logged in.')
                    ->send();
                return $this->redirect('/', navigate: true);
            } else {
                $this->errorMessage = $result['message'];
                Notification::make()
                    ->title('System Notification')
                    ->body('Error! ' . $this->errorMessage)
                    ->send();
                
                // Handle field-specific errors
                if (!empty($result['errors'])) {
                    foreach ($result['errors'] as $field => $messages) {
                        $this->addError($field, is_array($messages) ? $messages[0] : $messages);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'An unexpected error occurred. Please try again.';
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
