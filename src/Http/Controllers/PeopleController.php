<?php

namespace OhMyCod3\PeopleManager\Http\Controllers;

use OhMyCod3\PeopleManager\Models\People;
use Spatie\QueryBuilder\QueryBuilder;

class PeopleController extends Controller
{

    /**
     * Ritorna l'elenco delle persone, paginato, filtrato, sortato
     *
     * @return JsonResponse
     */
    function index(){
        
        $people = QueryBuilder::for(People::class)
                ->allowedFilters(['name','height','mass','hair_color','skin_color','eye_color','birth_year','gender'])
                ->allowedSorts(['name','height','mass','hair_color','skin_color','eye_color','birth_year','gender'])
                ->paginate();

        return response()->json($people);
    }

    /**
     * Mostra la singola persona
     *
     * @param People $person
     * @return JsonResponse
     */
    function show(People $person){

        $person->load('planet');

        return response()->json($person);

    }
}