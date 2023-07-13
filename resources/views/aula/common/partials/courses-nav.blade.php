


<div class="row mb-5 nav-modules-course">

    <ul class="nav nav-fill">
        <li class="nav-item">
            <a class="nav-link" href="#">Módulo 1</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Módulo 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Módulo 3</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{setActive('aula.course.evaluation.index')}}"
                href="{{route('aula.course.evaluation.index', $course)}}">Evaluaciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{setActive('aula.course.folder.*')}}"
                href="{{route('aula.course.folder.index', $course)}}">Carpetas</a>
        </li>
    </ul>

</div>