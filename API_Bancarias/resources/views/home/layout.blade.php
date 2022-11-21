<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet"> <!-- Import Bootstrap Style -->
    <link href="{{ asset('bootstrap/css/bootstrap-grid.css') }}" rel="stylesheet"> <!-- Import Bootstrap Style -->
    <link href="{{ asset('bootstrap/css/bootstrap-reboot.css') }}" rel="stylesheet"> <!-- Import Bootstrap Style -->

    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <title>{{ __("Claro SandBox Financiera ") }} </title>
</head>
<body>

    <nav class="navbar bg-light">
        <div class="container-fluid ">
          <a class="navbar-brand" href="#">
            <i class="bi bi-bank" style="font-size: 2rem"></i>
            Sandbox Financiera
          </a>
        </div>
    </nav>

    @yield('content')


    <!-- Footer -->
    <footer class="bg-light text-center pt-4 mt-4">
        <!-- Grid container -->
        <div class="container p-4">

            <!-- Section: Social media -->

            <!-- Section: Form -->
            <section class="">
                <form action="">
                    <!--Grid row-->
                    <div class="row d-flex justify-content-center">
                    <!--Grid column-->
                    <div class="col-auto">
                        <p class="pt-2">
                            <strong>Example page Financier</strong>
                        </p>
                    </div>
                    <!--Grid column-->


                    <!--Grid column-->
                    </div>
                    <!--Grid row-->
                </form>
            </section>
            <!-- Section: Form -->

            <!-- Section: Text -->
            <section class="mb-4">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt distinctio earum
                repellat quaerat voluptatibus placeat nam, commodi optio pariatur est quia magnam
                eum harum corrupti dicta, aliquam sequi voluptate quas.
            </p>
            </section>
            <!-- Section: Text -->

            <!-- Section: Links -->
            <section class="">
            <!--Grid row-->
            {{-- <div class="row">
                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Links</h5>

                <ul class="list-unstyled mb-0">
                    <li>
                    <a href="#!" class="text-dark">Link 1</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 2</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 3</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 4</a>
                    </li>
                </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Links</h5>

                <ul class="list-unstyled mb-0">
                    <li>
                    <a href="#!" class="text-dark">Link 1</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 2</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 3</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 4</a>
                    </li>
                </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Links</h5>

                <ul class="list-unstyled mb-0">
                    <li>
                    <a href="#!" class="text-dark">Link 1</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 2</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 3</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 4</a>
                    </li>
                </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Links</h5>

                <ul class="list-unstyled mb-0">
                    <li>
                    <a href="#!" class="text-dark">Link 1</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 2</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 3</a>
                    </li>
                    <li>
                    <a href="#!" class="text-dark">Link 4</a>
                    </li>
                </ul>
                </div>
                <!--Grid column-->
            </div> --}}
            <!--Grid row-->
            </section>
            <!-- Section: Links -->
        </div>
        <!-- Grid container -->


    <!-- Copyright -->
    </footer>
    <!-- Footer -->

</body>
</html>
