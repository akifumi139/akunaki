<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class AuthModal extends Component
{
    public bool $isLoginModal = false;
    public int $iconRotateNo = 0;
    public string $name = '';
    public string $password = '';

    public function render()
    {
        return view('livewire.auth-modal');
    }

    public function clickIcon()
    {
        if (Auth::check()) {
            Auth::logout();
            $this->dispatch('reload-list');
            return;
        }

        $this->iconRotateNo  = $this->iconRotateNo + 1;
        if ($this->iconRotateNo === 3) {
            $this->isLoginModal = true;
        }
    }

    public function closeLoginModal()
    {
        $this->isLoginModal = false;
        $this->iconRotateNo = 0;
        $this->reset(['name', 'password']);
    }

    public function login()
    {
        $this->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['name' => $this->name, 'password' => $this->password])) {
            throw ValidationException::withMessages([
                'name' => ['ユーザー名またはパスワードが無効です。'],
            ]);
        }

        session()->flash('message', 'ログイン成功');
        $this->dispatch('reload-list');
        $this->closeLoginModal();
    }
}
