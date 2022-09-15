select *
from "trprospect"
where ("prospectowner" = 22)
   or exists (
      select *
      from "trprospectassign"
      where "trprospect"."prospectid" = "trprospectassign"."prospectid"
         or (
            (
               "prospectassignto" = 22
               or "prospectreportto" = 22
            )
         )
   )
limit 10