<?php

namespace Database\Factories;

use App\Models\Masters\Schedule;
use Carbon\Carbon;
use DBTypes;
use FactoryCount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;
    protected $x = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->prepareAttributes();
        return [
            "schenm" => $this->faker->sentence(3),
            "schestartdate" => $this->getStartDate(),
            'schecd' => $this->generateCode($this->x++),
            "scheenddate" => $this->getEndDate(),
            "schestarttime" => $this->getStartTime(),
            "scheendtime" => $this->getEndTime(),
            "schetypeid" => $this->typeId,
            "schetowardid" => $this->faker->numberBetween(1, FactoryCount::userDetailCount),
            "schebpid" => $this->faker->numberBetween(1, FactoryCount::bpCount),
            "scheallday" => $this->getAllDay(),
            "scheloc" => $this->getLocation(),
            "scheprivate" => $this->faker->boolean,
            "scheonline" => $this->isOnline,
            "schetz" => $this->faker->timezone,
            "scheremind" => $this->faker->numberBetween(3, 45),
            "schedesc" => $this->getDescription(),
            "scheonlink" => $this->getOnlineLink(),
            'createdby' => 1,
            'updatedby' => 1,
        ];
    }

    function prepareAttributes()
    {
        $scheduletype = find_type()->byCode([\DBTypes::schedule])
            ->children(\DBTypes::schedule);
        $types = find_type()->in([DBTypes::scheduleEvent, DBTypes::scheduleTask, DBTypes::scheduleReminder]);

        $month = rand(1, 12);
        $day = rand(1, 28);
        $hour = rand(0, 23);
        $minute = [0, 15, 30, 45, 59][rand(0, 4)];

        $coordinates = $this->faker->localCoordinates();

        $this->typeId = $scheduletype->random()->getId();

        $this->isEvent = $this->typeId == $types->get(\DBTypes::scheduleEvent)->getId();
        $this->isTask = $this->typeId == $types->get(\DBTypes::scheduleTask)->getId();
        $this->isReminder = $this->typeId == $types->get(\DBTypes::scheduleReminder)->getId();

        $this->isAllDay = $this->faker->boolean;

        $this->startDate = Carbon::create(2022, $month, $day, $hour, $minute, 0);
        $this->endDate = Carbon::create(2022, $month, $day + rand(1, 27), $hour + rand(1, 23), $minute, 0);

        $this->location = "https://maps.google.com?q=$coordinates[latitude],$coordinates[longitude]";

        $this->isOnline = $this->faker->boolean;
    }

    function generateCode($count)
    {
        $code = "SCH";

        $date = Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $increment = str_pad($count, 4, "0", STR_PAD_LEFT);

        return "$code$year$month$day$increment";;
    }

    function getStartDate()
    {
        return $this->startDate->format('Y-m-d');
    }

    function getStartTime()
    {
        return !$this->isAllDay ? $this->startDate->format('H:i:s') : null;
    }

    function getEndDate()
    {
        return $this->isEvent ? $this->endDate->format("Y-m-d") : null;
    }

    function getEndTime()
    {
        return !$this->isAllDay && $this->isEvent ? $this->endDate->format('H:i:s') : null;
    }

    function getAllDay()
    {
        return !$this->isReminder ? $this->isAllDay : false;
    }

    function getLocation()
    {
        return $this->isEvent && !$this->isOnline ? $this->location : null;
    }

    function getDescription()
    {
        return $this->isEvent || $this->isTask  ? $this->faker->text : null;
    }

    function getOnlineLink()
    {
        return $this->isOnline ? $this->faker->url : null;
    }
}
