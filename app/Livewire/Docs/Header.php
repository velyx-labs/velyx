<?php

declare(strict_types=1);

namespace App\Livewire\Docs;

use Livewire\Component;

class Header extends Component
{
    public bool $mobileNavigationOpen = false;

    public function toggleMobileNavigation(): void
    {
        $this->mobileNavigationOpen = ! $this->mobileNavigationOpen;
    }

    public function closeMobileNavigation(): void
    {
        $this->mobileNavigationOpen = false;
    }
}
