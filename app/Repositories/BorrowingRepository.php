<?php

namespace App\Repositories;

use App\Interfaces\BorrowingRepositoryInterface;
use App\Models\BorrowingHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\Books;
use Carbon\Carbon;
use App\Traits\GeneralTraits;

class BorrowingRepository implements BorrowingRepositoryInterface
{
    use GeneralTraits;
    public function borrowBook($user, $bookId, $book)
    {



        if ($book->available_copies > 0) {
            $book->decrement('available_copies');

            // create a borrowing history record for the user and book

            $history = BorrowingHistory::create([
                'user_id' => $user->id,
                'book_id' => $bookId,
                'borrowed_at' => Carbon::now(),
            ]);
        }


        return $history;
    }

    public function returnBook($user, $bookId)
    {

        // find the borrowing history record for the user and book that is not returned yet
        $history = BorrowingHistory::where('user_id', $user->id)
            ->where('book_id', $bookId)
            ->whereNull('returned_at')
            ->first();

        // if the history exists, mark it as returned and increment the available copies in the books table
        if ($history) {
            $history->returned_at = now();
            $history->save();

            $book = Books::findOrFail($bookId);
            $book->increment('available_copies');

            return $history;
        }

        return $history;
    }

    public function getBorrowingHistory($userId)
    {
        // Logic to get borrowing history
    }
}
