<?php

namespace Innoflash\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Innoflash\Events\Http\Requests\Guest\CreateRequest;
use Innoflash\Events\Services\GuestService;

class GuestController extends Controller
{
    protected $guestService;

    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    function create(CreateRequest $request)
    {
        return $this->guestService->create($request->validated(), 'Guest added to the event');
    }
}
