psql -c "\copy mscountry FROM 'csv_backup/country.csv' delimiter ',' csv header;" "host=localhost port=5432 dbname=ventes user=postgres password=revan1853"
psql -c "\copy msprovince FROM 'csv_backup/province.csv' delimiter ',' csv header;" "host=localhost port=5432 dbname=ventes user=postgres password=revan1853"
psql -c "\copy mscity FROM 'csv_backup/city.csv' delimiter ',' csv header;" "host=localhost port=5432 dbname=ventes user=postgres password=revan1853"
psql -c "\copy mssubdistrict FROM 'csv_backup/subdistrict.csv' delimiter ',' csv header;" "host=localhost port=5432 dbname=ventes user=postgres password=revan1853"