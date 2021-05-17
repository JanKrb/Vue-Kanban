<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:56'],
            'order' => ['required', 'integer']
        ]);

        $params = $request->all();
        $params['user_id'] = auth()->user()->id;

        return $request->user()
            ->statuses()
            ->create($params);
    }

    public function sync(Request $request)
    {
        $this->validate(request(), [
            'columns' => ['required', 'array']
        ]);

        foreach ($request->columns as $i => $status) {
            $order = $i + 1;
            request()->user()->statuses()
                ->find($status['id'])
                ->update(['order' => $order]);
        }

        return $request->user()->statuses()->with('tasks')->get();
    }
}
