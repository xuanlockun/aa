<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;

class ScoreSearch extends Component
{
    public $sbd;
    public $student;
    public $notFound = false;

    public function search()
    {
        $this->validate([
            'sbd' => 'required|string|max:20'
        ]);

        $this->student = Student::where('sbd', $this->sbd)->first();

        $this->notFound = !$this->student;
    }

    public function render()
    {
        return view('score-search');
    }
}