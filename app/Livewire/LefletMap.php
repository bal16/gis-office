<?php

namespace App\Livewire;

use Livewire\Component;

class LefletMap extends Component
{
    public $latitude;
    public $longitude;

    protected $listeners = ['updateCoordinates'];

    public function updateCoordinates($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }    
    
    public function render()
    {
        return view('livewire.leflet-map');
    }
}


