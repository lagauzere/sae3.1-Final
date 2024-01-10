<nav class="navbar has-background-link-light is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
            <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span></span>
            <span></span>
            <span></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item">
                Accueil
            </a>

            <div class="navbar-item has-dropdown is-hoverable ">
                <a class="navbar-link">
                    Plus
                </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item">
                        À Propos
                    </a>
                    <a class="navbar-item">
                        Contact
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item">
                        Rapporter un problème
                    </a>
                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
<<<<<<< HEAD
                <x-user-credits :amount="1"/>
            </div>
            <div class="navbar-item">
                <div class="buttons">
                    @if(session()->has('userID'))
                    <?php var_dump(session('userID')) ?>
=======
            @if(session()->has('userID'))
                <p>Nombre de sessions restantes :&nbsp</p><x-user-credits :amount="1"/>
            @else
                <p>Connectez vous : </p>
            @endif
                
            </div>
            <div class="navbar-item">
                <div class="buttons">
                @if(session()->has('userID'))
                    <?php
                    $userName = session('userName');
                     ?>
                     <p>{{ $userName[0]->dvr_name }}</p>
>>>>>>> master
                    <form action="/disconnect" method="post">
                        @csrf
                        <button type="submit" class="button is-info is-light"><strong>Déconnexion</strong></button>
                    </form>
<<<<<<< HEAD
                    @else
                    <a class="button is-info" href="#Connexion">
                        <strong>Connexion</strong>
                    </a>
                    @endif
=======
                @else
                    <a class="button is-info" href="#Connexion">
                            <strong>Connexion</strong>
                    </a>
                @endif        
>>>>>>> master
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