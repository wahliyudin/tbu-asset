<?php

namespace Tests\Unit\Helpers;

use App\Helpers\Helper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    /** @test */
    public function it_can_reset_format_number()
    {
        $result = Helper::resetRupiah('200.000');
        $this->assertSame(200_000, $result);
    }

    /** @test */
    public function it_can_reset_format_rupiah()
    {
        $result = Helper::resetRupiah('Rp. 200.000');
        $this->assertSame(200_000, $result);
    }

    /** @test */
    public function it_can_format_number_to_rupiah()
    {
        $result = Helper::formatRupiah(200_000, true);
        $this->assertSame('Rp. 200.000', $result);
    }
}
