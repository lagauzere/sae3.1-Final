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
update PARTICIPATE set par_cancelled=TRUE where DVR_LICENCE=1005;
select * from PARTICIPATE join DIVERS using(DVR_LICENCE) where par_cancelled=TRUE;

# number of divers for each dive
select div_id,count(*) as nb_diver from PARTICIPATE group by (div_id);