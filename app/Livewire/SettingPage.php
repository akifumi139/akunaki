<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SettingPage extends Component
{
    public string $page = 'Setting';

    public User $user;
    public ?string $qrCodeImage = null;

    public function boot()
    {
        $this->user = Auth::user();
        $key = $this->user->key;

        if ($key) {
            $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($key));
            $this->qrCodeImage = "data:image/png;base64,$qrCode";
        }
    }

    public function render()
    {
        return view('livewire.setting-page');
    }

    public function makeQRCode()
    {
        $key = $this->user->createToken('akunaki')->plainTextToken;

        $this->user->update([
            'key' => $key,
        ]);

        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($key));
        $this->qrCodeImage = "data:image/png;base64,$qrCode";
    }
}
