<div class="max-w-4xl mx-auto p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">
        🏆 TOP 10 THÍ SINH KHỐI A (TOÁN - LÝ - HÓA)
    </h2>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                    <th class="p-3 text-center">#</th>
                    <th class="p-3 text-left">SBD</th>
                    <th class="p-3 text-center">Toán</th>
                    <th class="p-3 text-center">Vật Lý</th>
                    <th class="p-3 text-center">Hóa Học</th>
                    <th class="p-3 text-center bg-yellow-500">Tổng điểm</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topStudents as $index => $student)
                    <tr class="border-b hover:bg-gray-50 transition {{ $index < 3 ? 'bg-yellow' : '' }}">
                        <td class="p-3 text-center font-bold">
                            @if($index == 0)
                                <span class="text-2xl">🥇</span>
                            @elseif($index == 1)
                                <span class="text-2xl">🥈</span>
                            @elseif($index == 2)
                                <span class="text-2xl">🥉</span>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </td>
                        <td class="p-3 font-mono">{{ $student->sbd }}</td>
                        <td class="p-3 text-center">{{ number_format($student->toan, 2) }}</td>
                        <td class="p-3 text-center">{{ number_format($student->vat_li, 2) }}</td>
                        <td class="p-3 text-center">{{ number_format($student->hoa_hoc, 2) }}</td>
                        <td class="p-3 text-center font-bold text-lg {{ $index < 3 ? 'text-yellow-600' : 'text-blue-600' }}">
                            {{ number_format($student->total_score, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            Chưa có dữ liệu học sinh
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Thống kê thêm --}}
    @if(count($topStudents) > 0)
    <div class="mt-6 grid grid-cols-3 gap-4 text-center">
        <div class="bg-blue-100 p-4 rounded">
            <div class="text-sm text-gray-600">Điểm cao nhất</div>
            <div class="text-2xl font-bold text-blue-600">
                {{ number_format($topStudents->max('total_score'), 2) }}
            </div>
        </div>
        <div class="bg-green-100 p-4 rounded">
            <div class="text-sm text-gray-600">Điểm trung bình top 10</div>
            <div class="text-2xl font-bold text-green-600">
                {{ number_format($topStudents->avg('total_score'), 2) }}
            </div>
        </div>
        <div class="bg-purple-100 p-4 rounded">
            <div class="text-sm text-gray-600">Điểm thấp nhất top 10</div>
            <div class="text-2xl font-bold text-purple-600">
                {{ number_format($topStudents->min('total_score'), 2) }}
            </div>
        </div>
    </div>
    @endif
</div>