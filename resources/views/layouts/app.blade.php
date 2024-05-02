<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('meetings.index') }}">{{ __('Meetings') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
     @php
        $showToast = false;
        if ($messages = Session::get('success')) {
            $showToast = true;
            $toastType = 'success';
            $toastMessage = '<p>' . $messages . '</p>';
        }

        if ($messages = Session::get('error')) {
            $messages = $messages->all();
            $showToast = true;
            $toastType = 'error';
            $toastMessage = '';
            foreach ($messages as $message) {
                $toastMessage .= '<p>' . $message . '</p>';
            }
        }
    @endphp
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <!-- Sweetaleart -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($showToast)
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: "{{ $toastType }}",
                title: '{!! $toastMessage !!}'
            });
        </script>

    @endif
<script>
    $(document).ready(function() {
        // Function to add email record
        function addEmailRecord(inputValue) {
            $('#attendeesWrapper').append('<div class="input-group mt-2"><input type="email" class="form-control attendee-input" name="attendees[]" value="' + inputValue + '"><div class="input-group-append"><button class="btn btn-outline-danger remove-email" type="button">&times;</button></div></div>');
        }

        // Event listener for adding email record on Enter key press
        $('#attendeesWrapper').on('keydown', '.attendee-input', function(e) {
            if (e.keyCode == 13) { // Check if the key pressed is Enter
                e.preventDefault(); // Prevent the default action (submitting the form)
                var inputValue = $(this).val().trim();
                if (inputValue !== '') {
                    addEmailRecord(inputValue); // Call function to add email record
                    $(this).val(''); // Clear input value
                }
            }
        });

        // Event listener for removing email record
        $('#attendeesWrapper').on('click', '.remove-email', function() {
            $(this).closest('.input-group').remove(); // Remove the closest parent element with class .input-group
        });
    });
</script>

</body>
</html>
