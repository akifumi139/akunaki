<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostPin;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class RailsPage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $page = 'Rails';

    protected $listeners = ['load-more' => 'loadMore'];


    public function boot()
    {
        PostPin::where('status', false)->delete();
    }

    #[On('reload-list')]
    public function render()
    {
        return view('livewire.rails-page', []);
    }
}
