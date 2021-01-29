begin
 
      IF EXISTS(SELECT gateway_id
       FROM live_records
       WHERE id_card= NEW.id_card AND rssi >=new.rssi)
       THEN
           UPDATE live_records
           SET id=new.id,time_spend= TIMEDIFF(new.time,entry_time),time=NEW.time,rssi=new.rssi
           WHERE id_card= NEW.id_card ;
    
     ELSEIF EXISTS(SELECT gateway_id
       FROM live_records
       WHERE id_card= NEW.id_card and rssi<new.rssi AND gateway_id <> new.gateway_id)
       THEN
  INSERT INTO live_records_trace SELECT * FROM live_records WHERE live_records.id_card=new.id_card;
	SET @location_id=(SELECT location_id FROM location_mapping  WHERE gateway_id= NEW.gateway_id);
    
       UPDATE live_records
           SET id=new.id,gateway_id= NEW.gateway_id, time=NEW.time,entry_time=new.date_time,time_spend='00:00:00',status='0',location_id=@location_id,rssi=new.rssi
           WHERE id_card= NEW.id_card;
     ELSEIF EXISTS(SELECT gateway_id
       FROM live_records
       WHERE id_card= NEW.id_card AND rssi<new.rssi AND gateway_id=new.gateway_id)
       THEN
           UPDATE live_records
           SET id=new.id,time_spend= TIMEDIFF(new.time,entry_time),time=NEW.time,rssi=new.rssi
           WHERE id_card= NEW.id_card and gateway_id = NEW.gateway_id;
    
           ELSE
           SET @location_id=(SELECT location_id FROM location_mapping  WHERE gateway_id= NEW.gateway_id); 
           SET @icard_type=(SELECT type FROM icard_map WHERE id_card=new.id_card);
      INSERT INTO live_records(id_card,gateway_id,rssi,time_spend,time,entry_time,status,location_id,icard_type) VALUES 
        (new.id_card,NEW.gateway_id,new.rssi ,'00:00:00',NEW.time,CURRENT_TIME,'0',@location_id,@icard_type); 
           
        END IF;
END