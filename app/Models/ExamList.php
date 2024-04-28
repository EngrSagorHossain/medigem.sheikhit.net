<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamList extends Model
{
    use HasFactory;

    public function subcategories()
    {
        return $this->belongsTo(SubCategory::class,'sub_cat_id');
    }

    public function mcqlist()
    {
        return $this->HasMany(McqList::class,'exam_list_id');
    }

    public function examhistorie()
    {
        return $this->HasMany(ExamHistorie::class,'exam_list_id');
    }


}
