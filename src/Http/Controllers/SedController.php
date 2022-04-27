<?php

namespace Zhivkov\SedImplementation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zhivkov\SedImplementation\Repositories\SedRepository;


class SedController extends Controller
{

    protected $sedRepo;

    public function __construct(SedRepository $sedRepository)
    {
        $this->sedRepo = $sedRepository;
    }


    public function substitution(Request $request)
    {
        $result = $this->sedRepo->substitution($request);
    }
}
