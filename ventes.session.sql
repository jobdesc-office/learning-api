select villagename,
    subdistrictname,
    cityname,
    provname
from msvillage
    join mssubdistrict on villagesubdistrictid = subdistrictid
    join mscity on subdistrictcityid = cityid
    join msprovince on cityprovid = provid
where villagename = 'Mertani';