create table user_inf(
  user_id VARCHAR(10) PRIMARY KEY NOT NULL,
  pass VARCHAR(50) NOT NULL,
  target_amount money UNSIGNED
);

create table part_time_job_inf(
  user_id VARCHAR(10) NOT NULL,
  job_name TEXT NOT NULL,
  hourly_wage money  UNSIGNED NOT NULL,
  cutoff_day TINYINT UNSIGNED NOT NULL,
  payment_day TINYINT UNSIGNED NOT NULL,
  mid_wage  money UNSIGNED,
  start_mid_time TIME,
  end_mid_time TIME,
  PRIMARY KEY(user_id,job_name),
  FOREIGN KEY(user_id)
  REFERENCES user_inf(user_id)
  ON UPDATE CASCADE ON DELETE CASCADE
);

create table job_schedule(
  user_id VARCHAR(8) NOT NULL,
  job_name TEXT NOT NULL,
  job_date DATE NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  current_hourly_wage money UNSIGNED NOT NULL,
  current_mid_wage money UNSIGNED,
  PRIMARY KEY(user_id,job_name,jod_date,start_time),
  FOREIGN KEY(user_id,job_name)
  REFERENCES part_time_job_inf(user_id,job_name)
  ON UPDATE CASCADE ON DELETE CASCADE
);

create table job_income_aggregation( 
  user_id VARCHAR(8) NOT NULL, 
  job_name TEXT NOT NULL, 
  date DATE NOT NULL, 
  current_hourly_wage money UNSIGNED NOT NULL, 
  current_mid_wage money UNSIGNED, 
  current_cutoff_day TINYINT UNSIGNED NOT NULL, 
  current_start_mid_time TIME, 
  current_end_mid_time TIME, 
  predict_income MONEY UNSIGNED NOT NULL, 
  actual_income MONEY UNSIGNED, 
  PRIMARY KEY(user_id, job_name,date) 
  FOREIGN KEY(user_id, job_name) 
  REFERENCES part_time_job_inf(user_id, job_name) 
  ON UPDATE CASCADE ON DELETE CASCADE 
); 