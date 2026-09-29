-- ============================================================
-- Connect tblsetschedule to tblinstructor via a real foreign key
-- (INSTRUCTORID) instead of storing the instructor's name as text.
--
-- Run these in order. Steps 1-2 are safe to run anytime.
-- Step 3 (dropping the old INSTRUCTOR text column) is commented
-- out - only run it after you've confirmed the site works with
-- INSTRUCTORID and you no longer need the old text column.
-- ============================================================

-- 1) Add the new FK column (nullable, so schedules can be "unassigned").
ALTER TABLE `tblsetschedule`
  ADD COLUMN `INSTRUCTORID` INT(11) DEFAULT NULL AFTER `INSTRUCTOR`;

-- 2) Backfill INSTRUCTORID for existing rows by matching the old
--    INSTRUCTOR name text against tblinstructor.INSTRUCTOR.
--    Any row whose name doesn't match exactly (typos, extra spaces,
--    different capitalization) will be left NULL - check those
--    manually afterward.
UPDATE `tblsetschedule` s
JOIN `tblinstructor` i ON i.INSTRUCTOR = s.INSTRUCTOR
SET s.INSTRUCTORID = i.INSTRUCTORID;

-- Rows that failed to match (fix these manually, then re-run step 2
-- for just that row, or update them directly):
-- SELECT SCHEDULEID, INSTRUCTOR FROM tblsetschedule
-- WHERE INSTRUCTOR IS NOT NULL AND INSTRUCTOR <> '' AND INSTRUCTORID IS NULL;

-- 3) Add the actual foreign key constraint.
--    ON DELETE SET NULL: deleting an instructor un-assigns their
--    schedules instead of failing or cascading deletes.
ALTER TABLE `tblsetschedule`
  ADD CONSTRAINT `fk_tblsetschedule_instructor`
  FOREIGN KEY (`INSTRUCTORID`) REFERENCES `tblinstructor`(`INSTRUCTORID`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;

-- 4) OPTIONAL CLEANUP - only after confirming everything works:
-- ALTER TABLE `tblsetschedule` DROP COLUMN `INSTRUCTOR`;
