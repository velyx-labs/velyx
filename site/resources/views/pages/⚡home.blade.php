<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Velyx · Laravel components you own, line by line')] class extends Component
{
    //
};
?>

<div>
    <x-site.header />

    <main>
        <x-landing.hero />
        <x-landing.showcase />
        <x-landing.stack />
        <x-landing.steps />
        <x-landing.ownership />
        <x-landing.icons />
        <x-landing.open-source />
        <x-landing.cta />
    </main>

    <x-site.footer />
</div>
