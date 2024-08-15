<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class HomePage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $page = 'Home';

    protected $listeners = ['load-more' => 'loadMore'];

    public bool $isLoginModal = false;
    public int $iconRotateNo = 0;
    public string $name = '';
    public string $password = '';

    public $perPage = 10;

    public string $comment = '';
    public $image;


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
            $pin->delete();
            return;
        }

        $pin->create();
    }
}
