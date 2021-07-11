<?php

namespace pinkcrab_cccp_0_0_1;

use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Interface_A;
use pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Dependency_E;
/**
 * Stub file for testing Dice Dependencies.
 */
return array(
    // Silence
    \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Interface_A::class => array('instanceOf' => \pinkcrab_cccp_0_0_1\PinkCrab\Perique\Tests\Fixtures\DI\Dependency_E::class),
);
