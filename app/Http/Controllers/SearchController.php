<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @var SearchService $searchService
     */
    private $searchService;

    /**
     * SearchController constructor.
     */
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Busca y retorna a los clientes que coincidan con la razon social especificada
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param Request $request
     * @return string
     */
    public function searchCustomer(Request $request)
    {
        return response($this->searchService->searchCustomer($request->name))
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * Busca y retorna a los perfiles de examenes que coincidan con nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param Request $request
     * @return string
     */
    public function searchProfile(Request $request)
    {
        return response($this->searchService->searchProfile($request->display_name, $request->sucursal_id))
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * Busca y retorna a los clientes que coincidan con nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param Request $request
     * @return string
     */
    public function searchPatient(Request $request)
    {
        return response($this->searchService->searchPatient($request->name))
            ->header('Content-Type', 'application/json; charset=utf-8');
    }

}
