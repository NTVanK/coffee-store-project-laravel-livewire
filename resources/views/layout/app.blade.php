<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Hydros | @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets\img\logoC.svg') }}" />

    <!-- Thư viện style (font-awesome, bootstrap) -->
    <link rel="stylesheet" href="{{ asset('assets') }}/bootstrap/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets') }}/font-awesome/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/animate.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/app/navbar.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/app/footer.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/app/home.css" type="text/css">

    <!-- Thư viện script (jQuery, bootstrap) -->
    <script data-navigate-once src="{{ asset('assets') }}/node_modules/jquery/dist/jquery.min.js"></script>
    <script data-navigate-once defer src="https://unpkg.com/@alpinejs/ui@3.13.7-beta.0/dist/cdn.min.js"></script>
    @yield('css')
    @livewireStyles
</head>

<body class="bg-body-secondary">
    @include('layout.inc.app.navbar')
    @yield('content')
    @include('layout.inc.app.footer')
    @livewireScripts
</body>

@yield('js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        @if (session('toast'))
            var toastData = @json(session('toast'));
            showToast(toastData.type, toastData.message);
        @endif
    });

    function showToast(type, message) {
        var toastHTML =
            `<div id="liveToast" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header ${type === 'success' ? 'bg-success-subtle' : 'bg-danger-subtle'}">
                    <strong class="me-auto">Thông báo</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${ message }
                </div>
            </div>`;

        var toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        var toast = new bootstrap.Toast(toastContainer.lastElementChild);
        toast.show();
    }

    document.addEventListener('DOMContentLoaded', () => {
        window.addEventListener('show-toast', event => {
            const {
                type,
                message
            } = event.detail[0];
            showToast(type, message);
        });

        window.addEventListener('close-modal', () => {
            var modal = document.getElementById('closeModal');
            modal.click();
        });

        const backtotop = document.getElementById('BackToTop');
        backtotop.addEventListener('click', () => {
            document.body.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        });
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backtotop.classList.add('active');
            }
            else
            {
                backtotop.classList.remove('active');
            }
        });
    });
</script>
<script data-navigate-once src="{{ asset('assets') }}/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</html>
