@extends('admin.common.layouts.masterpage')

@section('content')

<div class="row content">

    <div class="main-container-page">
        <div class="card page-title-container">
            <div class="card-header">
                <div class="total-width-container">
                    <h4>EXÁMENES</h4>
                </div>
            </div>
        </div>

        <div id="question-box-container">
        </div>

        <div id="dropdown-questions-create" class="card-body card z-index-2 principal-container">

            <h5 class="title-header-show">
                <i class="fa-solid fa-chevron-left fa-xs"></i>
                <a href="{{route('admin.exams.index')}}">Inicio</a>
                / Examen:
                <a href="{{ route('admin.exams.showQuestions', ["exam" => $question->exam]) }}" class="to-capitalize">
                    {{mb_strtolower($question->exam->title, 'UTF-8')}}
                </a>
                / Enunciado:
                <span id="question-statement-container">
                    {{ $question->statement }}
                </span>
            </h5>

            <hr>

            <form id="updateQuestionForm" action="{{route('admin.exams.questions.update', $question)}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div id="question-type-container">

                    @if($question->question_type_id == 1)
                        @include('admin.exams.partials.questionTypes.unique_answer')
                    @elseif($question->question_type_id == 2)
                        @include('admin.exams.partials.questionTypes.multiple_answer')
                    @elseif($question->question_type_id == 3)
                        @include('admin.exams.partials.questionTypes.true_false')
                    @elseif($question->question_type_id == 4)
                        @include('admin.exams.partials.questionTypes.fill_in_the_blank')
                    @elseif($question->question_type_id == 5)
                        @include('admin.exams.partials.questionTypes.matching')
                    @endif

                </div>

            </form>

            <hr>
   
        </div>

    </div>

</div>

@endsection
