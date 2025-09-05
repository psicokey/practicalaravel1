<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class Comment extends Component
{
    public Model $commentable;
    public bool $showForm = false;
    public function toggle()
    {
        $this->showForm = !$this->showForm;
    }
    public function render()
    {
        return view('livewire.comment',[
            'comments' => $this->commentable->comments,
        ]);
    }
}
