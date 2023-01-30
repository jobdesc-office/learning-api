<?php

namespace Database\Factories;

use FactoryCount;
use Carbon\Carbon;
use App\Models\Masters\DailyActivity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Log;

class DailyActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DailyActivity::class;
    protected $x = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $this->prepareAttributes();
        return [
            'dayactcatid' => find_type()->childrenByCode([\DBTypes::activitycategory])->randomChildren()->getChildrenId(),
            'dayactdate' => $this->getActDate(),
            'dayactdesc' => $this->faker->text(),
            'dayactcd' => $this->generateCode($this->x++),
            'dayactreftypeid' => $this->getTypeId(),
            'dayactaddress' => $this->faker->address(),
            'dayactrefid' => $this->faker->numberBetween(1, 10),
            'dayactcustid' => $this->faker->numberBetween(1, 10),
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

    function getTypeid()
    {
        $customertype = find_type()->byCode([\DBTypes::dayactreftype])
            ->children(\DBTypes::dayactreftype);
        return $customertype->random()->getId();
    }

    function generateCode($count)
    {
        $code = "ACT";

        $date = Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $increment = str_pad($count, 4, "0", STR_PAD_LEFT);

        return "$code$year$month$day$increment";
    }
}
