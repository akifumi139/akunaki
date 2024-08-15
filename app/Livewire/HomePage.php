<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class HomePage extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $listeners = ['load-more' => 'loadMore'];

    public $perPage = 10;

    public string $comment = '';
    public $image;

    public $isLoginModal = false;
    public int $iconRotateNo = 0;

    public function loadMore(): void
    {
        $this->perPage += 10;
    }

    public function boot()
    {
        $user = User::find(1);
        Auth::login($user);
        // Auth::logout();
    }

    public function clickIcon()
    {
        $this->iconRotateNo  = $this->iconRotateNo + 1;
    }


    public function render()
    {
        $posts = Post::with('images')
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.home-page', [
            'posts' => $posts,
        ]);
    }

    public function add(): void
    {
        $this->validate([
            'image' => 'nullable|image|max:1024',
            'comment' => 'required|string|max:255',
        ]);

        $post =  Post::create([
            'user_id' => Auth::id(),
            'comment' => $this->comment,
        ]);

        if ($this->image) {
            $imagePath = $this->image->store('images', 'public');

            PostImage::create([
                'filename' => $this->image->getClientOriginalName(),
                'path' => $imagePath,
                'post_id' => $post->id,
            ]);
        }

        $this->reset(['comment', 'image']);
    }

    public function delete(int $id): void
    {
        Post::destroy($id);
    }

    public function pushPin(int $id): void
    {
        $pin = Post::find($id)->pin();

        if ($pin->first()) {
            $pin->delete();
            return;
        }

        $pin->create();
    }
}
