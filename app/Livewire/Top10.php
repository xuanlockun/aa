<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class Top10 extends Component
{
    public $topStudents = [];
    public $subject = 'group_a'; // mặc định là khối A

    public function mount()
    {
        $this->loadTop10();
    }

    public function loadTop10()
    {
        // Tính tổng điểm 3 môn Toán, Lý, Hóa
        $this->topStudents = Student::select(
                'sbd',
                'toan',
                'vat_li',
                'hoa_hoc',
                DB::raw('(COALESCE(toan, 0) + COALESCE(vat_li, 0) + COALESCE(hoa_hoc, 0)) as total_score')
            )
            ->whereNotNull('toan')
            ->whereNotNull('vat_li')
            ->whereNotNull('hoa_hoc')
            ->orderBy('total_score', 'desc')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('top10');
    }
}