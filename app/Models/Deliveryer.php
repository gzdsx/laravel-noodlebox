<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasImageAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliveryer extends Model
{
    use HasFactory, HasImageAttribute, HasDates;

    protected $table = 'deliveryer';
    protected $fillable = [
        'name',
        'phone',
        'image',
        'status',
        'lng',
        'lat',
    ];
}
