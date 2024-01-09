<h1>Vous avez bien été désinscrit de la plongée n° {{$div_id}} !! </h1>
<h2>La plongée restera comptabilisé et vous ne la regagnerez pas après désinscription</h2>

<form action="{{ route('viewDivesList')}}" method="POST">
    @csrf
    <input type="submit" value="Retourner à la liste des plongées">
</form>