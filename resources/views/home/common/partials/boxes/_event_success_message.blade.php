<div class="event-success-message">

    <div class="iziModal-content">

        <button data-iziModal-close class="icon-close">x</button>

        <div class="d-flex flex-column align-items-center justify-content-center main-message-container">

            <div class="text-center p-4">

                <i class="fa-regular fa-circle-check text-success icon-success"></i>

                <div class="mt-4">
                    ¡Te has inscrito correctamente en el evento <br> {{ ucwords(mb_strtolower($event->description,
                    'UTF-8')) }}!
                </div>

            </div>

            <footer>

                <a href="{{ route('aula.index') }}">
                    Ingresar al E-learning
                </a>

            </footer>

        </div>

    </div>

</div>