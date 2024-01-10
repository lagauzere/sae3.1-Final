<form method="POST" action="/login">
    @csrf
    <input type="text" name="licence">
    <input type="password" name="password">
    <button type="submit">Se connecter</button>
</form>
@if(session()->has('userID'))
    <?php $userID = session('userID'); ?>
    <p>UserID : {{ $userID }}</p>
@endif