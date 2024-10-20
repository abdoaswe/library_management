<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowingHistory extends Model
{
    use HasFactory;

    protected $table='borrowing_histories';

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'returned_at',
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    // العلاقة مع الكتاب
    public function book()
    {
        return $this->belongsTo(Books::class ,'book_id','id');
    }
}
