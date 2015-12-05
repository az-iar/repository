<?php

namespace spec\Inneuron\Repository\Stubs\Eloquent;

use Inneuron\Repository\Eloquent\BaseRepository;
use Inneuron\Repository\Stubs\Eloquent\User;
use Inneuron\Repository\Stubs\Eloquent\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserRepository::class);
        $this->shouldHaveType(BaseRepository::class);
    }

    function it_can_create_model_instance()
    {
        $this->getInstance()->shouldHaveType(User::class);
    }
}
