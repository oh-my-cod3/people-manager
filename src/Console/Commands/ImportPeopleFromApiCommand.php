<?php

namespace OhMyCod3\PeopleManager\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use OhMyCod3\PeopleManager\Models\People;
use OhMyCod3\PeopleManager\Models\Planet;

class ImportPeopleFromApiCommand extends Command
{

    /**
     * Planet URL
     *
     * @var string
     */
    protected $planet_url = "https://swapi.dev/api/planets/";

    /**
     * People URL
     *
     * @var string
     */
    protected $people_url = "https://swapi.dev/api/people";
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'pm:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import people from api';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'PeopleManager';

    /**
     * Execute the console command
     *
     * @return int
     */
    public function handle(){
        $this->info("Executing import....");


        $this->info("Fetching Planets from api");
        if(!$planets = $this->getPlanets()){
            return;
        }

        $this->info("Fetching People from api");
        if(!$people = $this->getPeople()){
            return;
        }

        $this->info("Data fetched from api");
        
        $this->info("-----------------------------------------");

        $this->info("Elaborating results...");


        /**
         * Converto i dati in un singolo array da poter inserire direttamente nel database
         */
        $now = now();
        $planets_to_inert = $planets->map(function($planet, $index) use ($now){
            return [
                'name' => $planet['name'],
                'rotation_period' => $planet['rotation_period'],
                'orbital_period' => $planet['orbital_period'],
                'diameter' => $planet['diameter'],
                'climate' => $planet['climate'],
                'gravity' => $planet['gravity'],
                'terrain' => $planet['terrain'],
                'surface_water' => $planet['surface_water'],
                'population' => $planet['population'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })
        ->toArray();

        $people_to_insert = $people->map(function($person) use ($now){

            // siccome da API arrivano in ordine di ID, li posso inserire direttamente
            $api_planet_id = Str::of(
                Str::endsWith($person['homeworld'], "/")
                ? Str::replaceLast("/", "", $person['homeworld'])
                : $person['homeworld']
            )->explode('/')->last();

            return [
                'planet_id' => $api_planet_id,
                'name' => $person['name'],
                'height' => $person['height'],
                'mass' => $person['mass'],
                'hair_color' => $person['hair_color'],
                'skin_color' => $person['skin_color'],
                'eye_color' => $person['eye_color'],
                'birth_year' => $person['birth_year'],
                'gender' => $person['gender'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        })
        ->toArray();


        /**
         * Inserendo i dati con due query "secche" si ottimizza il tempo di aggiornamento della procedura
         */
        try{

            DB::beginTransaction();
            
            // svuoto eventuali dati pregressi
            DB::table('planets')->delete();
            DB::table('people')->delete();



            Planet::insert($planets_to_inert);
            $this->info("Planets inserted: " . count($planets_to_inert) . " record");

            People::insert($people_to_insert);
            $this->info("People inserted: " . count($people_to_insert) . " record");

            DB::commit();

            $this->info("**** PROCESS ENDED ****");

        }catch(\Throwable $t){
            DB::rollback();
            $this->error($t->getMessage());
            return;
        }
        
    }

    /**
     * Get planets from api
     *
     * @return Collection
     */
    private function getPlanets(){

        $planets = [];

        $next = $this->planet_url;

        $page_num = 1;

        do {
            $this->info("Fetching page {$page_num}");

            $response = Http::get($next);

            if(!$response->ok()){
                $this->error("Unable to fetch data from planet api! ABORTING");
            }

            $planets[] = $response->json()['results'];

            $next = $response->json()['next'];

            $page_num++;
            
        } while ($next);
        
        return collect(array_merge(...$planets));
    }

    /**
     * Get people from api
     *
     * @return Collection
     */
    private function getPeople(){

        /**
         * L'api non ritorna tutta la collezione, ma pagina
         * nella proprietà next c'è la url della prossima pagina
         */

        $people = [];

        $next = $this->people_url;

        $page_num = 1;

        do {
            $this->info("Fetching page {$page_num}");

            $response = Http::get($next);

            if(!$response->ok()){
                $this->error("Unable to fetch data from people api! ABORTING");
            }

            // ottengo risultati
            $people[] = $response->json()['results'];

            // nuova pagina (o null)
            $next = $response->json()['next'];

            $page_num++;
            
        } while ($next);
        
        /**
         * mi permette di avere la collezione "piatta" su cui ciclare
         */
        return collect(array_merge(...$people));
    }
    
}