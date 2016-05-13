<?php

namespace Meritocracy\Adapters;

use Illuminate\Database\Eloquent\Model;
use Meritocracy\Entity\User;
use Tymon\JWTAuth\Providers\User\UserInterface;

class DoctrineUserAdapter implements UserInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $user;

    /**
     * Create a new User instance
     *
     * @param  \Illuminate\Database\Eloquent\Model  $user
     */
    public function __construct(\LaravelDoctrine\ORM\Contracts\Auth\Authenticatable $user)
    {
        $this->user = $user;
    }

    /**
     * Get the user by the given key, value
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getBy($key, $value)
    {
        die("auth");
        return $this->user->where($key, $value)->first();
    }
}
