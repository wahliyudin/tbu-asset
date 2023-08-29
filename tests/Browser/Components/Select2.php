<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class Select2 extends BaseComponent
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
        return $this->selector;
    }

    /**
     * Assert that the browser page contains the component.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPresent($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@container' => "~ span.select2.select2-container",
            '@dropdown' => "~ span.select2-container span.select2-dropdown",
            '@search' => "~ span.select2-container input.select2-search__field",
            '@options' => "~ span.select2-container .select2-results__options",
            '@first_child' => "~ span.select2-container li.select2-results__option:first-child",
            '@selected' => "~ span.select2-container span.select2-selection__rendered",
        ];
    }

    public function select2Select(Browser $browser, $searchText)
    {
        $browser->click("@container")
            ->waitFor("@dropdown")
            ->type("@search", $searchText)
            ->waitFor("@options")
            ->click("@first_child")
            ->assertSeeIn("@selected", $searchText);
    }
}
