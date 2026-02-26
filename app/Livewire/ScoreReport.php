<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use Illuminate\Support\Facades\Cache;

class ScoreReport extends Component
{
    public $report = [];
    public $fromCache = true;

    public function mount()
    {
        $this->loadReport();
    }

    public function loadReport()
    {
        // Cache trong 1 giờ (3600 giây)
        $this->report = Cache::remember('score_report', 3600, function () {
            $this->fromCache = false;
            return $this->queryFromDatabase();
        });

        $this->dispatch('report-updated');
    }

    private function queryFromDatabase()
    {
        $subjects = [
            'toan','ngu_van','ngoai_ngu',
            'vat_li','hoa_hoc','sinh_hoc',
            'lich_su','dia_li','gdcd'
        ];

        $report = [];

        foreach ($subjects as $subject) {
            $report[$subject] = [
                '>=8' => Student::where($subject, '>=', 8)->count(),
                '6-8' => Student::whereBetween($subject, [6, 7.99])->count(),
                '4-6' => Student::whereBetween($subject, [4, 5.99])->count(),
                '<4' => Student::where($subject, '<', 4)->count(),
            ];
        }

        return $report;
    }

    // Nếu muốn force refresh
    public function forceRefresh()
    {
        Cache::forget('score_report');
        $this->loadReport();
    }

    public function render()
    {
        return view('score-report');
    }
}