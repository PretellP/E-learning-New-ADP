<table>

    <thead>
        <tr>
            <th>N° de encuesta de usuario</th>
            <th>DNI</th>
            <th>A. Paterno</th>
            <th>A. Materno</th>
            <th>Nombres</th>
            <th>Empresa</th>
            <th>Encuesta</th>
            <th>Fecha de finalización</th>
            <th>Instructor</th>
            <th>Curso</th>

            @for ($i = 1; $i <= $maxColumns; $i++)
            <th> Pregunta #{{ $i }} </th>
            <th> Respuesta #{{ $i }} </th>
            @endfor

        </tr>
    </thead>

    <tbody>

        @foreach ($userSurveys as $userSurvey)

        <tr>
            <td> {{ $userSurvey->id }} </td>
            <td> {{ $userSurvey->user->dni }} </td>
            <td> {{ $userSurvey->user->paternal }} </td>
            <td> {{ $userSurvey->user->maternal }} </td>
            <td> {{ $userSurvey->user->name }} </td>
            <td> {{ $userSurvey->company->description }} </td>
            <td> {{ $userSurvey->survey->name }} </td>
            <td> {{ $userSurvey->end_time }} </td>
            <td> {{ $userSurvey->event != null ? $userSurvey->event->user->full_name : 'No hay registros' }} </td>
            <td> {{ $userSurvey->event != null ? $userSurvey->event->course->description : 'No hay registros' }} </td>

            @foreach ($userSurvey->surveyAnswers as $surveyAnswer)
            <td> {{ $surveyAnswer->pivot->statement }} </td>
            <td> {{ $surveyAnswer->pivot->answer }} </td>
            @endforeach

        </tr>
            
        @endforeach

    </tbody>

</table>