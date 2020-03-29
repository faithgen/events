<?php

namespace Innoflash\Events\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Innoflash\Events\Models\Guest;
use Innoflash\Events\Services\GuestService;
use Innoflash\Events\Http\Requests\Guest\CreateRequest;
use InnoFlash\LaraStart\Traits\APIResponses;

class GuestController extends Controller
{
    use AuthorizesRequests, APIResponses;

    protected $guestService;

    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    /**
     * Adds a guest to an event.
     *
     * @param CreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function create(CreateRequest $request)
    {
        return $this->guestService->create($request->validated(), 'Guest added to the event');
    }

    /**
     * Removes a guest from an event.
     *
     * @param Guest $guest
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Guest $guest)
    {
        $this->authorize('event.delete', $guest->event);
        try {
            $guest->delete();
            return $this->successResponse('Guest removed');
        } catch (\Throwable $e) {
            abort(500, $e->getMessage());
        }
    }
}
