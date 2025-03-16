<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'urgency',
        'topic_id',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
