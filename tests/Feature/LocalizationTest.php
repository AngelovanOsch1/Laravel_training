<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Header;
use PHPUnit\Framework\Attributes\Test;

class LocalizationTest extends TestCase
{
    #[Test]
    public function it_switches_locale_in_livewire_to_Dutch()
    {
        Livewire::test(Header::class)
            ->set('form.selectedLanguage', 'nl')
            ->assertSet('form.selectedLanguage', 'nl')
            ->assertSessionHas('locale', 'nl');

        $this->assertEquals('nl', session('locale'));
        $this->assertEquals('nl', app()->getLocale());
    }

    #[Test]
    public function it_switches_locale_in_livewire_to_English()
    {
        Livewire::test(Header::class)
            ->set('form.selectedLanguage', 'en')
            ->assertSet('form.selectedLanguage', 'en')
            ->assertSessionHas('locale', 'en');

        $this->assertEquals('en', session('locale'));
        $this->assertEquals('en', app()->getLocale());
    }
}
