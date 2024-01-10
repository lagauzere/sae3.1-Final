<?php
    use Livewire\Component;

class RegisterDiver extends Component {
    public $eventId;

    public function showEventRegistrationPopup($eventId){
        $this->eventId = $eventId;
        $this->emit('openModal');
    }
    public function registerForDive($diveId)
    {
      
        $this->emit('closeModal');
    }

    public function leaveDive($diveId)
    {

        $this->emit('closeModal');
    }

    public function render()
    {
        return view('livewire.register-diver');
    }

}