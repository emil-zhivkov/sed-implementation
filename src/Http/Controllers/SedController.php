<?php

namespace Zhivkov\SedImplementation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Zhivkov\SedImplementation\Repositories\SedRepository;


class SedController extends Controller
{

    protected $sedRepo;

    public function __construct(SedRepository $sedRepository)
    {
        $this->sedRepo = $sedRepository;
    }


    /**
     * @param  Request  $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Exception
     */
    public function substitution(Request $request) :StreamedResponse
    {
        return $this->sedRepo->substitution($request);
    }
}
