psql -c "\copy mscountry FROM 'csv_backup/country.csv' delimiter ',' csv header;" "host=10.21.1.30 port=5432 dbname=ventes user=postgres password=P@ssw0rd"
psql -c "\copy msprovince FROM 'csv_backup/province.csv' delimiter ',' csv header;" "host=10.21.1.30 port=5432 dbname=ventes user=postgres password=P@ssw0rd"
psql -c "\copy mscity FROM 'csv_backup/city.csv' delimiter ',' csv header;" "host=10.21.1.30 port=5432 dbname=ventes user=postgres password=P@ssw0rd"
psql -c "\copy mssubdistrict FROM 'csv_backup/subdistrict.csv' delimiter ',' csv header;" "host=10.21.1.30 port=5432 dbname=ventes user=postgres password=P@ssw0rd"
psql -c "\copy msvillage FROM 'csv_backup/village.csv' delimiter ',' csv header;" "host=10.21.1.30 port=5432 dbname=ventes user=postgres password=P@ssw0rd"