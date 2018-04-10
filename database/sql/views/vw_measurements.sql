CREATE OR REPLACE VIEW vw_measurements AS
  SELECT
    a.id as measurement_id,
    a.measurement_date,
    a.customer_id,
    a.measurements_person_name,
    a.sex as gender,
    a.length,
    a.waist,
    a.bottom,
    a.thigh,
    a.round,
    a.fly,
    a.shoulder,
    a.sleeves,
    a.chest,
    a.tummy,
    a.biceps,
    a.round_sleeve,
    a.burst,
    a.hips,
    a.bodies,
    a.description,
    a.ip_address,
    a.status as measurement_status,
    a.created_at,
    a.updated_at,
    b.name as addedby_user_name,
    c.name as modifiedby_user_name,
    d.name as customer_name
  FROM measurements a
    JOIN users b ON b.id = a.added_by
    JOIN users c ON c.id = a.modified_by
    JOIN customers d ON d.id = a.customer_id


