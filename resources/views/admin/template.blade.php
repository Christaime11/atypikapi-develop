<!doctype html>

<html lang="en">
    <head>
        {{--debut balise meta --}}
        @include('loadMeta')
        {{-- fin balise meta --}}

        {{--debut fichier css --}}
        @include('loadCss')
        <style>
            .dropdown-menu {
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 1000;
                display: none;
                float: left;
                min-width: 10rem;
                padding: 0.5rem 0;
                margin: 0.125rem 0 0;
                font-size: 1rem;
                text-align: left;
                list-style: none;
                background-clip: padding-box;
                border: 1px solid rgba(0, 0, 0, 0.15);
                border-radius: 0.25rem;
            }
        </style>
        {{--fin fichier css --}}

        <title>@yield('titre')</title>
    </head>


    <body>
       <div class=" container-fluid h-100">
            <div class="row h-100" >
                {{--début menu --}}
                <div class="col-md-2 px-0 bg-admin-base text-light">
                    <div class="p-fixed left_admin_menu">
                        @include('admin.left_menu')
                    </div>
                    <div class="px-5" style="position: fixed; bottom: 0; left: 0;">
                        <p class="px-4"> Atypikhouse &copy; {{date('Y')}}</p>
                    </div>
                </div>
                {{--fin menu --}}

                {{--début contenu --}}
                <div class="col-md-10  py-3 light ">
                    @yield('content')
                </div>
                {{--fin contenu --}}
            </div>
       </div>

        {{--debut fichiers javascript --}}
        @include('loadJs')
        {{-- fin fichier javascript--}}
    </body>
</html>
