<?php

namespace Database\Seeders;

use App\Models\Masters\BusinessPartner;
use App\Models\Masters\BpCustomer;
use App\Models\Masters\City;
use App\Models\Masters\Country;
use App\Models\Masters\Customer;
use App\Models\Masters\DailyActivity;
use App\Models\Masters\Province;
use App\Models\Masters\Schedule;
use App\Models\Masters\Subdistrict;
use App\Models\Masters\Village;
use App\Models\Masters\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function run()
    {
        $this->call([TypeSeeder::class]);

        // $countriesData = $this->getCountriesData();
        // $provincesData = $this->getProvincesData();
        // $citiesData = $this->getCitiesData();
        // $subdistrictsdata = $this->getSubdistrictData();
        // $villagesdata = $this->getVillageData();

        // Country::insert($countriesData);
        // Province::insert($provincesData);
        // City::insert($citiesData);
        // Subdistrict::insert($subdistrictsdata);
        // Village::insert($villagesdata);

        BusinessPartner::factory(\FactoryCount::bpCount)->create();
        UserDetail::factory(\FactoryCount::userDetailCount)->create();
        Schedule::factory(\FactoryCount::scheduleCount)->create();
        Customer::factory(\FactoryCount::customerCount)->create();
        DailyActivity::factory(\FactoryCount::dailyActivityCount)->create();
        // BpCustomer::factory(\FactoryCount::bpCustomerCount)->create();
    }


    /**
     * @return array
     * import contries from array
     * */
    private function getCountriesData()
    {
        return [
            ['countryname' => 'Indonesia',],
        ];
    }

    /**
     * @return array
     * import provinces from public api
     * */
    private function getProvincesData()
    {
        $provinces = collect($this->fetchData('https://ibnux.github.io/data-indonesia/provinsi.json'));

        return $provinces->map(function ($prov) {
            return [
                'provname' => $prov->nama,
                'provcountryid' => 1,
                'provid' => $prov->id,
            ];
        })->filter()->toArray();
    }

    /**
     * @return array
     * import cities from public api
     * */
    private function getCitiesData()
    {
        $results = collect([]);
        $provinces = collect($this->fetchData('https://ibnux.github.io/data-indonesia/provinsi.json'));

        $provinces->each(function ($prov) use ($results) {
            $cities = collect($this->fetchData("https://ibnux.github.io/data-indonesia/kabupaten/$prov->id.json"));

            $cities = $cities->map(function ($city) use ($prov) {
                return [
                    'cityname' => $city->nama,
                    'cityprovid' => $prov->id,
                    'cityid' => $city->id,
                ];
            })->filter();
            $results->push(...$cities->toArray());
        });
        return $results->filter()->toArray();
    }

    /**
     * @return array
     * import subdistrict from public api
     * */
    private function getSubdistrictData()
    {
        $results = collect([]);
        $provinces = collect($this->fetchData('https://ibnux.github.io/data-indonesia/provinsi.json'));

        $provinces->each(function ($prov) use ($results) {
            $cities = collect($this->fetchData("https://ibnux.github.io/data-indonesia/kabupaten/$prov->id.json"));

            $cities->each(function ($city) use ($results) {
                $subdistricts = collect($this->fetchData("https://ibnux.github.io/data-indonesia/kecamatan/$city->id.json"));

                $subdistricts = $subdistricts->map(function ($subd) use ($city) {
                    return [
                        'subdistrictname' => $subd->nama,
                        'subdistrictcityid' => $city->id,
                        'subdistrictid' => $subd->id,
                    ];
                })->filter();

                $results->push(...$subdistricts->toArray());
            });
        });
        return $results->filter()->toArray();
    }

    private function getVillageData()
    {
        $results = collect([]);
        $provinces = collect($this->fetchData('https://ibnux.github.io/data-indonesia/provinsi.json'));

        $provinces->each(function ($prov) use ($results) {
            $cities = collect($this->fetchData("https://ibnux.github.io/data-indonesia/kabupaten/$prov->id.json"));

            $cities->each(function ($city) use ($results) {
                $subdistricts = collect($this->fetchData("https://ibnux.github.io/data-indonesia/kecamatan/$city->id.json"));

                $subdistricts->each(function ($subdistrict) use ($results) {
                    $villages = collect($this->fetchData("https://ibnux.github.io/data-indonesia/kelurahan/$subdistrict->id.json"));

                    $villages = $villages->map(function ($vlg) use ($subdistrict) {
                        return [
                            'villagename' => $vlg->nama,
                            'villagesubdistrictid' => $subdistrict->id,
                            'villageid' => $vlg->id,
                        ];
                    })->filter();

                    $results->push(...$villages->toArray());
                });
            });
        });
        return $results->filter()->toArray();
    }

    /**
     * @return stdClass
     * send GET request to passed url
     */
    private function fetchData($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($curl);
        curl_close($curl);

        return json_decode($resp);
    }
}
