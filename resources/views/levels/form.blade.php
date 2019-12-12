@extends('app')

@section('content')
    <style>
        .tiles span {
            cursor: pointer;
            padding: 15px 20px;
            margin: 5px;
            display: inline-block;
        }
        .tiles .unselected {
            background-color: red;
        }
        .tiles .selected {
            background-color: green;
        }
    </style>
    <div class="container">
        <?php $formRoute = isset($level) ? 'update' : 'store' ?>
        {!! Form::open(['route' => 'levels.' . $formRoute . '', 'method' => 'post', 'id' => 'level-form']) !!}
            <h2>
                <a href="{{ route('levels.list') }}"><span class="glyphicon glyphicon-list-alt"></span></a>
                Level Creation {{ Form::submit('Save', ['class' => 'btn btn-success']) }}</h2>
            <div class="row">
                <div class='col-md-4'>
                    <hr>
                    <h3>Level Attrs.</h3>
                    <hr>
                    <div class="form-group">
                        <label class="control-label">Starting Seconds</label>
                        <?php $startingSeconds = (isset($level) ? $level->starting_seconds : '') ?>
                        {!! Form::number('starting_seconds',  $startingSeconds, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label class="control-label">Player frequency to change color</label>
                        <?php $changingColorFrequency = (isset($level) ? $level->player_frequency_to_change_color : '') ?>
                        {!! Form::number('player_frequency_to_change_color', $changingColorFrequency, ['class' => 'form-control', 'step' => 'any']) !!}
                    </div>
                    <div class="form-group">
                        <label class="control-label">Colors quantity</label>
                        <?php $colorsQuantity = (isset($level) ? $level->colors_quantity : '') ?>
                        {!! Form::number('colors_quantity', $colorsQuantity, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label class="control-label">Enabled</label>
                        <?php $enabled = (isset($level) ? $level->enabled : '') ?>
                        {!! Form::select('enabled', [1 => 'Yes', 0 => 'No'], $enabled) !!}
                    </div>
                </div>
                <div class='col-md-4'>
                    <hr>
                    <h3>Stars</h3>
                    <hr>
                    @if($stars->isEmpty())
                        <p>¡No hay estrellas!</p>
                    @else
                        <ul class="list-unstyled">
                        @foreach($stars as $star)
                            <div class="form-group">
                                <label class="control-label">{{ $star->name }}</label>
                                <?php $minimumScore = isset($level) ? $star->pivot->minimum_score : '' ?>
                                {!! Form::number('minimum_scores[' . $star->id . '][minimum_score]', $minimumScore, 
                                ['class' => 'form-control', 'placeholder' => 'Tip minimum score to get it ...']) !!}
                            </div>
                        @endforeach
                        </ul>
                    @endif
                </div>
                <div class='col-md-4'>
                    <hr>
                    <h3>Tiles [ Rows: {{ $tileDimensions->rowsQuantity }}, Columns: {{ $tileDimensions->columnsQuantity}} ]</h3>
                    <hr>
                    <div class='tiles'>
                        <?php
                            $prevRowId = -1;
                            $tilesCont = 0;
                            $tilesHtml = "";
                            foreach($tiles as $tile) {
                                $value = isset($level) ? $tile->pivot->contain_enemy : 0 ;
                                $className = $value == 0 ? 'unselected' : 'selected';

                                if ($tile->row_index != $prevRowId) {
                                    $tilesHtml .= "</div><div class='block'>";
                                    $prevRowId = $tile->row_index;
                                }
                                $tilesHtml .= "<span class='tile $className' data-tileId='$tile->id'></span>"
                                    . "<input type='hidden' name='tiles[$tile->id][contain_enemy]' value='$value'/>";
                                $tilesCont ++;
                            }
                        ?>
                        <div class="block">
                        {!! $tilesHtml !!}
                        </div>
                    </div>
                </div>
                @if(isset($level))
                    <input type='hidden' name='level_id' value='<?= $level->id ?>' />
                @endif
            </div>
            <div class='row'>
                <div class='col-md-4'>
                    <hr>
                    <h3>Enemy Types (Appear %)</h3>
                    <hr>
                    <div class='enemy-types'>
                        @foreach($enemyTypes as $enemyType)
                            <div class="form-group">
                                <label class="control-label">{{ $enemyType->type}}</label>
                                <?php $probability = isset($level) ? $enemyType->pivot->probability : '' ?>
                                {!! Form::number('probabilities[' . $enemyType->id . '][probability]', $probability,
                                ['class' => 'form-control', 'placeholder' => 'Tip probability to appear, Ex: 75.00', 'step' => 'any']) !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <script type='text/javascript'>
        $(".tile").click( function() {
            var tileId = $(this).attr('data-tileId');
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                $(this).addClass('unselected');
                $("[name='tiles["+tileId+"][contain_enemy]']").val(0);
            } else {
                $(this).removeClass('unselected');
                $(this).addClass('selected');
                $("[name='tiles["+tileId+"][contain_enemy]']").val(1);
            }
        });

        $("#level-form").submit( function() {
            var shouldSendForm = true;

            var totalPercentage = 0;
            $(".enemy-types input[type='number']").each(function () {
                totalPercentage += parseFloat($(this).val());
                if (totalPercentage > 100) {
                    shouldSendForm = false;
                    $(this).focus();
                    alert("La suma de porcentajes debe ser 100.");
                    return;
                }
            });

            return shouldSendForm;
        });

    </script>
@endsection