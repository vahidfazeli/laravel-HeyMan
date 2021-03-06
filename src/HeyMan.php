<?php

namespace Imanghafoori\HeyMan;

use Imanghafoori\HeyMan\Hooks\EloquentHooks;
use Imanghafoori\HeyMan\Hooks\RouteHooks;
use Imanghafoori\HeyMan\Hooks\ViewHooks;

class HeyMan
{
    use EloquentHooks, RouteHooks, ViewHooks;
    /**
     * @var \Imanghafoori\HeyMan\ConditionApplier
     */
    public $authorizer;

    public function whenEventHappens(...$event)
    {
        return $this->authorize($this->normalizeInput($event));
    }

    /**
     * @param $url
     * @return array
     */
    private function normalizeInput(array $url): array
    {
        return is_array($url[0]) ? $url[0] : $url;
    }

    /**
     * @param $value
     */
    private function authorize($value): YouShouldHave
    {
        $this->authorizer = app('hey_man_authorizer')->init($value);
        return app(YouShouldHave::class);
    }
}