<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\BorrowingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\GeneralTraits;

class BookReportsController extends Controller
{
    use GeneralTraits;
    public function borrowedBooksReport()
{
        $userId= Auth::user()->id;

        if(!$userId){
            return $this->sendErrorResponse('Unauthorized access');
        }

    // Get all borrowed books with their details (book title, borrower's name, and due date)
    $borrowedBooks = BorrowingHistory::whereNotNull('returned_at')
                            ->with(['book', 'user'])
                            ->get();


    // Check if there are any borrowed books
    if ($borrowedBooks->isEmpty()) {

        return $this->responseNotFound('No books are currently borrowed in this user');
    }

    return $this->responseSuccess($borrowedBooks );

}


public function popularBooksReport()
{
    // Get the top 10 most popular books based on the number of times they've been borrowed
    $popularBooks = Books::withCount('borrowingHistory')
                    ->orderBy('borrowing_history_count', 'desc')
                    ->take(10)
                    ->get();


   // Check if there are any popular books
    if ($popularBooks->isEmpty()) {
        return $this->responseNotFound('No popular books found');
    }



    return $this->responseSuccess($popularBooks );

}



}
