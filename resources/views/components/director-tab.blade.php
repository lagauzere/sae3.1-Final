<?php
use App\Models\User;
?>

@if(User::canDirect()>0)
<a class="navbar-item" href="/directedplanneddiveslist">
    Plongées dirigées prévues
 </a>
@endif

    

