<?php
    use App\Models\User;
?>

<nav class="navbar has-background-link-light is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="/">
            <img src="/resources/image/logo.png" width="112" height="28">
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span></span>
            <span></span>
            <span></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="/">
                Accueil
            </a>
            @if(session()->has('userID'))
            <a class="navbar-item" href="/diveslists">
                M'inscrire aux plongées
            </a>
            <x-director-tab/>
            <a class="navbar-item" href="/historique">
                Historique de plongées
            </a>
            @if(User::isAdmin()==1)
            <a class="navbar-item" href="/users">
                Utilisateurs
            </a>
            @endif
            @endif
        </div>

        <div class="navbar-end">
            <div class="navbar-item" style="width: auto;">
                @if(session()->has('userID'))
                <div style="display: flex;">
                    <p>Nombre de sessions restantes: </p>
                    <p style="padding-left: 5px;"><x-user-credits :amount="1" /></p>
                </div>
                @else
                <p>Connectez-vous : </p>
                @endif

            </div>
            <div class="navbar-item">
                @if(session()->has('userID'))
                <?php
                $userName = session('userName');
                ?>
                <p>{{ $userName[0]->DVR_NAME }}</p>
                @endif
            </div>
            <div class="navbar-item">
                <div class="buttons">
                    @if(session()->has('userID'))
                    <form action="/disconnect" method="post">
                        @csrf
                        <button type="submit" class="button is-info is-light"><strong>Déconnexion</strong></button>
                    </form>
                    @else
                    <a class="button is-info" href="#connexion">
                        <strong>Connexion</strong>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        // The following code is based off a toggle menu by @Bradcomp
        // source: https://gist.github.com/Bradcomp/a9ef2ef322a8e8017443b626208999c1
        (function() {
            var burger = document.querySelector('.burger');
            var menu = document.querySelector('#' + burger.dataset.target);
            burger.addEventListener('click', function() {
                burger.classList.toggle('is-active');
                menu.classList.toggle('is-active');


            });

        })();
    </script>
</nav>