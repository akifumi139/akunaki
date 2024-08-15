<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostPin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Livewire\Attributes\On;

class HomePage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $page = 'Home';

    protected $listeners = ['load-more' => 'loadMore'];

    public $perPage = 10;

    public string $comment = '';
    public $image;

    public function boot()
    {
        PostPin::where('status', false)->delete();
    }

    #[On('reload-list')]
    public function render()
    {
        $posts = Post::with('images')
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.home-page', [
            'posts' => $posts,
        ]);
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
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

        $this->uploadImage($post);

        $this->reset(['comment', 'image']);
    }

    private function uploadImage(Post $post): void
    {
        if (!$this->image) {
            return;
        }

        $tmpImagePath = $this->image->store('images', 'public');

        $accessPath = storage_path('app/public/' . $tmpImagePath);

        $manager = new ImageManager(Driver::class);
        $image = $manager->read($accessPath);


        $image->scaleDown(width: 2000);
        $image = $image->encode(new WebpEncoder(quality: 100));

        $pathInfo = pathinfo($tmpImagePath);
        $imagePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

        $savePath =  storage_path('app/public/' . $imagePath);
        $image->save($savePath);

        PostImage::create([
            'filename' => $this->image->getClientOriginalName(),
            'path' => $imagePath,
            'post_id' => $post->id,
        ]);
    }

    public function delete(int $id): void
    {
        Post::destroy($id);
    }

    public function pushPin(int $id): void
    {
        $pin = Post::find($id)->pin();

        if ($pin->first()) {
            $pin->where('user_id', Auth::id())->delete();
            return;
        }

        $pin->create([
            'user_id' => Auth::id(),
            'status' => true,
            'updated_at' => now(),
        ]);
    }
}
