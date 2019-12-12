@extends('app')

@section('content')
<div class="container">
    <h1>Levels List 
        <a href="{{ route('levels.create') }}">
            <button class="btn btn-success">Create</button>
        </a>
    </h1>
    @if (!empty($infoMessage))
        <div><p class='text-success'>{{ $infoMessage }}</p></div>
    @endif
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Starting seconds</th>
                <th class="text-center">Changing color time</th>
                <th class="text-center">Colors quantity</th>
                <th class="text-center">Enabled</th>
                <th class="text-center">Playing users</th>
                <th class="text-center">Acts.</th>
            </tr>
        </thead>
        <tbody>
            @if($levels->isEmpty())
            @else
                @foreach($levels as $level)
                    <tr>
                        <td>{{ $level->id }}</td>
                        <td>{{ $level->starting_seconds }}</td>
                        <td>{{ $level->player_frequency_to_change_color }}</td>
                        <td>{{ $level->colors_quantity }}</td>
                        <td>{{ $level->enabled_text }}</td>
                        <td>{{ $level->players_playing_quantity }}</td>
                        <td>
                            <a href="{{ route('levels.edit', ['id' => $level->id]) }}"><span class="glyphicon glyphicon-edit"></span></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection