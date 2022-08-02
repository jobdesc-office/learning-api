<?php

namespace Database\Factories;

use FactoryCount;
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
            'dayactdate' => $this->faker->date(),
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

        $this->location = "https://maps.google.com?q=$coordinates[latitude],$coordinates[longitude]";
    }

    function getLocation()
    {
        return $this->location;
    }
}
