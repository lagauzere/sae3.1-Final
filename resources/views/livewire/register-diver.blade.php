<div>
    @if($userIsLoggedIn)
        <form wire:submit.prevent="registerForDive('{{ $dive['DIV_ID'] }}')">
            @csrf
            <input type="submit" name="DiveParticipation" value="M'inscrire">
        </form>
    @else 
        <form wire:submit.prevent="leaveDive('{{ $dive['DIV_ID'] }}')">
            @csrf
            <input type="submit" value="Me désinscrire">
        </form>
    @endif
</div>
<livewire:register-diver />
