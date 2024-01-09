# shows the admins
SELECT * FROM DIVERS
where DVR_ISADMIN = true;

# Shows the dives of Jort
select DVR_FIRST_NAME, DVR_NAME, DVR_LICENCE, DIV_COMMENT from DIVERS
join PARTICIPATE USING (DVR_LICENCE) 
join DIVES using (DIV_ID)
where DVR_NAME = 'Jort';

# For each dive, shows its id, ship, status, site name and depth and director diver
select div_id, shp_name, sta_label, sit_name, sit_depth, dvr_name, DVR_FIRST_NAME from DIVES
join STATUS using (sta_id)
join SITES using (sit_id)
join SHIPS using (shp_id)
join DIVERS on (DIVERS.DVR_LICENCE = DVR_LICENCE_DIRECTS);

# list of dives where status=1 (=prévue);
select * from DIVES 
join STATUS using (STA_ID)
where STA_ID=1;


# updates the state of the dive one
update DIVES set sta_id = 2 where div_id = 1;


# list of sites where the depth is under 40 m.
select * from SITES where sit_depth > 40; 


# list of divers that cancelled a dive
update PARTICIPATE set par_cancelled=TRUE where DVR_LICENCE="A-04-100005";
select * from PARTICIPATE join DIVERS using(DVR_LICENCE) where par_cancelled=TRUE;

# number of divers for each dive
select div_id,count(*) as nb_diver from PARTICIPATE group by (div_id);


# show the remaining credits of "A-04-100004" this year, you can change the begining of a year (here 01-01)

SELECT 99-count(*) credits from PARTICIPATE 
JOIN DIVES using(div_id)
WHERE DVR_LICENCE = "A-04-100004"
AND
DATEDIFF(div_date, STR_TO_DATE(CONCAT('01-01-',DATE_FORMAT(NOW(), '%Y')),'%d-%m-%Y')) >= 0
AND
DATEDIFF(div_date, STR_TO_DATE(CONCAT('01-01-',DATE_FORMAT(NOW(), '%Y')+1),'%d-%m-%Y')) < 0
AND 
STA_ID != 3;