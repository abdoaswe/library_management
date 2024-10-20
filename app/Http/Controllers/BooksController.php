<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\BorrowingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Books\BooksRequest;
use App\Http\Requests\Books\UpdateBookRequest;
use App\Traits\GeneralTraits;

use App\Interfaces\BorrowingRepositoryInterface;


class BooksController extends Controller
{
    use GeneralTraits;
    private $borrowingRepository;
    public function __construct(BorrowingRepositoryInterface $borrowingRepository){
        $this->borrowingRepository = $borrowingRepository;
    }

    public function index()
    {
        return response()->json(Books::all());
    }

    public function store(BooksRequest $request)
    {


        $book = Books::create($request->all());

        if(!$book){

            return $this->responseError('Could not create');
        }

        return $this->responseCreated($book);

    }

    public function update(UpdateBookRequest $request, $id)
    {

        $book = Books::find($id);

       // check if book exists already in database and update
        if (!$book) {
            return $this->responseNotFound('Book not found' );
        }
        // update book details
        $book->update($request->all());


        return $this->responseSuccess($book);
    }

    public function destroy($id)
    {
        if (!$id) {
            return $this->responseError('Book ID is required');
        }
       $book= Books::find($id);
        if (!$book) {
            return $this->responseNotFound('Book not found');
        }
        $book->delete();

        return $this->responseSuccess('Book deleted successfully',204);
    }

    public function borrow(Request $request)
    {
        $bookId= $request->book_id;
        // check if book id is provided and exists in the database
        if(!$bookId){
            return $this->responseError('Book ID is required');
        }
        // check if user is authenticated and has a valid token
        $user = Auth::user();


        if (!$user) {
            return $this->responseNotFound('User not authenticated',401);
        }

        $book = Books::find($bookId);

       // check if book exists
        if (!$book) {
            return $this->responseNotFound('Book not found');
        }

        // borrowe book by  user
        $history=  $this->borrowingRepository->borrowBook($user,$bookId,$book);

       // check if book is already borrowed by the user
        if (!$history) {
            return $this->responseError('Could not borrow book');
        }

        return $this->responseSuccess($history,'Book borrowed successfully',201);


    }

    public function return(Request $request)
    {

        $bookId = $request->book_id;

         // check if book id is provided and exists in the database
        if (!$bookId) {
            return $this->responseError('Book ID is required');
        }
        $user = Auth::user();

        // check if user is authenticated and has a valid token
        if (!$user) {
            return $this->responseNotFound('User not authenticated',401);
        }

        $returnBooks= $this->borrowingRepository->returnBook($user ,$bookId);

        // check if book is returned successfully
        if (!$returnBooks) {
            return $this->responseNotFound('Could not Found book Or Returned');
        }

        return $this->responseSuccess($returnBooks,'Book returned successfully',201);

    }

    public function borrowingHistory()
    {
        $user = Auth::user();
        // check if user is authenticated and has a valid token
        if (!$user) {
            return $this->responseNotFound('User not authenticated',401);
        }

      $borrowingHistory=  $user->borrowingHistory()->with('book')->get();
        // get borrowing history of the user  with related book details  using eager loading
        return  $this->responseSuccess($borrowingHistory,'Book returned successfully',200);
    }
}
