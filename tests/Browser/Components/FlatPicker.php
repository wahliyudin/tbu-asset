<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class FlatPicker extends BaseComponent
{
    public function __construct(
        protected $selector
    ) {
    }

    /**
     * Get the root selector for the component.
     */
    public function selector(): string
    {
        return '';
    }

    /**
     * Assert that the browser page contains the component.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertVisible($this->selector);
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@calendar' => '.flatpickr-calendar',
            '@days' => '.flatpickr-days',
        ];
    }

    public function selectDate(Browser $browser, $date)
    {
        $browser->click($this->selector)
            ->waitFor('@calendar')
            ->click('@days .flatpickr-day[aria-label="' . $date . '"]')
            ->assertPresent('@days .flatpickr-day[aria-label="' . $date . '"].selected');
    }
}
