<?php

namespace App\Services;


use App\Cliente;
use App\Profile;
use Illuminate\Support\Facades\DB;

class SearchService
{

    /**
     * Busca y retorna a los clientes que coincidan con la razon social especificada
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param string $razon_social
     * @return string
     */
    public function searchCustomer($razon_social)
    {
        try {
            //$razon_social = Input::get('razon_social');
            $cliente = Cliente::where('razon_social', '~*', $razon_social)->get();
            $resultado = [
                "total_count" => count($cliente),
                "incomplete_results" => false,
                "items" => $cliente,
            ];
        } catch (\Exception $e) {
            $resultado = [
                "total_count" => 0,
                "incomplete_results" => true,
                "items" => [],
            ];
        }
        return json_encode($resultado);
    }

    /**
     * Busca y retorna a los perfiles de examenes que coincidan con nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param string $display_name
     * @param int $sucursal_id
     * @return string
     */
    public function searchProfile($display_name, $sucursal_id)
    {
        try {
            $perfil = Profile::select(['id', 'name', 'display_name', 'type', 'description', 'price'])
                ->where('display_name', '~*', $display_name)
                ->where('sucursal_id', $sucursal_id)
                ->where('enabled', true)
                ->join('profile_sucursal', 'profiles.id', '=', 'profile_sucursal.profile_id')
                ->get();
            $resultado = [
                "total_count" => count($perfil),
                "incomplete_results" => false,
                "items" => $perfil,
            ];
        } catch (\Exception $e) {
            $resultado = [
                "total_count" => 0,
                "incomplete_results" => true,
                "items" => [],
            ];
        }
        return json_encode($resultado);
    }

    /**
     * Busca y retorna a los clientes que coincidan con nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param string $full_name
     * @return string
     */
    public function searchPaciente($full_name)
    {
        try {
            $pacientes = DB::table('pacientes_vw')->where('full_name', '~*', $full_name)->get();
            $resultado = [
                "total_count" => count($pacientes),
                "incomplete_results" => false,
                "items" => $pacientes,
            ];
        } catch (\Exception $e) {
            $resultado = [
                "total_count" => 0,
                "incomplete_results" => true,
                "items" => [],
            ];
        }
        return json_encode($resultado);
    }

}