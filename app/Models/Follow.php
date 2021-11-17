<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\BaseModel;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        "source_id",
        "target_id",
    ];

    /**
     * Get the source user of this follow action
     * @return BelongsTo
     */
     public function source(): BelongsTo
     {
         return $this->belongsTo(User::class);
     }

    /**
     * Get the target user of this follow action
     * @return BelongsTo
     */
     public function target(): BelongsTo
     {
         return $this->belongsTo(User::class);
     }

     public function notification()
     {
         return $this->hasOne(Notification::class);
     }
}
