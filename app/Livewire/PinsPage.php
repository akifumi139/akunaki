<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostPin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Imagick;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Drivers\Imagick\Driver;

class PinsPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $page = 'Pins';

    protected $listeners = ['load-more' => 'loadMore'];

    public bool $isLoginModal = false;
    public int $iconRotateNo = 0;
    public string $name = '';
    public string $password = '';

    public $perPage = 10;

    public string $comment = '';
    public $image;

    public function boot()
    {
        PostPin::where('status', false)->delete();
    }

    public function render()
    {
        $posts = Post::with('images')
            ->orderByDesc('id')
            ->whereHas('pin', function ($query) {
                $query->whereNotNull('id');;
            })
            ->paginate($this->perPage);

        return view('livewire.pins-page', [
            'posts' => $posts,
        ]);
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
    }

    public function clickIcon()
    {
        if (Auth::check()) {
            Auth::logout();
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
        $this->closeLoginModal();
    }

    public function delete(int $id): void
    {
        Post::destroy($id);
    }

    public function pushPin(int $id): void
    {
        $pin = Post::find($id)->pin();

        if ($pin->first()) {
            // ピンを解除したとしてもつけなおす可能性が高いため、Pin止め情報は残す方針
            // ページリロード・遷移時に、ピン状態がfalseのものを消す
            $pin
                ->where('user_id', Auth::id())
                ->update([
                    'status' => false
                ]);
            return;
        }

        $pin->create([
            'user_id' => Auth::id(),
            'status' => true,
            'updated_at' => now(),
        ]);
    }
}
