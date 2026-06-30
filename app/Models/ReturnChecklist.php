<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnChecklist extends Model
{
    use HasFactory;

    protected $table = 'return_checklists';

    protected $primaryKey = 'return_checklist_id';

    protected $fillable = [
        'item_name',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('item_name');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
