<?php

use Livewire\Component;
use App\Models\Student;

new class extends Component {

    public $sbd = '';
    public $student = null;
    public $notFound = false;

    public function search()
    {
        $this->validate([
            'sbd' => 'required'
        ]);

        $this->student = Student::where('sbd', $this->sbd)->first();

        $this->notFound = !$this->student;
    }

};
?>

<div class="max-w-xl mx-auto p-6  shadow rounded">

    <h2 class="text-xl font-bold mb-4 text-center">
        Tra cứu điểm thi THPT 2024
    </h2>

    <div class="flex gap-2">
        <input 
            type="text"
            wire:model="sbd"
            placeholder="Nhập số báo danh"
            class="flex-1 border rounded px-3 py-2"
        >

        <button 
            wire:click="search"
            class="bg-blue-600 text-white px-4 py-2 rounded"
        >
            Tra cứu
        </button>
    </div>

    @error('sbd')
        <p class="text-red-500 mt-2">{{ $message }}</p>
    @enderror

    @if($student)
        <div class="mt-6 border-t pt-4">
            <h3 class="font-semibold mb-2">Kết quả:</h3>

            <p>Toán: {{ $student->toan }}</p>
            <p>Ngữ văn: {{ $student->ngu_van }}</p>
            <p>Ngoại ngữ: {{ $student->ngoai_ngu }}</p>
            <p>Vật lý: {{ $student->vat_li }}</p>
            <p>Hóa học: {{ $student->hoa_hoc }}</p>
            <p>Sinh học: {{ $student->sinh_hoc }}</p>
            <p>Lịch sử: {{ $student->lich_su }}</p>
            <p>Địa lý: {{ $student->dia_li }}</p>
            <p>GDCD: {{ $student->gdcd }}</p>
        </div>
    @endif

    @if($notFound)
        <p class="text-red-600 mt-4">
            Không tìm thấy số báo danh.
        </p>
    @endif

</div>