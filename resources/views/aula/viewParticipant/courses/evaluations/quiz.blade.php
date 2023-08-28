@extends('aula.common.layouts.masterpage')

@section('content')

<div class="content global-container quiz">

    <div class="quiz-container quiz col-12">

        <div class="card quiz z-index-2">

            @php

            $evaluation = $evaluations[$num_question];
            $evaluation_time = $evaluation->evaluation_time;
            $diff_time = ($evaluation_time + ($exam->exam_time * 60)) - time();
            $type_id = $question->question_type_id;

            @endphp

            @if(!is_null($exam))


            <div class="info">

                <h3> {{$exam->title}} </h3>

                <div class="timer-container">
                    <i class="fa-regular fa-clock fa-spin fa-lg"></i> &nbsp;
                    <span class="timer"> </span>
                </div>

            </div>

            <input type="hidden" name="examId" value="{{$exam->id}}">

            <ul id="progressbar">

                @foreach($evaluations as $key => $eval)

                <li class="{{$key <= $num_question ? 'active' : ''}}" style="width: calc(100%/{{count($evaluations)}}">
                </li>

                @endforeach

            </ul>


            @if ($type_id == 1 || $type_id == 3)
            @include('aula.viewParticipant.courses.evaluations.types.unique_answer')
            @elseif ($type_id == 2)
            @include('aula.viewParticipant.courses.evaluations.types.multiple_answers')
            @elseif ($type_id == 4)
            @include('aula.viewParticipant.courses.evaluations.types.fill_in_the_blank')
            @elseif ($type_id == 5)
            @include('aula.viewParticipant.courses.evaluations.types.matching')
            @endif
            
            <script>
                const timer = document.querySelector('.timer');
                    let diff = @json($diff_time);

                    function showTime()
                    {
                        let minutes = Math.floor((diff / 60));
                        let seconds = Math.floor((diff % 60));

                        timer.innerHTML=
                        minutes + " minutos " + seconds + " segundos";
                    }

                    function showRemaining(){
                        diff = diff - 1;
                        if(diff < 0)
                        {
                            clearInterval(clock);
                            timer.innerHTML = "SE ACABÓ EL TIEMPO";
                            return;
                        }
            
                        showTime();
                    }

                    showTime();
            
                    let clock; 
                    clock = setInterval(showRemaining, 1000); 
            
            </script>
            @endif

        </div>

    </div>

</div>

@endsection