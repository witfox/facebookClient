<?php
declare( strict_types = 1);

namespace FacebookClient\Client;
interface IQuery
{
    function notDone(): bool;

    function toArray(): array;

    function loadResponse(array $response);

    function getResponse():? array;
}