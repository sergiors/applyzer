<?php

namespace Sergiors\Applyzer\Tests;

use Sergiors\Applyzer\Applyzer;

class ApplyzerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnNameChanged()
    {
        $user = new User();
        $data = [
            'name' => 'James',
        ];

        $user = Applyzer::apply($data, $user);

        $this->assertEquals('James', $user->getName());
    }

    /**
     * @test
     */
    public function shouldReturnLastNameChanged()
    {
        $user = new User();
        $data = [
            'last_name' => 'Jackson',
        ];

        $user = Applyzer::apply($data, $user);

        $this->assertEquals('Jackson', $user->getLastName());
    }
}