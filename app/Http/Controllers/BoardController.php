<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {
        $boards = auth()->user()->boards->map(
          function ($board) {
              $board->user = User::where('id', $board->user_id)->first();
              return $board;
          }
        );

        return view('boards.index', compact('boards'));
    }
}
