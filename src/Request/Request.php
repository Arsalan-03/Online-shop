<?php

namespace Request;

class Request
{
    public function __construct(protected array $body)
    {
        return $this->body;
    }
}