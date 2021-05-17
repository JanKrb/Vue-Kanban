<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string', 'max:56'],
            'slug' => ['string'],
            'order' => ['required', 'integer']
        ]);

        $params = $request->all();
        $params['user_id'] = auth()->user()->id;

        return $request->user()
            ->statuses()
            ->create($params);
    }
}
