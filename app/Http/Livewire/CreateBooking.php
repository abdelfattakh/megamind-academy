<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Country;
use Livewire\Component;

class CreateBooking extends Component
{
    public $cities;
    public $countries;
    public $course;
    public $full_name;
    public $parent_name;
    public $phone;
    public $email;
    public $days;
    public $day;
    public $month;
    public $year;
    public $location_of_course;

    public $selectedCountry = null;
    public $selectedCity     = null;

    /**
     * @return void
     */
    public function mount($course)
    {
        $this->countries = Country::active()->get();
        $this->cities = collect();
        $this->course=$course;


    }
    /**
     * @return void
     */
    public function updateSelectedCountry()
    {
        $this->cities = City::where('country_id', $this->selectedCountry)->get();
        $this->selectedCity = Null;

        $this->dispatchBrowserEvent('contentChanged');
    }


    public function render()
    {
        return view('livewire.create-booking');
    }
}
