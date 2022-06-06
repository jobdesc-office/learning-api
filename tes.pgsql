select *
from mscustomer;
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