CREATE OR REPLACE VIEW vw_materials AS
  SELECT
    a.id as material_id,
    a.name as material_name,
    a.description,
    a.image as material_image,
    a.ip_address,
    a.status as material_status,
    a.created_at,
    a.updated_at,
    b.name as addedby_user_name,
    c.name as modifiedby_user_name
  FROM materials a
    JOIN users b ON b.id = a.added_by
    JOIN users c ON c.id = a.modified_by
