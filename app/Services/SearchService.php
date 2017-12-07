<?php

namespace App\Services;


use App\Customer;
use App\Exam;
use App\Profile;
use Illuminate\Support\Facades\DB;

class SearchService
{

    /**
     * Busca y retorna a los clientes que coincidan con la razon social especificada
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param string $name
     * @return string
     */
    public function searchCustomer($name)
    {
        try {
            //$name = Input::get('name');
            $cliente = Customer::select(['id', 'name', 'tradename', 'nit', 'photo'])->where('name', '~*', $name)
                ->orWhere('tradename', '~*', $name)->get();
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
     * @param string $name
     * @return string
     */
    public function searchPatient($name)
    {
        try {
            $pacientes = DB::table('patients_search_vw')->where('name', '~*', $name)->get();
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

    /**
     * Busca y retorna a los exámenes que coincidan con el nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param string $display_name
     * @return string
     */
    public function searchExam($display_name)
    {
        try {
            $exam = Exam::select(['id', 'name', 'display_name', 'observation', 'precio'])
                ->where('display_name', '~*', $display_name)
                ->get();
            $resultado = [
                "total_count" => count($exam),
                "incomplete_results" => false,
                "items" => $exam,
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