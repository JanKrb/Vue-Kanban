@extends('layouts.app')

@section('content')
    <div class="md:mx-4 relative overflow-hidden">
        <main class="h-full flex flex-col overflow-auto">
            <board-overview :initial-data="{{ $boards }}"></board-overview>
        </main>
    </div>
@endsection
