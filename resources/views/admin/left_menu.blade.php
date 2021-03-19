@section('page_level_css')
  <style>

  </style>
@endsection

<div class=" my-2">
    <div class="text-bold pl-3 py-3 mb-3 " style="border-bottom: 1.5px solid #ffffff63 ">
      @auth
        <a href="" class="administration_author text-light" title="accéder à mon profile">
          {{ Auth::user()->name }} <br>
          <span class="textlinkenav">

              <i class="fas fa-user-tie"></i>
              @if( Auth::user()->role=="secretaire" )
                secretaire
              @elseif( Auth::user()->role==env('ADMIN_ROLE') )
                Admin
              @endif

          </span>
        </a>
      @else
      Atypik House Administration
      @endauth
    </div>

    {{--début liens menu --}}
    @auth
    <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link active text-light text-bold" href="https://atypik-house.com/" target="_blank"><i class="fas fa-home"></i> Aller sur AtypikHouse</a>
        </li>

        {{-- début utilisateurs--}}
        <li class="nav-item">
          <span class=" nav-link text-light text-bold"><i class="fas fa-users"></i> Utilisateurs </span>
          <div class="pl-4 ">
            <a href="{{ route('register') }}">
                <span class="textlinkenav"> <i class="fas fa-plus-circle"></i> Nouvel utilisateur - Admin</span>
              </a> <br>

              <a href="{{ route('usersWhoWanToAddHabitat') }}">
                  <span class="textlinkenav"> <i class="fas fa-list "></i> Autorisations d'ajout d'habitats</span>
              </a>
          </div>
        </li>
        {{-- fin utilisateurs--}}

        {{--début habitats--}}
        <li class="nav-item mt-2">
          <span class=" nav-link text-light text-bold"><i class="fas fa-home"></i> Habitats </span>
          <div class="pl-4 ">
              <a href="{{ route('getAllHabitat') }}">
                  <span class="textlinkenav"> <i class="fas fa-list "></i> Tous les habitats </span>
              </a> <br>
              <a href="{{ route('getUnValidatedHabitat') }}">
                  <span class="textlinkenav"> <i class="fas fa-list "></i> Habitats en attente de validation</span>
              </a> <br>
              <a href="{{ route('listTypeHabitat') }}">
                  <span class="textlinkenav"> <i class="fas fa-list "></i> Les types d'habitats </span>
              </a> <br>
              <a href="{{ route('listProrieteTypeHabitat') }}">
                  <span class="textlinkenav"> <i class="fas fa-list "></i> Les propriétés dynamiques </span>
              </a>
          </div>
        </li>
        {{--fin habitats--}}

        <li class="nav-item">
            <a class="nav-link active text-light text-bold"
            href="{{ route('logout') }}"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off"></i> Déconnexion </a>
        </li>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: one;">
                {{ csrf_field() }}
            </form>
      </ul>

      @endauth
    {{--fin lien menu --}}

</div>
