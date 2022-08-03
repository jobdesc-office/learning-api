<?php

namespace Database\Factories;

use FactoryCount;
use Carbon\Carbon;
use App\Models\Masters\DailyActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $this->prepareAttributes();
        return [
            'dayactcatid' => find_type()->byCode([\DBTypes::activitytype])->children(\DBTypes::activitytype)->random()->getId(),
            'dayacttypeid' => find_type()->byCode([\DBTypes::activitycategory])->children(\DBTypes::activitycategory)->random()->getId(),
            'dayacttypevalue' => $this->faker->text(),
            'dayactdate' => $this->getActDate(),
            'dayactdesc' => $this->faker->text(),
            'dayactloc' => $this->getLocation(),
            'dayactlatitude' => $this->faker->latitude(),
            'dayactlongitude' => $this->faker->longitude(),
            'createdby' => $this->faker->numberBetween(1, FactoryCount::userDetailCount),
            'updatedby' => 1,
        ];
    }

    function prepareAttributes()
    {

        $coordinates = $this->faker->localCoordinates();

        $month = rand(1, 12);
        $day = rand(1, 28);
        $hour = rand(0, 23);
        $minute = [0, 15, 30, 45, 59][rand(0, 4)];

        $this->dayactdate = Carbon::create(2022, $month, $day, $hour, $minute, 0);

        $this->location = "https://maps.google.com?q=$coordinates[latitude],$coordinates[longitude]";
    }

    function getActDate()
    {
        return $this->dayactdate->format('Y-m-d');
    }

    function getLocation()
    {
        return $this->location;
    }
}
