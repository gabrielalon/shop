<!doctype html>
<html lang="{{locale()->current()}}" dir="{{locale()->dir()}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('images/web/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('assets/web/css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('assets/web/css/custom.css') }}" rel="stylesheet">
    @yield('css-script')
</head>
<body class="text-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 background-top"></div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <div class="content">
        <div class="container" style="max-width: 1400px">
            <div class="row">
                <div class="col-md-12 mt-5">
                    <nav class="navbar navbar-expand-lg rounded">
                        <a class="navbar-brand mb-3" href="#">
                            www.nowagruppe.com
                        </a>
                        <button class="navbar-toggler" type="button"
                                data-toggle="collapse"
                                data-target="#navbar" aria-controls="navbar"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-align-justify"></i>
                        </button>

                        <div class="collapse navbar-collapse justify-content-md-end" id="navbar">
                            <ul class="navbar-nav p-1">
                                <li class="nav-item active">
                                    <img class="m-3" src="{{ asset('images/web/ofirmie.png') }}" alt="" />
                                    <a class="nav-link mr-3 ml-3" href="#">O FIRMIE<span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <img class="m-3" src="{{ asset('images/web/oferta.png') }}" alt="" />
                                    <a class="nav-link mr-3 ml-3" href="#">OFERTA</a>
                                </li>
                                <li class="nav-item">
                                    <img class="m-3" src="{{ asset('images/web/galeria.png') }}" alt="" />
                                    <a class="nav-link mr-3 ml-3" href="#">GALERIA</a>
                                </li>
                                <li class="nav-item">
                                    <img class="m-3" src="{{ asset('images/web/wynajem.png') }}" alt="" />
                                    <a class="nav-link mr-3 ml-3" href="#">WYNAJEM ZGRZEWAREK</a>
                                </li>
                                <li class="nav-item">
                                    <img class="m-3" src="{{ asset('images/web/promocje.png') }}" alt="" />
                                    <a class="nav-link mr-3 ml-3" href="#">PROMOCJE</a>
                                </li>
                                <li class="nav-item">
                                    <img class="m-3" src="{{ asset('images/web/kontakt.png') }}" alt="" />
                                    <a class="nav-link mr-3 ml-3" href="#">KONTAKT</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4 text-right pt-lg-4">
                    <img src="{{ asset('images/web/mail.png') }}" alt="">
                    <a class="mail" href="mailto:biuro@nowagruppe.com">biuro@nowagruppe.com</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4 pt-lg-4">
                    <nav class="navbar navbar-expand-lg rounded justify-content-end p-0">
                        <ul class="navbar navbar-media p-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <img src="{{ asset('images/web/YouTube.png') }}" alt="">
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <img src="{{ asset('images/web/Facebook.png') }}" alt="">
                                </a>
                            </li>

                            <li class="nav-item pr-0">
                                <a class="nav-link pr-0" href="#">
                                    <img src="{{ asset('images/web/Instagram.png') }}" alt="">
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="row mt-3 p-3">
                <div class="col-md-8"></div>
                <div class="col-md-4 lider text-left">
                    <h1>LIDER PRODUKCJI</h1>

                    <br />
                    <p class="font-weight-normal">
                    ZAMOCOWAŃ DO
                    IZOLACJI TERMICZNYCH
                    ORAZ ZGRZEWAREK
                    </p>
                </div>
            </div>

            <div class="row p-3">
                <div class="col-md-1"></div>
                <div class="col-md-11 p-4 promo">
                    <span><strong>Teraz do 23.IX.2020</strong> - uzyskaj 20% rabatu na cały asortyment.
                    Przejdź do zakładki "PROMOCJE" i zapoznaj się z innymi przygotowanymi dla Ciebie promocjami...</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-lg-5 pb-lg-5"
         style="background: linear-gradient(to right, #171717 0, #171717 40%, #DEDEDE 40%, #DEDEDE 100%);">
        <br />
        <br />
        <br />
        <br />
        <div class="container" style="max-width: 1400px">
            <div class="row lead">
                <div class="col-md-7">
                    <img class="pic1" src="{{ asset('images/web/zdj_1.jpg') }}" alt="" />
                    <img class="pic2" src="{{ asset('images/web/zdj_2.jpg') }}" alt="" />
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-5 text">
                    <h1>SZUKASZ SPRAWDZONEGO PRODUCENTA ZAMOCOWAŃ IZOLACJI TECHNICZNYCH ?</h1>
                    <br />
                    <br />

                    <p>
                    Już od lat dziewięćdziesiątych ufają nam najwięksi producencji w branży HVAC,
                    Marine, energetycznej i motoryzacyjnej.
                    Większość naszej produkcji jest eksportowana.
                    Zaopatrujemy największych producentów i dystrybutorów izolacji technicznych
                    oraz najlepszych wykonawców.
                        <br />
                        <br />

                    Od początku naszej działalności stawiamy na rozbudowę i unowocześnianie
                    parku maszynowego.
                        <br />
                        <br />

                    Stale zwiększamy i ulepszamy ofertę naszych produktów.
                    Wychodzimy naprzeciw oczekiwaniom i potrzebom klientów.
                    Kluczem naszego sukcesu jest wysoka jakość oferowanych produktów,
                    doświadczona kadra i zaufanie odbiorców.
                    </p>
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <br />
                    <a href="#">ZAPOZNAJ SIĘ Z NASZĄ OFERTĄ!</a>
                </div>
            </div>
        </div>
    </div>

<div id="app">
    <main class="py-4">

        @yield('content')
    </main>
</div>

<footer class="footer">
</footer>

<!-- Scripts -->
<script src="{{ mix('assets/web/js/app.js') }}"></script>
@yield('js-script')
</body>
</html>
