<?php
use App\Models\User;
?>

@if(User::canDirect()>0 || User::isAdmin())
<a class="navbar-item" href="/directedplanneddiveslist">
    Plongées dirigées prévues
 </a>
@endif

    

