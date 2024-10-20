<?php

namespace App\Interfaces;

interface BorrowingRepositoryInterface
{
    public function borrowBook($user,$bookId,$book);
    public function returnBook($user, $bookId);
    public function getBorrowingHistory($userId);
}
