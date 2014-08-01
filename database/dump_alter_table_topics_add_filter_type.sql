USE sentis;
ALTER TABLE topics 
ADD COLUMN `filter_type` char(1) NOT NULL DEFAULT 'i';