<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Teacher extends Component
{
    public $informations;

    public function mount()
    {
        $informations = DB::table('information')
            ->leftJoin('users', 'information.user_id', '=', 'users.id')
            ->select('information.*', 'users.name')
            ->get();

        foreach ($informations as $information) {
            $information->information = mb_substr($information->information, 0, 100);
        }

        $this->informations = $informations;
    }

    public function render()
    {
        return view('livewire.teacher');
    }
}
