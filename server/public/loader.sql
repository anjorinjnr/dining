select  "${retailer}" as retailer,
        formattime('%m/%d/%Y', parsetime(xx._PARTITION_DATE, '%Y%m%d')) as p_date,
        xx.device as device,
        xx.destination as destination,
        unique(xx.keyword) as keyword,
        xx.avg_monthly_search as avg_monthly_search,
        yy.no_of_runs as no_of_runs,
        coalesce(zz.showed, 0) as showed
from ci_analysis.visus_automated_analysis.last7days as xx
join (
  select  formattime('%m/%d/%Y', parsetime(_PARTITION_DATE, '%Y%m%d')) as p_date,
          _PARTITION_DATE as date_,
          count(distinct crawl_date) AS no_of_runs
  from ci_analysis.visus_automated_analysis.last7days
  where device = 'DESKTOP' and destination = 'google.com'
  group by 1, 2
  
  ) as yy
on xx._partition_date = yy.date_
left join (
  --get the number of times the retailer showed
  select  a.retailer,
          a.keyword,
          a.device,
          a.destination,
          formattime('%m/%d/%Y', parsetime(a._PARTITION_DATE, '%Y%m%d')) as p_date,
          a.avg_monthly_search, b.no_of_runs,
          count(a.retailer)/ b.no_of_runs * 100 as showed
  from flatten((select *
                from ci_analysis.visus_automated_analysis.last7days
                where device = 'DESKTOP' and destination = 'google.com'
               ), retailer) as a
  join ( --get the number of runs for each day
    select  _PARTITION_DATE as date_,
            count(distinct crawl_date) AS no_of_runs
    from ci_analysis.visus_automated_analysis.last7days
    where device = 'DESKTOP' and destination = 'google.com'
    group by 1
    ) as b
  on a._PARTITION_DATE = b.date_
  where a.retailer != '' and a.retailer = "${retailer}"
  group by 1,2,3,4,5,6, 7
  ) as zz
on  xx.keyword = zz.keyword and
    xx.device = zz.device and
    xx.destination = zz.destination and
    yy.p_date = zz.p_date
where xx.keyword in  (${keywords})
and xx.device = 'DESKTOP' and xx.destination = 'google.com'
group by 1,2,3,4,6, 7, 8
order by 2 desc,3,4
