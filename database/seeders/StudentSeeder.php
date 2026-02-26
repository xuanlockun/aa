<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('app/diem_thi_thpt_2024.csv');

        if (!file_exists($path)) {
            $this->command->error("File not found!");
            return;
        }

        $file = fopen($path, 'r');

        // đọc header
        $header = fgetcsv($file);
        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

        $batch = [];
        $batchSize = 1000;

        while (($row = fgetcsv($file)) !== false) {

            if (count($row) !== count($header)) {
                continue;
            }

            $data = array_combine($header, $row);

            $batch[] = [
                'sbd' => $data['sbd'] ?? null,
                'toan' => $data['toan'] ?: null,
                'ngu_van' => $data['ngu_van'] ?: null,
                'ngoai_ngu' => $data['ngoai_ngu'] ?: null,
                'vat_li' => $data['vat_li'] ?: null,
                'hoa_hoc' => $data['hoa_hoc'] ?: null,
                'sinh_hoc' => $data['sinh_hoc'] ?: null,
                'lich_su' => $data['lich_su'] ?: null,
                'dia_li' => $data['dia_li'] ?: null,
                'gdcd' => $data['gdcd'] ?: null,
                'ma_ngoai_ngu' => $data['ma_ngoai_ngu'] ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) === $batchSize) {
                \App\Models\Student::insert($batch);
                $batch = [];
            }
        }

        // insert phần còn lại
        if (!empty($batch)) {
            \App\Models\Student::insert($batch);
        }

        fclose($file);

        $this->command->info("Import completed!");
    }
}
