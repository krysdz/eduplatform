<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleType;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use Closure;

class Authorize extends \Illuminate\Auth\Middleware\Authorize
{
    public function handle($request, Closure $next, $ability, ...$models)
    {
        $response = $this->gate->authorize($ability, $this->getGateArguments($request, $models));

        if ($response->allowed() && !in_array($ability, ['super_administrator'])) {
            try {
                $role = UserRoleType::fromKey(ucfirst($ability));
                $request->session()->put('current_role', $role);
                $request->session()->put('current_role_index', strtolower($role->key) . '.index');
            } catch (InvalidEnumKeyException $e) {
            }
        }

        return $next($request);
    }
}
