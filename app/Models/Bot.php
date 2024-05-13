<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    const ACTIVE    = 'ACTIVE';
    const UNACTIVE    = 'UNACTIVE';

    protected $fillable = [
        'name',
        'data_source',
        'status',
    ];

    protected $casts = [
        'data_source' => 'array'
    ];
}
