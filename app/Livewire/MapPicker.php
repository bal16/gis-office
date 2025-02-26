<?php

namespace App\Livewire;

use Livewire\Component;

class MapPicker extends Component
{
    public $latitude;
    public $longitude;

    // Listen for events to update coordinates
    protected $listeners = ['updateCoordinates'];

    // Method to update latitude and longitude
    public function updateCoordinates($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    // Render the Blade view
    public function render()
    {
        return view('livewire.map-picker');
    }
}
