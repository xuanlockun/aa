<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'sbd',
        'toan',
        'ngu_van',
        'ngoai_ngu',
        'vat_li',
        'hoa_hoc',
        'sinh_hoc',
        'lich_su',
        'dia_li',
        'gdcd',
        'ma_ngoai_ngu'
    ];

    public function khoiA()
    {
        return ($this->toan ?? 0)
            + ($this->vat_li ?? 0)
            + ($this->hoa_hoc ?? 0);
    }

    public function khoiB()
    {
        return ($this->toan ?? 0)
            + ($this->hoa_hoc ?? 0)
            + ($this->sinh_hoc ?? 0);
    }
}
