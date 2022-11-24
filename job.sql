create table user_inf(
  user_id VARCHAR(10) PRIMARY KEY NOT NULL,
  pass VARCHAR(50) NOT NULL 
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
  PRIMARY KEY(user_id,job_name,start_time),
  FOREIGN KEY(user_id,job_name)
  REFERENCES part_time_job_inf(user_id,job_name)
  ON UPDATE CASCADE ON DELETE CASCADE
);