<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqList extends Model
{
    use HasFactory;


    public function examlist()
    {
        return $this->belongsTo(ExamList::class,'exam_list_id');
    }

}
