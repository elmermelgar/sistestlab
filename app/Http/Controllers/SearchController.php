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
        return $this->searchService->searchCustomer($request->razon_social);
    }

    /**
     * Busca y retorna a los perfiles de examenes que coincidan con nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param Request $request
     * @return string
     */
    public function searchProfile(Request $request)
    {
        return $this->searchService->searchProfile($request->display_name, $request->sucursal_id);
    }

    /**
     * Busca y retorna a los clientes que coincidan con nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param Request $request
     * @return string
     */
    public function searchPaciente(Request $request)
    {
        return $this->searchService->searchPaciente($request->full_name);
    }

}
