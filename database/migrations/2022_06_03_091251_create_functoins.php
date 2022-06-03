<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunctoins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE FUNCTION get_schedule_from_dates(
                start_date1 DATE,
                end_date1 DATE,
                start_date2 DATE,
                end_date2 DATE
            ) RETURNS BOOLEAN LANGUAGE plpgsql AS $$
        DECLARE result BOOLEAN := false;
        DECLARE date1 DATE;
        DECLARE date2 DATE;
        DECLARE dates1 TIMESTAMP [] := get_dates (start_date1, end_date1);
        DECLARE dates2 TIMESTAMP [] := get_dates (start_date2, end_date2);
        BEGIN FOREACH date1 IN ARRAY dates1 LOOP FOREACH date2 IN ARRAY dates2 LOOP result := result
        OR to_char(date1, 'YYYY-MM-DD') = to_char(date2, 'YYYY-MM-DD');
        IF result THEN EXIT;
        END IF;
        END LOOP;
        END LOOP;
        RETURN result;
        END;
        $$;
        CREATE OR REPLACE FUNCTION get_dates(
                start_date1 date,
                end_date1 date
            ) RETURNS TIMESTAMP [] LANGUAGE plpgsql AS $$ BEGIN RETURN array(
                SELECT generate_series (
                        start_date1::DATE,
                        end_date1::DATE,
                        '1 day'::INTERVAL
                    )::TIMESTAMP
            );
        END;
        $$;
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
        drop function if exists get_schedule_from_dates(
            start_date1 date,
            end_date1 date,
            start_date2 date,
            end_date2 date
        );
        drop function if exists get_dates(start_date date, end_date date);
        ");
    }
}
