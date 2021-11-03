<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

class Follow extends BaseModel
{
    use HasFactory;

    // public function user_source_id() {
    //     return $this->belongsTo(User::class, "user_id", "source_id");
    // }

    // public function user_target_id() {
    //     return $this->belongsTo(User::class, "user_id", "target_id");
    // }

    protected $fillable = [
        "source_id",
        "target_id",
    ];
}
