<?php

namespace App\Livewire;

use Livewire\Component;

class ThemeToggle extends Component
{
    public $theme = 'dark';

    public function mount()
    {
        $this->theme = session('theme', 'dark');
    }

    public function toggle()
    {
        $this->theme = $this->theme === 'dark' ? 'light' : 'dark';
        session(['theme' => $this->theme]);
        $this->dispatch('theme-changed', theme: $this->theme);
    }

    public function render()
    {
        return view('livewire.theme-toggle');
    }
}
