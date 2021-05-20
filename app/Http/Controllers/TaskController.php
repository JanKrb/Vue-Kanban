<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($board_id)
    {
        $tasks = auth()->user()->statuses()->with('tasks')->get();

        return view('tasks.index', compact('tasks', 'board_id'));
    }

    public function store(Request $request, $board_id)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:56'],
            'description' => ['nullable', 'string'],
            'status_id' => ['required', 'exists:statuses,id'],
            'board_id' => ['required', 'integer']
        ]);

        return $request->user()
            ->tasks()
            ->create($request->only('title', 'description', 'status_id'));
    }

    public function sync(Request $request, $board_id)
    {
        $this->validate(request(), [
            'columns' => ['required', 'array']
        ]);

        foreach ($request->columns as $status) {
            foreach ($status['tasks'] as $i => $task) {
                $order = $i + 1;
                if ($task['status_id'] !== $status['id'] || $task['order'] !== $order) {
                    request()->user()->tasks()
                        ->find($task['id'])
                        ->update(['status_id' => $status['id'], 'order' => $order]);
                }
            }
        }

        return $request->user()->statuses()->with('tasks')->get();
    }

    public function update(Request $request, Task $task)
    {
        //
    }
}
