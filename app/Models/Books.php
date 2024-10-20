<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Books extends Model
{
    use HasFactory;

    protected $table='books';
    protected $fillable = [
        'title',
        'author',
        'year',
        'available_copies',
    ];

    public function borrowingHistory()
    {
        return $this->hasMany(BorrowingHistory::class, 'book_id');
    }
}
